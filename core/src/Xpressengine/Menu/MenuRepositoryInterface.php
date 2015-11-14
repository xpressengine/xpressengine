<?php
/**
 * Menu Repository
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

use Exception;

/**
 * Menu Repository
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
interface MenuRepositoryInterface
{

    /**
     * Get One Menu by Menu ID
     *
     * @param string $menuId string Menu ID
     *
     * @return MenuEntity
     */
    public function findMenu($menuId);

    /**
     * Get One Menu by Menu Item ID
     *
     * @param string $itemId string Menu Item ID
     *
     * @return MenuEntity
     */
    public function findMenuByItem($itemId);

    /**
     * findAllMenu
     * Return All Array of Menu Ids
     *
     * @param string $siteKey site key
     *
     * @return array
     */
    public function findAllMenuIds($siteKey);

    /**
     * Update Menu Object
     *
     * @param MenuEntity $menu menu object for update
     *
     * @return int $affectedRow
     */
    public function updateMenu(MenuEntity $menu);

    /**
     * Delete Menu
     *
     * @param MenuEntity $menu menu instance of menu entity
     *
     * @return void
     * @throws Exception
     */
    public function deleteMenu(MenuEntity $menu);

    /**
     * Create New Menu
     *
     * @param MenuEntity $menu new menu object to create
     *
     * @return MenuEntity
     */
    public function insertMenu(MenuEntity $menu);

    /**
     * Create New Item on Menu
     *
     * @param MenuItem $item new menuItem object to add at menu
     *
     * @return MenuItem
     * @throws Exception
     */
    public function insertItem(MenuItem $item);

    /**
     * Update MenuItem
     *
     * @param MenuItem $item item's id
     *
     * @return int affected row count
     */
    public function updateItem(MenuItem $item);

    /**
     * Delete Menu Item Menu Id & by Item Id
     *
     * @param MenuItem $item menu item
     *
     * @return int $affectedRow
     */
    public function deleteItem(MenuItem $item);

    /**
     * Get One Item by Item ID
     *
     * @param string $itemId string Item ID
     *
     * @return MenuItem
     */
    public function findItem($itemId);

    /**
     * count 메소드 동일한 메뉴 아이디가 이미 있는지 체크하는데 사용되는 함수
     *
     * @param string $menuId MenuEntity id
     *
     * @return int
     */
    public function countMenu($menuId);

    /**
     * count 메소드 동일한 메뉴 아이템 아이디가 이미 있는지 체크하는데 사용되는 함수
     *
     * @param string $itemId item id
     *
     * @return int
     */
    public function countItem($itemId);

    /**
     * Get children node items
     *
     * @param MenuItem $parent item object
     * @return MenuItem[]
     */
    public function children(MenuItem $parent);

    /**
     * return Menu XeDB row by menu Id
     *
     * @param string $itemId menuItem Id to get
     *
     * @return string
     */
    public function getMenuIdByItem($itemId);
}
