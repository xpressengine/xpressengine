<?php

/**
 * helper.php
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

use Xpressengine\Routing\InstanceConfig;
use Xpressengine\Routing\InstanceRouteHandler;

if (!function_exists('instanceRoute')) {
    /**
     * Generate a URL to a named route.
     *
     * @param  string                    $name       route name
     * @param  array                     $parameters route parameter
     * @param  string                    $instanceId instance id
     * @param  bool                      $absolute   absolute bool
     * @param  \Illuminate\Routing\Route $route      illuminate route
     *
     * @return string
     */
    function instanceRoute($name, $parameters = array(), $instanceId = null, $absolute = true, $route = null)
    {
        /**
         * @var Xpressengine\Routing\RouteCollection $routeCollection
         */

        if ($instanceId === null) {
            $instanceConfig = InstanceConfig::instance();
            $module = $instanceConfig->getModule();
            $url = $instanceConfig->getUrl();
        } else {
            /**
             * @var $instanceRouter InstanceRouteHandler
             */
            $instanceRouter = app('xe.router');
            $instanceRoute = $instanceRouter->getByInstanceId($instanceId);
            $url = $instanceRoute->url;
            $module = $instanceRoute->module;
        }

        $name = $module . '.' . $name;

        array_unshift($parameters, $url);

        return app('url')->route($name, $parameters, $absolute, $route);
    }
}
