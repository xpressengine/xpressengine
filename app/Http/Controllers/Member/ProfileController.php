<?php
namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Presenter;
use Theme;
use Validator;
use XeDB;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Member\MemberHandler;
use Xpressengine\Member\MemberImageHandler;
use Xpressengine\Member\MemberNotFoundException;
use Xpressengine\Member\Rating;
use Xpressengine\Member\Repositories\GroupRepositoryInterface;
use Xpressengine\Member\Repositories\MailRepositoryInterface;
use Xpressengine\Support\Exceptions\InvalidArgumentException;

class ProfileController extends Controller
{
    /**
     * @var MemberHandler
     */
    protected $handler;

    /**
     * @var GroupRepositoryInterface
     */
    protected $groups;

    /**
     * @var MailRepositoryInterface
     */
    protected $mails;

    protected $skin;

    public function __construct()
    {
        $this->handler = app('xe.member');

        Theme::selectSiteTheme();
        Presenter::setSkin('member/profile');
    }

    // 기본정보 보기
    public function index($member)
    {
        $member = $this->retreiveMember($member);
        $grant = $this->getGrant($member);

        return Presenter::make('index', compact('member', 'grant'));
    }

    public function update($memberId, Request $request)
    {
        // basic validation
        $validate = Validator::make(
            $request->all(),
            [
                'displayName' => 'required',
            ]
        );
        if ($validate->fails()) {
            $message = $validate->messages()->first();
            $e = new InvalidArgumentException();
            $e->setMessage($message);
            throw $e;
        }

        // member validation
        /** @var MemberEntityInterface $member */
        $member = $this->handler->findMember($memberId);
        if ($member === null) {
            throw new MemberNotFoundException();
        }

        $displayName = $request->get('displayName');
        $introduction = $request->get('introduction');

        // displayName validation
        if ($member->getDisplayName() !== trim($displayName)) {
            $this->handler->validateDisplayName($displayName);
        }

        // apply updated
        $member->displayName = $displayName;
        if($introduction !== null) {
            $member->introduction = $introduction;
        }

        XeDB::beginTransaction();
        try {
            // resolve profile file
            if ($profileFile = $request->file('profileImgFile')) {
                /** @var MemberImageHandler $imageHandler */
                $imageHandler = app('xe.member.image');
                $member->profileImageId = $imageHandler->updateMemberProfileImage($member, $profileFile);
            }

            $this->handler->update($member);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return redirect()->route('member.profile', [$member->getId()])->with(
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
    protected function retreiveMember($id)
    {
        $member = $this->handler->find($id, ['groups', 'accounts', 'mails']);
        if ($member === null) {
            $member = $this->handler->fetchOneMember(['displayName' => $id], ['groups', 'accounts', 'mails']);
        }

        if ($member === null) {
            throw MemberNotFoundException();
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
