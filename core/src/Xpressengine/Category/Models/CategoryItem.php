<?php
/**
 * This file is category item model class.
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
namespace Xpressengine\Category\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CategoryItem
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 *
 * @property Category $category
 */
class CategoryItem extends Node
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_item';

    /**
     * The pivot table associated with the model.
     *
     * @var string
     */
    protected $hierarchyTable = 'category_item_hierarchy';

    /**
     * protected property when update
     *
     * @var array
     */
    protected $guarded = ['id', 'categoryId'];

    /**
     * Node group relationship
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    /**
     * Scope for get node items of progenitor
     *
     * @param Builder  $query    query builder
     * @param Category $category category instance
     * @return Builder
     */
    public function scopeProgenitors(Builder $query, Category $category)
    {
        return $this->scopeRoots($query)->where('categoryId', $category->getKey());
    }

    /**
     * Get the pivot table for model's hierarchy
     *
     * @return string
     */
    public function getHierarchyTable()
    {
        return $this->hierarchyTable;
    }

    /**
     * Get the ancestor key name of pivot table
     *
     * @return string
     */
    public function getAncestorName()
    {
        return 'ancestor';
    }

    /**
     * Get the descendant key name of pivot table
     *
     * @return string
     */
    public function getDescendantName()
    {
        return 'descendant';
    }

    /**
     * Get the depth key name of pivot table
     *
     * @return string
     */
    public function getDepthName()
    {
        return 'depth';
    }

    /**
     * Get the parent key name for model
     *
     * @return string
     */
    public function getParentIdName()
    {
        return 'parentId';
    }

    /**
     * Get the order key name for model
     *
     * @return string
     */
    public function getOrderKeyName()
    {
        return 'ordering';
    }
}
