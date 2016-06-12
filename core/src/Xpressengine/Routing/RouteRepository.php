<?php
/**
 * RouteRepository
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

namespace Xpressengine\Routing;

/**
 * Interface RouteRepository
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
interface RouteRepository
{
    /**
     * Returns all route items
     *
     * @return InstanceRoute[]
     */
    public function all();

    /**
     * Retrieve a route by url segment and site key
     *
     * @param string $url     first segment of url
     * @param string $siteKey site key
     * @return InstanceRoute
     */
    public function findByUrlAndSiteKey($url, $siteKey);

    /**
     * Retrieve a route by instance identifier
     *
     * @param string $instanceId instance identifier
     * @return InstanceRoute
     */
    public function findByInstanceId($instanceId);

    /**
     * Retrieve routes by site key
     *
     * @param string $siteKey site key
     * @return InstanceRoute[]
     */
    public function fetchBySiteKey($siteKey);

    /**
     * Retrieve routes by module name
     *
     * @param string $module module name
     * @return InstanceRoute[]
     */
    public function fetchByModule($module);

    /**
     * Save a new route item and return the instance
     *
     * @param array $input route item attributes
     * @return InstanceRoute
     */
    public function create(array $input);

    /**
     * Save the route item
     *
     * @param InstanceRoute $route route instance
     * @return InstanceRoute
     */
    public function put(InstanceRoute $route);

    /**
     * Delete the route item from the repository
     *
     * @param InstanceRoute $route route instance
     * @return bool|null
     */
    public function delete(InstanceRoute $route);
}
