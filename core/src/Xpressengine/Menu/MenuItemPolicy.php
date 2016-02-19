<?php
/**
 * Menu Entity
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
namespace Xpressengine\Menu;

use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Permission\Policy;

/**
 * Class MenuItemPolicy
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
class MenuItemPolicy extends Policy
{
    /**
     * Check access allows
     *
     * @param MemberEntityInterface $user user instance
     * @param MenuItem              $item menu item instance
     * @return bool
     */
    public function access($user, MenuItem $item)
    {
        return $this->check($user, $this->get($item->getBreadCrumbsKeyString()), 'access');
    }

    /**
     * Check visible allows
     *
     * @param MemberEntityInterface $user user instance
     * @param MenuItem              $item menu item instance
     * @return bool
     */
    public function visible($user, MenuItem $item)
    {
        return $item->activated === 1 && $this->check($user, $this->get($item->getBreadCrumbsKeyString()), 'visible');
    }
}
