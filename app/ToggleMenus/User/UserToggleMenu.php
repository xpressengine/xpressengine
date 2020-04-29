<?php
/**
 * UserToggleMenu.php
 *
 * PHP version 7
 *
 * @category    ToggleMenus
 * @package     App\ToggleMenus\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\ToggleMenus\User;

use Xpressengine\ToggleMenu\AbstractToggleMenu as BaseToggleMenu;

/**
 * Abstract Class UserToggleMenu
 *
 * @category    ToggleMenus
 * @package     App\ToggleMenus\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class UserToggleMenu extends BaseToggleMenu
{
    /**
     * Returns the name of the component.
     *
     * @return string
     */
    public static function getName()
    {
        return static::getComponentInfo('name');
    }

    /**
     * Returns the description of the component.
     *
     * @return string
     */
    public static function getDescription()
    {
        return static::getComponentInfo('description');
    }
}
