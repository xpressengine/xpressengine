<?php
/**
 * CacheDecorator
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
use Xpressengine\Support\CacheInterface;

/**
 * Class CacheDecorator
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */
class CacheDecorator implements MenuRepository
{
    /**
     * MenuRepository instance
     *
     * @var MenuRepository
     */
    protected $repo;

    /**
     * Cache instance
     *
     * @var CacheInterface
     */
    protected $cache;

    /**
     * Prefix for cache key
     *
     * @var string
     */
    protected $prefix = 'menu';

    /**
     * CacheDecorator constructor.
     *
     * @param MenuRepository $repo  MenuRepository instance
     * @param CacheInterface $cache Cache instance
     */
    public function __construct(MenuRepository $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
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
        $key = $this->getCacheKey($id);

        return $this->cache->has($key) ? $this->cache->get($key) : call_user_func(
            function () use ($key, $id, $with) {
                if ($menu = $this->repo->find($id, $with)) {
                    $this->cache->put($key, $menu);
                }

                return $menu;
            }
        );
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
        $key = $this->getCacheKey($siteKey . '_all');

        return $this->cache->has($key) ? $this->cache->get($key) : call_user_func(
            function () use ($key, $siteKey, $with) {
                if ($menu = $this->repo->all($siteKey, $with)) {
                    $this->cache->put($key, $menu);
                }

                return $menu;
            }
        );
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
        $key = $this->getItemCacheKey($id);

        return $this->cache->has($key) ? $this->cache->get($key) : call_user_func(
            function () use ($key, $id, $with) {
                if ($menu = $this->repo->findItem($id, $with)) {
                    $this->cache->put($key, $menu);
                }

                return $menu;
            }
        );
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

        $key = $this->getCacheKey($menu->getKey());
        $this->cache->put($key, $menu);

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

        $key = $this->getCacheKey($menu->getKey());
        $this->cache->put($key, $menu);

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
        $key = $this->getCacheKey($menu->getKey());
        $this->cache->forget($key);

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

        $key = $this->getCacheKey($menu->getKey());
        $this->cache->put($key, $menu);

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

        $key = $this->getItemCacheKey($item->getKey());
        $this->cache->put($key, $item);

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

        $key = $this->getItemCacheKey($item->getKey());
        $this->cache->put($key, $item);

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
        $key = $this->getItemCacheKey($item->getKey());
        $this->cache->forget($key);

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
     * String for cache key
     *
     * @param string $keyword keyword
     * @return string
     */
    protected function getCacheKey($keyword)
    {
        return $this->prefix . '@' . $keyword;
    }

    /**
     * String for item cache key
     *
     * @param string $keyword keyword
     * @return string
     */
    protected function getItemCacheKey($keyword)
    {
        return $this->prefix . 'item@' . $keyword;
    }
}
