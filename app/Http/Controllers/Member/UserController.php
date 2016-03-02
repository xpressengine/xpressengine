<?php
namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Presenter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Theme;
use XeDB;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Support\Exceptions\HttpXpressengineException;
use Xpressengine\Support\Exceptions\InvalidArgumentException;
use Xpressengine\User\EmailBroker;
use Xpressengine\User\Exceptions\DisplayNameAlreadyExistsException;
use Xpressengine\User\Exceptions\InvalidConfirmationCodeException;
use Xpressengine\User\Exceptions\MailAlreadyExistsException;
use Xpressengine\User\Exceptions\PendingEmailAlreadyExistsException;
use Xpressengine\User\Exceptions\PendingEmailNotExistsException;
use Xpressengine\User\Repositories\PendingEmailRepositoryInterface;
use Xpressengine\User\Repositories\UserAccountRepositoryInterface;
use Xpressengine\User\Repositories\UserEmailRepositoryInterface;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserInterface;

class UserController extends Controller
{
    /**
     * @var \Xpressengine\User\Repositories\UserRepositoryInterface
     */
    protected $users;

    /**
     * @var \Xpressengine\User\Repositories\UserGroupRepositoryInterface
     */
    protected $groups;

    /**
     * @var UserEmailRepositoryInterface
     */
    protected $mails;

    /**
     * @var UserHandler
     */
    protected $handler;

    /**
     * @var UserInterface logged user
     */
    protected $user;

    /**
     * @var PendingEmailRepositoryInterface
     */
    protected $pendingMails;

    /**
     * @var UserAccountRepositoryInterface
     */
    protected $accounts;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->handler = app('xe.user');
        $this->users = app('xe.users');
        $this->groups = app('xe.user.groups');
        $this->mails = app('xe.user.emails');
        $this->pendingMails = app('xe.user.pendingEmails');
        $this->accounts = app('xe.user.accounts');

        $this->user = app('auth')->user();

