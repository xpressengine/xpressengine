<?php
/**
 * intercept function. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

if (function_exists('plugins_path') === false) {
    /**
     * @param string $path
     *
     * @return string
     */
    function plugins_path($path = '')
    {
        $path = trim($path, DIRECTORY_SEPARATOR);
        return rtrim(\XePlugin::getPluginsDir(), DIRECTORY_SEPARATOR).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}
