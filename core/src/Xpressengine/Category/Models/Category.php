<?php
/**
 * This file is category model class.
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

use Xpressengine\Database\Eloquent\DynamicModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Team (developers) <deelopers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Category extends DynamicModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_group';

    /**
     * Category item model
     *
     * @var string
     */
    protected static $itemModel = CategoryItem::class;

    /**
     * Items relationship
     *
     * @return HasMany
     */
    public function items()
    {
        return $this->hasMany(static::$itemModel, 'categoryId');
    }

    /**
     * Get category items of root level
     *
     * @return Collection
     */
    public function getProgenitors()
    {
        $class = static::getItemModel();

        return $class::progenitors($this)->get();
    }

    /**
     * Get a tree collection of category items
     *
     * @return Collection
     */
    public function getTree()
    {
        $collection = new Collection();

        $progenitors = $this->getProgenitors();

        /** @var CategoryItem $item */
        foreach ($progenitors as $item) {
            $item->setRelation($item->getTreeRelationName(), $item->getDescendantTree());
            $collection->put($item->getKey(), $item);
        }

        return $collection;
    }

    /**
     * Set the category item model
     *
     * @param $model
     * @return void
     */
    public static function setItemModel($model)
    {
        static::$itemModel = '\\' . ltrim($model, '\\');
    }

    /**
     * Get the category item model
     *
     * @return string
     */
    public static function getItemModel()
    {
        return static::$itemModel;
    }
}
