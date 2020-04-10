<?php
/**
 * Container class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Register;

use Xpressengine\Register\Exceptions\ValueMustBeArrayException;

/**
 * Class Container. 이 클래스는 Key Value의 저장소를 제공합니다.
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Container implements RegisterInterface
{
    /**
     * Register 에서 array 를 처리하기 위한 class 이름
     * 기본으로 Illuminate\Support\Arr 을 사용한다.
     *
     * @var \Illuminate\Support\Arr
     */
    protected $arrClass;

    /**
     * @var array registered items
     */
    protected $items = [];

    /**
     * @param \Illuminate\Support\Arr $arrClass array class name
     */
    public function __construct($arrClass)
    {
        $this->arrClass = $arrClass;
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string $key key
     *
     * @return bool
     */
    public function has($key)
    {
        $class = $this->arrClass;
        return $class::has($this->items, $key);
    }

    /**
     * Get the specified configuration value.
     *
     * @param  string $key     key
     * @param  mixed  $default default value
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $class = $this->arrClass;
        return $class::get($this->items, $key, $default);
    }

    /**
     * 주어진 key에 value를 지정한다. 이미 지정된 value가 있다면 덮어씌운다.
     *
     * @param  array|string $key   key
     * @param  mixed        $value value for setting
     *
     * @return void
     */
    public function set($key, $value = null)
    {
        $class = $this->arrClass;

        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                $class::set($this->items, $innerKey, $innerValue);
            }
        } else {
            $class::set($this->items, $key, $value);
        }
    }

    /**
     * 주어진 key에 value를 추가한다.
     * 만약 해당 key에 지정된 value가 이미 있을 경우, 아무 행동도 하지 않는다.
     *
     * @param  array|string $key   key
     * @param  mixed        $value value for adding
     *
     * @return void
     */
    public function add($key, $value)
    {
        $class = $this->arrClass;
        $this->items = $class::add($this->items, $key, $value);
    }

    /**
     * 주어진 키에 해당하는 array의 제일 앞에 value를 추가한다.
     * 만약 주어진 키에 해당하는 array가 없다면 array를 생성후 추가한다.
     *
     * @param  string $key   key
     * @param  mixed  $value value for prepend
     *
     * @return void
     */
    public function prepend($key, $value)
    {
        $array = $this->get($key, []);

        if (!is_array($array)) {
            throw new ValueMustBeArrayException();
        }

        array_unshift($array, $value);

        $this->set($key, $array);
    }

    /**
     * 주어진 키에 해당하는 array의 제일 뒤에 value를 추가한다.
     * 만약 주어진 키에 해당하는 array가 없다면 array를 생성후 추가한다.
     *
     *
     *
     *
     * Push a value onto an array configuration value.
     *
     * @param  string $key   key
     * @param  mixed  $id    pushed data's id
     * @param  mixed  $value pushed data's value
     *
     * @return void
     */
    public function push($key, $id, $value = null)
    {
        $array = $this->get($key, []);

        if (!is_array($array)) {
            throw new ValueMustBeArrayException();
        }

        if ($value === null) {
            $value = $id;
            $array[] = $value;
        } else {
            $array[$id] = $value;
        }

        $class = $this->arrClass;
        $this->items = $class::set($this->items, $key, $array);
    }

    /**
     * 등록된 모든 아이템을 조회한다.
     *
     * Get all of the configuration items for the application.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Determine if the given configuration option exists.
     *
     * @param  string $key key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Get a configuration option.
     *
     * @param  string $key key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set a configuration option.
     *
     * @param string $key   key
     * @param mixed  $value value for setting
     *
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Unset a configuration option.
     *
     * @param  string $key key
     *
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->set($key, null);
    }
}
