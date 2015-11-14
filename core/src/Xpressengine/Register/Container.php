<?php
/**
 * Container class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Register;

/**
 * 이 클래스는 Key Value 의 저장소를 제공합니다.
 * 인터페이스 구성은 Illuminate\Config\Repository 와 유사합니다.
 *
 * 내부 아이템을 구성하기 위해서 Illuminate\Support\Arr 을 사용합니다.
 * 이에 따라 key 를 구분할 때 dot(점, '.') 을 사용합니다.
 * key 구성은 Illuminate config 사용에 대해서 검색하세요.
 *
 * Register 는 CoreRegister, PluginRegister, PluginRegistryManager 를 통해서 사용됩니다.
 *
 * ## 사용
 *
 * ### set()
 * * key 를 이용해서 value 를 등록합니다.
 * ```php
 * Register->set('key', $mixedValue);
 * ```
 * > 'key' 이미 있는경우 Exception 이 발생합니다.
 *
 * * key 를 array 로 사용
 * ```php
 * Register->set([
 * 'key1' => $mixedValue1,
 * 'key2' => $mixedValue2,
 * ]);
 * ```
 * > key 유무에 상관없이 새로 등록됩니다.
 *
 * ### add()
 * * key 를 이용해서 value 를 등록합니다.
 * ```php
 * Register->set('key', $mixedValue);
 * ```
 *  > 'key' 가 없ㅇ면Exception 이 발생합니다.
 *
 * ### has()
 * * key 가 있는지 체크합니다.
 *
 * ### get()
 * * 'key' 의 정보를 반환합니다.
 *
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Container implements RegisterInterface
{
    /**
     * Register 에서 array 를 처리하기 위한 class 이름
     * 기본으로 Illuminate\Support\Arr 을 사용한다.
     * 변경할 이유는 없을 것같고.. DI 하기 위한 처리
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
     * Set a given configuration value.
     * 키가 이미 등록되어 있다면 등록 할 수 없음
     * 새로 생성
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
                $class::add($this->items, $innerKey, $innerValue);
            }
        } else {
            $class::add($this->items, $key, $value);
        }
    }

    /**
     * add item
     * 키가 없으면 등록할 수 없음 - Arr class spec
     * 있는거을 덮어 씀
     *
     * @param  array|string $key   key
     * @param  mixed        $value value for adding
     *
     * @return void
     * @todo   add , set 을 Arr, Repository 의 것을 가져와 놨는데.. 우리 요구사항은 한번 더 체크해 봐야함
     */
    public function add($key, $value)
    {
        $class = $this->arrClass;
        $this->items = $class::add($this->items, $key, $value);
    }

    /**
 * put item
 * 키가 있으면 수정
 *
 * @param  array|string $key   key
 * @param  mixed        $value value for putting
 *
 * @return void
 */
    public function put($key, $value)
    {
        $class = $this->arrClass;
        if ($class::has($this->items, $key)) {
            $this->items = $class::set($this->items, $key, $value);
        }
    }

    /**
     * Prepend a value onto an array configuration value.
     *
     * @param  string $key   key
     * @param  mixed  $value value for prepend
     *
     * @return void
     */
    public function prepend($key, $value)
    {
        $array = $this->get($key);

        array_unshift($array, $value);

        $this->set($key, $array);
    }

    /**
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
