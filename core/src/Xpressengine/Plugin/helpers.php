<?php
/**
 * intercept function. This file is part of the Xpressengine package.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
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
