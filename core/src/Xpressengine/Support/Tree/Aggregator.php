<?php
/**
 * Aggregator
 *
 * PHP version 7
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support\Tree;

use Illuminate\Support\Str;
use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * Abstract class Aggregator
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class Aggregator extends DynamicModel
{
    use TreeMakerTrait;

    /**
     * The tree instance consisting of item
     *
     * @var Tree
     */
    protected $tree;

    /**
     * Items relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany($this->itemClass(), $this->getForeignKey());
    }

    /**
     * Get a tree of node items
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
     * Get the node item class
     *
     * @return string
     */
    abstract public function itemClass();

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return Str::snake(class_basename($this)).'_id';
    }

    /**
     * Get the count name for model
     *
     * @return string
     */
    abstract public function getCountName();
}
