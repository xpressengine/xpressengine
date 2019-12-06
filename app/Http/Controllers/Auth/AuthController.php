<?php
/**
 * AuthController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers\Auth
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Xpressengine\User\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\UrlGenerator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XeDB;
use XeFrontend;
use XePresenter;
use XeTheme;
use Xpressengine\Theme\ThemeHandler;
use Xpressengine\User\EmailBroker;
use Xpressengine\User\Exceptions\InvalidConfirmationCodeException;
use Xpressengine\User\Exceptions\PendingEmailNotExistsException;
use Xpressengine\User\Models\User;
use Xpressengine\User\UserHandler;

/**
 * Class AuthController
 *
 * @category    Controllers
 * @package     App\Http\Controllers\Auth
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class AuthController extends Controller
{
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

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->auth = app('auth');
        $this->handler = app('xe.user');
        $this->emailBroker = app('xe.auth.email');

        XeTheme::selectSiteTheme();
        XePresenter::setSkinTargetId('user/auth');

        $this->middleware(
            'auth',
            [
                'only' => ['getConfirm', 'getLogout', 'getAdminAuth', 'postAdminAuth', 'pendingAdmin', 'pendingEmail']
            ]
        );
        $this->middleware(
            'guest',
            [
                'except' => ['getConfirm', 'getLogout', 'getAdminAuth', 'postAdminAuth', 'pendingAdmin', 'pendingEmail']
            ]
        );
    }

    /**
     * Show terms
     *
     * @param string $id term id
     * @return \Xpressengine\Presenter\Presentable
     */
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
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function getConfirm(Request $request)
    {
        $this->validate($request, ['email' => 'required|email', 'code' => 'required']);

        $address = $request->get('email');
        $code = $request->get('code');

        $email = $this->handler->pendingEmails()->findByAddress($address);

        if ($email === null) {
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

        return redirect('/')->with('alert', ['type' => 'success', 'message' => xe_trans('xe::verified')]);
    }

    /**
     * Show the application login form.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getLogin(Request $request)
    {
        $redirectUrl = $request->get(
            'redirectUrl',
            $request->session()->pull('url.intended') ?: url()->previous()
        );

        if ($redirectUrl !== $request->url()) {
            $request->session()->put('url.intended', $redirectUrl);
        }

        // common config
        $config = app('xe.config')->get('user.register');

        $loginRuleName = 'login';

        XeFrontend::rule($loginRuleName, [
            'email' => 'required',
            'password' => 'required'
        ]);

        return XePresenter::make('login', compact('config', 'loginRuleName'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $this->checkCaptcha();

        $credentials = $request->only('email', 'password');

        $credentials['email'] = trim($credentials['email']);

        $credentials['status'] = [User::STATUS_ACTIVATED, User::STATUS_PENDING_ADMIN, User::STATUS_PENDING_EMAIL];

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            $user = \Auth::user();

            switch ($user->status) {
                case User::STATUS_PENDING_ADMIN:
                    return redirect()->route('auth.pending_admin');
                    break;

                case User::STATUS_PENDING_EMAIL:
                    return redirect()->route('auth.pending_email');
                    break;

                default:
                    return redirect()->intended($this->redirectPath());
            }
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->with('alert', ['type' => 'danger', 'message' => xe_trans('xe::msgAccountNotFoundOrDisabled')]);
    }

    /**
     * 관리자 승인 대기 상태인 회원이 로그인 했을 떄 처리
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Xpressengine\Presenter\Presentable
     */
    public function pendingAdmin(Request $request)
    {
        $user = $this->auth->user();
        if ($user->getStatus() === User::STATUS_ACTIVATED) {
            return redirect('/');
        }

        $this->auth->logout();
        $request->session()->invalidate();

        return XePresenter::make('pending_admin');
    }

    /**
     * 이메일 인증 대기 상태인 회원이 로그인 했을 떄 처리
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Xpressengine\Presenter\Presentable
     */
    public function pendingEmail(Request $request)
    {
        $user = $this->auth->user();
        if ($user->getStatus() === User::STATUS_ACTIVATED) {
            return redirect('/');
        }

        $this->auth->logout();
        $request->session()->invalidate();

        return XePresenter::make('pending_email', compact('user'));
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout(Request $request)
    {
        $this->auth->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    /**
     * Get authenticate view for administrator
     *
     * @param ThemeHandler $themeHandler ThemeHandler instance
     * @param UrlGenerator $urlGenerator UrlGenerator instance
     * @param Request      $request      request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getAdminAuth(ThemeHandler $themeHandler, UrlGenerator $urlGenerator, Request $request)
    {
        if (config('auth.admin.without_theme', true) == true) {
            $themeHandler->selectBlankTheme();
        }

        $redirectUrl = $request->get('redirectUrl', $urlGenerator->previous());

        return XePresenter::make('admin', compact('redirectUrl'));
    }

    /**
     * Attempt authenticate for administrator
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
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

        return redirect()->back()->with('alert', ['type' => 'failed', 'message' => xe_trans('xe::msgInvalidPassword')]);
    }

    /**
     * Check captcha
     *
     * @return void
     */
    protected function checkCaptcha()
    {
        $config = app('xe.config')->get('user.register');
        if ($config->get('useCaptcha', false) === true) {
            if (app('xe.captcha')->verify() !== true) {
                throw new HttpException(Response::HTTP_FORBIDDEN, xe_trans('xe::msgFailToPassCAPTCHA'));
            }
        }
    }
}
