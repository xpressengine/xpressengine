<?php
/**
 * Editor package helpers
 *
 * PHP version 5
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
if (!function_exists('editor')) {
    /**
     * @param string      $instanceId instance id
     * @param array|false $arguments  argument for editor
     * @return string
     */
    function editor($instanceId, $arguments)
    {
        return app('xe.editor')->get($instanceId)->setArguments($arguments)->render();
    }
}

if (!function_exists('compile')) {
    /**
     * @param string $instanceId instance id
     * @param string $content    content
     * @return string
     */
    function compile($instanceId, $content)
    {
        return app('xe.editor')->compile($instanceId, $content);
    }
}
