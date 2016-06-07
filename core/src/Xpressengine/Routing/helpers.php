<?php
/**
 * helper.php
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
 */

use Xpressengine\Routing\InstanceConfig;
use Xpressengine\Routing\RouteRepository;

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
             * @var RouteRepository $instanceRouter
             */
            $instanceRouter = app('xe.router');
            $instanceRoute = $instanceRouter->findByInstanceId($instanceId);
            $url = $instanceRoute->url;
            $module = $instanceRoute->module;
        }

        $name = $module . '.' . $name;

        array_unshift($parameters, $url);

        return app('url')->route($name, $parameters, $absolute, $route);
    }
}
