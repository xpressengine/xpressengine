<?php
/**
 * Entity Trait
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Support;

/**
 * entity object 의 기본 get, set을 선언하고
 * 최초의 속성값과 변화된 이후의 속성값을 비교하여 다른 값을 반환해주는
 * 기능을 제공 함.
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @deprecated
 */
trait EntityTrait
{
    /**
     * original attributes
     *
     * @var array
     */
    protected $original = [];

    /**
     * current attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * constructor
     *
     * @param array $attributes attributes in object
     */
    public function __construct(array $attributes = [])
    {
        $this->original = $this->attributes = $attributes;
    }

    /**
     * returns original attributes
     *
     * @return array
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * returns current attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * different original and current attributes
     *
     * @return array
     */
    public function diff()
    {
        return array_diff_assoc($this->getAttributes(), $this->original);
    }

    /**
     * Access the original attributes.
     *
     * @param string $key key name of want get attribute
     * @return mixed
     */
    public function raw($key)
    {
        return isset($this->original[$key]) ? $this->original[$key] : null;
    }

    /**
     * Fill all attributes
     *
     * @param array $attributes attributes in object
     * @return void
     */
    public function fill(array $attributes)
    {
        if (property_exists($this, 'fillable')) {
            $attributes = array_intersect_key($attributes, array_flip($this->{'fillable'}));
        }

        $this->attributes = $attributes;
    }

    /**
     * Visible attribute returns to array
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = $this->getAttributes();
        if (property_exists($this, 'hidden')) {
            $attributes = array_diff_key($attributes, array_flip($this->{'hidden'}));
        }

        return $attributes;
    }

    /**
     * Dynamically access the object attributes.
     *
     * @param string $key key name of want get attribute
     * @return mixed
     */
    public function __get($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    /**
     * Dynamically set an attribute on the user.
     *
     * @param string $key key name of want set attribute
     * @param mixed  $val match value of key name
     * @return void
     */
    public function __set($key, $val)
    {
        if (isset($this->original[$key]) !== true
            || property_exists($this, 'guarded') !== true
            || in_array($key, $this->{'guarded'}) !== true) {
            $this->attributes[$key] = $val;
        }
    }

    /**
     * Dynamically check if a value is set on the object.
     *
     * @param string $key key name of want check attribute
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Dynamically unset a value on the object.
     *
     * @param string $key key name of want clear attribute
     * @return void
     */
    public function __unset($key)
    {
        if (property_exists($this, 'guarded') !== true || in_array($key, $this->{'guarded'}) !== true) {
            unset($this->attributes[$key]);
        }
    }
}
