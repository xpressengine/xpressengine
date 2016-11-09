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
class MemoryDecorator extends AbstractDecorator
{
    /**
     * Data bag
     *
     * @var array
     */
    protected $bag = [];

    /**
     * Find a menu
     *
     * @param string $id   menu identifier
     * @param array  $with relation
     * @return Menu
     */
    public function find($id, $with = [])
    {
        $key = $this->getWithKey($with);

        if (!isset($this->bag[$id])) {
            $this->bag[$id] = [];
        }
        if (!isset($this->bag[$id][$key])) {
            $this->bag[$id][$key] = $this->repo->find($id, $with);
        }

        return $this->bag[$id][$key];
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
        $key = $this->getWithKey($with);

        $menus = $this->repo->all($siteKey, $with);
        foreach ($menus as $menu) {
            $id = $menu->getKey();
            if (!isset($this->bag[$id])) {
                $this->bag[$id] = [];
            }
            if (!isset($this->bag[$id][$key])) {
                $this->bag[$id][$key] = $menu;
            }
        }

        return $menus;
    }

    /**
     * Update menu
     *
     * @param Menu $menu menu instance
     * @return Menu
     */
    public function update(Menu $menu)
    {
        unset($this->bag[$menu->getKey()]);

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
        unset($this->bag[$menu->getKey()]);
        
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
        unset($this->bag[$item->menu->getKey()]);

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
        unset($this->bag[$item->menu->getKey()]);

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
        unset($this->bag[$item->menu->getKey()]);

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

    /**
     * Get sub key by relationship
     *
     * @param array $with relationships
     * @return string
     */
    private function getWithKey($with = [])
    {
        $with = !is_array($with) ? [$with] : $with;

        if (empty($with)) {
            return '_alone';
        }

        return implode('.', $with);
    }
}
