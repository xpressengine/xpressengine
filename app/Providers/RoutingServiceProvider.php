<?php
/**
 * Service provider
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
namespace App\Providers;

use Closure;
use Illuminate\Routing\Matching\HostValidator;
use Illuminate\Routing\Matching\MethodValidator;
use Illuminate\Routing\Matching\SchemeValidator;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Routing\InstanceRoute;
use Xpressengine\Routing\ModuleValidator;
use Xpressengine\Routing\Repositories\CacheDecorator;
use Xpressengine\Routing\Repositories\DatabaseRouteRepository;
use Xpressengine\Routing\Repositories\MemoryDecorator;
use Xpressengine\Routing\RouteCollection;
use Xpressengine\Routing\RouteRepository;
use Xpressengine\Routing\UriValidator;
use Xpressengine\Support\LaravelCache;

/**
 * Routing Service Provider
 *
 * @category Routing
 * @package  Xpressengine\Routing
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class RoutingServiceProvider extends ServiceProvider
{

    /**
     * 주요 역활은 ModuleValidator 의 boot 를 실행.
     *
     * @return void
     */
    public function boot()
    {
        $routeValidator = Route::getValidators();
        $routeValidator['module']->boot(
            app('xe.router'),
            app('xe.menu'),
            app('xe.theme'),
            app('xe.site')
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            [RouteRepository::class => 'xe.router'],
            function ($app) {
                $repo = new DatabaseRouteRepository($app['config'], InstanceRoute::class);

                if (env('APP_DEBUG') != true) {
                    $repo = new CacheDecorator($repo, new LaravelCache($app['cache.store']));
                }

                return new MemoryDecorator($repo);
            }
        );

        $this->setNewRouteValidator();
        $this->registerMacro($this->app['router']);
        $this->registerRouteCollection($this->app['router']);

    }

    /**
     * Set New Route Validator
     *
     * Route 를 등록하고 matching 하는 과정에서 판별할 수 있는 validator 를 추가하는 부분
     * 특이점을 가지는 Xe 가 등록하는 Route 를 판별하기 위해서 Validator 를 추가함
     *
     * @return void
     */
    public function setNewRouteValidator()
    {
        Route::$validators = [
            'method' => new MethodValidator,
            'scheme' => new SchemeValidator,
            'host' => new HostValidator,
            'uri' => new UriValidator,
            'module' => new ModuleValidator
        ];
    }

    /**
     * Register Route Macro
     * XE 구동에 필요한 Route Macro 들을 등록해준다.
     *
     * @param Router $router to register macro
     *
     * @return void
     */
    public function registerMacro(Router $router)
    {
        $this->registerFixedMacro($router);
        $this->registerSettingsMacro($router);
        $this->registerInstanceMacro($router);

    }

    /**
     * Register Router Macro called Settings
     * settings 로 호출할 수 있는 Router 매크로를 등록하여
     * 관리자 ui 의 진입경로를 일관되게 유지할 수 있다.
     *
     * @param Router $router to register macro
     *
     * @return void
     */
    protected function registerSettingsMacro(Router $router)
    {
        $manageMacro = function ($key, Closure $callback, $routeOptions = null) {

            $key = str_replace('.', '/', $key);

            $attributes = [
                'prefix' => config('xe.routing.settingsPrefix') . '/' . $key,
                'middleware' => ['settings']
            ];

            if ($routeOptions !== null and is_array($routeOptions)) {
                $routeOptions = array_except($routeOptions, ['prefix']);
                $attributes = array_merge($attributes, $routeOptions);
            }

            $this->group($attributes, $callback);
        };

        $router->macro('settings', $manageMacro);
    }

    /**
     * Register Router Macro called Fixed
     * fixed 로 호출할 수 있는 Router 매크로를 등록하여
     * 플러그인 고유한 URL 을 가져갈 수 있도록 한다.
     *
     * @param Router $router to register macro
     *
     * @return void
     */
    protected function registerFixedMacro(Router $router)
    {
        $fixedMacro = function ($key, Closure $callback, $routeOptions = null) {

            $newKey = str_replace('@', '/', $key);

            $attributes = [
                'prefix' => config('xe.routing.fixedPrefix') . '/' . $newKey
            ];

            if ($routeOptions !== null and is_array($routeOptions)) {
                $routeOptions = array_except($routeOptions, ['prefix']);
                $attributes = array_merge($attributes, $routeOptions);
            }

            $this->group($attributes, $callback);
        };

        $router->macro('fixed', $fixedMacro);
    }

    /**
     * Register Router Macro called Instance
     * 플러그인에에서 등록한 route pattern 형태로 등록하여 instance route 를 찾을 수 있도록 하는
     * 매크로 등록
     *
     * @param Router $router to register macro
     *
     * @return void
     */
    protected function registerInstanceMacro(Router $router)
    {
        $instanceMacro = function ($key, Closure $callback, $routeOptions = null) {

            $pattern = sprintf("%s%s%s", "{", preg_replace("/[@\/]/", "_", $key), "}");

            $attributes = [
                'prefix' => $pattern,
                'module' => $key,
                'middleware' => ['access']
            ];

            if ($routeOptions !== null and is_array($routeOptions)) {
                $routeOptions = array_except($routeOptions, ['prefix', 'middleware']);
                $attributes = array_merge($attributes, $routeOptions);

                if (isset($routeOptions['middleware'])) {
                    $attributes['middleware'] .= '|' . $routeOptions['middleware'];
                }
            }

            $this->group($attributes, $callback);
        };

        $router->macro('instance', $instanceMacro);

    }

    /**
     * registerRouteCollection
     *
     * @param Router $router to register macro
     *
     * @return void
     */
    protected function registerRouteCollection(Router $router)
    {
        $router->setRoutes(
            new RouteCollection()
        );
    }
}
