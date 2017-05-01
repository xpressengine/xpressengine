<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\RegisterGuards\EmailRegisterGuard;
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
use Xpressengine\User\Exceptions\JoinNotAllowedException;
use Xpressengine\User\Exceptions\PendingEmailNotExistsException;
use Xpressengine\User\Models\User;
use Xpressengine\User\Rating;
use Xpressengine\User\RegisterGuard;
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
        XePresenter::setSkinTargetId('member/auth');

        $this->middleware('guest', ['except' => ['getLogin', 'getLogout', 'getConfirm']]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister(Request $request, UserHandler $handler)
    {
        $this->checkJoinable();

        $config = app('xe.config')->get('user.join');
        $this->addEmailRegister();

        // token 검사, token이 존재할 경우 form을 출력
        $token = $request->get('token');
        if ($token !== null) {
            return $this->getRegisterForm($request);
        }

        $sections = $handler->getRegisterGuards();
        if (!count($sections)) {
            $token = $this->handler->storeRegisterToken('direct', []);
            return redirect()->route('auth.register', ['token' => $token->id]);
        }

        return \XePresenter::make('register.index', compact('config', 'sections'));
    }

    /**
     * Show the application registration form.
     *
     * @param Request $request
     *
     * @return Response
     */
    protected function getRegisterForm(Request $request)
    {
        $config = app('xe.config')->get('user.join');

        $tokenId = $request->get('token');

        $register_token = $token = $this->handler->getRegisterToken($tokenId);

        if($token === null) {
            throw new HttpException(400, '정상적인 토큰이 아닙니다.');
        }

        $shared = $this->handler->resolveRegister($token, $request);

        // 기본정보 form 추가
        app('xe.register')->push('user/register/form', 'default-info', function ($data) {
            $skinHandler = app('xe.skin');
            $skin = $skinHandler->getAssigned('member/auth');
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
                $skin = $skinHandler->getAssigned('member/auth');

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
            $skin = $skinHandler->getAssigned('member/auth');
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

        $forms = $this->handler->getRegisterForms($shared, $token);

        return \XePresenter::make('register.create', compact('config', 'shared', 'forms', 'register_token'));
    }

    /**
     * 회원가입시 이메일 인증 요청 처리
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function postRegisterConfirm(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $this->addEmailRegister();

        $email = $request->get('email');

        if ($this->handler->emails()->findByAddress($email) !== null) {
            throw new HttpException(400, '이미 등록된 이메일입니다.');
        }

        $mailData = ['address'=>$email, 'userId' => app('xe.keygen')->generate()];

        if ($mail = $this->handler->pendingEmails()->findByAddress($email)) {
            ;
        } else {
            \DB::beginTransaction();
            try {
                $user = new User();
                $user->id = $mailData['userId'];
                $mail = $this->handler->pendingEmails()->create($user, $mailData);
                $this->emailBroker->sendEmailForConfirmation($mail, 'emails.register');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }
            \DB::commit();
        }

        $token = $this->handler->storeRegisterToken('email', ['email' => $email, 'userId' => $mail->userId]);

        return redirect()->route('auth.register', ['token'=>$token['id']])->with(['alert'=>['type'=>'success', 'message' => '인증 이메일이 전송되었습니다.']]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        // validation
        $this->checkJoinable();
        $this->checkCaptcha('join');

        $this->addEmailRegister();

        $this->validate(
            $request, [
                'email' => 'email',
                'displayName' => 'required',
                'password' => 'required|confirmed|password',
                'agree' => 'required|accepted',
                'register_token' => 'required'
            ]
        );

        $tokenId = $request->get('register_token');
        $token = $this->handler->getRegisterToken($tokenId);
        $this->handler->validateRegister($token, $request);

        // resolve data
        $userData = $request->except('_token');
        $userData['rating'] = Rating::MEMBER;
        $userData['status'] = \XeUser::STATUS_ACTIVATED;

        // set default join group
        $config = app('xe.config')->get('user.join');
        $joinGroup = $config->get('joinGroup');
        array_add($userData, 'groupId', []);
        $userData['groupId'][] = $joinGroup;

        XeDB::beginTransaction();
        try {
            $user = $this->handler->create($userData);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        // login and redirect
        $this->auth->login($user);
        return redirect($this->redirectPath());
    }

    public function getConfirm(Request $request)
    {
        // validation
        $this->validate(
            $request,
            [
                'email' => 'required|email',
            ]
        );

        $address = $request->get('email');
        $code = $request->get('code');

        $email = $this->handler->pendingEmails()->findByAddress($address);

        if($email === null) {
            // todo: change exception to http exception
            throw new PendingEmailNotExistsException();
        }

        // code가 없을 경우 인증 페이지 출력
        if ($code === null) {
            return \XePresenter::make('register_confirm');
        }

        XeDB::beginTransaction();
        try {
            $this->emailBroker->confirmEmail($email, $code);
        } catch (Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return redirect('/')->with('alert', ['type' => 'success', 'message' => '인증되었습니다. 로그인하시기 바랍니다.']);
    }

    /**
     * checkJoinable
     *
     * @return mixed
     */
    protected function checkJoinable()
    {
        $config = app('xe.config')->get('user.join');
        if ($config->get('joinable') !== true) {
            throw new JoinNotAllowedException();
        }
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
     * @return RegisterGuard
     */
    protected function addEmailRegister()
    {
        if ($this->useEmailConfirm()) {
            $emailGuard = new EmailRegisterGuard();

            app('xe.register')->push(
                'user/register/guard',
                'email',
                function () {
                    $skinHandler = app('xe.skin');
                    $skin = $skinHandler->getAssigned('member/auth');
                    return $skin->setView('register.sections.email')->render();
                }
            );
            app('xe.register')->push(
                'user/register/resolver',
                'email',
                function ($token, $request, $shared) use ($emailGuard) {
                    $code = $request->get('code');
                    if($token->guard === 'email') {
                        if($code !== null) {
                            $this->checkPendingEmail($token->email, $code);
                        }
                        $shared->email = $token->email;
                    }
                    return $shared;
                }
            );
            app('xe.register')->push(
                'user/register/form',
                'email',
                function ($data, $token) {
                    if ($token->guard !== 'email') {
                        return null;
                    }

                    $code = request()->get('code');

                    if($code !== null) {
                        $this->checkPendingEmail($token->email, $code);
                    }

                    $skinHandler = app('xe.skin');
                    $skin = $skinHandler->getAssigned('member/auth');
                    return $skin->setView('register.forms.confirm')->setData(compact('data', 'code'))->render();
                }
            );
            app('xe.register')->push(
                'user/register/validator',
                'email',
                function ($token, $request) use ($emailGuard) {
                    if($token->guard === 'email') {
                        $code = $request->get('code');
                        $email = $this->checkPendingEmail($token->email, $code);
                    }
                    $request['id'] = $email->userId;
                    return true;
                }
            );

            return $emailGuard;
        }
    }
}
