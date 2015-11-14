<?php
namespace App\Http\Controllers\Member\Settings;

use App;
use App\Http\Controllers\Controller;
use Exception;
use Input;
use Presenter;
use Validator;
use XeDB;
use Xpressengine\Member\Entities\Database\GroupEntity;
use Xpressengine\Member\Repositories\GroupRepositoryInterface;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;

class GroupController extends Controller
{
    /**
     * @var \Xpressengine\Member\Repositories\GroupRepositoryInterface
     */
    protected $groups;

    public function __construct()
    {
        $this->groups = app('xe.member.groups');
    }

    public function index()
    {
        // todo: validate inputs!!
        $groups = $this->groups->paginate();

        return Presenter::make('member.settings.group.index', compact('groups'));
    }

    public function getCreate()
    {
        return Presenter::make('member.settings.group.create');
    }

    public function postCreate()
    {
        $input = Input::only(['name', 'description']);

        $validator = Validator::make($input, ['name' => 'Required']);

        if ($validator->fails()) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage($validator->errors()->first());
            throw $e;
        }

        XeDB::beginTransaction();
        try {
            $group = new GroupEntity($input);
            $this->groups->insert($group);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return redirect()->route('manage.group.index')->with('alert', ['type' => 'success', 'message' => '추가되었습니다.']);
    }

    public function getEdit($id)
    {
        $group = $this->groups->find($id);
        return Presenter::make('member.settings.group.edit', compact('group'));
    }

    public function postEdit($id)
    {
        $input = Input::only(['name', 'description']);

        $validator = Validator::make($input, ['name' => 'Required']);

        if ($validator->fails()) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage($validator->errors()->first());
            throw $e;
        }

        XeDB::beginTransaction();
        try {
            $group = $this->groups->find($id);
            $group->fill($input);
            $this->groups->update($group);
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return redirect()->route('manage.group.index')->with('alert', ['type' => 'success', 'message' => '수정되었습니다.']);
    }

    public function deleteGroup()
    {
        $groupIds = Input::get('id');
        $groups   = $this->groups->findAll($groupIds);

        XeDB::beginTransaction();
        try {
            foreach ($groups as $group) {
                $this->groups->delete($group);
            }
        } catch (Exception $e) {
            XeDB::rollBack();
            throw $e;
        }
        XeDB::commit();

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '삭제되었습니다.']);
    }

    /**
     * searchGroup
     *
     * @param GroupRepositoryInterface $groupRepo
     * @param null                     $keyword
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function searchGroup(GroupRepositoryInterface $groupRepo, $keyword = null)
    {

        if ($keyword === null) {
            return Presenter::makeApi($groupRepo->all());
        }

        $matchedGroupList = $groupRepo->search(['name' => $keyword])->items();
        return Presenter::makeApi($matchedGroupList);
    }
}
