<?php
/**
 * ComponentInterface class. This file is part of the Xpressengine package.
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
 * 플러그인에서 등록할 수 있는 XpressEngine의 구성요소(Component)들이 구현해야 하는 인터페이스
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
interface ComponentInterface
{
    /**
     * get component's id
     *
     * @return string
     */
    public static function getId();

    /**
     * set component's id
     *
     * @param string $id component id
     *
     * @return void
     */
    public static function setId($id);

    /**
     * set component's information
     *
     * @param string $key   추가하거나 수정할 information의 key
     * @param mixed  $value 추가하거나 수정할 information의 value
     *
     * @return void
     */
    public static function setComponentInfo($key, $value = null);

    /**
     * get component's information
     *
     * @param string $key 검색할 information의 키
     *
     * @return mixed
     */
    public static function getComponentInfo($key = null);

    /**
     * boot
     *
     * @return void
     * @deprecated since beta.28, v3.1 에서 제거 예정
     */
    public static function boot();

    /**
     * return settings settings uri
     *
     * @return null|string
     */
    public static function getSettingsURI();
}
