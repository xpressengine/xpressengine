<?php
namespace App\Http\Controllers\Member\Settings;

use App\Http\Controllers\Controller;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Input;
use Intervention\Image\ImageManager;
use Member;
use Presenter;
use Validator;
use XeDB;
use Xpressengine\Media\MediaManager;
use Xpressengine\Media\Thumbnailer;
use Xpressengine\Member\Entities\Database\MailEntity;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Member\Exceptions\MailAlreadyExistsException;
use Xpressengine\Member\Exceptions\EmailNotFoundException;
use Xpressengine\Member\MemberHandler;
use Xpressengine\Member\MemberImageHandler;
use Xpressengine\Member\Rating;
use Xpressengine\Member\Repositories\AccountRepositoryInterface;
use Xpressengine\Member\Repositories\GroupRepositoryInterface;
use Xpressengine\Member\Repositories\MailRepositoryInterface;
use Xpressengine\Member\Repositories\MemberRepositoryInterface;
use Xpressengine\Member\Repositories\PendingMailRepositoryInterface;
use Xpressengine\Storage\Storage;
use Xpressengine\Support\Exceptions\InvalidArgumentException;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;

class MemberController extends Controller
{
    /**
     * @var MemberRepositoryInterface
     */
    protected $members;

    /**
     * @var GroupRepositoryInterface
     */
    protected $groups;

    /**
     * @var MailRepositoryInterface
     */
    protected $mails;

    /**
     * @var PendingMailRepositoryInterface
     */
    protected $pendingMails;

    /**
     * @var AccountRepositoryInterface
     */
    protected $accounts;

    /**
     * @var MemberHandler
     */
    protected $handler;

    public function __construct()
    {
        $this->members = app('xe.members');
        $this->accounts = app('xe.member.accounts');
        $this->groups = app('xe.member.groups');
        $this->mails = app('xe.member.mails');
        $this->pendingMails = app('xe.member.pendingMails');
        $this->handler = app('xe.member');
    }

    public function index(Request $request)
    {
        // todo: validate inputs!!

        $wheres = [];
        $searches = [];

        // resolve group
        if ($group = $request->get('group')) {
            array_set($wheres, 'groups', $group);
        }

        // resolve status
        if ($status = $request->get('status')) {
            array_set($wheres, 'status', $status);
        }

        // resolve search keyword
        // keyfield가 지정되지 않을 경우 email, customId에서 입력된 keyword를 검색함
        $field = $request->get('keyfield', 'email,displayName');
        $field = $field === '' ? 'email,displayName' : $field;
        if ($query = $request->get('keyword')) {
            $searches = [$field => $query];
        }

        $wheres = (count($wheres) === 0) ? null : $wheres;
        $searches = (count($searches) === 0) ? null : $searches;

        // get members
        if ($searches) {
            $members = $this->members->search($searches, $wheres, ['groups', 'accounts']);
        } elseif ($wheres) {
            $members = $this->members->fetch($wheres, ['groups', 'accounts']);
        } else {
            $members = $this->members->paginate(['groups', 'accounts']);
        }

        // get all groups
        $groups = $this->groups->all();

        $selectedGroup = null;
        if ($group !== null) {
            $selectedGroup = $this->groups->find($group);
        }
        return Presenter::make('member.settings.member.index', compact('members', 'groups', 'selectedGroup'));
    }

