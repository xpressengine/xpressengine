<?php
namespace Xpressengine\Routing;

interface RouteRepository
{
    public function all();

    public function findByUrlAndSiteKey($url, $siteKey);

    public function findByInstanceId($instanceId);

    public function fetchBySiteKey($siteKey);

    public function fetchByModule($module);

    public function create(array $input);

    public function put(InstanceRoute $route);

    public function delete(InstanceRoute $route);
}
