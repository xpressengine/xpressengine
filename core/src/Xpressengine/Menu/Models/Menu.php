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

use Xpressengine\Category\Models\Category;
use Xpressengine\Site\Site;

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
class Menu extends Category
{
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'siteKey', 'description'];

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
