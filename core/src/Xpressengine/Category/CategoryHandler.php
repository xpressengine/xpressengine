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
 * Class CategoryHandler
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
     * Create category
     *
     * @param array $attributes attributes
     * @return Category
     *
     * @deprecated since beta.17. use createCate instead.
     */
    public function create(array $attributes)
    {
        return $this->createCate($attributes);
    }

    /**
     * Create category
     *
     * @param array $attributes attributes
     * @return Category
     */
    public function createCate(array $attributes)
    {
        return $this->cates->create($attributes);
    }

    /**
     * Update category
     *
     * @param Category $category category instance
     * @param array    $data     attributes
     * @return Category
     *
     * @deprecated since beta.17. use updateCate instead.
     */
    public function put(Category $category, array $data = [])
    {
        return $this->updateCate($category, $data);
    }

    /**
     * Update category
     *
     * @param Category $category category instance
     * @param array    $data     attributes
     * @return Category
     */
    public function updateCate(Category $category, array $data = [])
    {
        return $this->cates->update($category, $data);
    }

    /**
     * Remove category
     *
     * @param Category $category category instance
     * @return bool
     *
     * @deprecated since beta.17. use deleteCate instead.
     */
    public function remove(Category $category)
    {
        return $this->deleteCate($category);
    }

    /**
     * Delete category
     *
     * @param Category $category category instance
     * @return bool
     */
    public function deleteCate(Category $category)
    {
        foreach ($category->getProgenitors() as $item) {
            $this->deleteItem($item);
        }

        return $this->cates->delete($category);
    }

    /**
     * Create a new category item, alias for itemCreate
     *
     * @param Category $category   category instance
     * @param array    $attributes item attributes for created
     * @return CategoryItem
     */
    public function createItem(Category $category, array $attributes)
    {
        $model = $this->items()->createModel();
        /** @var CategoryItem $item */
        $item = $this->items->create(array_merge($attributes, [$model->getAggregatorKeyName() => $category->getKey()]));

        $this->setHierarchy($item);
        $this->setOrder($item);

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
        if ($item->{$item->getParentIdName()}) {
            /** @var CategoryItem $parent */
            $parent = $this->items()->find($item->{$item->getParentIdName()});

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
     * @deprecated since beta.17. use updateItem instead.
     */
    public function putItem(CategoryItem $item, array $data = [])
    {
        return $this->updateItem($item, $data);
    }

    /**
     * Modify item information
     *
     * @param CategoryItem $item item object
     * @param array        $data attribute data
     * @return CategoryItem
     */
    public function updateItem(CategoryItem $item, array $data = [])
    {
        $parentIdName = $item->getParentIdName();
        // 내용 수정시 부모 키 변경은 허용하지 않음
        // 부모 키가 변경되는 경우는 반드시 moveTo, setOrder 를
        // 통해 처리되야 함
        return $this->items->update($item, array_merge($data, [$parentIdName => $item->getOriginal($parentIdName)]));
    }

    /**
     * Remove single item or all descendant
     *
     * @param CategoryItem $item  item object
     * @param bool         $force if true then remove all descendant
     * @return bool
     *
     * @deprecated since beta.17. use deleteItem instead.
     */
    public function removeItem(CategoryItem $item, $force = true)
    {
        return $this->deleteItem($item, $force);
    }

    /**
     * Delete single item or all descendant
     *
     * @param CategoryItem $item  item object
     * @param bool         $force if true then remove all descendant
     * @return bool
     */
    public function deleteItem(CategoryItem $item, $force = true)
    {
        /** @var CategoryItem $desc */
        foreach ($item->descendants as $desc) {
            if ($force === true) {
                $this->items->delete($desc);
            } else {
                $this->items->exclude($desc, $item);
            }
        }

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
        return $this->items->find($item->getKey());
    }

    /**
     * Get CategoryRepository instance
     *
     * @return CategoryRepository
     */
    public function cates()
    {
        return $this->cates;
    }

    /**
     * Get CategoryItemRepository instance
     *
     * @return CategoryItemRepository
     */
    public function items()
    {
        return $this->items;
    }
}
