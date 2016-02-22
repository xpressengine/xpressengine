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
use Xpressengine\Member\EmailBroker;
use Xpressengine\Member\Entities\Database\MailEntity;
use Xpressengine\Member\Entities\Database\PendingMailEntity;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Member\Exceptions\PendingEmailAlreadyExistsException;
use Xpressengine\Member\Exceptions\DisplayNameAlreadyExistsException;
use Xpressengine\Member\Exceptions\InvalidConfirmationCodeException;
use Xpressengine\Member\Exceptions\MailAlreadyExistsException;
use Xpressengine\Member\Exceptions\PendingEmailNotExistsException;
use Xpressengine\Member\MemberHandler;
use Xpressengine\Member\Repositories\MailRepositoryInterface;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Support\Exceptions\InvalidArgumentException;

class MemberController extends Controller
{
    /**
     * @var \Xpressengine\Member\Repositories\MemberRepositoryInterface
     */
    protected $members;

    /**
     * @var \Xpressengine\Member\Repositories\GroupRepositoryInterface
     */
    protected $groups;

    /**
     * @var MailRepositoryInterface
     */
    protected $mails;

    /**
     * @var MemberHandler
     */
    protected $handler;

    /**
     * @var MemberEntityInterface
     */
    protected $member;

    public function __construct()
    {
        $this->handler = app('xe.member');
        $this->members = app('xe.members');
        $this->groups = app('xe.member.groups');
        $this->mails = app('xe.member.mails');
        $this->pendingMails = app('xe.member.pendingMails');
        $this->accounts = app('xe.member.accounts');

        $this->member = app('auth')->user();

        Theme::selectSiteTheme();
        Presenter::setSkin('member/settings');
        $this->middleware('auth');
    }

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
        $member = $this->member;

        $content = $selectedSection['content'];
        $tabContent = $content instanceof \Closure ? $content($member) : $content;

        app('xe.frontend')->css(
            [
                'assets/core/common/css/grid.css',
                'assets/core/common/css/form.css',
                'assets/core/member/setting.css',
                'assets/core/common/css/dropdown.css',
            ]
        )->load();

        app('xe.frontend')->js('assets/core/member/snb.js')->load();

