<?php
/**
 * Menu
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

use Xpressengine\Routing\InstanceConfig;

if (!function_exists('getCurrentInstanceId')) {
    /**
     * Return current Instance Id
     *
     * @return string
     */
    function getCurrentInstanceId()
    {
        $instanceConfig = InstanceConfig::instance();
        return $instanceConfig->getInstanceId();
    }
}
