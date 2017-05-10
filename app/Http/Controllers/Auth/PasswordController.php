<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InvalidArgumentException;
use XePresenter;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use XeTheme;
use Xpressengine\User\UserHandler;

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
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
     * @return void
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
     * @return Response
     */
    public function getReset()
    {
        $email = Session::get('email');

        return XePresenter::make('reset', compact('email'));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postReset(Request $request)
    {

        $this->validate(
            $request,
            [
                'email' => 'required|email',
            ]
        );

        $response = $this->passwords->sendResetLink(
            $request->only('email'),
            function ($m) {
                $m->subject($this->getEmailSubject());
            }
        );

        $email = $request->get('email');

        switch ($response)
        {
            case PasswordBroker::RESET_LINK_SENT:
                return redirect()->back()->with('status', $response)->with('email', $email);

            case PasswordBroker::INVALID_USER:
                return redirect()->back()->with('alert', ['type' => 'danger', 'message' => '등록되지 않았거나 등록대기중인 이메일입니다.']);
        }
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return xe_trans(app('xe.site')->getSiteConfig()->get('site_title')).' '.xe_trans('xe::linkForPasswordReset');
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return Response
     */
    public function getPassword(Request $request)
    {
        $token = $request->get('token');
        $email = $request->get('email');
        if (is_null($token))
        {
            throw new NotFoundHttpException;
        }

        return XePresenter::make('password', compact('email','token'));
    }

    /**
     * Reset the given user's password.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->passwords->reset(
            $credentials,
            function ($user, $password) {
                $this->handler->update($user, compact('password'));

                $this->auth->login($user);
            }
        );

        switch ($response)
        {
            case PasswordBroker::PASSWORD_RESET:
                return redirect('/')->with('status', $response);

            default:
                // password configuration
                $passwordConfig = app('config')->get('xe.user.password');
                $passwordLevel = array_get($passwordConfig['levels'], $passwordConfig['default']);
                return redirect()->back()
                                 ->withInput($request->only('email'))
                                 ->with('alert', ['type' => 'danger', 'message' => xe_trans($passwordLevel['description'])]);
        }
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath'))
        {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }


}
