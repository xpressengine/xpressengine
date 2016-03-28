<?php
/**
 * This file is category handler class.
 *
 * PHP version 5
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Category;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Xpressengine\Category\Exceptions\UnableMoveToSelfException;
use Xpressengine\Category\Models\Category;
use Xpressengine\Category\Models\CategoryItem;

/**
 * # CategoryHandler
 * 여러단어들로 구성된 카테고리 처리를 담당
 *
 * ### app binding : xe.category 로 바인딩 되어 있음
 * `XeCategory` Facade 로 접근 가능
 *
 * ### 카테고리 생성
 * ```php
 *  // 신규 카테고리 그룹 생성
 *  $category = XeCategory::create();
 *  // 카테고리 그룹에 아이템 추가
 *  $item = XeCategory::createItem($category, ['word' => '단어', 'description' => '설명']);
 *  // 특정 단어의 하위 노드로 등록하고자 할땐
 *  // 부모에 해당하는 아이템의 고유키를 넘겨주면 됩니다.
 *  $child = XeCategory::createItem($category, ['word' => '자식', 'parentId' => 1]);
 * ```
 *
 * ### 카테고리 사용
 * ```php
 *  // 최상위 레벨 아이템 목록
 *  $items = $category->getProgenitors();
 *  // 특정 아이템의 하위 노드 아이템 목록
 *  $item = CategoryItem::find($id);
 *  $children = $item->getChildren();
 *  // 상위 노드 아이템
 *  $parent = $item->getParent();
 *  // 트리 구조의 자손 아이템
 *  $tree = $item->getDescendantTree();
 * ```
 *
 * 전체를 tree collection 으로 반환 받을수도 있습니다.
 * ```php
 *  $category = Category::get($id);
 *  $tree = $category->getTree();
 * ```
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CategoryHandler
{
    protected $model = Category::class;

    /**
     * Create new category
     *
     * @param array $inputs attributes for created
     * @return Category
     */
    public function create(array $inputs = [])
    {
        $class = $this->getModel();

        return $class::create($inputs);
    }

    /**
     * Remove category
     *
     * @param Category $category category object
     * @return bool
     */
    public function remove(Category $category)
    {
        foreach ($category->getProgenitors() as $item) {
            $this->removeItem($item);
        }

        return $category->delete();
    }

    /**
     * Create a new category item
     *
     * @param Category $category category object
     * @param array    $inputs   item attributes for created
     * @return CategoryItem
     */
    public function createItem(Category $category, $inputs)
    {
        /** @var CategoryItem $item */
        $item = $category->items()->create($inputs);
        $item->ancestors()->attach($item->getKey(), [$item->getDepthName() => 0]);

        if ($item->{$item->getParentIdName()}) {
            $itemModel = $category->getItemModel();
            /** @var CategoryItem $parent */
            $parent = $itemModel::find($item->{$item->getParentIdName()});
            $ascIds = array_reverse($parent->getBreadcrumbs());
            $depth = 1;

            // todo: linkHierarchy method 사용?
            foreach ($ascIds as $ascId) {
                $item->ancestors()->attach($ascId, [$item->getDepthName() => $depth]);
                $depth++;
            }
        }

        $this->setOrder($item, $category->count);

        // 아이템이 추가되면 카테고리 그룹의 아이템 수량을 증가 시킴
        $category->increment('count');

        return $item;
    }

    /**
     * Modify item information
     *
     * @param CategoryItem $item item object
     * @return CategoryItem
     */
    public function putItem(CategoryItem $item)
    {
        /** @var CategoryItem $parent */
        $parent = null;
        if ($item->isDirty($item->getParentIdName())) {
            $parent = $item->newQuery()->find($item->getAttribute($item->getParentIdName()));
        }

        $item->save();

        if ($parent) {
            $this->moveTo($item, count($parent->getChildren()), $parent);
        }

        return $item;
    }

    /**
     * Remove single item or all descendant
     *
     * @param CategoryItem $item  item object
     * @param bool         $force if true then remove all descendant
     * @return bool
     */
    public function removeItem(CategoryItem $item, $force = true)
    {
        $count = 1;

        /** @var CategoryItem $desc */
        foreach ($item->descendants as $desc) {
            if ($force === true) {
                $desc->ancestors()->detach();
                $desc->descendants()->detach();

                $desc->ancestors()->newPivotStatement()
                    ->where($desc->getDescendantName(), $desc->getKey())->where($desc->getDepthName(), 0)
                    ->delete();

                $desc->delete();
                $count++;
            } else {
                // 하위 아이템을 삭제하지 않는 경우
                // 하위 아이템을 삭제할 대상 아이템의 부모 아이템의
                // 자식 아이템으로 변경해 줌
                $desc->descendants()->newPivotStatement()
                    ->where($desc->getDescendantName(), $desc->getKey())
                    ->where($desc->getAncestorName(), '!=', $item->getKey())
                    ->where($desc->getDepthName(), '>', 0)
                    ->decrement($desc->getDepthName());

                $parentId = ($parent = $item->getParent()) ? $parent->getKey() : null;

                $desc->{$desc->getParentIdName()} = $parentId;
                $desc->save();
            }
        }

        $result = $item->delete();

        // 아이템이 삭제되면 아이템이 속해있던 카테고리 그룹의 아이템 수량을 감소 시킴
        $item->category->decrement('count', $count);

        return $result;
    }

    /**
     * Move to another parent CategoryItem
     *
     * @param CategoryItem $item     item object
     * @param int          $position position for order
     * @param CategoryItem $parent   new parent item object
     * @return void
     * @throws UnableMoveToSelfException
     */
    public function moveTo(CategoryItem $item, $position, CategoryItem $parent = null)
    {
        $oldParent = $item->getParent();
        if ($parent !== null) {
            if ($item->getKey() === $parent->getKey()) {
                throw new UnableMoveToSelfException();
            }

            if ($oldParent !== null && $oldParent->getKey() == $parent->getKey()) {
                $this->setOrder($item, $position);
                return;
            }
        }

        if ($oldParent !== null) {
            $this->unlinkHierarchy($item, $oldParent);
            $item->{$item->getParentIdName()} = null;
            // unlink 작업이 객체에 의해 처리되지 않으므로
            // 객채가 갱신되지 않음
            // 그래서 수동으로 객체에 로드된 연관객체를 초기화 함
            unset($item->ancestors);
        }

        if ($parent !== null) {
            $this->linkHierarchy($item, $parent);
            $item->{$item->getParentIdName()} = $parent->getKey();
        }

        $item->save();

        $this->setOrder($item, $position);
    }

    /**
     * Linked parent and child relation
     *
     * @param CategoryItem $item   child item instance
     * @param CategoryItem $parent parent item instance
     * @return bool
     */
    protected function linkHierarchy(CategoryItem $item, CategoryItem $parent)
    {
        $conn = $item->getConnection();
        $prefix = $conn->getTablePrefix();
        $table = $item->getHierarchyTable();
        $ancestor = $item->getAncestorName();
        $descendant = $item->getDescendantName();
        $depth = $item->getDepthName();

        $select = $conn->table($table . ' as a')
            ->joinWhere($table . ' as d', "d.{$ancestor}", '=', $item->getKey())
            ->where("a.{$descendant}", '=', $parent->getKey())
            ->select([
                "a.{$ancestor}",
                "d.{$descendant}",
                new Expression("`{$prefix}a`.`{$depth}` + `{$prefix}d`.`{$depth}` + 1")
            ]);

        $bindings = $select->getBindings();

        $insertQuery = sprintf("insert into %s (`{$ancestor}`, `{$descendant}`, `{$depth}`) ", $prefix . $table)
            . $select->toSql();

        return $conn->insert($insertQuery, $bindings);
    }

    /**
     * unlinked parent and child relation
     *
     * @param CategoryItem $item   child item instance
     * @param CategoryItem $parent parent item instance
     * @return int affected row count
     */
    protected function unlinkHierarchy(CategoryItem $item, CategoryItem $parent)
    {
        $conn = $item->getConnection();
        $table = $item->getHierarchyTable();
        $ancestor = $item->getAncestorName();
        $descendant = $item->getDescendantName();

        $rows = $conn->table($table . ' as a')
            ->join($table . ' as rel', "a.{$ancestor}", '=', "rel.{$ancestor}")
            ->join($table . ' as d', "d.{$descendant}", '=', "rel.{$descendant}")
            ->where("a.{$descendant}", $parent->getKey())
            ->where("d.{$ancestor}", $item->getKey())
            ->get(['rel.' . $item->getKeyName()]);

        $ids = array_column($rows, $item->getKeyName());

        return $conn->table($table)->whereIn($item->getKeyName(), $ids)->delete();
    }

    /**
     * Set item ordering value
     *
     * @param CategoryItem $item     item object
     * @param int          $position sequence value
     * @return void
     */
    protected function setOrder(CategoryItem $item, $position)
    {
        /** @var CategoryItem $parent */
        if (!$parent = $item->getParent()) {
            $children = $item->category->getProgenitors();
        } else {
            $children = $parent->getChildren();
        }

        /** @var Collection $children */
        $children = $children->filter(function (CategoryItem $model) use ($item) {
            return $model->getKey() != $item->getKey();
        });

        $children = $children->slice(0, $position)
            ->merge([$item])
            ->merge($children->slice($position));

        $children->each(function (CategoryItem $model, $idx) {
            $model->{$model->getOrderKeyName()} = $idx;
            $model->save();
        });
    }

    /**
     * The name of Category model class
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the name of Category model
     *
     * @param string $model model class
     * @return void
     */
    public function setModel($model)
    {
        $this->model = '\\' . ltrim($model, '\\');
    }

    /**
     * Create model instance
     *
     * @return Category
     */
    public function newModel()
    {
        $class = $this->getModel();

        return new $class;
    }
}
