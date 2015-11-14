<?php namespace Xpressengine\Tests\Routing;

use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Routing\InstanceRoute;
use Xpressengine\Routing\InstanceRouteHandler;
use Xpressengine\Routing\ModuleValidator;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Xpressengine\Routing\RouteCollection;

/**
 * Class ModuleValidatorTest
 *
 * @package Xpressengine\Tests\Routing
 */
class ModuleValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var
     */
    protected $moduleValidator;

    /**
     * @var
     */
    protected $route;
    /**
     * @var
     */
    protected $request;
    /**
     * @var
     */
    protected $routeHandler;
    /**
     * @var
     */
    protected $menuConfigHandler;
    /**
     * @var
     */
    protected $menuHandler;

    protected $themeHandler;

    protected $siteHandler;

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * testHomeStaticRouteUri
     *
     * @return void
     */
    public function testHomeStaticRouteUri()
    {
        /**
         * @var Route $route;
         * @var Request $request;
         * @var ModuleValidator $moduleValidator;
         */
        $route = $this->route;

        $request = $this->request;
        $request->shouldReceive('segment')->with(1)->andReturn('home');
        $route->shouldReceive('uri')->andReturn('');
        $route->shouldReceive('getAction')->andReturn([]);

        $moduleValidator = $this->moduleValidator;
        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(true, $result);
    }

    /**
     * testRootNotMatchUri
     *
     * @return void
     */
    public function testRootNotMatchUri()
    {
        /**
         * @var Route $route;
         * @var Request $request;
         * @var ModuleValidator $moduleValidator;
         * @var InstanceRouteHandler $routeHandler
         * @var InstanceRoute
         */
        $route = $this->route;
        $request = $this->request;

        $routeHandler = $this->routeHandler;

        $request->shouldReceive('segment')->with(1)->andReturn(null);
        $route->shouldReceive('getAction')->andReturn([
            'module' => 'module/pluginB@page'
        ]);

        $moduleValidator = $this->moduleValidator;
        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(false, $result);
    }

    /**
     * testRootMatchUri
     *
     * @return void
     */
    public function testRootMatchUri()
    {
        /**
         * @var Route $route;
         * @var Request $request;
         * @var ModuleValidator $moduleValidator;
         * @var InstanceRouteHandler $routeHandler
         * @var InstanceRoute
         */
        $route = $this->route;
        $request = $this->request;

        $routeHandler = $this->routeHandler;
        $menuHandler = $this->menuHandler;
        $menuConfigHandler = $this->menuConfigHandler;
        $themeHandler = $this->themeHandler;

        $request->shouldReceive('segment')->with(1)->andReturn(null);
        $route->shouldReceive('getAction')->andReturn([
            'as' => 'test.root.match',
            'module' => 'module/xpressengine@board'
        ]);

        $dummyItem = m::mock('Xpressengine\Menu\MenuItem');

        $route->shouldReceive('setAction')->andReturn($route);

        $menuHandler->shouldReceive('getItem')->andReturn($dummyItem);
        $menuConfigHandler->shouldReceive('getMenuItemTheme')->andReturn('defaultTheme');

        $routeHandler->shouldReceive('getByIndexSelected')->andReturn($route);
        $themeHandler->shouldReceive('selectTheme')->andReturn(null);

        $moduleValidator = $this->moduleValidator;
        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(false, $result);
    }

    /**
     * testAboutUsNotMatchUri
     *
     * @return void
     */
    public function testAboutUsNotMatchUri()
    {
        /**
         * @var Route $route;
         * @var Request $request;
         * @var ModuleValidator $moduleValidator;
         */
        $route = $this->route;

        $request = $this->request;
        $request->shouldReceive('segment')->with(1)->andReturn('home');
        $route->shouldReceive('uri')->andReturn('{module_pluginB_page}');
        $route->shouldReceive('getAction')->andReturn([
            'module' => 'module/pluginB@page'
        ]);

        $moduleValidator = $this->moduleValidator;
        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(false, $result);

    }

    /**
     * testAboutUsNotMatchUriNoModuleAttr
     *
     * @return void
     */
    public function testAboutUsNotMatchUriNoModuleAttr()
    {
        /**
         * @var Route $route;
         * @var Request $request;
         * @var ModuleValidator $moduleValidator;
         */
        $route = $this->route;

        $request = $this->request;
        $request->shouldReceive('segment')->with(1)->andReturn('home');
        $route->shouldReceive('uri')->andReturn('{module_pluginB_page}');
        $route->shouldReceive('getAction')->andReturn([

        ]);

        $moduleValidator = $this->moduleValidator;
        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(true, $result);

    }

    /**
     * testBoardMatchUri
     *
     * @return void
     */
    public function testBoardMatchUri()
    {
        /**
         * @var Route $route;
         * @var Request $request;
         * @var ModuleValidator $moduleValidator;
         * @var InstanceRouteHandler $routeHandler
         * @var InstanceRoute
         */
        $route = $this->route;
        $request = $this->request;

        $routeHandler = $this->routeHandler;
        $menuHandler = $this->menuHandler;
        $menuConfigHandler = $this->menuConfigHandler;

        $instanceRoute = new InstanceRoute(
            [
                'instanceId' => 'board',
                'module' => 'module/pluginB@page',
                'url' => 'freeboard',
                'menuId' => 'basic',
                'site' => 'default'
            ]
        );

        $routeHandler->shouldReceive('getByUrl')->with('board')->andReturn(
            $instanceRoute
        );

        $request->shouldReceive('segment')->with(1)->andReturn('board');
        $route->shouldReceive('getAction')->andReturn([
            'as' => 'test.root.match',
            'module' => 'module/pluginB@page'
        ]);

        $dummyItem = m::mock('Xpressengine\Menu\MenuItem');

        $route->shouldReceive('uri')->andReturn('freeboard');
        $route->shouldReceive('setAction')->andReturn($route);

        $menuHandler->shouldReceive('getItem')->andReturn($dummyItem);
        $menuConfigHandler->shouldReceive('getMenuItemTheme')->andReturn('defaultTheme');

        $moduleValidator = $this->moduleValidator;
        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(true, $result);
    }

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        /**
         * @var Route           $route
         * @var Request     $request
         */
        $route = m::mock('Illuminate\Routing\Route');
        $request = m::mock('Illuminate\Http\Request');

        $routeHandler = m::mock('Xpressengine\Routing\InstanceRouteHandler');
        $menuConfigHandler = m::mock('Xpressengine\Menu\MenuConfigHandler');
        $menuHandler = m::mock('Xpressengine\Menu\MenuRetrieveHandler');
        $themeHandler = m::mock('Xpressengine\Theme\ThemeHandler');
        $siteHandler = m::mock('Xpressengine\Site\SiteHandler');

        $this->routeHandler = $routeHandler;
        $this->menuConfigHandler = $menuConfigHandler;
        $this->menuHandler = $menuHandler;
        $this->themeHandler = $themeHandler;
        $this->siteHandler = $siteHandler;

        $instanceRoute = new InstanceRoute(
            [
                'instanceId' => 'board',
                'module' => 'module/xpressengine@board',
                'url' => 'freeboard',
                'menuId' => 'basic',
                'site' => 'default'
            ]
        );

        $siteHandler->shouldReceive('getHomeInstanceId')->andReturn('board');

        $routeHandler->shouldReceive('getByInstanceId')->andReturn(
            $instanceRoute
        );



        $moduleValidator = new ModuleValidator();

        $moduleValidator->boot($routeHandler, $menuHandler, $menuConfigHandler, $themeHandler, $siteHandler);

        $this->moduleValidator = $moduleValidator;

        $this->route = $route;
        $this->request = $request;




        parent::setUp();
    }
}
