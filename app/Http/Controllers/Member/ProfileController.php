<?php
namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Presenter;
use Theme;
use XeDB;
use Xpressengine\User\Exceptions\MemberNotFoundException;
use Xpressengine\User\Rating;
use Xpressengine\User\Repositories\UserEmailRepositoryInterface;
use Xpressengine\User\Repositories\UserGroupRepositoryInterface;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserImageHandler;
use Xpressengine\User\UserInterface;

class ProfileController extends Controller
{
    /**
     * @var UserHandler
     */
    protected $handler;

    /**
     * @var UserGroupRepositoryInterface
     */
    protected $groups;

    /**
     * @var UserEmailRepositoryInterface
     */
    protected $mails;

    protected $skin;

    public function __construct()
    {
        $this->handler = app('xe.user');

        Theme::selectSiteTheme();
        Presenter::setSkin('member/profile');
    }

    // 기본정보 보기
    public function index($user)
    {
        $user = $this->retreiveUser($user);
        $grant = $this->getGrant($user);

        return Presenter::make('index', compact('user', 'grant'));
    }

    public function update($userId, Request $request)
    {
        // basic validation
        $this->validate(
            $request,
            [
                'displayName' => 'required',
            ]
        );

        // member validation
        /** @var UserInterface $user */
        $user = $this->handler->users()->find($userId);
        if ($user === null) {
            throw new MemberNotFoundException();
        }

        $displayName = $request->get('displayName');
        $introduction = $request->get('introduction');

        // displayName validation
        if ($user->getDisplayName() !== trim($displayName)) {
            $this->handler->validateDisplayName($displayName);
        }

        XeDB::beginTransaction();
        try {
            // resolve profile file
            if ($profileFile = $request->file('profileImgFile')) {
                /** @var UserImageHandler $imageHandler */
                $imageHandler = app('xe.user.image');
                $user->profileImageId = $imageHandler->updateUserProfileImage($user, $profileFile);
            }

            $this->handler->update($user, compact('displayName', 'introduction'));

        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return redirect()->route('member.profile', [$user->getId()])->with(
            'alert',
            [
                'type' => 'success',
                'message' => '변경되었습니다.'
            ]
        );
    }

    /**
     * retreiveMember
     *
     * @param $id
     *
     * @return mixed
     */
    protected function retreiveUser($id)
    {
        $member = $this->handler->users()->find($id);
        if ($member === null) {
            $member = $this->handler->users()->where(['displayName' => $id]);
        }

        if ($member === null) {
            throw new MemberNotFoundException();
        }

        return $member;
    }

    /**
     * getGrant
     *
     * @param $member
     *
     * @return array
     */
    protected function getGrant($member)
    {
        $logged = Auth::user();

        $grant = [
            'modify' => false,
            'manage' => false
        ];
        if ($logged->getId() === $member->getId()) {
            $grant['modify'] = true;
        }

        if (Rating::compare($logged->getRating(), Rating::MANAGER) >= 0) {
            $grant['manage'] = true;
            $grant['modify'] = true;
            return $grant;
        }
        return $grant;
    }
}
