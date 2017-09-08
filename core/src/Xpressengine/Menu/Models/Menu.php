<?php
/**
 * Menu
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Menu\Models;

use Xpressengine\Category\Models\Category;
use Xpressengine\Site\Site;

/**
 * Class Menu
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 *
 * @property string $id
 * @property string $title
 * @property string $site_key
 * @property string $description
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
    protected $fillable = ['title', 'site_key', 'description'];

    /**
     * Item model class
     *
     * todo: see Category class
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
        return $this->belongsTo(Site::class, 'site_key', 'site_key');
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
