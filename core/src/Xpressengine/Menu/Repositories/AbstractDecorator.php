<?php
/**
 * AbstractDecorator.php
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
 * Abstract class AbstractDecorator
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */
abstract class AbstractDecorator implements MenuRepository
{
    /**
     * MenuRepository instance
     *
     * @var MenuRepository
     */
    protected $repo;

    /**
     * AbstractDecorator constructor.
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
        return $this->repo->find($id, $with);
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
        return $this->repo->all($siteKey, $with);
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
        return $this->repo->findItem($id, $with);
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
        return $this->repo->fetchInItem($ids, $with);
    }

    /**
     * Insert menu
     *
     * @param Menu $menu menu instance
     * @return Menu
     */
    public function insert(Menu $menu)
    {
        return $this->repo->insert($menu);
    }

    /**
     * Update menu
     *
     * @param Menu $menu menu instance
     * @return Menu
     */
    public function update(Menu $menu)
    {
        return $this->repo->update($menu);
    }

    /**
     * Delete menu
     *
     * @param Menu $menu menu instance
     * @return bool
     */
    public function delete(Menu $menu)
    {
        return $this->repo->delete($menu);
    }

    /**
     * Insert menu item
     *
     * @param MenuItem $item menu item instance
     * @return MenuItem
     */
    public function insertItem(MenuItem $item)
    {
        return $this->repo->insertItem($item);
    }

    /**
     * Update menu item
     *
     * @param MenuItem $item menu item instance
     * @return MenuItem
     */
    public function updateItem(MenuItem $item)
    {
        return $this->repo->updateItem($item);
    }

    /**
     * Delete menu item
     *
     * @param MenuItem $item menu item instance
     * @return bool
     */
    public function deleteItem(MenuItem $item)
    {
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
