<?php
/**
 * RouteRepository
 *
 * PHP version 7
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Routing;

/**
 * Interface RouteRepository
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
