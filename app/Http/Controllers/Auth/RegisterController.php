<?php
/**
 * RegisterController.php
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
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XeConfig;
use XeDB;
use XeDynamicField;
use XeFrontend;
use XePresenter;
use XeTheme;
use Xpressengine\User\EmailBroker;
use Xpressengine\User\Exceptions\DisplayNameAlreadyExistsException;
use Xpressengine\User\Exceptions\EmailAlreadyExistsException;
use Xpressengine\User\Exceptions\InvalidDisplayNameException;
use Xpressengine\User\Exceptions\PendingEmailAlreadyExistsException;
use Xpressengine\User\Models\User;
use Xpressengine\User\Repositories\RegisterTokenRepository;
use Xpressengine\User\UserHandler;

/**
 * Class RegisterController
 *
 * @category    Controllers
 * @package     App\Http\Controllers\Auth
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
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
     * @var EmailBroker
     */
    protected $emailBroker;

    /**
     * redirect path
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->auth = app('auth');
        $this->handler = app('xe.user');
        $this->emailBroker = app('xe.auth.email');

        XeTheme::selectSiteTheme();
        XePresenter::setSkinTargetId('user/auth');

        $this->middleware('auth', ['only' => ['getRegisterAddInfo', 'postRegisterAddInfo']]);
        $this->middleware('guest', [
            'except' => ['getLogin', 'getLogout', 'getConfirm', 'getRegisterAddInfo', 'postRegisterAddInfo']
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse|\Xpressengine\Presenter\Presentable
     */
    public function getRegister(Request $request)
    {
        // 회원 가입 허용 검사
        if (!$this->checkJoinable()) {
            return redirect()->back()->with(
                ['alert' => ['type' => 'danger', 'message' => xe_trans('xe::joinNotAllowed')]]
            );
        }

        $config = app('xe.config')->get('user.register');

        // 가입 인증을 사용하지 않을 경우, 곧바로 회원가입 폼 출력
        if (!$config->get('guard_forced', false) || $request->get('token')) {
            return $this->getRegisterForm($request);
        }

        return \XePresenter::make('register.index');
    }

    /**
     * Show the application registration form.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    protected function getRegisterForm(Request $request)
    {
        $config = app('xe.config')->get('user.register');

        // 활성화된 가입폼 가져오기
        $parts = $this->handler->getRegisterParts();
        $activated = array_keys(array_intersect_key(array_flip($config->get('forms', [])), $parts));

        $parts = collect($parts)->filter(function ($part, $key) use ($activated) {
            return in_array($key, $activated) || $part::isImplicit();
        })->map(function ($part) use ($request) {
            return new $part($request);
        });

        $rules = $parts->map(function ($part) {
            return $part->rules();
        })->collapse()->all();

        XeFrontend::rule('join', $rules);

        return \XePresenter::make('register.create', compact('config', 'parts'));
    }

    /**
     * 회원가입시 이메일 인증 요청 처리
     *
     * @param Request                 $request         request
     * @param RegisterTokenRepository $tokenRepository RegisterTokenRepository instance
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function postRegisterConfirm(Request $request, RegisterTokenRepository $tokenRepository)
    {
        $this->validate($request, ['email' => 'required|email']);

        $email = $request->get('email');

        try {
            $this->handler->validateEmail($email);
        } catch (\Exception $e) {
            throw new HttpException(400, xe_trans('xe::emailAlreadyExists'));
        }

        $mail = $this->handler->pendingEmails()->findByAddress($email);

        if ($mail === null) {
            \DB::beginTransaction();
            try {
                $mailData = ['address' => $email];
                $user = new User();
                $user->id = app('xe.keygen')->generate();
                $mail = $this->handler->createEmail($user, $mailData, false);
            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }
            \DB::commit();
        }

        $token = $tokenRepository->create('email', ['email' => $email, 'user_id' => $mail->user_id]);
        $this->emailBroker->sendEmailForRegister($mail, $token);

        return redirect()->route('auth.register', ['token' => $token['id']])->with(
            ['alert' => ['type' => 'success', 'message' => xe_trans('xe::msgEmailSendComplete')]]
        );
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function postRegister(Request $request)
    {
        // validation
        if (!$this->checkJoinable()) {
            return redirect()->back()->with(
                ['alert' => ['type' => 'danger', 'message' => xe_trans('xe::joinNotAllowed')]]
            );
        }

        $config = app('xe.config')->get('user.register');

        // 활성화된 가입폼 가져오기
        $parts = $this->handler->getRegisterParts();
        $activated = array_keys(array_intersect_key(array_flip($config->get('forms', [])), $parts));

        $parts = collect($parts)->filter(function ($part, $key) use ($activated) {
            return in_array($key, $activated) || $part::isImplicit();
        })->map(function ($part) use ($request) {
            return new $part($request);
        });

        $parts->each(function ($part) {
            $part->validate();
        });

        $userData = $request->except(['_token']);

        // set default join group
        $joinGroup = $config->get('joinGroup');
        if ($joinGroup !== null) {
            $userData['group_id'] = [$joinGroup];
        }

        XeDB::beginTransaction();
        try {
            $user = $this->handler->create($userData);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        // login
        if (app('config')->get('xe.user.registrationAutoLogin') == true) {
            $this->auth->login($user);
        }

        return redirect()->intended(($this->redirectPath()));
    }

    /**
     * Indicate able to join
     *
     * @return boolean
     */
    protected function checkJoinable()
    {
        return XeConfig::getVal('user.register.joinable') === true;
    }

    /**
     * Show additional form for user.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getRegisterAddInfo()
    {
        $fields = $this->getAdditionalField();

        XeFrontend::rule('add-info', $fields->map(function ($field) {
            return $field->getRules();
        })->collapse()->all());

        $userData = array_merge(request()->all(), \Auth::user()->getAttributes());

        return XePresenter::make('register.add-info', compact('fields', 'userData'));
    }

    /**
     * Register additional information of user.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegisterAddInfo(Request $request)
    {
        $fields = $this->getAdditionalField();
        $rules =$fields->map(function ($field) {
            return $field->getRules();
        })->collapse();

        $inputs = $this->validate($request, $rules->all());

        $this->handler->update(auth()->user(), $inputs);

        return redirect($this->redirectPath());
    }

    /**
     * Returns additional dynamic fields
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getAdditionalField()
    {
        return collect(XeDynamicField::gets('user'))->filter(function ($field) {
            if (!$field->isEnabled()) {
                return false;
            }

            $rules = implode('|', $field->getRules());
            $rules = array_map('\Illuminate\Support\Str::snake', explode('|', $rules));

            return in_array('required', $rules);
        });
    }

    /**
     * Validate Email
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     * @throws Exception
     */
    public function validateEmail(Request $request)
    {
        $email = $request->input('email');
        $email = trim($email);
        $exceptId = $request->input('except_id', null);

        $valid = true;
        $message = 'xe::usableEmailAddress';

        try {
            $this->validate($request, [ 'email' => 'email' ]);

            // 인증 요청중인 이메일이 있는지 확인
            $useEmailConfirm = app('xe.config')->getVal('user.register.guard_forced') === true;
            if ($useEmailConfirm) {
                if ($request->user()->getPendingEmail() !== null) {
                    throw new PendingEmailAlreadyExistsException();
                }
            }

            // 존재하는 이메일이 있는지 확인
            try {
                $uniqueRule = Rule::unique('user', 'email');

                if (isset($input['except_id'])) {
                    $uniqueRule->ignore($exceptId);
                }

                $this->validate($request, [ 'email' => $uniqueRule ]);
            } catch (\Exception $e) {
                throw new EmailAlreadyExistsException();
            }
        } catch (EmailAlreadyExistsException $e) {
            $valid = false;
            $message = $e->getMessage();
        } catch (PendingEmailAlreadyExistsException $e) {
            $valid = false;
            $message = $e->getMessage();
        } catch (\Exception $e) {
            $valid = false;
            throw $e;
        }

        return XePresenter::makeApi(
            ['type' => 'success', 'message' => xe_trans($message), 'email' => $email, 'valid' => $valid]
        );
    }

    /**
     * Validate display name
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     * @throws Exception
     */
    public function validateDisplayName(Request $request)
    {
        $displayName = $request->get('display_name');
        $displayName = trim($displayName);
        $message = 'xe::usableDisplayName';

        $valid = true;
        try {
            $this->validate($request, [ 'display_name' => 'display_name' ]);

            // 존재하는 display_name이 있는지 확인
            try {
                $this->validate($request, [ 'display_name' => Rule::unique('user', 'display_name') ]);
            } catch (\Exception $e) {
                throw new DisplayNameAlreadyExistsException();
            }
        } catch (DisplayNameAlreadyExistsException $e) {
            $valid = false;
            $message = $e->getMessage();
        } catch (InvalidDisplayNameException $e) {
            $valid = false;
            $message = $e->getMessage();
        } catch (\Exception $e) {
            $valid = false;
            throw $e;
        }

        return XePresenter::makeApi(
            ['type' => 'success', 'message' => xe_trans($message), 'displayName' => $displayName, 'valid' => $valid]
        );
    }
}
