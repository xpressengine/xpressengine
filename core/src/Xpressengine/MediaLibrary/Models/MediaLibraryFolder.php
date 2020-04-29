<?php
/**
 * MediaLibraryFolder.php
 *
 * PHP version 7
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\MediaLibrary\Models;

use Xpressengine\Support\Tree\Node;

/**
 * Class MediaLibraryFolder
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MediaLibraryFolder extends Node
{
    public $incrementing = false;

    public $timestamps = true;

    protected $table = 'media_library_folders';

    protected $fillable = ['disk', 'parent_id', 'name', 'ordering'];

    protected $hidden = ['files'];

    protected static $aggregator;

    /**
     * @return string
     */
    public function getClosureTable()
    {
        return 'media_library_folder_closure';
    }

    /**
     * @return string
     */
    public function getAncestorName()
    {
        return 'ancestor';
    }

    /**
     * @return string
     */
    public function getDescendantName()
    {
        return 'descendant';
    }

    /**
     * @return string
     */
    public function getDepthName()
    {
        return 'depth';
    }

    /**
     * @return string
     */
    public function getParentIdName()
    {
        return 'parent_id';
    }

    /**
     * @return string
     */
    public function getOrderKeyName()
    {
        return 'ordering';
    }

    /**
     * @return string
     */
    public function getAggregatorModel()
    {
        return static::$aggregator;
    }

    /**
     * @return string
     */
    public function getAggregatorKeyName()
    {
        return 'folder_id';
    }

    /**
     * @param string $model model name
     * @return void
     */
    public static function setAggregatorModel($model)
    {
        static::$aggregator = '\\' . ltrim($model, '\\');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(MediaLibraryFile::class, 'folder_id', 'id');
    }
}
