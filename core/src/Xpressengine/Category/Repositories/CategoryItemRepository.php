<?php
/**
 * CategoryItemRepository.php
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

namespace Xpressengine\Category\Repositories;

use Illuminate\Contracts\Events\Dispatcher;
use Xpressengine\Category\Models\CategoryItem;
use Xpressengine\Support\EloquentRepositoryTrait;

/**
 * Class CategoryItemRepository
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CategoryItemRepository
{
    use EloquentRepositoryTrait {
        delete as traitDelete;
    }

    /**
     * Event dispatcher instance
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Category model class provider
     *
     * @var callable
     */
    protected static $provider;

    /**
     * CategoryItemRepository constructor.
     *
     * @param Dispatcher $dispatcher Event dispatcher instance
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Create category item
     *
     * @param array $attributes attributes
     * @return CategoryItem
     */
    public function create(array $attributes = [])
    {
        $item = $this->createModel()->create($attributes);
        $item->ancestors()->attach($item->getKey(), [$item->getDepthName() => 0]);
        $this->dispatcher->fire('xe.category.categoryitem.created', $item);

        return $item;
    }

    /**
     * Delete a category item
     *
     * @param CategoryItem $item category item
     * @return bool|null
     */
    public function delete(CategoryItem $item)
    {
        $item->ancestors(false)->detach();
//        $item->descendants(false)->detach();

        $result = $this->traitDelete($item);
        $this->dispatcher->fire('xe.category.categoryitem.deleted', $item);

        return $result;
    }

    /**
     * Exclude object from ancestors of item
     *
     * @param CategoryItem $item     category item
     * @param CategoryItem $excluded to be excluded category item
     * @return void
     */
    public function exclude(CategoryItem $item, CategoryItem $excluded)
    {
        $item->descendants()->newPivotStatement()
            ->where($item->getDescendantName(), $item->getKey())
            ->where($item->getAncestorName(), '!=', $excluded->getKey())
            ->where($item->getDepthName(), '>', 0)
            ->decrement($item->getDepthName());

        $parentId = ($parent = $item->getParent()) ? $parent->getKey() : null;

        $this->update($item, [$item->getParentIdName() => $parentId]);
    }

    /**
     * 카테고리를 삭제할 때 자식 카테고리의 부모 카테고리id 재설정
     *
     * @param CategoryItem $desc    삭제할 카테고리의 자식 카테고리
     * @param CategoryItem $delItem 삭제할 카테고리
     *
     * @return void
     */
    public function setNewParent(CategoryItem $desc, CategoryItem $delItem)
    {
        $newParentId = ($newParent = $delItem->getParent()) ? $newParent->getKey() : null;
        $delItemOrdering = $delItem[$delItem->getOrderKeyName()];

        $this->update($desc, [$desc->getParentIdName() => $newParentId, $desc->getOrderKeyName() => $delItemOrdering]);
    }

    /**
     * 삭제할 카테고리의 자식 카테고리들 depth를 감소
     *
     * @param CategoryItem $desc    삭제할 카테고리의 자식 카테고리
     * @param CategoryItem $delItem 삭제할 카테고리
     *
     * @return void
     */
    public function decrementDepth(CategoryItem $desc, CategoryItem $delItem)
    {
        $delItemDepth = $desc->descendants()->newPivotStatement()
            ->where($desc->getDescendantName(), $desc->getKey())
            ->where($desc->getAncestorName(), '=', $delItem->getKey())
            ->get()->first()->depth;

        $desc->descendants()->newPivotStatement()
            ->where($desc->getDescendantName(), $desc->getKey())
            ->where($desc->getAncestorName(), '!=', $delItem->getKey())
            ->where($desc->getDepthName(), '>=', $delItemDepth)
            ->decrement($desc->getDepthName());

        $desc->descendants()->newPivotStatement()
            ->where($desc->getDescendantName(), $desc->getKey())
            ->where($desc->getAncestorName(), '=', $delItem->getKey())
            ->delete();
    }

    /**
     * The name of Category model class
     *
     * @return string
     */
    public static function getModel()
    {
        $categoryModel = static::provideCategoryModel();

        return $categoryModel::getItemModel();
    }

    /**
     * Set the name of Category model
     *
     * @param string $model model class
     * @return void
     */
    public static function setModel($model)
    {
        $categoryModel = static::provideCategoryModel();
        $categoryModel::setItemModel($model);

        static::setAggregator($categoryModel);
    }

    /**
     * Set aggregator to model
     *
     * @param string $aggregator aggregator class
     * @return void
     */
    protected static function setAggregator($aggregator)
    {
        $model = static::getModel();
        $model::setAggregatorModel($aggregator);
    }

    /**
     * Set category model class provider
     *
     * @param callable $provider callable
     * @return void
     */
    public static function setCategoryModelProvider(callable $provider)
    {
        static::$provider = $provider;
    }

    /**
     * Provide category model class
     *
     * @return string
     */
    public static function provideCategoryModel()
    {
        return call_user_func(static::$provider);
    }
}
