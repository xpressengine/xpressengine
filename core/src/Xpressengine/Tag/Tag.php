<?php
/**
 * This file is tag model class
 *
 * PHP version 7
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tag;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * Class Tag
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Tag extends DynamicModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * The table associated with the model for morph.
     *
     * @var string
     */
    protected $taggableTable = 'taggables';

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
    protected $guarded = ['id', 'count'];

    /**
     * Used count of model
     *
     * @return int
     */
    public function getCount()
    {
        if (array_key_exists('cnt', $this->getAttributes())) {
            return $this->getAttribute('cnt');
        } else {
            return $this->getAttribute('count');
        }
    }

    /**
     * Returns table
     *
     * @return string
     */
    public function getTaggableTable()
    {
        return $this->taggableTable;
    }
}
