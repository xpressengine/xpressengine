<?php
/**
 * PasswordController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers\Auth
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
namespace App\Http\Controllers\Auth;

use App\Events\PreResetUserPasswordEvent;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;
use XePresenter;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use XeTheme;
use Xpressengine\User\UserHandler;

/**
 * Class PasswordController
 *
 * @category    Controllers
 * @package     App\Http\Controllers\Auth
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The password broker implementation.
     *
     * @var PasswordBroker
     */
    protected $passwords;

    /**
     * @var UserHandler
     */
    protected $handler;

    /**
     * Create a new password controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard          $auth      Guard instance
     * @param  \Illuminate\Contracts\Auth\PasswordBroker $passwords PasswordBroker instance
     */
    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->handler = app('xe.user');

        XeTheme::selectSiteTheme();
        XePresenter::setSkinTargetId('user/auth');

        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getReset()
    {
        $email = Session::get('email');

        return XePresenter::make('reset', compact('email'));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postReset(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $result = $this->passwords->sendResetLink($request->only('email'));

        $email = $request->get('email');

        switch ($result)
        {
            case PasswordBroker::RESET_LINK_SENT:
                return redirect()->back()->with('status', PasswordBroker::RESET_LINK_SENT)->with('email', $email);

            case PasswordBroker::INVALID_USER:
                return redirect()->back()->with('alert', [
                    'type' => 'danger',
                    'message' => xe_trans('xe::emailNotRegisteredOrPendingRegistration')
                ]);
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getPassword(Request $request)
    {
        $token = $request->get('token');
        $email = $request->get('email');

        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return XePresenter::make('password', compact('email','token'));
    }

    /**
     * Reset the given user's password.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|password',
        ]);

        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        \Event::dispatch(new PreResetUserPasswordEvent($credentials));

        $result = $this->passwords->reset(
            $credentials,
            function ($user, $password) {
                $this->handler->update($user, compact('password'));

                if (app('config')->get('xe.user.registrationAutoLogin') == true) {
                    $this->auth->login($user);
                }
            }
        );

        switch ($result) {
            case PasswordBroker::PASSWORD_RESET:
                if (app('config')->get('xe.user.registrationAutoLogin') == true) {
                    return redirect('/')->with('status', PasswordBroker::PASSWORD_RESET);
                } else {
                    return redirect(route('login'))->with('status', PasswordBroker::PASSWORD_RESET);
                }

            case PasswordBroker::INVALID_USER:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->with('alert', ['type' => 'danger', 'message' => xe_trans('xe::userNotFound')]);

            case PasswordBroker::INVALID_TOKEN:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->with('alert', ['type' => 'danger', 'message' => xe_trans('xe::msgTokenIsInvalid')]);

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->with('alert', ['type' => 'danger', 'message' => app('xe.password.validator')->getMessage()]);
        }
    }
}
