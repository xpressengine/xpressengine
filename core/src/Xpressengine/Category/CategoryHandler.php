<?php
/**
 * This file is category handler class.
 *
 * PHP version 7
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Category;

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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
     */
    public function updateCate(Category $category, array $data = [])
    {
        return $this->cates->update($category, $data);
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
     * Delete single item or all descendant
     *
     * @param CategoryItem $item  item object
     * @param bool         $force if true then remove all descendant
     * @return bool
     */
    public function deleteItem(CategoryItem $item, $force = true)
    {
        if ($force == true) {
            /** @var CategoryItem $desc */
            foreach ($item->descendants as $desc) {
                $this->items->delete($desc);
            }
        } else {
            foreach ($item->descendants as $desc) {
                if ($item->getDepth() + 1 == $desc->getDepth()) {
                    $this->items->setNewParent($desc, $item);
                    $this->items->decrementDepth($desc, $item);
                } else {
                    $this->items->decrementDepth($desc, $item);
                }
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
                return $item;
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
