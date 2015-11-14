<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Member;
use Presenter;
use Theme;
use XeDB;
use Xpressengine\Member\EmailBrokerInterface;
use Xpressengine\Member\Exceptions\JoinNotAllowedException;
use Xpressengine\Member\Exceptions\NotFoundEmailException;
use Xpressengine\Member\MemberHandler;
use Xpressengine\Member\Rating;
use Xpressengine\Support\Exceptions\HttpXpressengineException;
use Xpressengine\Support\Exceptions\InvalidArgumentException;

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
     * @var MemberHandler
     */
    protected $handler;

    /**
     * @var EmailBrokerInterface
     */
    protected $emailBroker;

    public function __construct()
    {
        $this->auth = app('auth');
        $this->handler = app('xe.member');
        $this->emailBroker = app('xe.auth.email');

        Theme::selectSiteTheme();
        Presenter::setSkin('member/auth');

        $this->middleware('guest', ['except' => ['getLogout', 'getConfirm']]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $this->checkJoinable();

        // password configuration
        $passwordConfig = app('config')->get('xe.member.password');
        $passwordLevel = array_get($passwordConfig['levels'], $passwordConfig['default']);

        // dynamic field
        $dynamicField = app('xe.dynamicField');
        $fieldTypes = $dynamicField->gets('member');

        // join config
        $config = app('xe.config')->get('member.join');

        return \Presenter::make('register', compact('config', 'fieldTypes', 'passwordLevel'));
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
        $validate = \Validator::make(
            $request->all(), [
                'email' => 'email|required|unique:member_mails,address',
                'displayName' => 'required',
                'password' => 'required|confirmed|password',
                'agree' => 'required',
            ]
        );

        if ($validate->fails()) {
            $e = new InvalidArgumentException();
            $e->setMessage($validate->errors()->first());
            throw $e;
        }

        // resolve data
        $memberData = $request->except('_token');
        $memberData['rating'] = Rating::MEMBER;
        $memberData['status'] = Member::STATUS_ACTIVATED;
        unset($memberData['password_confirmation']);

        XeDB::beginTransaction();
        try {
            $member = $this->handler->create($memberData);
            $mail = $member->getPendingEmail();
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        // if email confirmation enabled, send email for confirm
        if ($this->useEmailConfirm() !== false) {
            try {
                /** @var EmailBrokerInterface $broker */
                $this->emailBroker->sendEmailForConfirmation($mail);
            } catch (Exception $e) {
                throw $e;
            }

            // redirect to email confirm info page
            return redirect()
                ->route('auth.confirm', ['email' => $member->email])
                ->with('alert', ['type' => 'info', 'message' => '회원가입이 정상적으로 처리되었습니다. 회원계정을 활성화하려면 이메일 인증을 하셔야 합니다.']);
        }

        // login and redirect
        $this->auth->login($member);
        return redirect($this->redirectPath());
    }

    public function getConfirm(Request $request)
    {
        // validation
        $validate =\Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
            ]
        );

        if ($validate->fails()) {
            $e = new InvalidArgumentException();
            $e->setMessage($validate->errors()->first());
            throw $e;
        }

        $email = $request->get('email');
        $code = $request->get('code');

        // code가 없을 경우 인증 페이지 출력
        if ($code === null) {
            return \Presenter::make('register_confirm');
        }

        XeDB::beginTransaction();
        try {
            $this->emailBroker->confirmEmail($email, $code);
        } catch (Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return redirect()->route('login')->with('alert', ['type' => 'success', 'message' => '인증되었습니다.']);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin(UrlGenerator $urlGenerator, Request $request)
    {
        $redirectUrl = $this->redirectPath = $request->get('redirectUrl', $urlGenerator->previous());

        // common config
        $config = app('xe.config')->get('member.common');

        $loginRuleName = 'login';
        \Frontend::rule($loginRuleName, [
            'email' => 'required|email_prefix',
            'password' => 'required'
        ]);

        return \Presenter::make('login', compact('config', 'loginRuleName', 'redirectUrl'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $validate =\Validator::make(
            $request->all(),
            [
                'email' => 'required|email_prefix',
                'password' => 'required'
            ]
        );

        if ($validate->fails()) {
            $e = new InvalidArgumentException();
            $e->setMessage($validate->errors()->first());
            throw $e;
        }

        $this->checkCaptcha('login');

        $credentials = $request->only('email', 'password');
        $credentials['status'] = Member::STATUS_ACTIVATED;

        try {
            if ($this->auth->attempt($credentials, $request->has('remember'))) {
                $this->redirectPath = $request->get('redirectUrl');
                return redirect()->intended($this->redirectPath());
            }
        } catch (NotFoundEmailException $e) {
            // by pass
        } catch (\Exception $e) {
            throw $e;
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
    public function getLogout()
    {
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
        $config = app('xe.config')->get('member.join');
        if ($config->get('joinable') !== true) {
            throw new JoinNotAllowedException();
        }
    }

    protected function checkCaptcha($action)
    {
        $action = ($action === 'login') ? 'common' : $action;
        $config = app('xe.config')->get('member.'.$action);
        if ($config->get('useCaptcha', false) === true) {
            if (app('xe.captcha')->verify() !== true) {
                $e = new HttpXpressengineException(403);
                $e->setMessage('자동인증방지 기능을 통과하지 못하였습니다.');
                throw $e;
            }
        }
    }

    private function useEmailConfirm()
    {
        $config = app('xe.config')->get('member.join');
        return $config->get('useMailCertify', true);
    }
}
