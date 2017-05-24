<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XePresenter;
use XeTheme;
use XeDB;
use Xpressengine\User\Exceptions\UserNotFoundException;
use Xpressengine\User\Rating;
use Xpressengine\User\Repositories\UserEmailRepositoryInterface;
use Xpressengine\User\Repositories\UserGroupRepositoryInterface;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserImageHandler;
use Xpressengine\User\UserInterface;
use Xpressengine\WidgetBox\WidgetBoxHandler;

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

        XeTheme::selectSiteTheme();
        XePresenter::setSkinTargetId('user/profile');
    }

    // 기본정보 보기
    public function index($user, WidgetBoxHandler $handler)
    {
        $user = $this->retreiveUser($user);
        $grant = $this->getGrant($user);

        $widgetbox = $handler->find('user-profile');

        return XePresenter::make('index', compact('user', 'grant', 'widgetbox'));
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
        $user = $this->retreiveUser($userId);
        $userId = $user->getId();

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

        return redirect()->route('user.profile', [$user->getId()])->with(
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
        $user = $this->handler->users()->find($id);
        if ($user === null) {
            $user = $this->handler->users()->where(['displayName' => $id])->first();
        }

        if ($user === null) {
            $e = new UserNotFoundException();
            throw new HttpException(404, xe_trans('xe::userNotFound'), $e);
        }

        return $user;
    }

    /**
     * getGrant
     *
     * @param $user
     *
     * @return array
     */
    protected function getGrant($user)
    {
        $logged = Auth::user();

        $grant = [
            'modify' => false,
            'manage' => false
        ];
        if ($logged->getId() === $user->getId()) {
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
