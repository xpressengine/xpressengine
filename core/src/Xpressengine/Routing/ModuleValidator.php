<?php
/**
 * ModuleValidator
 *
 * PHP version 5
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\Routing;

use Illuminate\Http\Request;
use Xpressengine\Http\Request as XeRequest;
use Illuminate\Routing\Route;
use Illuminate\Routing\Matching\ValidatorInterface;
use Xpressengine\Menu\MenuConfigHandler;
use Xpressengine\Menu\MenuHandler;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Site\SiteHandler;
use Xpressengine\Theme\ThemeHandler;

/**
 * Class ModuleValidator
 *
 * @category    Routing
 * @package     Xpressengine\Routing
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ModuleValidator implements ValidatorInterface
{

    /**
     * @var null
     */
    private static $homeInstanceRoute = null;

    /**
     * @var MenuHandler
     */
    private $menuHandler;
    /**
     * @var InstanceRouteHandler
     */
    private $routeHandler;
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
     * @param InstanceRouteHandler $routeHandler      route handler
     * @param MenuHandler  $menuHandler       menu handler
     * @param MenuConfigHandler    $menuConfigHandler menu config handler
     * @param ThemeHandler         $themeHandler      theme handler
     * @param SiteHandler          $siteHandler       site handler
     *
     * @return void
     */
    public function boot(
        InstanceRouteHandler $routeHandler,
        MenuHandler $menuHandler,
        ThemeHandler $themeHandler,
        SiteHandler $siteHandler
    ) {
        $this->menuHandler = $menuHandler;
        $this->routeHandler = $routeHandler;
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
                $this->setInstanceConfig($instanceRoute, $request, $route);

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
        $firstSegment = $request->segment(1);

        if ($firstSegment === null) {
            return true;
        }

        $uri = $route->uri();
        if (strpos($uri, '{') === false) {
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
            $instanceRouter = $this->routeHandler;
            $instanceRoute = $instanceRouter->getByUrl($siteKey, $firstSegment);
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
     * @param Route         $route         route
     *
     * @return void
     */
    private function setInstanceConfig(InstanceRoute $instanceRoute, XeRequest $request, Route $route)
    {
        $menuModel = $this->menuHandler->getModel();
        $itemModel = $menuModel::getItemModel();
        $item = $itemModel::find($instanceRoute->instanceId);
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

        $themeHandler = $this->themeHandler;
        $themeHandler->selectTheme($theme);

        $this->replaceRouteUri($route, $item);
    }

    /**
     * Replace route's uri first segment
     *
     * @param Route    $route route
     * @param MenuItem $item  menu item
     *
     * @return void
     */
    private function replaceRouteUri(Route $route, MenuItem $item)
    {
        $action = $route->getAction();
        $route->setUri(str_replace($action['prefix'], $item->url, $route->getUri()));
        $action['prefix'] = $item->url;
        $route->setAction($action);
    }

    /**
     * getHomeInstanceRoute
     *
     * @return InstanceRoute
     */
    private function getHomeInstanceRoute()
    {
        /**
         * @var $instanceRouter InstanceRouteHandler
         **/
        if (static::$homeInstanceRoute === null) {
            $instanceRouter = $this->routeHandler;
            $homeInstanceId = $this->siteHandler->getHomeInstanceId();
            $instanceRoute = $instanceRouter->getByInstanceId($homeInstanceId);

            static::$homeInstanceRoute = $instanceRoute;

            return $instanceRoute;
        } else {
            return static::$homeInstanceRoute;
        }
    }
}
