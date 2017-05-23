<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XeDB;
use XePresenter;
use XeTheme;
use Xpressengine\User\EmailBrokerInterface;
use Xpressengine\User\EmailInterface;
use Xpressengine\User\Models\User;
use Xpressengine\User\Rating;
use Xpressengine\User\Repositories\RegisterTokenRepository;
use Xpressengine\User\UserHandler;

class RegisterController extends Controller
{
    use RedirectsUsers;

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * @var UserHandler
     */
    protected $handler;

    /**
     * @var EmailBrokerInterface
     */
    protected $emailBroker;

    public function __construct()
    {
        $this->auth = app('auth');
        $this->handler = app('xe.user');
        $this->emailBroker = app('xe.auth.email');

        XeTheme::selectSiteTheme();
        XePresenter::setSkinTargetId('user/auth');

        $this->middleware('guest', ['except' => ['getLogin', 'getLogout', 'getConfirm']]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister(Request $request, UserHandler $handler, RegisterTokenRepository $tokenRepository)
    {
        if(!$this->checkJoinable()) {
            return redirect()->back()->with(['alert'=>['type'=>'danger', 'message'=> xe_trans('xe::joinNotAllowed')]]);
        }

        $config = app('xe.config')->get('user.join');
        $this->addEmailRegister();

        // token 검사, token이 존재할 경우 form을 출력
        $token = $request->get('token');
        if ($token !== null) {
            return $this->getRegisterForm($request);
        }

        $guards = $handler->getRegisterGuards();
        if (!count($guards)) {
            $token = $tokenRepository->create('direct', []);
            return redirect()->route('auth.register', ['token' => $token->id]);
        }

        return \XePresenter::make('register.index', compact('config', 'guards'));
    }

    /**
     * Show the application registration form.
     *
     * @param Request                 $request
     *
     * @return Response
     */
    protected function getRegisterForm(Request $request)
    {
        $config = app('xe.config')->get('user.join');

        $tokenId = $request->get('token');

        $tokenRepository = app('xe.user.register.tokens');
        $register_token = $token = $tokenRepository->find($tokenId);

        if($token === null) {
            throw new HttpException(400, '정상적인 토큰이 아닙니다.');
        }

        // 기본정보 form 추가
        app('xe.register')->push('user/register/form', 'default-info', function ($data) {
            $skinHandler = app('xe.skin');
            $skin = $skinHandler->getAssigned('user/auth');
            // password configuration
            $passwordConfig = app('config')->get('xe.user.password');
            $passwordLevel = array_get($passwordConfig['levels'], $passwordConfig['default']);
            return $skin->setView('register.forms.default')->setData(compact('data', 'passwordLevel'))->render();
        });

        // dynamic field form 추가
        app('xe.register')->push(
            'user/register/form',
            'dynamic-fields',
            function ($data) use ($request) {
                $dynamicField = app('xe.dynamicField');
                $fieldTypes = $dynamicField->gets('user');

                $skinHandler = app('xe.skin');
                $skin = $skinHandler->getAssigned('user/auth');

                $html = '';
                foreach ($fieldTypes as $id => $fieldType) {
                    $html .= sprintf(
                        '<div class="control-group">%s</div>',
                        $fieldType->getSkin()->create($request->all())
                    );
                }

                return $skin->setView('register.forms.dfields')->setData(compact('data', 'html'))->render();
            }
        );

        // agreement form 추가
        app('xe.register')->push('user/register/form', 'agreements', function ($data) {

            app('xe.frontend')->html('auth.register')->content("
                    <script>
                        $(function($) {
                            $('.__xe_btn_privacy').click(function(){
                                XE.pageModal('".route('auth.privacy')."');
                                return false;
                            });
                            $('.__xe_btn_agreement').click(function(){
                                XE.pageModal('".route('auth.agreement')."');
                                return false;
                            })
                        });
                    </script>
                ")->load();

            $skinHandler = app('xe.skin');
            $skin = $skinHandler->getAssigned('user/auth');
            return $skin->setView('register.forms.agreements')->setData(compact('data'))->render();
        });

        // captcha form 추가
        if ($config['useCaptcha'] === true) {
            app('xe.register')->push(
                'user/register/form',
                'captcha',
                function ($data) {
                    return uio('captcha');
                }
            );
        }

        $forms = $this->handler->getRegisterForms($token);

        return \XePresenter::make('register.create', compact('config', 'forms', 'register_token'));
    }

    /**
     * 회원가입시 이메일 인증 요청 처리
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function postRegisterConfirm(Request $request, RegisterTokenRepository $tokenRepository)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $this->addEmailRegister();

        $email = $request->get('email');

        try {
            $this->handler->validateEmail($email);
        } catch (\Exception $e) {
            throw new HttpException(400, '이미 등록된 이메일입니다.');
        }

        $mail = $this->handler->pendingEmails()->findByAddress($email);

        if ($mail === null) {
            \DB::beginTransaction();
            try {
                $mailData = ['address'=>$email, 'userId' => app('xe.keygen')->generate()];
                $user = new User();
                $user->id = $mailData['userId'];
                $mail = $this->handler->createEmail($user, $mailData, false);
            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }
            \DB::commit();
        }

        $token = $tokenRepository->create('email', ['email' => $email, 'userId' => $mail->userId]);
        $this->emailBroker->sendEmailForRegister($mail, $token, 'emails.register', function ($m) {
            $m->subject(xe_trans(app('xe.site')->getSiteConfig()->get('site_title')).' '.xe_trans('xe::emailConfirm'));
        });

        return redirect()->route('auth.register', ['token'=>$token['id']])->with(['alert'=>['type'=>'success', 'message' => '인증 이메일이 전송되었습니다.']]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request, RegisterTokenRepository $tokenRepository)
    {
        // validation
        if(!$this->checkJoinable()) {
            return redirect()->back()->with(['alert'=>['type'=>'danger', 'message'=> xe_trans('xe::joinNotAllowed')]]);
        }

        $this->checkCaptcha('join');

        $this->addEmailRegister();

        $this->validate(
            $request, [
                'email' => 'email',
                'displayName' => 'required',
                'password' => 'confirmed|password',
                'agree' => 'required|accepted',
                'register_token' => 'required'
            ]
        );

        $tokenId = $request->get('register_token');
        $token = $tokenRepository->find($tokenId);

        if($token === null) {
            throw new HttpException(400, '잘못된 가입 토큰입니다.');
        }

        $userData = $request->all();

        // set default join group
        $config = app('xe.config')->get('user.join');
        $joinGroup = $config->get('joinGroup');
        if($joinGroup !== null) {
            $userData['groupId'] = [$joinGroup];
        }

        $userData['rating'] = Rating::MEMBER;
        $userData['status'] = \XeUser::STATUS_ACTIVATED;

        XeDB::beginTransaction();
        try {
            $user = $this->handler->create($userData, $token);
            $tokenRepository->delete($tokenId);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        // login and redirect
        $this->auth->login($user);
        return redirect($this->redirectPath());
    }

    /**
     * checkJoinable
     *
     * @return boolean
     */
    protected function checkJoinable()
    {
        $config = app('xe.config')->get('user.join');
        return $config->get('joinable') === true;
    }

    protected function checkCaptcha($action)
    {
        $action = ($action === 'login') ? 'common' : $action;
        $config = app('xe.config')->get('user.'.$action);
        if ($config->get('useCaptcha', false) === true) {
            if (app('xe.captcha')->verify() !== true) {
                throw new HttpException(Response::HTTP_FORBIDDEN, '자동인증방지 기능을 통과하지 못하였습니다.');
            }
        }
    }

    protected function useEmailConfirm()
    {
        $config = app('xe.config')->get('user.join');
        return $config->get('useEmailCertify', true);
    }

    /**
     * addEmailRegisterSection
     *
     * @param $config
     *
     */
    protected function addEmailRegister()
    {
        if ($this->useEmailConfirm()) {

            app('xe.register')->push(
                'user/register/guard',
                'email',
                function () {
                    $skinHandler = app('xe.skin');
                    $skin = $skinHandler->getAssigned('user/auth');
                    return $skin->setView('register.sections.email')->render();
                }
            );

            app('xe.register')->push(
                'user/register/form',
                'email',
                function ($token) {
                    if ($token->guard !== 'email') {
                        return null;
                    }
                    $code = request()->get('code');

                    if($code !== null) {
                        $this->checkPendingEmail($token->email, $code);
                    }

                    app('xe.frontend')->html('email.setter')->content("
                    <script>
                        $('input[name=email]').attr('readonly','readonly').val('{$token->email}');
                    </script>
                    ")->load();

                    $skinHandler = app('xe.skin');
                    $skin = $skinHandler->getAssigned('user/auth');
                    return $skin->setView('register.forms.confirm')->setData(compact('token', 'code'))->render();
                }
            );
            intercept('XeUser@validateForCreate', 'register.email.validator', function($target, $data, $token = null) {

                if($token->guard === 'email') {
                    $code = array_get($data, 'code');
                    $email = $this->checkPendingEmail($token->email, $code);
                    $data['id'] = $email->userId;
                }

                return $target($data, $token);
            });
        }
    }

    /**
     * checkPendingEmail
     *
     * @param $email
     * @param $code
     *
     * @return EmailInterface
     */
    protected function checkPendingEmail($email, $code)
    {
        $emailEntity = app('xe.user')->pendingEmails()->findByAddress($email);
        if ($emailEntity->getConfirmationCode() !== $code) {
            throw new HttpException(400, '잘못된 이메일 인증 코드입니다.');
        }

        return $emailEntity;
    }
}
