<?php
/**
 * Menu Entity
 *
 * PHP version 7
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Menu;

use Xpressengine\User\UserInterface;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Permission\Policy;
use Xpressengine\Menu\Models\MenuItem;

/**
 * Class MenuItemPolicy
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MenuItemPolicy extends Policy
{
    /**
     * Check access allows
     *
     * @param UserInterface $user user instance
     * @param MenuItem      $item menu item instance
     * @param Menu|null     $menu menu instance
     * @return bool
     */
    public function access(UserInterface $user, MenuItem $item, Menu $menu = null)
    {
        $breadcrumbs = $this->getItemBreadcrumbs($item, $menu);

        return $this->check($user, $this->get(implode('.', $breadcrumbs)), 'access');
    }

    /**
     * Check visible allows
     *
     * @param UserInterface $user user instance
     * @param MenuItem      $item menu item instance
     * @param Menu|null     $menu menu instance
     * @return bool
     */
    public function visible(UserInterface $user, MenuItem $item, Menu $menu = null)
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

        $breadcrumbs = $item->getBreadcrumbs();
        return array_merge([$menu->getKey()], $breadcrumbs->modelKeys());
    }
}
