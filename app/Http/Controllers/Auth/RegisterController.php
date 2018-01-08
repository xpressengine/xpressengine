<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XeDB;
use XeDynamicField;
use XeFrontend;
use XePresenter;
use XeTheme;
use Xpressengine\User\EmailBroker;
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
     * @var EmailBroker
     */
    protected $emailBroker;

    protected $redirectTo = '/';

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
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister(Request $request)
    {
        // 회원 가입 허용 검사
        if (!$this->checkJoinable()) {
            return redirect()->back()->with(
                ['alert' => ['type' => 'danger', 'message' => xe_trans('xe::joinNotAllowed')]]
            );
        }

        $config = app('xe.config')->get('user.join');

        // 가입 인증을 사용하지 않을 경우, 곧바로 회원가입 폼 출력
        if (!$config->get('guard_forced', false)) {
            return $this->getRegisterForm($request);
        }

        // token 검사, token이 존재할 경우 form을 출력
        $token = $request->get('token');
        if ($token !== null) {
            return $this->getRegisterForm($request);
        }

        // 활성화된 인증방식 가져오기
        $allGuards = $this->handler->getRegisterGuards();
        $activated = $config->get('guards', []);
        $guards = [];

        foreach ($activated as $id) {
            if (array_has($allGuards, $id)) {
                $guards[$id] = $allGuards[$id];
                $guards[$id]['activated'] = true;
                unset($allGuards[$id]);
            }
        }
        foreach ($allGuards as $id => $guard) {
            $guards[$id] = $guard;
            $guards[$id]['activated'] = false;
        }

        return \XePresenter::make('register.index', compact('config', 'guards'));
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

        // 인증 토큰 검사
        $tokenId = $request->get('token');
        $tokenRepository = app('xe.user.register.tokens');
        $register_token = null;
        if ($tokenId !== null) {
            $register_token = $tokenRepository->find($tokenId);
            if ($register_token === null) {
                throw new HttpException(400, '유효기간이 만료되었거나 정상적인 토큰이 아닙니다. 다시 인증 받으시기 바랍니다.');
            }
        }

        // 활성화된 가입폼 가져오기
        $allForms = $this->handler->getRegisterForms();
        $activated = $config->get('forms', []);
        $forms = [];

        foreach ($activated as $id) {
            if (array_has($allForms, $id)) {
                $forms[$id] = $allForms[$id];
                $forms[$id]['activated'] = true;
                unset($allForms[$id]);
            }
        }
        foreach ($allForms as $id => $form) {
            $forms[$id] = $form;
            $forms[$id]['activated'] = false;
        }

        $rules = [
            'email' => 'email',
            'display_name' => 'required',
            'password' => 'confirmed|password',
            'agree' => 'required|accepted',
//            'register_token' => 'required'
        ];

        /** @var \Xpressengine\DynamicField\ConfigHandler $dynamicFieldConfigHandler */
        $dynamicFieldConfigHandler = XeDynamicField::getConfigHandler();
        $dynamicFieldConfigs = $dynamicFieldConfigHandler->gets('user');
        /** @var \Xpressengine\Config\ConfigEntity $dynamicFieldConfig */
        foreach ($dynamicFieldConfigs as $dynamicFieldConfig) {
            if ($dynamicFieldConfig->get('use') == true) {
                $rules = array_merge($rules, XeDynamicField::getRules($dynamicFieldConfig));
            }

        }

        XeFrontend::rule('join', $rules);

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
        $this->validate(
            $request,
            [
                'email' => 'required|email'
            ]
        );

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
            ['alert' => ['type' => 'success', 'message' => '인증 이메일이 전송되었습니다.']]
        );
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
        if (!$this->checkJoinable()) {
            return redirect()->back()->with(
                ['alert' => ['type' => 'danger', 'message' => xe_trans('xe::joinNotAllowed')]]
            );
        }

        $this->checkCaptcha();

        $rules = [
            'email' => 'email',
            'display_name' => 'required',
            'password' => 'confirmed|password',
            'agree' => 'required|accepted',
//            'register_token' => 'required'
        ];

        /** @var \Xpressengine\DynamicField\ConfigHandler $dynamicFieldConfigHandler */
        $dynamicFieldConfigHandler = XeDynamicField::getConfigHandler();
        $dynamicFieldConfigs = $dynamicFieldConfigHandler->gets('user');
        /** @var \Xpressengine\Config\ConfigEntity $dynamicFieldConfig */
        foreach ($dynamicFieldConfigs as $dynamicFieldConfig) {
            if ($dynamicFieldConfig->get('use') == true) {
                $rules = array_merge($rules, XeDynamicField::getRules($dynamicFieldConfig));
            }
        }

        $this->validate($request, $rules);

        // 인증토큰 조회
        $tokenId = $request->get('register_token');
        $token = null;
        if ($tokenId) {
            $token = $tokenRepository->find($tokenId);
        }
        if ($tokenId && $token === null) {
            throw new HttpException(400, '잘못된 가입 토큰입니다.');
        }

        $config = app('xe.config')->get('user.join');

        //  가입인증을 사용하지만 인증토큰이 유효하지 않을 경우 검사
        if ($config->get('guard_forced', false) && $token === null) {
            throw new HttpException(400, '가입 토큰이 없거나 잘못된 가입 토큰입니다.');
        }

        $userData = $request->all();

        // set default join group
        $joinGroup = $config->get('joinGroup');
        if ($joinGroup !== null) {
            $userData['group_id'] = [$joinGroup];
        }

        $userData['rating'] = Rating::MEMBER;
        $userData['status'] = \XeUser::STATUS_ACTIVATED;

        XeDB::beginTransaction();
        try {
            $user = $this->handler->create($userData, $token);
            if ($token !== null) {
                $tokenRepository->delete($tokenId);
            }
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

    protected function checkCaptcha()
    {
        $config = app('xe.config')->get('user.join');
        if (in_array('captcha', $config->get('forms', []))) {
            if (app('xe.captcha')->verify() !== true) {
                throw new HttpException(Response::HTTP_FORBIDDEN, '자동인증방지 기능을 통과하지 못하였습니다.');
            }
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
