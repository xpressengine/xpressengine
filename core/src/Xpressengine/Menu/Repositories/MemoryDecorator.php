<?php
/**
 * MemoryDecorator
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */
namespace Xpressengine\Menu\Repositories;

use Xpressengine\Menu\MenuRepository;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;

/**
 * Class MemoryDecorator
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */
class MemoryDecorator implements MenuRepository
{
    /**
     * MenuRepository instance
     *
     * @var MenuRepository
     */
    protected $repo;

    /**
     * Data bag
     *
     * @var array
     */
    protected $bag = [];

    /**
     * Data bag
     *
     * @var array
     */
    protected $itemBag = [];

    /**
     * MemoryDecorator constructor.
     *
     * @param MenuRepository $repo MenuRepository instance
     */
    public function __construct(MenuRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Find a menu
     *
     * @param string $id   menu identifier
     * @param array  $with relation
     * @return Menu
     */
    public function find($id, $with = [])
    {
        if (!isset($this->bag[$id])) {
            $this->bag[$id] = $this->repo->find($id, $with);
        }

        return $this->bag[$id];
    }

    /**
     * Get all menu
     *
     * @param string $siteKey site key
     * @param array  $with    relation
     * @return Menu[]
     */
    public function all($siteKey, $with = [])
    {
        $menus = $this->repo->all($siteKey, $with);
        foreach ($menus as $menu) {
            $this->bag[$menu->getKey()] = $menu;
        }

        return $menus;
    }

    /**
     * Find a menu item
     *
     * @param string $id   menu item identifier
     * @param array  $with relation
     * @return MenuItem
     */
    public function findItem($id, $with = [])
    {
        if (!isset($this->itemBag[$id])) {
            $this->itemBag[$id] = $this->repo->findItem($id, $with);
        }

        return $this->itemBag[$id];
    }

    /**
     * Get menu items by identifier list
     *
     * @param array $ids  menu item identifier
     * @param array $with relation
     * @return MenuItem[]
     */
    public function fetchInItem(array $ids, $with = [])
    {
        $items = $this->repo->fetchInItem($ids, $with);

        foreach ($items as $item) {
            $this->bag[$item->getKey()] = $item;
        }

        return $items;
    }

    /**
     * Insert menu
     *
     * @param Menu $menu menu instance
     * @return Menu
     */
    public function insert(Menu $menu)
    {
        $menu = $this->repo->insert($menu);
        $this->bag[$menu->getKey()] = $menu;

        return $menu;
    }

    /**
     * Update menu
     *
     * @param Menu $menu menu instance
     * @return Menu
     */
    public function update(Menu $menu)
    {
        $menu = $this->repo->update($menu);
        $this->bag[$menu->getKey()] = $menu;

        return $menu;
    }

    /**
     * Delete menu
     *
     * @param Menu $menu menu instance
     * @return bool
     */
    public function delete(Menu $menu)
    {
        unset($this->bag[$menu->getKey()]);
        
        return $this->repo->delete($menu);
    }

    /**
     * Increment item count
     *
     * @param Menu $menu   menu instance
     * @param int  $amount amount
     * @return bool
     */
    public function increment(Menu $menu, $amount = 1)
    {
        $result = $this->repo->increment($menu, $amount);
        $this->bag[$menu->getKey()] = $menu;

        return $result;
    }

    /**
     * Insert menu item
     *
     * @param MenuItem $item menu item instance
     * @return MenuItem
     */
    public function insertItem(MenuItem $item)
    {
        $item = $this->repo->insertItem($item);
        $this->itemBag[$item->getKey()] = $item;

        return $item;
    }

    /**
     * Update menu item
     *
     * @param MenuItem $item menu item instance
     * @return MenuItem
     */
    public function updateItem(MenuItem $item)
    {
        $item = $this->repo->updateItem($item);
        $this->itemBag[$item->getKey()] = $item;

        return $item;
    }

    /**
     * Delete menu item
     *
     * @param MenuItem $item menu item instance
     * @return bool
     */
    public function deleteItem(MenuItem $item)
    {
        unset($this->itemBag[$item->getKey()]);

        return $this->repo->deleteItem($item);
    }

    /**
     * Create new menu model
     *
     * @return Menu
     */
    public function createModel()
    {
        return $this->repo->createModel();
    }

    /**
     * Create new menu item model
     *
     * @param Menu $menu menu instance
     * @return MenuItem
     */
    public function createItemModel(Menu $menu = null)
    {
        return $this->repo->createItemModel($menu);
    }
}
