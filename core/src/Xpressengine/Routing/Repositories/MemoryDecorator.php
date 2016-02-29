<?php
namespace Xpressengine\Routing\Repositories;

use Xpressengine\Routing\InstanceRoute;
use Xpressengine\Routing\RouteRepository;

class MemoryDecorator implements RouteRepository
{
    protected $repo;

    protected $mapBySiteKey = [];
    protected $mapByInstanceId = [];
    protected $mapByModule = [];

    public function __construct(RouteRepository $repo)
    {
        $this->repo = $repo;
    }

    public function all()
    {
        $routes = $this->repo->all();
        
        foreach ($routes as $route) {
            $this->setToMap($route);
        }

        return $routes;
    }

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

    public function create(array $input)
    {
        $route = $this->repo->create($input);
        $this->setToMap($route);

        return $route;
    }

    public function put(InstanceRoute $route)
    {
        $route = $this->repo->put($route);
        $this->setToMap($route);

        return $route;
    }

    public function delete(InstanceRoute $route)
    {
        $this->unsetFromMap($route);

        return $this->repo->delete($route);
    }

    protected function setToMap(InstanceRoute $route)
    {
        $this->setToSiteKeyMap($route);
        $this->setToModuleMap($route);
        $this->setToInstanceIdMap($route);
    }

    protected function setToSiteKeyMap(InstanceRoute $route)
    {
        if (!isset($this->mapBySiteKey[$route->siteKey])) {
            $this->mapBySiteKey[$route->siteKey] = [];
        }

        $this->mapBySiteKey[$route->siteKey][$route->url] = $route;
    }

    protected function setToModuleMap(InstanceRoute $route)
    {
        if (!isset($this->mapByModule[$route->module])) {
            $this->mapByModule[$route->module] = [];
        }

        $this->mapByModule[$route->module][$route->url] = $route;
    }

    protected function setToInstanceIdMap(InstanceRoute $route)
    {
        $this->mapByInstanceId[$route->instanceId] = $route;
    }

    protected function unsetFromMap(InstanceRoute $route)
    {
        $this->unsetFromSiteKeyMap($route);
        $this->unsetFromModuleMap($route);
        $this->unsetFromInstanceIdMap($route);
    }

    protected function unsetFromSiteKeyMap(InstanceRoute $route)
    {
        if (isset($this->mapBySiteKey[$route->siteKey]) && isset($this->mapBySiteKey[$route->siteKey][$route->url])) {
            unset($this->mapBySiteKey[$route->siteKey][$route->url]);
        }
    }

    protected function unsetFromModuleMap(InstanceRoute $route)
    {
        if (isset($this->mapByModule[$route->module]) && isset($this->mapByModule[$route->module][$route->url])) {
            unset($this->mapByModule[$route->module][$route->url]);
        }
    }

    protected function unsetFromInstanceIdMap(InstanceRoute $route)
    {
        if (isset($this->mapByInstanceId[$route->instanceId])) {
            unset($this->mapByInstanceId[$route->instanceId]);
        }
    }
}