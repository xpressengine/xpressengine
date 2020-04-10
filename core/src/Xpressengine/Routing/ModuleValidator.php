<?php
/**
 * ModuleValidator
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

use Illuminate\Http\Request;
use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Routing\Route;
use Xpressengine\Site\SiteHandler;

/**
 * Class ModuleValidator
 *
 * @category    Routing
 * @package     Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ModuleValidator implements ValidatorInterface
{
    use InstanceRouteChecker;
    /**
     * @var null
     */
    private static $homeInstanceRoute = null;

    /**
     * @var RouteRepository
     */
    private $routeRepo;

    /**
     * @var SiteHandler
     */
    private $siteHandler;

    /**
     * this is not instance route
     */
    const THIS_IS_NOT_INSTANCE_ROUTE = true;
    /**
     * route not match
     */
    const NOT_MATCH_INSTANCE_ROUTE_SOURCE = false;
    /**
     * route match
     */
    const INSTANCE_ROUTE_MATCHED = true;

    /**
     * boot
     *
     * @param RouteRepository $routeRepo   route handler
     * @param SiteHandler     $siteHandler site handler
     *
     * @return void
     */
    public function boot(RouteRepository $routeRepo, SiteHandler $siteHandler)
    {
        $this->routeRepo = $routeRepo;
        $this->siteHandler = $siteHandler;
    }

    /**
     * Validate a given rule against a route and request.
     *
     * @param  Route   $route   laravel route
     * @param  Request $request laravel request
     *
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        if (!$this->canReview($route)) {
            return static::THIS_IS_NOT_INSTANCE_ROUTE;
        }
        try {
            $instanceRoute = $this->getInstanceRoute($request);
            $routeSource = $this->getRouteModule($route);

            $instanceSource = $instanceRoute->module;
            if ($instanceSource !== $routeSource) {
                return static::NOT_MATCH_INSTANCE_ROUTE_SOURCE;
            } else {
                return static::INSTANCE_ROUTE_MATCHED;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * canReview
     *
     * @param Route $route laravel route
     *
     * @return bool
     */
    private function canReview(Route $route)
    {
        if (!is_null($route->getCompiled()->getHostRegex())) {
            return false;
        }

        if (!$this->isInstance($route)) {
            return false;
        }

        $actions = $route->getAction();
        if (isset($actions['module'])) {
            return true;
        }

        return false;
    }

    /**
     * getInstanceRoute
     *
     * @param Request $request laravel request
     *
     * @return InstanceRoute
     */
    private function getInstanceRoute(Request $request)
    {
        $firstSegment = $request->segment(1);
        $siteKey = $this->siteHandler->getCurrentSiteKey();

        if ($firstSegment === null) {
            $instanceRoute = $this->getHomeInstanceRoute();
        } else {
            $instanceRoute = $this->routeRepo->findByUrlAndSiteKey($firstSegment, $siteKey);
        }

        return $instanceRoute;
    }

    /**
     * getRouteModule
     *
     * @param Route $route route
     *
     * @return mixed
     */
    private function getRouteModule(Route $route)
    {
        $actions = $route->getAction();

        return $actions['module'];
    }

    /**
     * getHomeInstanceRoute
     *
     * @return InstanceRoute
     */
    private function getHomeInstanceRoute()
    {
        if (static::$homeInstanceRoute === null) {
            $homeInstanceId = $this->siteHandler->getHomeInstanceId();
            $instanceRoute = $this->routeRepo->findByInstanceId($homeInstanceId);

            static::$homeInstanceRoute = $instanceRoute;

            return $instanceRoute;
        } else {
            return static::$homeInstanceRoute;
        }
    }
}
