<?php
/**
 * UserController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers\User\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XeDB;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;
use Xpressengine\User\Exceptions\EmailAlreadyExistsException;
use Xpressengine\User\Exceptions\EmailNotFoundException;
use Xpressengine\User\Models\User;
use Xpressengine\User\Rating;
use Xpressengine\User\Repositories\UserRepository;
use Xpressengine\User\UserException;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserInterface;

/**
 * Class UserController
 *
 * @category    Controllers
 * @package     App\Http\Controllers\User\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UserController extends Controller
{
    /**
     * @var UserHandler
     */
    protected $handler;

    /**
     * UserController constructor.
     *
     * @param UserHandler $handler user handler
     */
    public function __construct(UserHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Show user list
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index(Request $request)
    {
        $query = $this->handler->users()->query();
        $allUserCount = $query->count();

        if ($startDate = $request->get('startDate')) {
            $query = $query->where('created_at', '>=', $startDate . ' 00:00:00');
        }

        if ($endDate = $request->get('endDate')) {
            $query = $query->where('created_at', '<=', $endDate . ' 23:59:59');
        }

        // resolve group
        if ($group = $request->get('group')) {
            $query = $query->whereHas(
                'groups',
                function (Builder $q) use ($group) {
                    $q->where('group_id', $group);
                }
            );
        }

        // resolve status
        if ($status = $request->get('status')) {
            $query = $query->where('status', $status);
        }

        // resolve rating
        if ($rating = $request->get('rating')) {
            $query = $query->where('rating', $rating);
        }

        // resolve search keyword
        // keyfield가 지정되지 않을 경우 email, display_name, login_id를 대상으로 검색함
        $field = $request->get('keyfield') ?: 'email,display_name,login_id';

        if ($keyword = trim($request->get('keyword'))) {
            $query = $query->where(
                function (Builder $q) use ($field, $keyword) {
                    foreach (explode(',', $field) as $f) {
                        $q->orWhere($f, 'like', '%'.$keyword.'%');
                    }
                }
            );
        }

        $users = $query->orderBy('created_at', 'desc')->paginate()->appends(request()->query());

        // get all groups
        $groups = $this->handler->groups()->all();

        // get all ratings
        $ratings = Rating::getUsableAll();
        $ratingNames = [
            Rating::USER => xe_trans('xe::userRatingNormal'),
            Rating::MANAGER => xe_trans('xe::userRatingManager'),
            Rating::SUPER => xe_trans('xe::userRatingAdministrator'),
        ];

        foreach ($ratings as $key => $rating) {
            $ratings[$key] = [
                'value' => $rating,
                'text' => $ratingNames[$rating],
            ];
        }

        $selectedGroup = null;
        if ($group !== null) {
            $selectedGroup = $this->handler->groups()->find($group);
        }

        $config = app('xe.config')->get('user.register');

        return XePresenter::make(
            'user.settings.user.index',
            compact('users', 'groups', 'selectedGroup', 'allUserCount', 'ratings', 'config')
        );
    }

    /**
     * Show user creation page.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function create()
    {
        $ratings = Rating::getUsableAll();
        $ratingNames = [
            Rating::USER => xe_trans('xe::userRatingNormal'),
            Rating::MANAGER => xe_trans('xe::userRatingManager'),
            Rating::SUPER => xe_trans('xe::userRatingAdministrator'),
        ];

        foreach ($ratings as $key => $rating) {
            $ratings[$key] = [
                'value' => $rating,
                'text' => $ratingNames[$rating],
            ];
        }

        $groupList = $this->handler->groups()->all();
        $groups = $this->getGroupInfo($groupList);
        $status = $this->getUserStatus();

        // dynamic field
        $dynamicField = app('xe.dynamicField');
        $fieldTypes = $dynamicField->gets('user');

        return XePresenter::make('user.settings.user.create', compact('ratings', 'groups', 'status', 'fieldTypes'));
    }

    /**
     * Store user.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        $rules = [
            'email' => 'email|required',
            'login_id' => 'required|login_id',
            'password' => 'required|password',
        ];

        if (app('xe.config')->getVal('user.register.use_display_name') === true) {
            $rules['display_name'] = 'required';
        }

        $this->validate($request, $rules);

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

        return redirect()->route('settings.user.index')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::saved')]
        );
    }

    /**
     * Show user editing page.
     *
     * @param string $id identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function edit($id)
    {
        $user = $this->handler->users()->with('groups', 'emails', 'accounts')->find($id);

        if ($user === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage(xe_trans('xe::userNotFound'));
            throw $e;
        }

        $ratings = Rating::getUsableAll();
        $ratingNames = [
            Rating::USER => xe_trans('xe::userRatingNormal'),
            Rating::MANAGER => xe_trans('xe::userRatingManager'),
            Rating::SUPER => xe_trans('xe::userRatingAdministrator'),
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

        foreach ($user->groups as $group) {
            $groups[$group->id]['checked'] = 'checked';
        }

        $status = $this->getUserStatus();
        $status[$user->status]['selected'] = 'selected';

        // profileImage config
        $profileImgSize = config('xe.user.profileImage.size');

        // dynamic field
        $dynamicField = app('xe.dynamicField');
        $fieldTypes = $dynamicField->gets('user');

        return XePresenter::make(
            'user.settings.user.edit',
            compact(
                'user',
                'ratings',
                'groups',
                'status',
                'fieldTypes',
                'profileImgSize'
            )
        );
    }

    /**
     * Update user.
     *
     * @param Request $request request
     * @param string  $id      user id
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function update(Request $request, $id)
    {
        /** @var UserInterface $user */
        $user = $this->handler->users()->with('groups', 'emails', 'accounts')->find($id);

        if ($user === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage(xe_trans('xe::userNotFound'));
            throw $e;
        }

        $rules = [
            'email' => 'email',
            'login_id' => 'required|login_id',
            'rating' => 'required',
            'status' => 'required',
        ];

        if (app('xe.config')->getVal('user.register.use_display_name') === true) {
            $rules['display_name'] = 'required';
        }

        $this->validate($request, $rules);

        if ($user->isAdmin() &&
            ($request->get('status') === User::STATUS_DENIED || $request->get('rating') !== Rating::SUPER)
        ) {
            $cnt = $this->handler->users()
                ->where('rating', Rating::SUPER)
                ->where('status', User::STATUS_ACTIVATED)
                ->count();
            if ($cnt === 1) {
                throw new HttpException(422, xe_trans('xe::msgUnableToChangeStatusForSuperUser'));
            }
        }

        $userData = $request->except('_token');

        if (array_get($userData, 'profile_img_file') === '__delete_file__') {
            $userData['profile_img_file'] = false;
        }
        $userData['group_id'] = $request->get('group_id') ?: [];

        XeDB::beginTransaction();
        try {
            $this->handler->update($user, $userData);
        } catch (UserException $e) {
            XeDB::rollback();
            throw new HttpException('400', $e->getMessage());
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * get user status list
     *
     * @return array
     */
    protected function getUserStatus()
    {
        return [
            User::STATUS_ACTIVATED => ['value' => User::STATUS_ACTIVATED, 'text' => xe_trans('xe::permitted')],
            User::STATUS_DENIED => ['value' => User::STATUS_DENIED, 'text' => xe_trans('xe::rejected')],
            User::STATUS_PENDING_ADMIN => [
                'value' => User::STATUS_PENDING_ADMIN,
                'text' => xe_trans('xe::pending_admin')
            ],
            User::STATUS_PENDING_EMAIL => [
                'value' => User::STATUS_PENDING_EMAIL,
                'text' => xe_trans('xe::pending_email')
            ]
        ];
    }

    /**
     * Response user's email list.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getMailList(Request $request)
    {
        $this->validate($request, ['userId' => 'required']);
        $id = $request->get('userId');

        $mails = $this->handler->emails()->where(['user_id' => $id])->get();

        return XePresenter::makeApi(['mails' => $mails]);
    }

    /**
     * Add email.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     * @throws Exception
     */
    public function postAddMail(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required',
            'address' => 'required|email'
        ]);

        $userId = $request->get('userId');
        $address = $request->get('address');

        try {
            $this->handler->validateEmail($address);
        } catch (EmailAlreadyExistsException $e) {
            throw new HttpException(400, xe_trans('xe::emailAlreadyExists'), $e);
        }

        $user = $this->handler->users()->find($userId);

        XeDB::beginTransaction();
        try {
            $data = [
                'user_id' => $user->id,
                'address' => $address,
            ];
            $email = $this->handler->createEmail($user, $data);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();


        return XePresenter::makeApi(['mail' => $email]);
    }

    /**
     * Confirm email
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     * @throws Exception
     */
    public function postConfirmMail(Request $request)
    {
        $pendingEmail = $this->handler->pendingEmails()->find($request->get('id'));

        if ($pendingEmail === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage(xe_trans('xe::EmailNotExistOrAlreadyConfirmed'));
            throw $e;
        }

        $user = $pendingEmail->user;
        $address = $pendingEmail->address;

        XeDB::beginTransaction();
        try {
            // create email
            $email = $this->handler->createEmail($user, compact('address'));

            // remove pending email
            $this->handler->deleteEmail($pendingEmail);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return XePresenter::makeApi(['mail' => $email]);
    }

    /**
     * Delete a mail.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     * @throws Exception
     */
    public function postDeleteMail(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required',
            'address' => 'required'
        ]);

        $address = $request->get('address');

        $mail = $this->handler->emails()->findByAddress($address);

        if ($mail === null) {
            throw new EmailNotFoundException();
        }

        XeDB::beginTransaction();
        try {
            $this->handler->deleteEmail($mail);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return XePresenter::makeApi(['type' => 'success', 'address' => $address]);
    }

    /**
     * Show confirm for delete a user.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function deletePage(Request $request)
    {
        $userIds = $request->get('userIds');

        $userIds = explode(',', $userIds);

        $users = $this->handler->users()->whereIn('id', $userIds)->where('rating', '<>', Rating::SUPER)->get();

        return api_render('user.settings.user.delete', compact('users'));
    }

    /**
     * Delete a user.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request)
    {
        $userIds = $request->get('userId', []);

        XeDB::beginTransaction();
        try {
            $this->handler->leave($userIds);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::deleted')]);
    }

    /**
     * Search user.
     *
     * @param string|null $keyword keyword
     * @return \Xpressengine\Presenter\Presentable
     */
    public function search($keyword = null)
    {
        /** @var UserRepository $users */
        $users = $this->handler->users();

        if ($keyword === null) {
            return XePresenter::makeApi([]);
        }

        $matchedUserList = $users->query()->where('display_name', 'like', '%'.$keyword.'%')
            ->paginate(null, ['id', 'display_name', 'email'])->items();

        return XePresenter::makeApi($matchedUserList);
    }

    /**
     * Get group information
     *
     * @param \Xpressengine\User\Models\UserGroup[] $groupList groups
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
