<?php
/**
 * helpers.php
 *
 * @category    Module
 * @package     Xpressengine\Module
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

if (!function_exists('shortModuleId')) {
    /**
     * Generate a short Menu Type Id
     *
     * @param  string $moduleId extract 'module/'
     *
     * @return string
     */
    function shortModuleId($moduleId)
    {
        return str_ireplace('module/', '', $moduleId);
    }
}

if (!function_exists('fullModuleId')) {
    /**
     * Get a full Module Id
     *
     * @param  string $moduleId to prepend 'module/'
     *
     * @return string
     */
    function fullModuleId($moduleId)
    {
        if (stripos($moduleId, 'module/') !== false) {
            return $moduleId;
        } else {
            return 'module/' . $moduleId;
        }
    }
}

if (!function_exists('moduleClass')) {
    /**
     * Get a Module Id class name
     *
     * @param  string $moduleId to find menu type class
     *
     * @return string|null
     */
    function moduleClass($moduleId)
    {
        return app('xe.module')->getModuleClassName(fullModuleId($moduleId));
    }
}
