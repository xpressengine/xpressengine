<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Xpressengine\User\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\UrlGenerator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XeDB;
use XePresenter;
use XeTheme;
use Xpressengine\Theme\ThemeHandler;
use Xpressengine\User\EmailBroker;
use Xpressengine\User\Exceptions\InvalidConfirmationCodeException;
use Xpressengine\User\Exceptions\PendingEmailNotExistsException;
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

    use AuthenticatesUsers;

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
     * @var EmailBroker
     */
    protected $emailBroker;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->auth = app('auth');
        $this->handler = app('xe.user');
        $this->emailBroker = app('xe.auth.email');

        XeTheme::selectSiteTheme();
        XePresenter::setSkinTargetId('user/auth');

        $this->middleware('auth', ['only' => ['getConfirm', 'getLogout', 'getAdminAuth', 'postAdminAuth']]);
        $this->middleware('guest', ['except' => ['getConfirm', 'getLogout', 'getAdminAuth', 'postAdminAuth']]);
    }

    public function terms($id)
    {
        if (!$term = app('xe.terms')->find($id)) {
            abort(404);
        }

        return api_render('terms', compact('term'));
    }

    /**
     * 이메일 인증 페이지. 사용자가 개인 설정에서 이메일을 추가했을 때, 전송되는 이메일의 링크를 통해 이 페이지에 접근한다.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Xpressengine\Presenter\RendererInterface
     * @throws Exception
     */
    public function getConfirm(Request $request)
    {
        // validation
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'code' => 'required',
            ]
        );

        $address = $request->get('email');
        $code = $request->get('code');

        $email = $this->handler->pendingEmails()->findByAddress($address);

        if($email === null) {
            // todo: change exception to http exception
            throw new PendingEmailNotExistsException();
        }

        XeDB::beginTransaction();
        try {
            $this->emailBroker->confirmEmail($email, $code);
        } catch (InvalidConfirmationCodeException $e) {
            XeDB::rollback();
            throw new HttpException(Response::HTTP_FORBIDDEN, xe_trans('xe::invalidConfirmationCode'), $e);
        } catch (Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return redirect('/')->with('alert', ['type' => 'success', 'message' => '인증되었습니다.']);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin(UrlGenerator $urlGenerator, Request $request)
    {
        $redirectUrl = $request->get('redirectUrl', $urlGenerator->previous());

        if ($redirectUrl !== $request->url()) {
            app('session.store')->put('url.intended', $redirectUrl);
        }

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

        $this->checkCaptcha();

        $credentials = $request->only('email', 'password');

        $credentials['email'] = trim($credentials['email']);

        $credentials['status'] = \XeUser::STATUS_ACTIVATED;

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            $this->redirectTo = $request->get('redirectUrl', $this->redirectTo);
            return redirect()->intended($this->redirectPath());
        }

        return redirect()->back()
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
        $this->auth->logout();

        return redirect($request->get('redirectUrl', $urlGenerator->previous()));
    }

    /**
     * getAdminAuth
     *
     * @param ThemeHandler $themeHandler
     * @param UrlGenerator $urlGenerator
     * @param Request      $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function getAdminAuth(ThemeHandler $themeHandler, UrlGenerator $urlGenerator, Request $request)
    {
        $themeHandler->selectBlankTheme();

        $redirectUrl = $request->get('redirectUrl', $urlGenerator->previous());

        return \XePresenter::make('admin', compact('redirectUrl'));
    }

    public function postAdminAuth(Request $request)
    {
        $this->validate($request, [
            'password' => 'required'
        ]);

        $credentials = $request->only('password');

        if ($this->auth->attemptAdminAuth($credentials)) {
            $redirectUrl = $request->get('redirectUrl');
            return redirect()->intended($redirectUrl);
        }

        return redirect()->back()->with('alert', ['type' => 'failed', 'message' => '입력하신 암호가 틀렸습니다.']);
    }

    protected function checkCaptcha()
    {
        $config = app('xe.config')->get('user.common');
        if ($config->get('useCaptcha', false) === true) {
            if (app('xe.captcha')->verify() !== true) {
                throw new HttpException(Response::HTTP_FORBIDDEN, '자동인증방지 기능을 통과하지 못하였습니다.');
            }
        }
    }
}
