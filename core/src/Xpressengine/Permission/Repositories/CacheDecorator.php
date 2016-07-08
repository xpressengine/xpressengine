<?php
/**
 * This file is a cache decorator.
 *
 * PHP version 5
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
namespace Xpressengine\Permission\Repositories;

use Xpressengine\Permission\Permission;
use Xpressengine\Permission\PermissionRepository;
use Xpressengine\Support\CacheInterface;

/**
 * Class CacheDecorator
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CacheDecorator implements PermissionRepository
{
    /**
     * PermissionRepository instance
     *
     * @var PermissionRepository
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
    protected $prefix = 'permission';

    /**
     * CacheDecorator constructor.
     *
     * @param PermissionRepository $repo  PermissionRepository instance
     * @param CacheInterface       $cache Cache instance
     */
    public function __construct(PermissionRepository $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Find a registered by type and name
     *
     * @param string $siteKey site key
     * @param string $name    target name
     * @return Permission
     */
    public function findByName($siteKey, $name)
    {
        $key = $this->getCacheKey($siteKey, $name);

        if (!$permission = $this->cache->get($key)) {
            if ($permission = $this->repo->findByName($siteKey, $name)) {
                $this->cache->put($key, $permission);
            }
        }

        return $permission;
    }

    /**
     * Insert register information
     *
     * @param Permission $item permission instance
     * @return Permission
     */
    public function insert(Permission $item)
    {
        $item = $this->repo->insert($item);
        $this->cache->put($this->getCacheKey($item->siteKey, $item->name), $item);

        return $item;
    }

    /**
     * Update register information
     *
     * @param Permission $item permission instance
     * @return Permission
     */
    public function update(Permission $item)
    {
        $item = $this->repo->update($item);
        $this->cache->put($this->getCacheKey($item->siteKey, $item->name), $item);

        return $item;
    }

    /**
     * Delete register information
     *
     * @param Permission $item permission instance
     * @return int affecting statement
     */
    public function delete(Permission $item)
    {
        $this->forget($item);

        return $this->repo->delete($item);
    }

    /**
     * Returns ancestor of item
     *
     * @param Permission $item permission instance
     * @return array
     */
    public function fetchAncestor(Permission $item)
    {
        $key = $this->getCacheKey($item->siteKey, $item->name, 'ancestor');
        if (!$ancestors = $this->cache->get($key)) {
            $ancestors = $this->repo->fetchAncestor($item);
            if (!empty($ancestors)) {
                $this->cache->put($key, $ancestors);
            }
        }

        return $ancestors;
    }

    /**
     * Returns descendant of item
     *
     * @param Permission $item permission instance
     * @return array
     */
    public function fetchDescendant(Permission $item)
    {
        $key = $this->getCacheKey($item->siteKey, $item->name, 'descendant');
        if (!$descendants = $this->cache->get($key)) {
            $descendants = $this->repo->fetchDescendant($item);
            if (!empty($descendants)) {
                $this->cache->put($key, $descendants);
            }
        }

        return $descendants;
    }

    /**
     * Parent Changing with descendant
     *
     * @param Permission $item permission instance
     * @param string     $to   parent name
     * @return void
     */
    public function foster(Permission $item, $to)
    {
        $this->forget($item);

        $this->repo->foster($item, $to);
    }

    /**
     * affiliated to another registered
     *
     * @param Permission $item permission instance
     * @param string     $to   parent name
     * @return void
     */
    public function affiliate(Permission $item, $to)
    {
        $this->forget($item);

        $this->repo->affiliate($item, $to);
    }

    /**
     * Remove an item from the cache.
     *
     * @param Permission $item permission instance
     * @return void
     */
    protected function forget(Permission $item)
    {
        $this->cache->forget($this->getCacheKey($item->siteKey, $item->name));
        $this->cache->forget($this->getCacheKey($item->siteKey, $item->name, 'ancestor'));
        $this->cache->forget($this->getCacheKey($item->siteKey, $item->name, 'descendant'));
    }

    /**
     * String for cache key
     *
     * @param string      $siteKey site key
     * @param string      $name    permission name
     * @param string|null $etc     etc keyword
     * @return string
     */
    protected function getCacheKey($siteKey, $name, $etc = null)
    {
        return $this->prefix . '::' . $siteKey . '-' . $name . ($etc ? '_' . $etc : '');
    }
}
