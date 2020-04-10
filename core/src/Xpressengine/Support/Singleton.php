<?php
/**
 * abstract class Singleton
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

namespace Xpressengine\Support;

/**
 * singleton 패턴을 사용하는 대상의 공통 요소를 가지는 추상 클래스
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class Singleton
{
    /**
     * singleton instances
     *
     * @var array
     */
    private static $instances = [];

    /**
     * do not use constructor
     */
    private function __construct()
    {
        // nothing to do
    }

    /**
     * not able clone
     *
     * @return void
     */
    private function __clone()
    {
        // nothing to do
    }

    /**
     * create instance if not exists
     *
     * @return static
     */
    public static function instance()
    {
        $class = get_called_class();
        if (isset(self::$instances[$class]) === false || self::$instances[$class] === null) {
            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }
}
