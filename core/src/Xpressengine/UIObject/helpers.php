<?php
/**
 * intercept function. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    UIObject
 * @package     Xpressengine\UIObject
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

if (function_exists('uio') === false) {
    function uio($id, $args = [], $callback = null)
    {
        return \UI::create($id, $args, $callback);
    }
}
