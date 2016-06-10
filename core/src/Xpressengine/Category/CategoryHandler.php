<?php
/**
 * This file is category handler class.
 *
 * PHP version 5
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Category;

use Xpressengine\Category\Exceptions\UnableMoveToSelfException;
use Xpressengine\Category\Models\Category;
use Xpressengine\Category\Models\CategoryItem;
use Xpressengine\Support\Tree\NodePositionTrait;

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
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CategoryHandler
{
    use NodePositionTrait;

    /**
     * Model class
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Create new category
     *
     * @param array $inputs attributes for created
     * @return Category
     */
    public function create(array $inputs)
    {
        $category = $this->createModel();
        $category->fill($inputs);
        $category->save();

        return $category;
    }

    /**
     * Update category
     *
     * @param Category $category category instance
     * @return Category
     */
    public function put(Category $category)
    {
        if ($category->isDirty()) {
            $category->save();
        }

        return $category;
    }

    /**
     * Remove category
     *
     * @param Category $category category instance
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
     * @param Category $category category instance
     * @param array    $inputs   item attributes for created
     * @return CategoryItem
     */
    public function createItem(Category $category, array $inputs)
    {
        /** @var CategoryItem $item */
        $item = $category->items()->create($inputs);

        $this->setHierarchy($item);
        $this->setOrder($item);

        // 아이템이 추가되면 카테고리 그룹의 아이템 수량을 증가 시킴
        $category->increment($category->getCountName());

        return $item;
    }

    /**
     * Set hierarchy information for new item
     *
     * @param CategoryItem $item item object
     * @return void
     */
    protected function setHierarchy(CategoryItem $item)
    {
        // 이미 존재하는 경우 hierarchy 정보를 새로 등록하지 않음
        try {
            $item->ancestors()->attach($item->getKey(), [$item->getDepthName() => 0]);
        } catch (\Exception $e) {
            return;
        }

        if ($item->{$item->getParentIdName()}) {
            $model = $this->createItemModel();
            /** @var CategoryItem $parent */
            $parent = $model->newQuery()->find($item->{$item->getParentIdName()});

            $this->linkHierarchy($item, $parent);
        }
    }

    /**
     * Modify item information
     *
     * @param CategoryItem $item item object
     * @return CategoryItem
     */
    public function putItem(CategoryItem $item)
    {
        if ($item->isDirty($parentIdName = $item->getParentIdName())) {
            // 내용 수정시 부모 키 변경은 허용하지 않음
            // 부모 키가 변경되는 경우는 반드시 moveTo, setOrder 를
            // 통해 처리되야 함
            $item->{$parentIdName} = $item->getOriginal($parentIdName);
        }

        $item->save();

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
     * @param CategoryItem $item   item object
     * @param CategoryItem $parent new parent item object
     * @return CategoryItem
     * @throws UnableMoveToSelfException
     */
    public function moveTo(CategoryItem $item, CategoryItem $parent = null)
    {
        $oldParent = $item->getParent();
        if ($parent !== null) {
            if ($item->getKey() === $parent->getKey()) {
                throw new UnableMoveToSelfException();
            }

            if ($oldParent !== null && $oldParent->getKey() == $parent->getKey()) {
                return;
            }
        }

        if ($oldParent !== null) {
            $this->unlinkHierarchy($item, $oldParent);
            $item->{$item->getParentIdName()} = null;
        }

        if ($parent !== null) {
            $this->linkHierarchy($item, $parent);
            $item->{$item->getParentIdName()} = $parent->getKey();
        }

        $item->save();

        // 연관 객체 정보들이 변경 되었으므로 객채를 갱신 함
        return $item->newQuery()->find($item->getKey());
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
    public function createModel()
    {
        $class = $this->getModel();

        return new $class;
    }

    /**
     * Create new category item model
     *
     * @param Category $category category instance
     * @return mixed
     */
    public function createItemModel(Category $category = null)
    {
        $category = $category ?: $this->createModel();
        $class = $category->getItemModel();

        return new $class;
    }
}
