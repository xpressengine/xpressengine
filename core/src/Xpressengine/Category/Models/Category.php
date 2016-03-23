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
use Xpressengine\Support\Tree\Tree;
use Xpressengine\Support\Tree\TreeMakerTrait;

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
    use TreeMakerTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_group';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The tree instance consisting of item
     *
     * @var Tree
     */
    protected $tree;

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
     * Get a tree of category items
     *
     * @return Tree
     */
    public function getTree()
    {
        if (!$this->tree) {
            $this->tree = $this->makeTree($this->items);
        }

        return $this->tree;
    }

    /**
     * Set the category item model
     *
     * @param string $model model name
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
