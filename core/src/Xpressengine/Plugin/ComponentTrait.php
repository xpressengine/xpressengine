<?php
/**
 * ComponentTrait trait. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin;

/**
 * ComponentInterface를 구현한 Trait
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait ComponentTrait
{
    /**
     * Component id,
     * 만약 이 trait을 사용한 클래스를 상속한 클래스가 id를 지정하지 않았다면, 그 클래스의 id는 이 trait에서 가지고 있는 id에 저장된다.
     *
     * @var array
     */
    private static $id = [];

    /**
     * Component Informations,
     * 만약 이 trait을 사용한 클래스를 상속한 클래스가 componentInfo를 지정하지 않았다면,
     * 그 클래스의 infomation은 이 trait에서 가지고 있는 componentInfo에 저장된다.
     *
     * @var array
     */
    private static $componentInfo = [];

    /**
     * component의 id를 반환한다.
     *
     * @return string
     */
    public static function getId()
    {
        if (property_exists(static::class, 'id')) {
            return static::$id;
        }

        return array_get(self::$id, static::class, null);
    }

    /**
     * component의 id를 지정한다.
     *
     * @param string $id 지정할 id
     *
     * @return void
     */
    public static function setId($id)
    {
        if (property_exists(static::class, 'id')) {
            static::$id = $id;
        } else {
            self::$id[static::class] = $id;
        }
    }

    /**
     * information을 검색한다.
     *
     * @param string $key 검색할 information의 키
     *
     * @return mixed 검색된 information를 반환함.
     */
    public static function getComponentInfo($key = null)
    {
        if (property_exists(static::class, 'componentInfo')) {
            return array_get(static::$componentInfo, $key);
        }
        return array_get(self::$componentInfo, static::class.'.'.$key);
    }

    /**
     * information을 추가하거나 수정한다.
     *
     * @param string $key   추가하거나 수정할 information의 key
     * @param mixed  $value 추가하거나 수정할 information의 value
     *
     * @return void
     */
    public static function setComponentInfo($key, $value = null)
    {
        if ($value !== null) {
            $key = [$key => $value];
        }

        if (property_exists(static::class, 'componentInfo')) {
            static::$componentInfo = array_merge(static::$componentInfo, $key);
        } else {
            $componentInfo = array_get(self::$componentInfo, static::class, []);
            $componentInfo = array_merge($componentInfo, $key);
            self::$componentInfo = array_add(self::$componentInfo, static::class, $componentInfo);
        }
    }

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
    }


    /**
     * return settings manage uri
     *
     * @return null|string
     */
    public static function getSettingsURI()
    {
        return null;
    }
}
