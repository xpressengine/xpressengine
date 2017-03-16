<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Routing;

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
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class ModuleValidatorTest extends PHPUnit_Framework_TestCase
{
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
        list($routeRepo, $menuHandler, $themeHandler, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $menuHandler, $themeHandler, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();

        $request->shouldReceive('segment')->with(1)->andReturn('home');
        $route->shouldReceive('uri')->andReturn('');
        $route->shouldReceive('getAction')->andReturn([]);


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
        list($routeRepo, $menuHandler, $themeHandler, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $menuHandler, $themeHandler, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();

        $request->shouldReceive('segment')->with(1)->andReturn(null);
        $route->shouldReceive('uri')->andReturn('{instanceGroup}');
        $route->shouldReceive('getAction')->andReturn([
            'module' => 'module/pluginB@page'
        ]);

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
        list($routeRepo, $menuHandler, $themeHandler, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $menuHandler, $themeHandler, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();

        $request->shouldReceive('segment')->with(1)->andReturn(null);
        $route->shouldReceive('uri')->andReturn('{instanceGroup}');
        $route->shouldReceive('getAction')->andReturn([
            'as' => 'test.root.match',
            'module' => 'module/xpressengine@board'
        ]);

        $dummyItem = m::mock('Xpressengine\Menu\MenuItem');

        $route->shouldReceive('setAction')->andReturn($route);

        $menuHandler->shouldReceive('getItem')->andReturn($dummyItem);
        $menuHandler->shouldReceive('getMenuItemTheme')->andReturn('defaultTheme');

        $themeHandler->shouldReceive('selectTheme')->andReturn(null);

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
        list($routeRepo, $menuHandler, $themeHandler, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $menuHandler, $themeHandler, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();

        $request->shouldReceive('segment')->with(1)->andReturn('aboutus');
        $route->shouldReceive('uri')->andReturn('{module_pluginB_page}');
        $route->shouldReceive('getAction')->andReturn([
            'module' => 'module/pluginB@page'
        ]);

        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(true, $result);

    }

    /**
     * testAboutUsNotMatchUriNoModuleAttr
     *
     * @return void
     */
    public function testAboutUsNotMatchUriNoModuleAttr()
    {
        list($routeRepo, $menuHandler, $themeHandler, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $menuHandler, $themeHandler, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();

        $request->shouldReceive('segment')->with(1)->andReturn('home');
        $route->shouldReceive('uri')->andReturn('{module_pluginB_page}');
        $route->shouldReceive('getAction')->andReturn([

        ]);

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
        list($routeRepo, $menuHandler, $themeHandler, $siteHandler, $route, $request) = $this->getMocks();
        $moduleValidator = new ModuleValidator();
        $moduleValidator->boot($routeRepo, $menuHandler, $themeHandler, $siteHandler);

        $route->shouldReceive('getCompiled')->andReturnSelf();
        $route->shouldReceive('getHostRegex')->andReturnNull();
        
        $request->shouldReceive('segment')->with(1)->andReturn('board');
        $route->shouldReceive('getAction')->andReturn([
            'as' => 'test.root.match',
            'module' => 'module/pluginB@page'
        ]);

        $dummyItem = m::mock('Xpressengine\Menu\MenuItem');

        $route->shouldReceive('uri')->andReturn('freeboard');
        $route->shouldReceive('setAction')->andReturn($route);

        $menuHandler->shouldReceive('getItem')->andReturn($dummyItem);
        $menuHandler->shouldReceive('getMenuItemTheme')->andReturn('defaultTheme');

        $result = $moduleValidator->matches($route, $request);

        $this->assertEquals(true, $result);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Routing\RouteRepository'),
            m::mock('Xpressengine\Menu\MenuHandler'),
            m::mock('Xpressengine\Theme\ThemeHandler'),
            m::mock('Xpressengine\Site\SiteHandler'),
            m::mock('Illuminate\Routing\Route'),
            m::mock('Illuminate\Http\Request'),
        ];
    }
}
