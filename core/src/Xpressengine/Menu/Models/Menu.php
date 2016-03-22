<?php
/**
 * Menu
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Menu\Models;

use Illuminate\Database\Eloquent\Collection;
use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\Site\Site;
use Xpressengine\Support\Tree\Tree;
use Xpressengine\Support\Tree\TreeMakerTrait;

/**
 * Class Menu
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 *
 * @property string $id
 * @property string $title
 * @property string $siteKey
 * @property string $description
 */
class Menu extends DynamicModel
{
    use TreeMakerTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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
     * Item model class
     *
     * @var string
     */
    protected static $itemModel = MenuItem::class;

    /**
     * Relation of site
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {
        return $this->belongsTo(Site::class, 'siteKey', 'siteKey');
    }

    /**
     * Relation of items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(static::$itemModel, 'menuId');
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
     * Set selected to item has given key
     *
     * @param string $itemKey item key
     * @return void
     */
    public function setItemSelected($itemKey)
    {
        $tree = $this->getTree();

        if (isset($tree[$itemKey])) {
            $tree[$itemKey]->setSelected();
        }
    }

    /**
     * Set the menu item model
     *
     * @param string $model model class
     * @return void
     */
    public static function setItemModel($model)
    {
        static::$itemModel = '\\' . ltrim($model, '\\');
    }

    /**
     * Get the menu item model
     *
     * @return string
     */
    public static function getItemModel()
    {
        return static::$itemModel;
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $tree = $this->getTree();

        return array_merge(parent::toArray(), [
            'items' => $tree,
            'entity' => 'menu',
            'itemCount' => $tree->size()
        ]);
    }
}
