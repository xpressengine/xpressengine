<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\UrlGenerator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XeDB;
use XePresenter;
use XeTheme;
use Xpressengine\User\EmailBrokerInterface;
use Xpressengine\User\Exceptions\JoinNotAllowedException;
use Xpressengine\User\Exceptions\PendingEmailNotExistsException;
use Xpressengine\User\Models\User;
use Xpressengine\User\Rating;
use Xpressengine\User\UserHandler;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

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

        $this->addEmailRegisterSection($config);

        // type, section 검사.
        $type = $request->get('type');
        if ($type !== null) {
            return $this->getRegisterForm($request);
        }

        $sections = $handler->getRegisterSections();
        if (!count($sections)) {
            return $this->getRegisterForm($request);
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
        // join config
        $config = app('xe.config')->get('user.join');

        $registerInfo = $request->session()->get('register-info');

        /** @var array $data form 출력시 필요한 데이터를 저장하는 array */
        $data = [];

        // type은 항상 존재한다.
        $type = $request->get('type');

        if($type === 'email') {
            $email = $request->get('email');
            $code = $request->get('code');

            if($email === null) {
                throw new HttpException(400, '잘못된 접근입니다');
            }

            $info = $this->addEmailRegisterForm($config, $email, $code);
            $data = array_merge($data, $info);
        }

        // 기본정보 form 추가
        $defaultInfoForm = [
            'title' => '이메일 인증코드 입력',
            'content' => function ($data) {

                $skinHandler = app('xe.skin');
                $skin = $skinHandler->getAssigned('member/auth');

                // password configuration
                $passwordConfig = app('config')->get('xe.user.password');
                $passwordLevel = array_get($passwordConfig['levels'], $passwordConfig['default']);

                return $skin->setView('register.forms.default')->setData(compact('data', 'passwordLevel'))->render();
            }
        ];
        app('xe.register')->push('user/register/form', 'default-info', $defaultInfoForm);

        // dynamic field form 추가
        app('xe.register')->push('user/register/form', 'dynamic-fields', [
            'title' => '',
            'content' => function ($data) use ($request) {
                $dynamicField = app('xe.dynamicField');
                $fieldTypes = $dynamicField->gets('user');

                $skinHandler = app('xe.skin');
                $skin = $skinHandler->getAssigned('member/auth');

                $html = '';
                foreach ($fieldTypes as $id => $fieldType) {
                    $html .= sprintf('<div class="control-group">%s</div>', $fieldType->getSkin()->create($request->all()));
                }

                return $skin->setView('register.forms.dfields')->setData(compact('data', 'html'))->render();
            }
        ]);

        // agreement form 추가
        app('xe.register')->push('user/register/form', 'agreements', [
            'title' => '',
            'content' => function($data) {

                app('xe.frontend')->html('auth.register')->content("
                    <script>
                        $(function($) {
                            $('.__xe_btn_privacy').click(function(){
                                XE.pageModal('".route('auth.privacy')."');
                                return false;
                            })
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
            }
        ]);

        // captcha form 추가
        if ($config['useCaptcha'] === true) {
            app('xe.register')->push('user/register/form', 'captcha', [
                'title' => '',
                'content' => function($data) {
                    return uio('captcha');
                }
            ]);
        }

        $data = (object)$data;
        $forms = $this->handler->getRegisterForms($type, $data);

        return \XePresenter::make('register.create', compact('config', 'fieldTypes', 'data', 'forms'));
    }

    protected function addEmailRegisterForm($config, $email, $code)
    {
        $data = [];
        $confirmed = false;
        if ($config->get('useEmailCertify')) {
            // validate code
            if($code !== null) {
                $emailEntity = $this->handler->pendingEmails()->findByAddress($email);
                if ($emailEntity->getConfirmationCode() !== $code) {
                    throw new HttpException(400, '잘못된 접근입니다');
                }
                $data['code'] = $code;
                $confirmed = true;
            }
        } else {
            throw new HttpException(400, '잘못된 접근입니다');
        }

        $data['email'] = $email;
        $emailConfirmForm = [
            'title' => '이메일 인증코드 입력',
            'content' => function ($data) use($confirmed){
                $skinHandler = app('xe.skin');
                $skin = $skinHandler->getAssigned('member/auth');
                return $skin->setView('register.forms.confirm')->setData(compact('data', 'confirmed'))->render();
            }
        ];
        app('xe.register')->push('user/register/form', 'email-confirm', $emailConfirmForm);

        return $data;
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

        $email = $request->get('email');

        if ($this->handler->emails()->findByAddress($email) !== null) {
            throw new HttpException(400, '이미 등록된 이메일입니다.');
        }

        $mailData = ['address'=>$email, 'userId' => app('xe.keygen')->generate()];

        if ($existed = $this->handler->pendingEmails()->findByAddress($email)) {
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

        return redirect()->route('auth.register', ['type'=>'email', 'email'=>$email])->with(['alert'=>['type'=>'success', 'message' => '인증 이메일이 전송되었습니다.']]);
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

        $this->validate(
            $request, [
                'email' => 'email',
                'displayName' => 'required',
                'password' => 'required|confirmed|password',
                'agree' => 'required|accepted',
            ]
        );

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

    public function getAgreement(){

        $config = app('xe.config')->get('user.common');
        $agreement = $config->get('agreement');

        return apiRender('agreement', compact('agreement'));
    }



    public function getPrivacy()
    {
        $config = app('xe.config')->get('user.common');
        $privacy = $config->get('privacy');

        return apiRender('privacy', compact('privacy'));
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
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin(UrlGenerator $urlGenerator, Request $request)
    {
        $redirectUrl = $this->redirectPath = $request->get('redirectUrl', $urlGenerator->previous());

        if(auth()->check()) {
            return redirect($request->get('redirectUrl', '/'));
        }

        app('session.store')->put('url.intended', $redirectUrl);

        // common config
        $config = app('xe.config')->get('user.common');

        $loginRuleName = 'login';

        \XeFrontend::rule($loginRuleName, [
            'email' => 'required|email_prefix',
            'password' => 'required'
        ]);

        return \XePresenter::make('login', compact('config', 'loginRuleName', 'redirectUrl'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function postLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email_prefix',
                'password' => 'required'
            ]
        );

        $this->checkCaptcha('login');

        $credentials = $request->only('email', 'password');
        $credentials['status'] = \XeUser::STATUS_ACTIVATED;

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            $this->redirectPath = $request->get('redirectUrl');
            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
            ->withInput($request->only('email', 'remember'))
            ->with('alert', ['type' => 'danger', 'message' => '입력한 정보에 해당하는 계정을 찾을 수 없거나 사용 중지 상태인 계정입니다.']);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'These credentials do not match our records.';
    }


    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout(UrlGenerator $urlGenerator, Request $request)
    {
        $redirectUrl = $this->redirectAfterLogout = $request->get('redirectUrl', $urlGenerator->previous());

        $this->auth->logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
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
     * @return void
     */
    protected function addEmailRegisterSection($config)
    {
        if ($config->get('useEmailCertify')) {
            $section = [
                'email' => [
                    'title' => '이메일 인증으로 회원가입하기',
                    'content' => function () {
                        $skinHandler = app('xe.skin');
                        $skin = $skinHandler->getAssigned('member/auth');
                        return $skin->setView('register.sections.email')->render();
                    }
                ]
            ];

            app('xe.register')->add('user/register/section', $section);
        }
}
}
