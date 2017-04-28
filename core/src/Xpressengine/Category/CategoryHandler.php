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

use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Xpressengine\Category\Exceptions\UnableMoveToSelfException;
use Xpressengine\Category\Models\Category;
use Xpressengine\Category\Models\CategoryItem;
use Xpressengine\Category\Repositories\CategoryItemRepository;
use Xpressengine\Category\Repositories\CategoryRepository;
use Xpressengine\Support\Tree\NodePositionTrait;

/**
 * todo: docblock remove or update
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
    use NodePositionTrait, Macroable;

    /**
     * CategoryRepository instance
     *
     * @var CategoryRepository
     */
    protected $cates;

    /**
     * CategoryItemRepository instance
     *
     * @var CategoryItemRepository
     */
    protected $items;

    /**
     * CategoryHandler constructor.
     *
     * @param CategoryRepository     $cates CategoryRepository instance
     * @param CategoryItemRepository $items CategoryItemRepository instance
     */
    public function __construct(CategoryRepository $cates, CategoryItemRepository $items)
    {
        $this->cates = $cates;
        $this->items = $items;
    }

    /**
     * Update category
     *
     * @param Category $category category instance
     * @param array    $data     attributes
     * @return Category
     *
     * @deprecated since beta.17. use update instead.
     */
    public function put(Category $category, array $data = [])
    {
        return $this->cates->update($category, $data);
    }

    /**
     * Remove category
     *
     * @param Category $category category instance
     * @return bool
     *
     * @deprecated since beta.17. use delete instead.
     */
    public function remove(Category $category)
    {
        return $this->delete($category);
    }

    /**
     * Delete category
     *
     * @param Category $category category instance
     * @return bool
     */
    public function delete(Category $category)
    {
        foreach ($category->getProgenitors() as $item) {
            $this->deleteItem($item);
        }

        return $this->cates->delete($category);
    }

    /**
     * Create a new category item
     *
     * @param Category $category category instance
     * @param array    $data     item attributes for created
     * @return CategoryItem
     */
    public function itemCreate(Category $category, array $data)
    {
        $model = $this->createItemModel();
        /** @var CategoryItem $item */
        $item = $this->items->create(array_merge($data, [$model->getAggregatorKeyName() => $category->getKey()]));

        $this->setHierarchy($item);
        $this->setOrder($item);

        // 아이템이 추가되면 카테고리 그룹의 아이템 수량을 증가 시킴
        $category->increment($category->getCountName());

        return $item;
    }

    /**
     * Create a new category item, alias for itemCreate
     *
     * @param Category $category category instance
     * @param array    $data     item attributes for created
     * @return CategoryItem
     */
    public function createItem(Category $category, array $data)
    {
        return $this->itemCreate($category, $data);
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
     * @param array        $data attribute data
     * @return CategoryItem
     *
     * @deprecated since beta.17. use itemUpdate instead.
     */
    public function putItem(CategoryItem $item, array $data = [])
    {
        return $this->itemUpdate($item, $data);
    }

    /**
     * Modify item information
     *
     * @param CategoryItem $item item object
     * @param array        $data attribute data
     * @return CategoryItem
     */
    public function itemUpdate(CategoryItem $item, array $data = [])
    {
        $parentIdName = $item->getParentIdName();
        // 내용 수정시 부모 키 변경은 허용하지 않음
        // 부모 키가 변경되는 경우는 반드시 moveTo, setOrder 를
        // 통해 처리되야 함
        $this->items->update($item, array_merge($data, [$parentIdName => $item->getOriginal($parentIdName)]));

        return $item;
    }

    /**
     * Modify item information, alias for itemUpdate
     *
     * @param CategoryItem $item item object
     * @param array        $data attribute data
     * @return CategoryItem
     */
    public function updateItem(CategoryItem $item, array $data = [])
    {
        return $this->itemUpdate($item, $data);
    }

    /**
     * Remove single item or all descendant
     *
     * @param CategoryItem $item  item object
     * @param bool         $force if true then remove all descendant
     * @return bool
     *
     * @deprecated since beta.17. use itemDelete instead.
     */
    public function removeItem(CategoryItem $item, $force = true)
    {
        return $this->itemDelete($item, $force);
    }

    /**
     * Delete single item or all descendant
     *
     * @param CategoryItem $item  item object
     * @param bool         $force if true then remove all descendant
     * @return bool
     */
    public function itemDelete(CategoryItem $item, $force = true)
    {
        $count = 1;

        /** @var CategoryItem $desc */
        foreach ($item->descendants as $desc) {
            if ($force === true) {
                $this->itemRawDelete($desc);
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

                $this->items->update($desc, [$desc->getParentIdName() => $parentId]);
            }
        }

        $result = $this->itemRawDelete($item);

        // 아이템이 삭제되면 아이템이 속해있던 카테고리 그룹의 아이템 수량을 감소 시킴
        $item->category->decrement('count', $count);

        return $result;
    }

    /**
     * Delete single item or all descendant, alias for itemDelete
     *
     * @param CategoryItem $item  item object
     * @param bool         $force if true then remove all descendant
     * @return bool
     */
    public function deleteItem(CategoryItem $item, $force = true)
    {
        return $this->itemDelete($item, $force);
    }

    /**
     * Raw delete item
     *
     * @param CategoryItem $item item instance
     * @return bool|null
     */
    protected function itemRawDelete(CategoryItem $item)
    {
        $item->ancestors()->detach();
        $item->descendants()->detach();
        $item->ancestors()->newPivotStatement()
            ->where($item->getDescendantName(), $item->getKey())->where($item->getDepthName(), 0)
            ->delete();

        return $this->items->delete($item);
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
     * Create new category item model
     *
     * @return CategoryItem
     */
    public function createItemModel()
    {
        return $this->items->createModel();
    }

    /**
     * __call
     *
     * @param string $name      method name
     * @param array  $arguments arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (Str::startsWith($name, 'item')) {
            $method = Str::camel(Str::substr($name, 4));
            return call_user_func_array([$this->items, $method], $arguments);
        }

        return call_user_func_array([$this->cates, $name], $arguments);
    }
}
