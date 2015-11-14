<?php
/**
 * This file is a registered information.
 *
 * PHP version 5
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Permission;

use ArrayAccess;
use IteratorAggregate;
use ArrayIterator;
use Xpressengine\Support\EntityTrait;

/**
 * register 된 정보를 가지는 클래스
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Registered implements ArrayAccess, IteratorAggregate
{
    use EntityTrait;

    /**
     * Parent Registered instance
     *
     * @var Registered
     */
    protected $parent;

    /**
     * Grant object
     *
     * @var Grant
     */
    protected $grant;

    /**
     * protected property when update
     *
     * @var array
     */
    protected $guarded = ['id', 'type', 'name'];

    /**
     * constructor
     *
     * @param array $attributes attributes array
     */
    public function __construct(array $attributes = [])
    {
        $this->original = $this->attributes = $attributes;

        $grantInfo = isset($attributes['grants']) ? json_decode($attributes['grants'], true) : [];
        $this->grant = new Grant($grantInfo);
    }

    /**
     * Add parent to ancestor
     *
     * @param Registered $parent parent instance
     * @return void
     */
    public function addParent(Registered $parent)
    {
        if ($this->isParent($parent) === true) {
            $this->parent = $parent;
        } elseif ($this->parent !== null) {
            $this->parent->addParent($parent);
        }
    }

    /**
     * Check parent of current at a given.
     *
     * @param Registered $parent parent instance
     * @return bool
     */
    protected function isParent(Registered $parent)
    {
        $aLen = count(explode('.', $this->name));
        $bLen = count(explode('.', $parent->name));

        return $aLen - 1 == $bLen ?: false;
    }

    /**
     * Returns parent registered
     *
     * @return Registered
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get value of without inherit
     *
     * @param string $key grant action name
     * @return mixed|null
     */
    public function pure($key)
    {
        return isset($this->grant->$key) ? $this->grant->$key : null;
    }

    /**
     * Set the grant
     *
     * @param Grant $grant grant object
     * @return void
     */
    public function setGrant(Grant $grant)
    {
        $this->grant = $grant;
    }

    /**
     * Set the item at a given offset.
     *
     * @param mixed $offset array offset
     * @param mixed $value  array value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        // nothing to do
    }

    /**
     * Unset the item at a given offset.
     *
     * @param string $offset array offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        // nothing to do
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param mixed $offset array offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->grant->$offset);
    }

    /**
     * Get an item at a given offset.
     *
     * @param mixed $offset array offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->grant->$offset) ? $this->grant->$offset
                                            : ($this->parent !== null ? $this->parent[$offset] : null);
    }

    /**
     * Get an iterator for the items.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->grant->getAttributes());
    }

    /**
     * returns current attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        $this->attributes['grants'] = json_encode($this->grant->getAttributes());

        return $this->attributes;
    }

    /**
     * Returns depth
     *
     * @return int
     */
    public function getDepth()
    {
        return count(explode('.', $this->name));
    }
}
