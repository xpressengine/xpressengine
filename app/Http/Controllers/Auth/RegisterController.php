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
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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
use Xpressengine\User\Exceptions\InvalidConfirmationCodeException;
use Xpressengine\User\Exceptions\InvalidDisplayNameException;
use Xpressengine\User\Exceptions\PendingEmailAlreadyExistsException;
use Xpressengine\User\Models\User;
use Xpressengine\User\Repositories\RegisterTokenRepository;
use Xpressengine\User\TermsHandler;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserInterface;
use Xpressengine\User\UserRegisterHandler;

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
     * @var TermsHandler
     */
    protected $termsHandler;

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
        $this->termsHandler = app('xe.terms');

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
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getRegister(Request $request)
    {
        // 회원 가입 허용 검사
        if (!$this->checkJoinable()) {
            return redirect()->back()->with(
                ['alert' => ['type' => 'danger', 'message' => xe_trans('xe::joinNotAllowed')]]
            );
        }

        $request->session()->forget('user_agree_terms');

        //약관을 회원정보 입력 전에 받는 경우 처리
        $agreeType = app('xe.config')->getVal(
            'user.register.term_agree_type',
            UserRegisterHandler::TERM_AGREE_WITH
        );
        $terms = $this->termsHandler->fetchEnabled();

        $isAllRequireTermAgree = true;
        $requireTerms = $this->termsHandler->fetchRequireEnabled();
        foreach ($requireTerms as $requireTerm) {
            if ($request->has($requireTerm->id) === false) {
                $isAllRequireTermAgree = false;
                break;
            }
        }

        if ($agreeType === UserRegisterHandler::TERM_AGREE_PRE && count($terms) > 0 &&  //가입 정보 이전에 약관 동의 출력 여부
            (
                $isAllRequireTermAgree === false || //필수 조건이 있는데 선택 안했을 경우
                ($requireTerms->count() === 0 && $request->session()->has('pass_agree') === false))
                //약관에 선택 약관만 존재하는데 session에 약관 동의에 대한 데이터가 없을 경우
        ) {
            return \XePresenter::make('register.agreement', compact('terms'));
        }

        return $this->getRegisterForm($request);
    }

    /**
     * 회원가입시 회원정보 입력 전에 약관 동의를 진행 할 경우 validation 처리
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postTermAgree(Request $request)
    {
        $terms = $this->termsHandler->fetchRequireEnabled();

        $rule = [];
        foreach ($terms as $term) {
            $rule[$term->id] = 'bail|accepted';
        }

        $this->validate(
            $request,
            $rule,
            ['*.accepted' => xe_trans('xe::pleaseAcceptRequireTerms')]
        );

        $request->session()->flash('pass_agree');

        return redirect()->route('auth.register', $request->except('_token'));
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
        })->sortBy(function ($part, $key) use ($activated) {
            return array_search($key, $activated);
        })->map(function ($part) use ($request) {
            return new $part($request);
        });

        $rules = $parts->map(function ($part) {
            return $part->rules();
        })->collapse()->all();

        XeFrontend::rule('join', $rules);

        $userAgreeTerms = [];
        $enableTerms = $this->termsHandler->fetchEnabled();
        foreach ($enableTerms as $enableTerm) {
            if ($request->has($enableTerm->id) === true) {
                $userAgreeTerms[] = $enableTerm->id;
            }
        }

        if (count($userAgreeTerms) > 0) {
            $request->session()->put('user_agree_terms', $userAgreeTerms);
        }

        expose_trans('xe::passwordIncludeNumber');
        expose_trans('xe::passwordIncludeCharacter');
        expose_trans('xe::passwordIncludeSpecialCharacter');
        expose_trans('xe::enterPasswordConfirmation');

        return \XePresenter::make('register.create', compact('config', 'parts'));
    }

    /**
     * 회원가입시 이메일 인증 요청 처리
     *
     * @param Request                 $request         request
     * @param RegisterTokenRepository $tokenRepository RegisterTokenRepository instance
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     *
     * @deprecated since 3.0.8 회원가입 하기 전 이메일 인증 기능 삭제
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

        if ($request->session()->has('user_agree_terms') === true) {
            $userData['user_agree_terms'] = $request->session()->pull('user_agree_terms');
        } elseif ($request->has('agree') === true) {
            $enableTermIds = [];
            $enableTerms = $this->termsHandler->fetchEnabled();
            foreach ($enableTerms as $term) {
                $enableTermIds[] = $term->id;
            }

            $userData['user_agree_terms'] = $enableTermIds;
        }

        XeDB::beginTransaction();
        try {
            $user = $this->handler->create($userData);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        //이메일 인증 후 가입 옵션을 사용 했을 때 회원가입 후 인증 메일 발송
        if ($user->status === User::STATUS_PENDING_EMAIL) {
            $this->sendApproveEmail($user);
        }

        // login
        if (app('config')->get('xe.user.registrationAutoLogin') === true) {
            $this->auth->login($user);

            switch ($user->status) {
                case User::STATUS_PENDING_ADMIN:
                    return redirect()->route('auth.pending_admin');
                    break;

                case User::STATUS_PENDING_EMAIL:
                    return redirect()->route('auth.pending_email');
                    break;
            }
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
     * 링크를 통해서 회원가입 시 사용하는 인증 메일 발송
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getSendApproveEmail(Request $request)
    {
        $address = $request->get('email');
        $email = $this->handler->pendingEmails()->findByAddress($address);

        $user = $email->user;
        $this->handler->deleteEmail($email);

        $this->sendApproveEmail($user);

        return redirect('/')->with('alert', ['type' => 'success', 'message' => xe_trans('xe::msgEmailSendComplete')]);
    }

    /**
     * 회원가입 인증 메일 발송
     *
     * @param UserInterface $user userItem
     *
     * @return void
     */
    protected function sendApproveEmail(UserInterface $user)
    {
        $tokenRepository = app('xe.user.register.tokens');

        $mail = $this->handler->createEmail($user, ['address' => $user->email], false);
        $token = $tokenRepository->create('register', ['email' => $user->email, 'user_id' => $user->id]);
        $this->emailBroker->sendEmailForRegisterApprove($mail, $token);
    }

    /**
     * 이메일을 통해 회원가입 이메일 인증 처리
     *
     * @param Request                 $request         request
     * @param RegisterTokenRepository $tokenRepository register token repository
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function postApproveEmail(Request $request, RegisterTokenRepository $tokenRepository)
    {
        $tokenId = $request->get('token');
        if (!$token = $tokenRepository->find($tokenId)) {
            throw new HttpException(400, xe_trans('xe::msgTokenIsInvalid'));
        }

        $emailAddress = $token->email;
        $email = $this->handler->pendingEmails()->findByAddress($emailAddress);

        $code = $request->get('code');

        XeDB::beginTransaction();
        try {
            //이메일 승인 처리
            $this->emailBroker->approvalEmail($email, $code);

            //회원 상태 변경
            $user = $email->user;
            $this->handler->update($user, ['status' => User::STATUS_ACTIVATED]);

            //register token 삭제
            $tokenRepository->delete($tokenId);
        } catch (InvalidConfirmationCodeException $e) {
            XeDB::rollback();
            throw new HttpException(Response::HTTP_FORBIDDEN, xe_trans('xe::invalidConfirmationCode'), $e);
        } catch (Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return \XePresenter::make('confirm_email', compact('user'));
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
        $valid = true;
        $message = 'xe::usableDisplayName';
        $displayName = trim($request->get('display_name'));

        try {
            $this->handler->validateDisplayName($displayName);
        } catch (ValidationException $exception) {
            $valid = false;
            $message = Arr::first($exception->errors()['display_name']);
        } catch (\Exception $exception) {
            throw $exception;
        }

        return XePresenter::makeApi(
            ['type' => 'success', 'message' => xe_trans($message), 'displayName' => $displayName, 'valid' => $valid]
        );
    }

    /**
     * validate login id
     *
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function validateLoginId(Request $request)
    {
        $valid = true;
        $message = 'xe::usableLoginId';
        $loginId = trim($request->input('login_id'));

        try {
            $this->validate($request, [
                'login_id' => ['login_id', Rule::unique('user', 'login_id')]
            ]);
        }

        catch (ValidationException $exception) {
            $valid = false;
            $message = Arr::first($exception->errors()['login_id']);
        }

        catch (\Exception $e) {
            throw $e;
        }

        return XePresenter::makeApi(
            ['type' => 'success', 'message' => xe_trans($message), 'login_id' => $loginId, 'valid' => $valid]
        );
    }
}