    public function create()
    {
        $ratings = Rating::getUsableAll();
        $ratingNames = [
            'member' => '일반',
            'manager' => '관리자',
            'super' => '최고관리자',
        ];

        foreach ($ratings as $key => $rating) {
            $ratings[$key] = [
                'value' => $rating,
                'text' => $ratingNames[$rating],
            ];
        }

        $groupEntities = $this->groups->all();
        $groups = [];
        foreach ($groupEntities as $key => $group) {
            $groups[$key] = [
                'value' => $group->id,
                'text' => $group->name,
            ];
        }

        $status = [
            ['value' => Member::STATUS_ACTIVATED, 'text' => '승인됨'],
            ['value' => Member::STATUS_DENIED, 'text' => '거절됨'],
        ];

        // dynamic field
        $dynamicField = app('xe.dynamicField');
        $fieldTypes = $dynamicField->gets('member');

        return Presenter::make('member.settings.member.create', compact('ratings', 'groups', 'status', 'fieldTypes'));
    }

    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'email' => 'email|required|unique:member_mails,address',
                'displayName' => 'required|unique:member',
                'password' => 'required',
            ]
        );

        $memberData = $request->except('_token');
        $memberData['emailConfirmed'] = 1;

        XeDB::beginTransaction();
        try {
            $this->handler->create($memberData);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return redirect()->route('settings.member.index')->with('alert', ['type' => 'success', 'message' => '추가되었습니다.']);
    }

    public function edit($id)
    {
        $member = $this->members->find($id, ['groups', 'mails', 'accounts']);

        if ($member === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage('존재하지 않는 회원입니다.');
            throw $e;
        }

        $ratings = Rating::getUsableAll();
        $ratingNames = [
            'member' => '일반',
            'manager' => '관리자',
            'super' => '최고관리자',
        ];
        foreach ($ratings as $key => $rating) {
            $ratings[$key] = [
                'value' => $rating,
                'text' => $ratingNames[$rating],
            ];
            if ($rating === $member->rating) {
                $ratings[$key]['selected'] = 'selected';
            }
        }

        $groupEntities = $this->groups->all();
        $groups = [];
        $joinedGroups = array_pluck($member->groups ?: [], 'id');
        foreach ($groupEntities as $key => $group) {
            $groups[$key] = [
                'value' => $group->id,
                'text' => $group->name,
            ];
            if (in_array($group->id, $joinedGroups)) {
                $groups[$key]['checked'] = 'checked';
            }
        }

        $status = [
            Member::STATUS_ACTIVATED => ['value' => Member::STATUS_ACTIVATED, 'text' => '승인됨'],
            Member::STATUS_DENIED => ['value' => Member::STATUS_DENIED, 'text' => '거부됨'],
        ];

        $status[$member->status]['selected'] = 'selected';

        // profileImage config
        $profileImgSize = config('xe.member.profileImage.size');

        // dynamic field
        $dynamicField = app('xe.dynamicField');
        $fieldTypes = $dynamicField->gets('member');

        $defaultAccount = null;
        if (isset($member->accounts)) {
            foreach ($member->accounts as $account) {
                if ($account->provider === Member::PROVIDER_DEFAULT) {
                    $defaultAccount = $account;
                }
            }
        }

        return Presenter::make(
            'member.settings.member.edit',
            compact(
                'member',
                'ratings',
                'groups',
                'status',
                'defaultAccount',
                'fieldTypes',
                'profileImgSize'
            )
        );
    }

    public function update($id, Request $request)
    {
        /** @var MemberEntityInterface $member */
        $member = $this->members->find($id, ['mails', 'groups']);

        if ($member === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage('존재하지 않는 회원입니다.');
            throw $e;
        }

        // default validation
        $validate = Validator::make(
            $request->all(),
            [
                'email' => 'email',
                'displayName' => 'required',
                'rating' => 'required',
                'status' => 'required',
            ]
        );
        if ($validate->fails()) {
            $messages = $validate->messages();
            $message = $messages->first();
            $e = new InvalidArgumentException();
            $e->setMessage($message);
            throw $e;
        }

        // display name validation
        $displayName = trim($request->get('displayName'));
        if ($member->getDisplayName() !== $displayName) {
            $this->handler->validateDisplayName($displayName);
        }

        $memberData = $request->except('groupId', 'profileImgFile', '_token');

        // encrypt password
        if (!empty($memberData['password'])) {
            $memberData['password'] = Hash::make($memberData['password']);
        } else {
            unset($memberData['password']);
        }

        if ($profileFile = $request->file('profileImgFile')) {
            /** @var MemberImageHandler $imageHandler */
            $imageHandler = app('xe.member.image');
            $memberData['profileImageId'] = $imageHandler->updateMemberProfileImage($member, $profileFile);
        }

        $inputtedGroup = $request->get('groupId', []);
        $currentGroups = array_pluck($member->groups ?: [], 'id');
        $newGroups = array_diff($inputtedGroup, $currentGroups);
        $oldGroups = array_diff($currentGroups, $inputtedGroup);

        XeDB::beginTransaction();

        try {
            $member->fill($memberData);
            $member = $this->members->update($member);

            // join to new group
            $newGroups = $this->groups->findAll($newGroups);
            foreach ($newGroups as $group) {
                $this->groups->addMember($group, $member);
            }

            // remove from old groups
            if ($member->groups !== null) {
                foreach ($member->groups as $group) {
                    if (in_array($group->id, $oldGroups)) {
                        $this->groups->exceptMember($group, $member);
                    }
                }
            };
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }

        XeDB::commit();

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '수정되었습니다.']);
    }

    public function getMailList()
    {
        $id = Input::get('memberId');
        if ($id === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage('회원 번호를 입력해야 합니다.');
            throw $e;
        }

        $mails = $this->mails->fetchAll(['memberId' => $id]);

        return Presenter::makeApi(['mails' => $mails]);
    }

    public function postAddMail(Request $request)
    {

        $validate = Validator::make(
            $request->all(),
            [
                'memberId' => 'required',
                'address' => 'required|email'
            ]
        );
        if ($validate->fails()) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage('잘못된 요청입니다.');
            throw $e;
        }

        $address = $request->get('address');

        if($this->handler->findMailByAddress($address)) {
            throw new MailAlreadyExistsException();
        }

        $mail = new MailEntity($request->only('address', 'memberId'));

        $mail = $this->handler->insertMail($mail);

        return Presenter::makeApi(['mail' => $mail]);
    }

    public function postConfirmMail()
    {
        $input = Input::only('id', 'confirm');
        $mail = $this->mails->find($input['id']);

        if ($mail === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage('존재하지 않는 이메일입니다.');
            throw $e;
        }

        $mail->confirmed = array_get($input, 'confirm', 1);
        $mail = $this->mails->update($mail);

        return Presenter::makeApi(['mail' => $mail]);
    }

    public function postDeleteMail(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'memberId' => 'required',
                'address' => 'required'
            ]
        );

        if($validate->fails()) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage('잘못된 요청입니다.');
            throw $e;
        }

        $address = $request->get('address');
        $memberId = $request->get('memberId');

        $mail = $this->handler->findMailByAddress($address);

        if($mail === null) {
            throw new EmailNotFoundException();
        }

        $result = $this->handler->deleteMail($mail);

        return Presenter::makeApi(['type' => 'success', 'address' => $address]);
    }

    public function deleteMember()
    {
        $memberIds = Input::get('id', []);

        XeDB::beginTransaction();
        try {
            $this->handler->leave($memberIds);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '삭제되었습니다.']);
    }

    /**
     * searchMember
     *
     * @param MemberRepositoryInterface $memberRepo
     * @param null                      $keyword
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function searchMember(MemberRepositoryInterface $memberRepo, $keyword = null)
    {

        if ($keyword === null) {
            return Presenter::makeApi($memberRepo->all());
        }

        $matchedMemberList = $memberRepo->search(['displayName' => $keyword])->items();
        return Presenter::makeApi($matchedMemberList);
    }
}
