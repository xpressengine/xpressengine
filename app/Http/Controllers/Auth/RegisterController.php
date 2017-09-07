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
use Xpressengine\User\EmailBrokerInterface;
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
     * @var EmailBrokerInterface
     */
    protected $emailBroker;

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
     * @return \Illuminate\Http\Response
     */
    public function getRegister(Request $request, RegisterTokenRepository $tokenRepository)
    {
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

        $tokenId = $request->get('token');
        $tokenRepository = app('xe.user.register.tokens');

        $register_token = null;
        if ($tokenId !== null) {
            $register_token = $tokenRepository->find($tokenId);
            if ($register_token === null) {
                throw new HttpException(400, '유효기간이 만료되었거나 정상적인 토큰이 아닙니다. 다시 인증 받으시기 바랍니다.');
            }
        }

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
            'displayName' => 'required',
            'password' => 'confirmed|password',
            'agree' => 'required|accepted',
            'register_token' => 'required'
        ];

        /** @var \Xpressengine\DynamicField\ConfigHandler $dynamicFieldConfigHandler */
        $dynamicFieldConfigHandler = XeDynamicField::getConfigHandler();
        $dynamicFieldConfigs = $dynamicFieldConfigHandler->gets('user');
        /** @var \Xpressengine\Config\ConfigEntity $dynamicFieldConfig */
        foreach ($dynamicFieldConfigs as $dynamicFieldConfig) {
            /** @var \Xpressengine\DynamicField\AbstractType $type */
            $rules = array_merge($rules, XeDynamicField::getRules($dynamicFieldConfig));
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
                $mailData = ['address' => $email, 'userId' => app('xe.keygen')->generate()];
                $user = new User();
                $user->id = $mailData['userId'];
                $mail = $this->handler->createEmail($user, $mailData, false);
            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }
            \DB::commit();
        }

        $token = $tokenRepository->create('email', ['email' => $email, 'userId' => $mail->userId]);
        $this->emailBroker->sendEmailForRegister(
            $mail,
            $token,
            'emails.register',
            function ($m) {
                $m->subject(
                    xe_trans(app('xe.site')->getSiteConfig()->get('site_title')).' '.xe_trans('xe::emailConfirm')
                );
            }
        );

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
            'displayName' => 'required',
            'password' => 'confirmed|password',
            'agree' => 'required|accepted',
            'register_token' => 'required'
        ];

        /** @var \Xpressengine\DynamicField\ConfigHandler $dynamicFieldConfigHandler */
        $dynamicFieldConfigHandler = XeDynamicField::getConfigHandler();
        $dynamicFieldConfigs = $dynamicFieldConfigHandler->gets('user');
        /** @var \Xpressengine\Config\ConfigEntity $dynamicFieldConfig */
        foreach ($dynamicFieldConfigs as $dynamicFieldConfig) {
            /** @var \Xpressengine\DynamicField\AbstractType $type */
            $rules = array_merge($rules, XeDynamicField::getRules($dynamicFieldConfig));
        }

        $this->validate($request, $rules);

        $tokenId = $request->get('register_token');
        $token = $tokenRepository->find($tokenId);

        if ($token === null) {
            throw new HttpException(400, '잘못된 가입 토큰입니다.');
        }

        $userData = $request->all();

        // set default join group
        $config = app('xe.config')->get('user.join');
        $joinGroup = $config->get('joinGroup');
        if ($joinGroup !== null) {
            $userData['groupId'] = [$joinGroup];
        }

        $userData['rating'] = Rating::MEMBER;
        $userData['status'] = \XeUser::STATUS_ACTIVATED;

        XeDB::beginTransaction();
        try {
            $user = $this->handler->create($userData, $token);
            $tokenRepository->delete($tokenId);
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
