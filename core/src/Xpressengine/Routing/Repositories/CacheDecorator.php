<?php
/**
 * CacheDecorator
 *
 * PHP version 5
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Routing\Repositories;

use Illuminate\Contracts\Cache\Repository as CacheContract;
use Xpressengine\Routing\InstanceRoute;
use Xpressengine\Routing\RouteRepository;

/**
 * Class CacheDecorator
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CacheDecorator implements RouteRepository
{
    /**
     * Repository instance
     *
     * @var RouteRepository
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
    protected $minutes;

    /**
     * Prefix for cache key
     *
     * @var string
     */
    protected $prefix = 'route';

    /**
     * CacheDecorator constructor.
     *
     * @param RouteRepository $repo    Repository instance
     * @param CacheContract   $cache   Cache instance
     * @param int             $minutes expire time
     */
    public function __construct(RouteRepository $repo, CacheContract $cache, $minutes = 60)
    {
        $this->repo = $repo;
        $this->cache = $cache;
        $this->minutes = $minutes;
    }

    /**
     * Returns all route items
     *
     * @return InstanceRoute[]
     */
    public function all()
    {
        $key = $this->getCacheKey('all');

        $routes = $this->cache->has($key) ? $this->cache->get($key) : call_user_func(function () use ($key) {
            $routes = $this->repo->all();
            if (count($routes) > 1) {
                $this->cache->put($key, $routes, $this->minutes);
            }

            return $routes;
        });

        return $routes;
    }

    /**
     * Retrieve a route by url segment and site key
     *
     * @param string $url     first segment of url
     * @param string $siteKey site key
     * @return InstanceRoute|null
     */
    public function findByUrlAndSiteKey($url, $siteKey)
    {
        $key = $this->getCacheKey($siteKey . '_' . $url);

        $route = $this->cache->has($key) ? $this->cache->get($key) : call_user_func(function () use ($url, $siteKey) {
            if ($route = $this->repo->findByUrlAndSiteKey($url, $siteKey)) {
                $this->cachingItem($route);
            }

            return $route;
        });

        return $route;
    }

    /**
     * Do caching a route item
     *
     * @param InstanceRoute $route route instance
     * @return void
     */
    protected function cachingItem(InstanceRoute $route)
    {
        $this->cache->put($this->getCacheKey($route->site_key . '_' . $route->url), $route, $this->minutes);
        $this->cache->put($this->getCacheKey($route->instance_id), $route, $this->minutes);
    }

    /**
     * Retrieve a route by instance identifier
     *
     * @param string $instanceId instance identifier
     * @return InstanceRoute|null
     */
    public function findByInstanceId($instanceId)
    {
        $key = $this->getCacheKey($instanceId);

        $route = $this->cache->has($key) ? $this->cache->get($key) : call_user_func(function () use ($instanceId) {
            if ($route = $this->repo->findByInstanceId($instanceId)) {
                $this->cachingItem($route);
            }

            return $route;
        });

        return $route;
    }

    /**
     * Retrieve routes by site key
     *
     * @param string $siteKey site key
     * @return InstanceRoute[]
     */
    public function fetchBySiteKey($siteKey)
    {
        $key = $this->getCacheKey($siteKey);

        $routes = $this->cache->has($key) ? $this->cache->get($key) : call_user_func(function () use ($siteKey, $key) {
            $routes = $this->repo->fetchBySiteKey($siteKey);
            if (count($routes) > 0) {
                $this->cache->put($key, $routes, $this->minutes);
            }

            return $routes;
        });

        return $routes;
    }

    /**
     * Retrieve routes by module name
     *
     * @param string $module module name
     * @return InstanceRoute[]
     */
    public function fetchByModule($module)
    {
        $key = $this->getCacheKey($module);

        $routes = $this->cache->has($key) ? $this->cache->get($key) : call_user_func(function () use ($module, $key) {
            $routes = $this->repo->fetchByModule($module);
            if (count($routes) > 0) {
                $this->cache->put($key, $routes, $this->minutes);
            }

            return $routes;
        });

        return $routes;
    }

    /**
     * Save a new route item and return the instance
     *
     * @param array $input route item attributes
     * @return InstanceRoute
     */
    public function create(array $input)
    {
        $route = $this->repo->create($input);
        $this->cachingItem($route);

        return $route;
    }

    /**
     * Save the route item
     *
     * @param InstanceRoute $route route instance
     * @return InstanceRoute
     */
    public function put(InstanceRoute $route)
    {
        $route = $this->repo->put($route);
        $this->cachingItem($route);

        return $route;
    }

    /**
     * Delete the route item from the repository
     *
     * @param InstanceRoute $route route instance
     * @return bool|null
     */
    public function delete(InstanceRoute $route)
    {
        $this->cache->forget($this->getCacheKey($route->site_key . '_' . $route->url));
        $this->cache->forget($this->getCacheKey($route->instance_id));

        return $this->repo->delete($route);
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