        return Presenter::make('index', compact('member', 'menus', 'tabContent'));
    }


    public function updateDisplayName(Request $request)
    {
        $name = $request->get('name');
        $name = str_replace('  ', ' ', trim($name));

        $this->handler->validateDisplayName($name);

        $member = $request->user();

        $member->displayName = $name;

        $this->members->update($member);

        return Presenter::makeApi(
            ['type' => 'success', 'message' => 'success', 'displayName' => $name]
        );
    }


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

    public function updatePassword(Request $request)
    {

        $validate = \Validator::make(
            $request->all(),
            ['password' => 'required|confirmed']
        );

        $result = true;
        $message = 'success';
        $target = null;

        if ($validate->fails()) {
            $target = 'password';
            $result = false;
        }

        if($this->member->getAuthPassword() !== "") {

            $credentials = [
                'id' => $this->member->getId(),
                'password' => $request->get('current_password')
            ];

            if (Auth::validate($credentials) === false) {
                $message = '현재 비밀번호가 틀렸습니다.';
                $target = 'current_password';
                $result = false;
            }
        }

        // save password
        $this->member->password = \Hash::make($request->get('password'));
        $this->members->update($this->member);

        return Presenter::makeApi(
            ['type' => 'success', 'result' => $result, 'message' => $message, 'target' => $target]
        );
    }

    public function validatePassword(Request $request)
    {
        $password = $request->get('password');
        $password = trim($password);

        try {
            $secure = '';
            if ($this->handler->validatePassword($password)) {
                $levels = app('config')->get('xe.member.password.levels');

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


    /*public function getEdit()
    {
        $member = $this->member;

        // dynamic field
        $dynamicField = app('xe.dynamicField');
        $fieldTypes = $dynamicField->gets('member');
        return Presenter::make('edit', compact('member', 'fieldTypes'));
    }*/

    /*public function postEdit(Request $request)
    {
        $member = $this->member;

        $input = $request->except(
            'email',
            'displayName',
            'currentPassword',
            'password',
            'password_confirmation',
            '_token'
        );

        $rules = ['password' => 'confirmed'];

        // displayName
        if (!empty($request->get('displayName')) && $request->get('displayName') !== $member->displayName) {
            $input['displayName'] = $request->get('displayName');
            $rules['displayName'] = 'unique:member';
        }

        // email
        if ($request->get('email') !== $member->email) {
            $input['email'] = $request->get('email');
            $rules['email'] = 'email';
        }

        $this->validate($request, $rules);

        // password
        if (!empty($input['password'])) {
            if (Auth::validate(['id' => $member->getId(), 'password' => $request->get('currentPassword')]) !== true) {
                $e = new InvalidArgumentHttpException();
                $e->setMessage('현재 비밀번호가 일치하지 않습니다');
                throw $e;
            }
            $input['password'] = Hash::make($input['password']);
        }

        XeDB::beginTransaction();

        try {
            $member->fill(array_only($input, ['displayName', 'email', 'password']));
            $member = $this->members->update($member);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }

        XeDB::commit();

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '수정되었습니다.']);
    }*/

    public function updateMainMail(Request $request)
    {
        $address = $request->get('address');

        if ($this->member->email === $address) {
            $e = new InvalidArgumentException();
            $e->setMessage('기존 대표 이메일과 동일합니다.');
            throw $e;
        }

        $selected = null;
        foreach ($this->member->mails as $mail) {
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

        $this->member->email = $address;

        XeDB::beginTransaction();
        try {
            $this->members->update($this->member);
        } catch (\Exception $e) {
            XeDB::rollback();
        }
        XeDB::commit();

        \Session::flash('alert', ['type' => 'success', 'message' => '수정되었습니다.']);
        return Presenter::makeApi(['message' => '수정되었습니다']);
    }

    public function getMailList()
    {
        $member = $this->member;
        $mails = $member->mails;
        if ($mails === null) {
            $mails = $this->mails->fetchAll(['memberId' => $member->getId()]);
        } else {
            $mails = array_values($mails);
        }
        return Presenter::makeApi(['mails' => $mails]);
    }

    public function addMail(Request $request)
    {
        $input = $request->only('address');

        // validation
        $validate = \Validator::make(
            $request->all(),
            [
                'address' => 'email|required'
            ]
        );
        if ($validate->fails()) {
            $e = new InvalidArgumentException();
            $e->setMessage('이메일 형식이 잘못되었습니다.');
            throw $e;
        }

        // 이미 인증 요청중인 이메일이 있는지 확인한다.
        $useEmailConfirm = $this->handler->usingEmailConfirm();
        if ($useEmailConfirm) {
            if ($this->member->getPendingEmail() !== null) {
                throw new PendingEmailAlreadyExistsException();
            }
        }

        // 이미 존재하는 이메일이 있는지 확인한다.
        $exists = $this->mails->findByAddress($input['address']);
        if ($exists !== null) {
            throw new MailAlreadyExistsException();
        }

        array_set($input, 'memberId', $this->member->getId());
        XeDB::beginTransaction();
        try {
            if ($useEmailConfirm) {
                $mail = new PendingMailEntity($input);
                $mail = $this->pendingMails->insert($mail);

                /** @var EmailBroker $broker */
                $broker = app('xe.auth.email');
                $broker->sendEmailForConfirmation($mail);
            } else {
                $mail = new MailEntity($input);
                $mail = $this->mails->insert($mail);
            }
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        \Session::flash('alert', ['type' => 'success', 'message' => '추가되었습니다.']);
        return Presenter::makeApi(['message' => '추가되었습니다']);
    }

    public function confirmMail(Request $request)
    {
        $input = $request->get('code');
        $pendingMail = $this->member->getPendingEmail();

        if ($pendingMail === null) {
            throw new PendingEmailNotExistsException();
        }

        XeDB::beginTransaction();
        try {
            app('xe.auth.email')->confirmEmail($pendingMail->getAddress(), $input);
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

    public function resendPendingMail(Request $request)
    {
        $pendingMail = $this->member->getPendingEmail();

        if ($pendingMail === null) {
            throw new PendingEmailNotExistsException();
        }

        /** @var EmailBroker $broker */
        $broker = app('xe.auth.email');
        $broker->sendEmailForConfirmation($pendingMail);

        return Presenter::makeApi(['message' => '재전송하였습니다.']);
    }

    public function deleteMail(Request $request)
    {
        $input = $request->get('address');

        // 해당회원이 가진 이메일을 찾는다.
        $selected = null;
        foreach ($this->member->mails as $mail) {
            if ($mail->address === $input) {
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

        XeDB::beginTransaction();
        try {
            $this->mails->delete($selected);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return Presenter::makeApi(['message' => '삭제되었습니다.']);
    }

    public function deletePendingMail(Request $request)
    {
        $input = $request->get('address');

        // 해당회원이 가진 이메일을 찾는다.
        $selected = $this->member->getPendingEmail();


        // 해당회원이 가진 이메일이 아닐 경우 예외처리한다.
        if ($selected === null) {
            $e = new InvalidArgumentException();
            $e->setMessage('존재하지 않는 이메일입니다.');
            throw $e;
        }

        XeDB::beginTransaction();
        try {
            $this->pendingMails->delete($selected);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return Presenter::makeApi(['message' => '삭제되었습니다.']);
    }

    /*public function getLeave()
    {
        $member = $this->member;
        return \Presenter::make('leave', compact('member'));
    }*/

    public function leave(Request $request)
    {
        $confirm = $request->get('confirm_leave');

        if($confirm !== 'Y') {
            $e = new InvalidArgumentException();
            $e->setMessage('약관의 동의가 필요합니다.');
            throw $e;
        }

        $id = $this->member->getId();

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

    private function memberEditView(MemberEntityInterface $member)
    {

        // dynamic field
        $dynamicField = app('xe.dynamicField');
        $fieldTypes = $dynamicField->gets('member');

        // password configuration
        $passwordConfig = app('config')->get('xe.member.password');
        $passwordLevel = array_get($passwordConfig['levels'], $passwordConfig['default']);

        $useEmailConfirm = $this->handler->usingEmailConfirm();

        app('xe.frontend')->js('assets/core/member/settings.js')->load();

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
        return $skin->setView('edit')->setData(compact('member', 'fieldTypes', 'passwordLevel'));
    }
}
