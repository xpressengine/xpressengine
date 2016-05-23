<?php
/**
 * Menu
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

use Illuminate\Support\Collection;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Routing\InstanceConfig;

if (!function_exists('getCurrentInstanceId')) {
    /**
     * Return current Instance Id
     *
     * @return string
     */
    function getCurrentInstanceId()
    {
        $instanceConfig = InstanceConfig::instance();
        return $instanceConfig->getInstanceId();
    }

    function current_menu()
    {
        $id = getCurrentInstanceId();
        if($id !== null) {
            return MenuItem::find($id);
        }
        return null;
    }

    /**
     * 메뉴를 html 마크업으로 출력할 때, 사용하기 쉽도록 메뉴아이템 리스트를 제공한다.
     *
     * @param string $menuId 출력할 메뉴의 ID
     *
     * @return Collection 메뉴아이템 리스트
     */
    function menu_list($menuId)
    {
        $menu = null;
        if ($menuId !== null) {
            $menu = Menu::with('items.basicImage', 'items.hoverImage', 'items.selectedImage')->find($menuId);
            // pre load
            app('xe.permission')->loadBranch($menuId);
        }

        if ($menu !== null) {
            $current = getCurrentInstanceId();
            if($current !== null) {
                $menu->setItemSelected($current);
            }
            $menuTree = $menu->getTree()->getTreeNodes();
            return $menuTree;
        } else {
            return new Collection();
        }
    }

}
