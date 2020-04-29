<?php
/**
 * GroupController.php
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
use XePresenter;
use XeDB;
use Xpressengine\Http\Request;
use Xpressengine\User\Repositories\UserGroupRepositoryInterface;

/**
 * Class GroupController
 *
 * @category    Controllers
 * @package     App\Http\Controllers\User\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class GroupController extends Controller
{
    /**
     * @var UserGroupRepositoryInterface
     */
    protected $groups;

    /**
     * GroupController constructor.
     */
    public function __construct()
    {
        $this->groups = app('xe.user.groups');
    }

    /**
     * Show group list
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index()
    {
        $groups = $this->groups->with('userCountRelation')->orderBy('created_at')->get();

        $config = app('xe.config')->get('user.register');
        $joinGroup = $config->get('joinGroup');

        return XePresenter::make('user.settings.group.index', compact('groups', 'joinGroup'));
    }

    /**
     * Show group creation page
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function create()
    {
        return XePresenter::make('user.settings.group.create');
    }

    /**
     * Store group
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        $input = $request->only(['name', 'description']);

        $this->validate($request, ['name' => 'Required', 'description' => 'Required']);

        XeDB::beginTransaction();
        try {
            $this->groups->create($input);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return redirect()->route('manage.group.index')->with('alert', [
            'type' => 'success', 'message' => xe_trans('xe::saved')
        ]);
    }

    /**
     * Show group editing page
     *
     * @param string $id identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function edit($id)
    {
        $group = $this->groups->find($id);
        return XePresenter::make('user.settings.group.edit', compact('group'));
    }

    /**
     * Update group information.
     *
     * @param Request $request request
     * @param string  $id      identifier
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function update(Request $request, $id)
    {
        $input = $request->only(['name', 'description']);

        $this->validate($request, ['name' => 'required']);

        $group = $this->groups->find($id);

        XeDB::beginTransaction();
        try {
            $this->groups->update($group, $input);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return redirect()->route('manage.group.index')->with('alert', [
            'type' => 'success', 'message' => xe_trans('xe::saved')
        ]);
    }

    /**
     * Set the group to be registered when the user registered.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function updateJoinGroup(Request $request)
    {
        $this->validate($request, ['join_group' => 'required']);

        $groupId = $request->get('join_group');

        $joinConfig = \app('xe.config')->get('user.register');

        $joinConfig->set('joinGroup', $groupId);
        \app('xe.config')->modify($joinConfig);

        return XePresenter::makeApi([
            'type' => 'success',
            'message' => xe_trans('xe::defaultGroupHasChanged'),
            'groupId' => $groupId
        ]);
    }

    /**
     * Delete a group
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request)
    {
        $groupIds = $request->get('id');

        $joinConfig = \app('xe.config')->get('user.register');
        $joinGroup = $joinConfig->get('joinGroup');
        $groups = $this->groups->query()->whereIn('id', $groupIds)->get();

        XeDB::beginTransaction();
        try {
            foreach ($groups as $group) {
                if ($joinGroup !== $group->id) {
                    $this->groups->delete($group);
                }
            }
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::deleted')]);
    }

    /**
     * Search group
     *
     * @param string|null $keyword keyword
     * @return \Xpressengine\Presenter\Presentable
     */
    public function search($keyword = null)
    {
        if ($keyword === null) {
            return XePresenter::makeApi([]);
        }

        $matched = $this->groups->where('name', 'like', '%'.$keyword.'%')->paginate()->items();
        return XePresenter::makeApi($matched);
    }
}
