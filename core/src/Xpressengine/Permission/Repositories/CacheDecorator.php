<?php
/**
 * This file is a cache decorator.
 *
 * PHP version 7
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
namespace Xpressengine\Permission\Repositories;

use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Xpressengine\Permission\Permission;
use Xpressengine\Permission\PermissionRepository;

/**
 * Class CacheDecorator
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
     * @var CacheContract
     */
    protected $cache;

    /**
     * expire time
     *
     * @var int
     */
    protected $seconds;

    /**
     * Prefix for cache key
     *
     * @var string
     */
    protected $prefix = 'permission';

    /**
     * memory cache
     *
     * @var array
     */
    protected $bag = [];

    /**
     * CacheDecorator constructor.
     *
     * @param PermissionRepository $repo    PermissionRepository instance
     * @param CacheContract        $cache   Cache instance
     * @param  int  $seconds expire time
     */
    public function __construct(PermissionRepository $repo, CacheContract $cache, int $seconds = 3600)
    {
        $this->repo = $repo;
        $this->cache = $cache;
        $this->seconds = $seconds;
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
        $data = $this->getData($siteKey, $this->getHead($name));

        return Arr::first($data, function ($item, $idx) use ($name) {
            return $item->name === $name;
        });
    }

    /**
     * Insert register information
     *
     * @param Permission $item permission instance
     * @return Permission
     */
    public function insert(Permission $item)
    {
        $this->erase($item->site_key, $item->name);

        return $this->repo->insert($item);
    }

    /**
     * Update register information
     *
     * @param Permission $item permission instance
     * @return Permission
     */
    public function update(Permission $item)
    {
        $this->erase($item->site_key, $item->name);

        return $this->repo->update($item);
    }

    /**
     * Delete register information
     *
     * @param Permission $item permission instance
     * @return int affecting statement
     */
    public function delete(Permission $item)
    {
        $this->erase($item->site_key, $item->name);

        return $this->repo->delete($item);
    }

    /**
     * Returns ancestor of item
     *
     * @param string $siteKey site key
     * @param string $name    target name
     * @return array
     */
    public function fetchAncestor($siteKey, $name)
    {
        $data = $this->getData($siteKey, $this->getHead($name));

        return Arr::where($data, function ($item, $idx) use ($name) {
            return Str::startsWith($name, $item->name.'.') && $name !== $item->name;
        });
    }

    /**
     * Returns descendant of item
     *
     * @param string $siteKey site key
     * @param string $name    target name
     * @return array
     */
    public function fetchDescendant($siteKey, $name)
    {
        $data = $this->getData($siteKey, $this->getHead($name));

        return Arr::where($data, function ($item, $idx) use ($name) {
            return Str::startsWith($item->name, $name.'.') && $name !== $item->name;
        });
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
        $this->erase($item->site_key, $item->name);
        $this->erase($item->site_key, $to);

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
        $this->erase($item->site_key, $item->name);
        $this->erase($item->site_key, $to);

        $this->repo->affiliate($item, $to);
    }

    /**
     * get cached data
     *
     * @param string $siteKey site key
     * @param string $head    root name
     * @return array
     */
    protected function getData($siteKey, $head)
    {
        $key = $this->makeKey($siteKey, $head);

        if (!isset($this->bag[$key])) {
            $cacheKey = $this->getCacheKey($key);
            $data = $this->cache->get($cacheKey);


            if ($data !== null) {
                $item = $this->repo->findByName($siteKey, $head);

                if ($item !== null) {
                    return [];
                }

                $descendant = $this->repo->fetchDescendant($siteKey, $head);
                $data = array_merge([$item], $descendant);
                $this->cache->put($cacheKey, $data, $this->seconds);
            }

            $this->bag[$key] = $data;
        }

        return $this->bag[$key];
    }

    /**
     * Remove cache data
     *
     * @param string $siteKey site key
     * @param string $name    target name
     * @return void
     */
    protected function erase($siteKey, $name)
    {
        $key = $this->makeKey($siteKey, $this->getHead($name));

        unset($this->bag[$key]);
        $this->cache->forget($this->getCacheKey($key));
    }

    /**
     * parse name to head and segments
     *
     * @param string $name the name
     * @return string
     */
    private function getHead($name)
    {
        $segments = explode('.', $name);

        return reset($segments);
    }

    /**
     * Make key by combination of site key and target name
     *
     * @param string $siteKey site key
     * @param string $name    target name
     * @return string
     */
    protected function makeKey($siteKey, $name)
    {
        return $siteKey . ':' . $name;
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
}