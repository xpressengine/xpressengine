<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\ToggleMenus\User;

use Xpressengine\ToggleMenu\AbstractToggleMenu as BaseToggleMenu;

/**
 * @category
 * @package     App\ToggleMenus\User
 */
abstract class UserToggleMenu extends BaseToggleMenu
{
    public static function getName()
    {
        return static::getComponentInfo('name');
    }

    public static function getDescription()
    {
        return static::getComponentInfo('description');
    }
}
