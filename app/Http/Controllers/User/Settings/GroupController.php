<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use Exception;
use XePresenter;
use XeDB;
use Xpressengine\Http\Request;
use Xpressengine\User\Repositories\UserGroupRepositoryInterface;

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
     * show group list
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function index()
    {
        $groups = $this->groups->with('userCountRelation')->orderBy('created_at')->get();

        $config = app('xe.config')->get('user.join');
        $joinGroup = $config->get('joinGroup');

        return XePresenter::make('user.settings.group.index', compact('groups', 'joinGroup'));
    }

    /**
     * show group creation page
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function create()
    {
        return XePresenter::make('user.settings.group.create');
    }

    /**
     * store group
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        $input = $request->only(['name', 'description']);

        $this->validate($request, ['name' => 'Required']);

        XeDB::beginTransaction();
        try {
            $this->groups->create($input);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return redirect()->route('manage.group.index')->with('alert', ['type' => 'success', 'message' => '추가되었습니다.']);
    }

    /**
     * show group editing page
     *
     * @param $id
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function edit($id)
    {
        $group = $this->groups->find($id);
        return XePresenter::make('user.settings.group.edit', compact('group'));
    }

    /**
     * postEdit
     *
     * @param Request $request
     * @param         $id
     *
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

        return redirect()->route('manage.group.index')->with('alert', ['type' => 'success', 'message' => '수정되었습니다.']);
    }

    public function updateJoinGroup(Request $request)
    {
        $this->validate($request, ['join_group' => 'required']);

        $groupId = $request->get('join_group');

        $joinConfig = \app('xe.config')->get('user.join');

        $joinConfig->set('joinGroup', $groupId);
        \app('xe.config')->modify($joinConfig);

        return XePresenter::makeApi(['type' => 'success', 'message' => '기본 가입 그룹이 변경되었습니다.', 'groupId' => $groupId]);
    }

    /**
     * delete group
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request)
    {
        $groupIds = $request->get('id');

        $joinConfig = \app('xe.config')->get('user.join');
        $joinGroup = $joinConfig->get('joinGroup');



        $groups = $this->groups->query()->whereIn('id', $groupIds)->get();

        XeDB::beginTransaction();
        try {
            foreach ($groups as $group) {
                if($joinGroup !== $group->id) {
                    $this->groups->delete($group);
                }
            }
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '삭제되었습니다.']);
    }

    /**
     * search Group
     *
     * @param null $keyword
     *
     * @return \Xpressengine\Presenter\RendererInterface
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
