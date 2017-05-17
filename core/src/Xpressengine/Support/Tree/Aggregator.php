<?php
/**
 * Aggregator
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
        return Str::camel(class_basename($this)).'Id';
    }

    /**
     * Get the count name for model
     *
     * @return string
     */
    abstract public function getCountName();
}
