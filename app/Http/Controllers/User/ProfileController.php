<?php
/**
 * ProfileController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
use Xpressengine\User\Models\User;
use Xpressengine\User\Rating;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserImageHandler;
use Xpressengine\User\UserInterface;
use Xpressengine\Widget\WidgetBoxHandler;

/**
 * Class ProfileController
 *
 * @category    Controllers
 * @package     App\Http\Controllers\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ProfileController extends Controller
{
    /**
     * @var UserHandler
     */
    protected $handler;

    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->handler = app('xe.user');

        XeTheme::selectSiteTheme();
        XePresenter::setSkinTargetId('user/profile');
    }

    // 기본정보 보기

    /**
     * Show profile of user.
     *
     * @param string           $user    user id
     * @param WidgetBoxHandler $handler WidgetBoxHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index($user, WidgetBoxHandler $handler)
    {
        $user = $this->retrieveUser($user);
        $grant = $this->getGrant($user);

        $widgetbox = $handler->find('user-profile');

        return XePresenter::make('index', compact('user', 'grant', 'widgetbox'));
    }

    /**
     * Update user profile.
     *
     * @param string  $userId  user id
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update($userId, Request $request)
    {
        $this->validate($request, ['display_name' => 'required']);

        $currentUser = auth()->user();

        if ($currentUser->id !== $userId) {
            abort(403, 'You do not have permission to edit this profile.');
        }

        // user validation
        /** @var UserInterface $user */
        $user = $this->retrieveUser($userId);

        $displayName = $request->get('display_name');
        $introduction = $request->get('introduction');

        XeDB::beginTransaction();
        try {
            // resolve profile file
            if ($profileFile = $request->file('profile_img_file')) {
                /** @var UserImageHandler $imageHandler */
                $imageHandler = app('xe.user.image');
                $user->profile_image_id = $imageHandler->updateUserProfileImage($user, $profileFile);
            }

            $this->handler->update($user, ['display_name' => $displayName, 'introduction' => $introduction]);

        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return redirect()->route('user.profile', [$user->getId()])->with('alert', [
            'type' => 'success',
            'message' => xe_trans('xe::saved')
        ]);
    }

    /**
     * Retrieve user
     *
     * @param string $id user id
     * @return User
     */
    protected function retrieveUser($id)
    {
        $user = $this->handler->users()->find($id);
        if ($user === null) {
            $user = $this->handler->users()->where(['display_name' => $id])->first();
        }

        if ($user === null) {
            $e = new UserNotFoundException();
            throw new HttpException(404, xe_trans('xe::userNotFound'), $e);
        }

        return $user;
    }

    /**
     * Get grant
     *
     * @param User $user user
     * @return array
     */
    protected function getGrant(User $user)
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
