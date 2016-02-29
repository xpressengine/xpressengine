<?php
namespace App\Http\Controllers\Member\Settings;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Input;
use Presenter;
use XeDB;
use Xpressengine\Member\Exceptions\EmailNotFoundException;
use Xpressengine\Member\Exceptions\MailAlreadyExistsException;
use Xpressengine\User\Rating;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserInterface;

class UserController extends Controller
{
    /**
     * @var UserHandler
     */
    protected $handler;

    /**
     * UserController constructor.
     *
     * @param UserHandler $handler
     */
    public function __construct(UserHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * index. show user list
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function index(Request $request)
    {
        $query = $this->handler->users()->query();

        // resolve group
        if ($group = $request->get('group')) {
            $query = $query->whereHas('groups', function(Builder $q) use ($group) {
                $q->where('id', $group);
            });
        }

        // resolve status
        if ($status = $request->get('status')) {
            $query = $query->where('status', $status);
        }

        // resolve search keyword
        // keyfield가 지정되지 않을 경우 email, displayName를 대상으로 검색함
        $field = $request->get('keyfield', 'email,displayName');
        $field = ($field === '') ? 'email,displayName' : $field;

        if ($keyword = $request->get('keyword')) {
            $query = $query->where(function(Builder $q) use ($field, $keyword) {
                foreach(explode(',',$field) as $f) {
                    $q->orWhere($f, 'like', '%'.$keyword.'%');
                };
            });
        }

        $users = $query->paginate();

        // get all groups
        $groups = $this->handler->groups()->all();

        $selectedGroup = null;
        if ($group !== null) {
            $selectedGroup = $this->handler->groups()->find($group);
        }
        return Presenter::make('member.settings.member.index', compact('users', 'groups', 'selectedGroup'));
    }

    /**
     * show user creation page
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
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

        $groupList = $this->handler->groups()->all();
        $groups = $this->getGroupInfo($groupList);

        $status = [
            ['value' => \XeUser::STATUS_ACTIVATED, 'text' => '승인됨'],
            ['value' => \XeUser::STATUS_DENIED, 'text' => '거절됨'],
        ];

        // dynamic field
        $dynamicField = app('xe.dynamicField');
        $fieldTypes = $dynamicField->gets('member');

        return Presenter::make('member.settings.member.create', compact('ratings', 'groups', 'status', 'fieldTypes'));
    }

    /**
     * store user
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'email' => 'email|required',
                'displayName' => 'required',
                'password' => 'required',
            ]
        );

        $userData = $request->except('_token');
        $userData['emailConfirmed'] = 1;

        XeDB::beginTransaction();
        try {
            $this->handler->create($userData);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return redirect()->route('settings.member.index')->with('alert', ['type' => 'success', 'message' => '추가되었습니다.']);
    }

    /**
     * show user editing page
     *
     * @param $id
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function edit($id)
    {

        $user = $this->handler->users()->with('groups', 'emails', 'accounts')->find($id);

        if ($user === null) {
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
            if ($rating === $user->rating) {
                $ratings[$key]['selected'] = 'selected';
            }
        }

        $groupList = $this->handler->groups()->all();
        $groups = $this->getGroupInfo($groupList);

        foreach($user->groups as $group) {
            $groups[$group->id]['checked'] = 'checked';
        }

        $status = [
            \XeUser::STATUS_ACTIVATED => ['value' => \XeUser::STATUS_ACTIVATED, 'text' => '승인됨'],
            \XeUser::STATUS_DENIED => ['value' => \XeUser::STATUS_DENIED, 'text' => '거절됨'],
        ];

        $status[$user->status]['selected'] = 'selected';

        // profileImage config
        $profileImgSize = config('xe.user.profileImage.size');

        // dynamic field
        $dynamicField = app('xe.dynamicField');
        $fieldTypes = $dynamicField->gets('user');

        $defaultAccount = null;
        if (isset($user->accounts)) {
            foreach ($user->accounts as $account) {
                if ($account->provider === \XeUser::PROVIDER_DEFAULT) {
                    $defaultAccount = $account;
                }
            }
        }
        return Presenter::make(
            'member.settings.member.edit',
            compact(
                'user',
                'ratings',
                'groups',
                'status',
                'defaultAccount',
                'fieldTypes',
                'profileImgSize'
            )
        );
    }

    /**
     * update user
     *
     * @param         $id
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function update($id, Request $request)
    {
        /** @var UserInterface $user */
        $user = $this->handler->users()->with('groups', 'emails', 'accounts')->find($id);

        if ($user === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage('존재하지 않는 회원입니다.');
            throw $e;
        }

        // default validation
        $this->validate(
            $request,
            [
                'email' => 'email',
                'displayName' => 'required',
                'rating' => 'required',
                'status' => 'required',
            ]
        );

        $userData = $request->except('_token');

        XeDB::beginTransaction();
        try {
            $this->handler->update($user, $userData);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '수정되었습니다.']);
    }

    /**
     * response user's email list
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function getMailList()
    {
        $id = Input::get('userId');
        if ($id === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage('회원 번호를 입력해야 합니다.');
            throw $e;
        }

        $mails = $this->handler->emails()->where(['userId' => $id])->get();

        return Presenter::makeApi(['mails' => $mails]);
    }

    /**
     * add email
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function postAddMail(Request $request)
    {
        $this->validate(
            $request,
            [
                'userId' => 'required',
                'address' => 'required|email'
            ]
        );

        $userId = $request->get('userId');
        $address = $request->get('address');

        if($this->handler->emails()->findByAddress($address)) {
            throw new MailAlreadyExistsException();
        }

        $user = $this->handler->users()->find($userId);

        XeDB::beginTransaction();
        try {
            $email = $this->handler->emails()->create($user, $request->only('address', 'userId'));
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();


        return Presenter::makeApi(['mail' => $email]);
    }

    /**
     * confirm email
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function postConfirmMail(Request $request)
    {
        $pendingEmail = $this->handler->pendingEmails()->find($request->get('id'));

        if ($pendingEmail === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage('존재하지 않거나 이미 승인된 이메일입니다.');
            throw $e;
        }

        $user = $pendingEmail->user;
        $address = $pendingEmail->address;

        XeDB::beginTransaction();
        try {
            // create pending email
            $email = $this->handler->emails()->create($user, compact('address'));

            // remove pending email
            $this->handler->pendingEmails()->delete($pendingEmail);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return Presenter::makeApi(['mail' => $email]);
    }

    /**
     * postDeleteMail
     *
     * @param Request $request
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function postDeleteMail(Request $request)
    {
        $this->validate(
            $request,
            [
                'userId' => 'required',
                'address' => 'required'
            ]
        );

        $address = $request->get('address');

        $mail = $this->handler->emails()->findByAddress($address);

        if($mail === null) {
            throw new EmailNotFoundException();
        }

        XeDB::beginTransaction();
        try {
            $this->handler->emails()->delete($mail);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return Presenter::makeApi(['type' => 'success', 'address' => $address]);
    }

    /**
     * delete user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function deleteMember()
    {
        $userIds = Input::get('id', []);

        XeDB::beginTransaction();
        try {
            $this->handler->leave($userIds);
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
     * @param null                      $keyword
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function searchMember($keyword = null)
    {
        $users = $this->handler->users();

        if ($keyword === null) {
            return Presenter::makeApi($users->paginate());
        }

        $matchedMemberList = $users->search(['displayName' => $keyword])->items();
        return Presenter::makeApi($matchedMemberList);
    }

    /**
     * getGroupInfo
     *
     * @param $groupList
     *
     * @return array
     */
    protected function getGroupInfo($groupList)
    {
        $groups = [];
        foreach ($groupList as $key => $group) {
            $groups[$group->id] = [
                'value' => $group->id,
                'text' => $group->name,
            ];
        }
        return $groups;

}
}
