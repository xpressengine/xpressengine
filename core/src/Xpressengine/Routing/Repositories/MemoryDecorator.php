<?php
/**
 * MemoryDecorator
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

use Xpressengine\Routing\InstanceRoute;
use Xpressengine\Routing\RouteRepository;

/**
 * Class MemoryDecorator
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class MemoryDecorator implements RouteRepository
{
    /**
     * Repository instance
     *
     * @var RouteRepository
     */
    protected $repo;

    /**
     * Map consist of route item by site key
     *
     * @var array
     */
    protected $mapBySiteKey = [];

    /**
     * Map consist of route item by instance identifier
     *
     * @var array
     */
    protected $mapByInstanceId = [];

    /**
     * Map consist of route item by module name
     *
     * @var array
     */
    protected $mapByModule = [];

    /**
     * MemoryDecorator constructor.
     *
     * @param RouteRepository $repo Repository instance
     */
    public function __construct(RouteRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Returns all route items
     *
     * @return InstanceRoute[]
     */
    public function all()
    {
        $routes = $this->repo->all();

        foreach ($routes as $route) {
            $this->setToMap($route);
        }

        return $routes;
    }

    /**
     * Retrieve a route by url segment and site key
     *
     * @param string $url     first segment of url
     * @param string $siteKey site key
     * @return InstanceRoute
     */
    public function findByUrlAndSiteKey($url, $siteKey)
    {
        if (!isset($this->mapBySiteKey[$siteKey]) || !array_key_exists($url, $this->mapBySiteKey[$siteKey])) {
            if (!$route = $this->repo->findByUrlAndSiteKey($url, $siteKey)) {
                return null;
            }

            $this->setToMap($route);
        }

        return $this->mapBySiteKey[$siteKey][$url];
    }

    /**
     * Retrieve a route by instance identifier
     *
     * @param string $instanceId instance identifier
     * @return InstanceRoute
     */
    public function findByInstanceId($instanceId)
    {
        if (!array_key_exists($instanceId, $this->mapByInstanceId)) {
            if (!$route = $this->repo->findByInstanceId($instanceId)) {
                return null;
            }

            $this->setToMap($route);
        }

        return $this->mapByInstanceId[$instanceId];
    }

    /**
     * Retrieve routes by site key
     *
     * @param string $siteKey site key
     * @return InstanceRoute[]
     */
    public function fetchBySiteKey($siteKey)
    {
        if (!isset($this->mapBySiteKey[$siteKey])) {
            $routes = $this->repo->fetchBySiteKey($siteKey);

            foreach ($routes as $route) {
                $this->setToMap($route);
            }
        }

        return $this->mapBySiteKey[$siteKey];
    }

    /**
     * Retrieve routes by module name
     *
     * @param string $module module name
     * @return InstanceRoute[]
     */
    public function fetchByModule($module)
    {
        if (!isset($this->mapByModule[$module])) {
            $routes = $this->repo->fetchByModule($module);

            foreach ($routes as $route) {
                $this->setToMap($route);
            }
        }

        return $this->mapByModule[$module];
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
        $this->setToMap($route);

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
        $this->setToMap($route);

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
        $this->unsetFromMap($route);

        return $this->repo->delete($route);
    }

    /**
     * Set a route item to map
     *
     * @param InstanceRoute $route route item instance
     * @return void
     */
    protected function setToMap(InstanceRoute $route)
    {
        $this->setToSiteKeyMap($route);
        $this->setToModuleMap($route);
        $this->setToInstanceIdMap($route);
    }

    /**
     * Set a route item to site key map
     *
     * @param InstanceRoute $route route item instance
     * @return void
     */
    protected function setToSiteKeyMap(InstanceRoute $route)
    {
        if (!isset($this->mapBySiteKey[$route->site_key])) {
            $this->mapBySiteKey[$route->site_key] = [];
        }

        $this->mapBySiteKey[$route->site_key][$route->url] = $route;
    }

    /**
     * Set a route item to module map
     *
     * @param InstanceRoute $route route item instance
     * @return void
     */
    protected function setToModuleMap(InstanceRoute $route)
    {
        if (!isset($this->mapByModule[$route->module])) {
            $this->mapByModule[$route->module] = [];
        }

        $this->mapByModule[$route->module][$route->url] = $route;
    }

    /**
     * Set a route item to instance map
     *
     * @param InstanceRoute $route route item instance
     * @return void
     */
    protected function setToInstanceIdMap(InstanceRoute $route)
    {
        $this->mapByInstanceId[$route->instance_id] = $route;
    }

    /**
     * Unset a route item from map
     *
     * @param InstanceRoute $route route item instance
     * @return void
     */
    protected function unsetFromMap(InstanceRoute $route)
    {
        $this->unsetFromSiteKeyMap($route);
        $this->unsetFromModuleMap($route);
        $this->unsetFromInstanceIdMap($route);
    }

    /**
     * Unset a route item from site key map
     *
     * @param InstanceRoute $route route item instance
     * @return void
     */
    protected function unsetFromSiteKeyMap(InstanceRoute $route)
    {
        if (isset($this->mapBySiteKey[$route->site_key]) && isset($this->mapBySiteKey[$route->site_key][$route->url])) {
            unset($this->mapBySiteKey[$route->site_key][$route->url]);
        }
    }

    /**
     * Unset a route item from module map
     *
     * @param InstanceRoute $route route item instance
     * @return void
     */
    protected function unsetFromModuleMap(InstanceRoute $route)
    {
        if (isset($this->mapByModule[$route->module]) && isset($this->mapByModule[$route->module][$route->url])) {
            unset($this->mapByModule[$route->module][$route->url]);
        }
    }

    /**
     * Unset a route item from instance map
     *
     * @param InstanceRoute $route route item instance
     * @return void
     */
    protected function unsetFromInstanceIdMap(InstanceRoute $route)
    {
        if (isset($this->mapByInstanceId[$route->instance_id])) {
            unset($this->mapByInstanceId[$route->instance_id]);
        }
    }
}
