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
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Permission\Policy;
use Xpressengine\Menu\Models\MenuItem;

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
     * @param Menu|null             $menu menu instance
     * @return bool
     */
    public function access($user, MenuItem $item, Menu $menu = null)
    {
        $breadcrumbs = $this->getItemBreadcrumbs($item, $menu);

        return $this->check($user, $this->get(implode('.', $breadcrumbs)), 'access');
    }

    /**
     * Check visible allows
     *
     * @param MemberEntityInterface $user user instance
     * @param MenuItem              $item menu item instance
     * @param Menu|null             $menu menu instance
     * @return bool
     */
    public function visible($user, MenuItem $item, Menu $menu = null)
    {
        $breadcrumbs = $this->getItemBreadcrumbs($item, $menu);

        return $item->activated === 1 && $this->check($user, $this->get(implode('.', $breadcrumbs)), 'visible');
    }

    /**
     * Returns breadcrumbs for permission
     *
     * @param MenuItem  $item menu item instance
     * @param Menu|null $menu menu instance
     * @return array
     */
    private function getItemBreadcrumbs(MenuItem $item, Menu $menu = null)
    {
        $menu = $menu ?: $item->menu;

        return array_merge([$menu->getKey()], $item->getBreadcrumbs());
    }
}
