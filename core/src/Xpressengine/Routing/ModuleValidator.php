<?php
/**
 * ModuleValidator
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

use Illuminate\Http\Request;
use Xpressengine\Http\Request as XeRequest;
use Illuminate\Routing\Route;
use Illuminate\Routing\Matching\ValidatorInterface;
use Xpressengine\Menu\MenuHandler;
use Xpressengine\Site\SiteHandler;
use Xpressengine\Theme\ThemeHandler;

/**
 * Class ModuleValidator
 *
 * @category    Routing
 * @package     Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class ModuleValidator implements ValidatorInterface
{
    /**
     * @var null
     */
    private static $homeInstanceRoute = null;

    /**
     * @var RouteRepository
     */
    private $routeRepo;

    /**
     * @var MenuHandler
     */
    private $menuHandler;

    /**
     * @var ThemeHandler
     */
    private $themeHandler;

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
     * @param RouteRepository $routeRepo    route handler
     * @param MenuHandler     $menuHandler  menu handler
     * @param ThemeHandler    $themeHandler theme handler
     * @param SiteHandler     $siteHandler  site handler
     *
     * @return void
     */
    public function boot(
        RouteRepository $routeRepo,
        MenuHandler $menuHandler,
        ThemeHandler $themeHandler,
        SiteHandler $siteHandler
    ) {
        $this->routeRepo = $routeRepo;
        $this->menuHandler = $menuHandler;
        $this->themeHandler = $themeHandler;
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
        if (!$this->canReview($route, $request)) {
            return static::THIS_IS_NOT_INSTANCE_ROUTE;
        }
        try {
            $instanceRoute = $this->getInstanceRoute($request);
            $routeSource = $this->getRouteModule($route);

            $instanceSource = $instanceRoute->module;
            if ($instanceSource !== $routeSource) {
                return static::NOT_MATCH_INSTANCE_ROUTE_SOURCE;
            } else {
                /**
                 * @var XeRequest $request
                 */
                $this->setInstanceConfig($instanceRoute, $request);

                return static::INSTANCE_ROUTE_MATCHED;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * canReview
     *
     * @param Route   $route   laravel route
     * @param Request $request laravel request
     *
     * @return bool
     */
    private function canReview(Route $route, Request $request)
    {
        if (!is_null($route->getCompiled()->getHostRegex())) {
            return false;
        }

        $uri = $route->uri();

        if(strpos($uri, '{instanceGroup') !== 0) {
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
     * setInstanceConfig
     *
     * @param InstanceRoute $instanceRoute instance route
     * @param XeRequest     $request       xpressengine request
     *
     * @return void
     */
    private function setInstanceConfig(InstanceRoute $instanceRoute, XeRequest $request)
    {
        $item = $this->menuHandler->getItem($instanceRoute->instanceId);
        $menuConfig = $this->menuHandler->getMenuItemTheme($item);
        if ($request->isMobile()) {
            $theme = $menuConfig->get('mobileTheme');
        } else {
            $theme = $menuConfig->get('desktopTheme');
        }
        $instanceId = $instanceRoute->instanceId;
        $module = $instanceRoute->module;
        $url = $instanceRoute->url;

        $instanceConfig = InstanceConfig::instance();
        $instanceConfig->setTheme($theme);
        $instanceConfig->setInstanceId($instanceId);
        $instanceConfig->setModule($module);
        $instanceConfig->setUrl($url);
        $instanceConfig->setMenuItem($item);

        $themeHandler = $this->themeHandler;
        $themeHandler->selectTheme($theme);
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
