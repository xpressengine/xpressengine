<?php
/**
 * widget helper function. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Team (develop) <develops@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

if (function_exists('widget') === false) {
    /**
     * widget
     *
     * @param string  $id       widget id
     * @param array   $args     to render html arguments
     * @param closure $callback if it need
     *
     * @return mixed
     */
    function widget($id, $args = [], $callback = null)
    {
        return app('xe.widget')->create($id, $args, $callback);
    }
}

if (function_exists('setupWidget') === false) {
    /**
     * setupWidget
     *
     * @param string $id widget id
     *
     * @return mixed
     */
    function setupWidget($id)
    {
        return app('xe.widget')->setup($id);
    }
}

if (!function_exists('shortWidgetId')) {
    /**
     * Generate a short Menu Type Id
     *
     * @param  string $widgetId widget id
     *
     * @return string
     */
    function shortWidgetId($widgetId)
    {
        return str_ireplace('widget/', '', $widgetId);
    }
}

if (!function_exists('fullWidgetId')) {
    /**
     * Get a full Menu Type Id
     *
     * @param  string $widgetId widget id
     *
     * @return string
     */
    function fullWidgetId($widgetId)
    {
        if (stripos($widgetId, 'widget/') !== false) {
            return $widgetId;
        } else {
            return 'widget/' . $widgetId;
        }
    }
}
