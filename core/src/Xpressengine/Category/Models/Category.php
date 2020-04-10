<?php
/**
 * This file is category model class.
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

namespace Xpressengine\Category\Models;

use Illuminate\Database\Eloquent\Collection;
use Xpressengine\Support\Tree\Aggregator;

/**
 * Class Category
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Category extends Aggregator
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Category item model
     *
     * @var string
     */
    protected static $itemModel;

    /**
     * Get category items of root level
     *
     * @return Collection
     */
    public function getProgenitors()
    {
        $class = $this->itemClass();

        return $class::progenitors($this)->get();
    }

    /**
     * Get the node item class
     *
     * @return string
     */
    public function itemClass()
    {
        return static::getItemModel();
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

    /**
     * Get the count name for model
     *
     * @return string
     */
    public function getCountName()
    {
        return 'count' ;
    }
}