        Theme::selectSiteTheme();
        Presenter::setSkin('member/settings');
        $this->middleware('auth');
    }

    /**
     * show
     *
     * @param Request $request
     * @param string  $section
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function show(Request $request, $section = 'settings')
    {
        // remove & move code
        $settingsSection = [
            'settings' => [
                'title' => xe_trans('xe::defaultSettings'),
                'content' => function ($member) {
                    return $this->memberEditView($member);
                }
            ]
        ];

        // get sections
        $menus = $this->handler->getSettingsSections();

        // add default settings section
        $menus = array_merge($settingsSection, $menus);

        // get Selected section
        if(isset($menus[$section]) === false) {
            throw new NotFoundHttpException();
        }
        $selectedSection = $menus[$section];
        if ($selectedSection === null) {
            $selectedSection = reset($menus);
        }

        // get current member
        $user = $this->user;

        $content = $selectedSection['content'];
        $tabContent = $content instanceof \Closure ? $content($user) : $content;

        app('xe.frontend')->css(
            [
                'assets/common/css/grid.css',
                'assets/common/css/form.css',
                'assets/member/setting.css',
                'assets/common/css/dropdown.css',
            ]
        )->load();

        app('xe.frontend')->js('assets/member/snb.js')->load();

        return Presenter::make('index', compact('user', 'menus', 'tabContent'));
    }


    /**
     * update DisplayName
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function updateDisplayName(Request $request)
    {
        $displayName = $request->get('name');
        $displayName = str_replace('  ', ' ', trim($displayName));

        $user = $this->user;

        XeDB::beginTransaction();
        try {
            $user = $this->handler->update($user, compact('displayName'));
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return Presenter::makeApi(
            ['type' => 'success', 'message' => 'success', 'displayName' => $displayName]
        );
    }


    /**
     * validate DisplayName
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     * @throws Exception
     */
    public function validateDisplayName(Request $request)
    {
        $name = $request->get('name');
        $name = trim($name);

        $valid = true;
        try {
            $this->handler->validateDisplayName($name);
            $message = '사용 가능한 이름입니다.';
        } catch (DisplayNameAlreadyExistsException $e) {
            $valid = false;
            $message = $e->getMessage();
        } catch (InvalidArgumentException $e) {
            $valid = false;
            $message = $e->getMessage();
        } catch (\Exception $e) {
            throw $e;
        }

        return Presenter::makeApi(
            ['type' => 'success', 'message' => $message, 'displayName' => $name, 'valid' => $valid]
        );
    }

    /**
     * update Password
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function updatePassword(Request $request)
    {

        $this->validate(
            $request,
            ['password' => 'required|confirmed']
        );

        $result = true;
        $message = 'success';
        $target = null;

        if($this->user->getAuthPassword() !== "") {

            $credentials = [
                'id' => $this->user->getId(),
                'password' => $request->get('current_password')
            ];

            if (Auth::validate($credentials) === false) {
                $message = '현재 비밀번호가 틀렸습니다.';
                $target = 'current_password';
                $result = false;
            }
        }

        $password = $request->get('password');

        try {
            $this->handler->validatePassword($password);
        } catch(Exception $e) {
            $e = new HttpXpressengineException();
            $e->setMessage('비밀번호 보안수준을 만족하지 못했습니다.');
            throw $e;
        }

        XeDB::beginTransaction();
        try {
            // save password
            $password = \Hash::make($password);
            $this->users->update($this->user, compact('password'));
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();


        return Presenter::makeApi(
            ['type' => 'success', 'result' => $result, 'message' => $message, 'target' => $target]
        );
    }

    /**
     * validate Password
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function validatePassword(Request $request)
    {
        $password = $request->get('password');
        $password = trim($password);

        try {
            $secure = '';
            if ($this->handler->validatePassword($password)) {
                $levels = app('config')->get('xe.user.password.levels');

                foreach ($levels as $key => $level) {
                    $validate = $level['validate'];
                    if ($validate($password)) {
                        $secure = $key;
                    }
                }
            }
            return Presenter::makeApi(
                ['type' => 'success', 'message' => 'success', 'valid' => true, 'level' => $secure]
            );
        } catch (\Exception $e) {
            return Presenter::makeApi(
                ['type' => 'success', 'message' => $e->getMessage(), 'valid' => false]
            );
        }
    }

    /**
     * update user's main email address
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function updateMainMail(Request $request)
    {
        $address = $request->get('address');

        if ($this->user->email === $address) {
            $e = new InvalidArgumentException();
            $e->setMessage('기존 대표 이메일과 동일합니다.');
            throw $e;
        }

        $selected = null;
        foreach ($this->user->emails as $mail) {
            if ($mail->address === $address) {
                $selected = $mail;
                break;
            }
        }

        // 해당회원이 가진 이메일이 아닐 경우 예외처리한다.
        if ($selected === null) {
            $e = new InvalidArgumentException();
            $e->setMessage('존재하지 않는 이메일입니다.');
            throw $e;
        }

        $this->user->email = $address;

        XeDB::beginTransaction();
        try {
            $this->users->update($this->user);
        } catch (\Exception $e) {
            XeDB::rollback();
        }
        XeDB::commit();

        \Session::flash('alert', ['type' => 'success', 'message' => '수정되었습니다.']);
        return Presenter::makeApi(['message' => '수정되었습니다']);
    }

    public function getMailList()
    {
        $user = $this->user;
        $mails = $user->mails;
        if ($mails === null) {
            $mails = $this->mails->fetchAll(['memberId' => $user->getId()]);
        } else {
            $mails = array_values($mails);
        }
        return Presenter::makeApi(['mails' => $mails]);
    }

    /**
     * add email
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     * @throws Exception
     */
    public function addMail(Request $request)
    {
        $input = $request->only('address');

        // validation
        $this->validate(
            $request,
            [
                'address' => 'email|required'
            ]
        );

        // 이미 인증 요청중인 이메일이 있는지 확인한다.
        $useEmailConfirm = $this->handler->usingEmailConfirm();
        if ($useEmailConfirm) {
            if ($this->user->getPendingEmail() !== null) {
                throw new PendingEmailAlreadyExistsException();
            }
        }

        // 이미 존재하는 이메일이 있는지 확인한다.
        if($this->mails->findByAddress($input['address'])) {
            throw new MailAlreadyExistsException();
        }

        //array_set($input, 'userId', $this->user->getId());
        XeDB::beginTransaction();
        try {
            $mail = $this->handler->createEmail($this->user, $input, !$useEmailConfirm);

            if ($useEmailConfirm) {
                /** @var EmailBroker $broker */
                $broker = app('xe.auth.email');
                $broker->sendEmailForConfirmation($mail);
            }
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        \Session::flash('alert', ['type' => 'success', 'message' => '추가되었습니다.']);
        return Presenter::makeApi(['message' => '추가되었습니다']);
    }

    /**
     * confirm email
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     * @throws Exception
     */
    public function confirmMail(Request $request)
    {
        $code = $request->get('code');
        $pendingMail = $this->user->getPendingEmail();

        if ($pendingMail === null) {
            throw new PendingEmailNotExistsException();
        }

        XeDB::beginTransaction();
        try {
            app('xe.auth.email')->confirmEmail($pendingMail, $code);
        } catch (InvalidConfirmationCodeException $e) {
            $e = new InvalidArgumentException();
            $e->setMessage('잘못된 인증 코드입니다. 인증 코드를 확인하시고 다시 입력해주세요.');
            throw $e;
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        \Session::flash('alert', ['type' => 'success', 'message' => '인증되었습니다.']);
        return Presenter::makeApi(['message' => '인증되었습니다.']);
    }

    /**
     * resend pending email
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function resendPendingMail(Request $request)
    {
        $pendingMail = $this->user->getPendingEmail();

        if ($pendingMail === null) {
            throw new PendingEmailNotExistsException();
        }

        /** @var EmailBroker $broker */
        $broker = app('xe.auth.email');
        $broker->sendEmailForConfirmation($pendingMail);

        return Presenter::makeApi(['message' => '재전송하였습니다.']);
    }

    /**
     * delete email
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     * @throws Exception
     */
    public function deleteMail(Request $request)
    {
        $address = $request->get('address');

        // 해당회원이 가진 이메일을 찾는다.
        $selected = null;

        $pendingEmail = $this->user->getPendingEmail();
        if($pendingEmail !== null && $pendingEmail->getAddress() === $address) {
            $selected = $pendingEmail;
        } else {
            foreach ($this->user->emails as $mail) {
                if ($mail->address === $address) {
                    $selected = $mail;
                    break;
                }
            }
        }

        // 해당회원이 가진 이메일이 아닐 경우 예외처리한다.
        if ($selected === null) {
            $e = new InvalidArgumentException();
            $e->setMessage('존재하지 않는 이메일입니다.');
            throw $e;
        }

        XeDB::beginTransaction();
        try {
            $this->handler->deleteEmail($selected);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return Presenter::makeApi(['message' => '삭제되었습니다.']);
    }

    /**
     * delete user's pending email
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     * @throws Exception
     */
    public function deletePendingMail(Request $request)
    {
        return $this->deleteMail($request);
    }

    /**
     * leave
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function leave(Request $request)
    {
        $confirm = $request->get('confirm_leave');

        if($confirm !== 'Y') {
            $e = new InvalidArgumentException();
            $e->setMessage('약관의 동의가 필요합니다.');
            throw $e;
        }

        $id = $this->user->getId();

        XeDB::beginTransaction();
        try {
            $this->handler->leave($id);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        Auth::logout();

        return redirect()->to('/');
    }

    /**
     * show user info page
     *
     * @param UserInterface $user
     *
     * @return $this
     */
    private function memberEditView(UserInterface $user)
    {
        // dynamic field
        $dynamicField = app('xe.dynamicField');
        $fieldTypes = $dynamicField->gets('member');

        // password configuration
        $passwordConfig = app('config')->get('xe.user.password');
        $passwordLevel = array_get($passwordConfig['levels'], $passwordConfig['default']);

        $useEmailConfirm = $this->handler->usingEmailConfirm();

        app('xe.frontend')->js('assets/member/settings.js')->load();

        app('xe.frontend')->html('member.settings.loadScript')->content(
            "<script>
            XE.$(function () {
                $('.__xe_setting.__xe_settingDisplayName').xeDisplayNameSetting({
                    checkUrl: '".route('member.settings.name.check')."',
                    saveUrl: '".route('member.settings.name.update')."'
                });
                $('.__xe_setting.__xe_settingPassword').xePasswordSetting({
                    checkUrl: '".route('member.settings.password.check')."',
                    saveUrl: '".route('member.settings.password.update')."'
                });
                $('.__xe_setting.__xe_settingEmail').xeEmailSetting({
                    addUrl: '".route('member.settings.mail.add')."',
                    saveUrl: '".route('member.settings.mail.update')."',
                    deleteUrl: '".route('member.settings.mail.delete')."',
                    confirmUrl: '".route('member.settings.mail.confirm')."',
                    deletePendingUrl: '".route('member.settings.pending_mail.delete')."',
                    resendPendingUrl: '".route('member.settings.pending_mail.resend')."',
                    useEmailConfirm: ".($useEmailConfirm ? 'true' : 'false')."
                });
                $('.__xe_setting.__xe_settingLeave').xeLeaveSetting({
                    saveUrl: '".route('member.settings.leave')."'
                });
            });
            </script>"
        )->appendTo('body')->load();

        /** @var SkinHandler $skinHandler */
        $skinHandler = app('xe.skin');
        $skin = $skinHandler->getAssigned('member/settings');
        return $skin->setView('edit')->setData(compact('user', 'fieldTypes', 'passwordLevel'));
    }
}
