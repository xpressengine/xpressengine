<?php
/**
 * MenuRetrieveHandler class
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

use Xpressengine\Module\ModuleHandler;

/**
 * MenuRetrieveHandler
 * Menu 및 MenuItem 의 조회를 처리하며
 * MenuAlterHandler 와 같이 메뉴를 처리하는 역활을 함
 *
 * ## app binding : xe.menu 으로 바인딩 되어 있음
 * Menu Facade 로 접근이 가능함.
 *
 * ## 사용법
 *
 * ### 사이트의 전체 Menu 조회
 * * 특정 사이트에 소속된 전체 메뉴를 조회
 * ```php
 * $menuEntities = $menuHandler->getAllMenu($siteKey);
 * ```
 *
 * ### 하나의 Menu 조회
 * * 찾고자 하는 MenuEntity 의 Id 를 인자로 전달
 * ```php
 * $menuHandler->getMenu($menuId);
 * ```
 *
 * ### 하나의 Menu 조회 - 보유하고 있는 Item 의 Id 를 통해서 조회
 * * MenuEntity 가 보유하고 있는 Item 의 Id 를 통해서 찾고자 할때 사용.
 * * Item Id 를 인자로 전달함.
 * ```php
 * $menuHandler->getMenuByItem($itemId);
 * ```
 *
 * ### MenuItem 조회
 * * 찾고자 하는 MenuItem 의 Id 를 인자로 전달
 * ```php
 * $menuHandler->getItem($itemId);
 * ```
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuRetrieveHandler
{
    /**
     * @var DBMenuRepository
     */
    protected $menuRepository;
    /**
     * @var ModuleHandler
     */
    protected $typeHandler;
    /**
     * @var MenuPermissionHandler
     */
    protected $menuPermission;
    /**
     * @var MenuCacheHandler $cache
     */
    protected $cache;

    /**
     * @param MenuRepositoryInterface $menuRepository menu repository
     * @param ModuleHandler           $typeHandler    type handler
     * @param MenuPermissionHandler   $menuPermission menu permission
     * @param MenuCacheHandler        $cacheHandler   menu cache handler
     */
    public function __construct(
        MenuRepositoryInterface $menuRepository,
        ModuleHandler $typeHandler,
        MenuPermissionHandler $menuPermission,
        MenuCacheHandler $cacheHandler
    ) {
        $this->menuRepository = $menuRepository;
        $this->typeHandler = $typeHandler;
        $this->menuPermission = $menuPermission;
        $this->cache = $cacheHandler;
    }

    /**
     * Return All Menu
     *
     * @param string $siteKey site key
     *
     * @return MenuEntity[]
     */
    public function getAllMenu($siteKey)
    {
        $menus = [];
        $menuIds = $this->menuRepository->findAllMenuIds($siteKey);
        foreach ($menuIds as $menuId) {
            if ($this->cache->isExistCachedMenu($menuId)) {
                $menu = $this->cache->getCachedMenu($menuId);
            } else {
                $menu = $this->menuRepository->findMenu($menuId);
                $this->applyMenuPermission($menu);
                $this->cache->setCachedMenu($menu);
            }
            $menus[$menu->id] = $menu;
        }
        return $menus;
    }

    /**
     * Return One Menu by Menu Id
     *
     * @param string $menuId menu Id to find one menu
     *
     * @return MenuEntity
     */
    public function getMenu($menuId)
    {
        if ($this->cache->isExistCachedMenu($menuId)) {
            return $this->cache->getCachedMenu($menuId);
        } else {
            $menu = $this->menuRepository->findMenu($menuId);
            $this->applyMenuPermission($menu);
            $this->cache->setCachedMenu($menu);
            return $menu;
        }
    }

    /**
     * Return One Menu by MenuItem Id
     *
     * @param string $itemId menuItem Id to find one menu
     *
     * @return MenuEntity
     */
    public function getMenuByItem($itemId)
    {
        $menuId = $this->findMenuIdOnMap($itemId);

        return $this->getMenu($menuId);
    }

    /**
     * Return One Item by Item Id
     *
     * @param string $itemId       item Id to find one item
     * @param bool   $selected     flag to menu item selected
     * @param bool   $parentSelect flag to parent item selected
     *
     * @return MenuItem
     */
    public function getItem($itemId, $selected = true, $parentSelect = true)
    {
        $menu = $this->getMenuByItem($itemId);
        $item = $menu->getItem($itemId);
        $item->setSelected($selected, $parentSelect);
        return $item;
    }

    /**
     * applyMenuPermission
     *
     * @param object $target menu entity or menu item object
     *
     * @return void
     */
    protected function applyMenuPermission($target)
    {
        $permissions = $this->menuPermission->getMenuPermissions();
        $target->applyPermission($permissions);
    }

    /**
     * findMenuIdOnMap
     *
     * @param string $itemId menu item object id
     *
     * @return string
     */
    protected function findMenuIdOnMap($itemId)
    {
        $menuMap = $this->cache->getMenuMap();
        if (isset($menuMap[$itemId])) {
            $menuId = $menuMap[$itemId];
            if ($menuId !== null) {
                return $menuId;
            }
        }
        $menuId = $this->menuRepository->getMenuIdByItem($itemId);
        return $menuId;
    }
}
