<?php
/**
 * InstanceRouteCacheHandlerTest.php
 *
 * PHP version 5
 *
 * @category    Test
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Tests\Routing;

use Mockery as m;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Xpressengine\Routing\InstanceRoute;
use Xpressengine\Routing\InstanceRouteCacheHandler;

/**
 * Class InstanceRouteCacheHandlerTest
 *
 * @package Xpressengine\Tests\Routing
 */
class InstanceRouteCacheHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockInterface
     */
    protected $cache;

    /**
     * testIsExistCachedInstanceRoute
     *
     * @return void
     */
    public function testIsExistCachedInstanceRoute()
    {
        $cache = $this->cache;
        $cache->shouldReceive('has')->andReturn(true);

        $cacheHandler = new InstanceRouteCacheHandler($cache, false);

        $exist = $cacheHandler->isExistCachedInstanceRoute('test');

        $this->assertEquals(true, $exist);
    }

    public function testGetCachedInstanceRouteThrowException()
    {
        $this->setExpectedException('Xpressengine\Routing\Exceptions\NotFoundInstanceRouteException');

        $cache = $this->cache;
        $cache->shouldReceive('get')->andReturn(serialize(new InstanceRoute(['site' => 'testSiteKey'])));
        $cache->shouldReceive('has')->andReturn(false);
        $cacheHandler = new InstanceRouteCacheHandler($cache, false);

        $cacheHandler->getCachedInstanceRoute('testInstanceId');
    }

    /**
     * testSetInstanceRouteCache
     *
     * @return void
     */
    public function testSetInstanceRouteCache()
    {
        $cache = $this->cache;
        $cache->shouldReceive('forever')->andReturn(true);

        $cacheHandler = new InstanceRouteCacheHandler($cache, false);

        $instanceRoute = new InstanceRoute(['site' => 'test']);
        $cacheHandler->setInstanceRouteCache('testInstanceId', $instanceRoute);
    }

    public function testDeleteCachedInstanceRoute()
    {
        $cache = $this->cache;
        $cache->shouldReceive('forget')->andReturn(true);

        $cacheHandler = new InstanceRouteCacheHandler($cache, false);

        $cacheHandler->deleteCachedInstanceRoute('testInstanceId');
    }

    /**
     * testIsExistCachedInstanceRouteDebugMode
     *
     * @return void
     */
    public function testIsExistCachedInstanceRouteDebugMode()
    {
        $cache = $this->cache;
        $cache->shouldReceive('has')->andReturn(true);

        $cacheHandler = new InstanceRouteCacheHandler($cache, true);

        $exist = $cacheHandler->isExistCachedInstanceRoute('test');

        $this->assertEquals(false, $exist);
    }

    /**
     * testIsExistCachedSiteInstanceRoutes
     *
     * @return void
     */
    public function testIsExistCachedSiteInstanceRoutes()
    {
        $cache = $this->cache;
        $cache->shouldReceive('has')->andReturn(true);

        $cacheHandler = new InstanceRouteCacheHandler($cache, false);

        $exist = $cacheHandler->isExistCachedSiteInstanceRoutes('default');

        $this->assertEquals(true, $exist);
    }

    /**
     * testIsExistCachedSiteInstanceRoutesWithDebugMode
     *
     * @return void
     */
    public function testIsExistCachedSiteInstanceRoutesWithDebugMode()
    {
        $cache = $this->cache;

        $cacheHandler = new InstanceRouteCacheHandler($cache, true);

        $exist = $cacheHandler->isExistCachedSiteInstanceRoutes('default');

        $this->assertEquals(false, $exist);
    }

    /**
     * testSetSiteInstanceCache
     *
     * @return void
     */
    public function testSetSiteInstanceCache()
    {
        $cache = $this->cache;
        $cache->shouldReceive('forever')->andReturn();
        $cacheHandler = new InstanceRouteCacheHandler($cache, true);

        $cacheHandler->setSiteInstanceCache('defaultSiteKey', []);
    }

    /**
     * testDeleteCachedSiteInstanceRoutes
     *
     * @return void
     */
    public function testDeleteCachedSiteInstanceRoutes()
    {
        $cache = $this->cache;
        $cache->shouldReceive('forget')->andReturn();
        $cacheHandler = new InstanceRouteCacheHandler($cache, false);
        $cacheHandler->deleteCachedSiteInstanceRoutes('defaultSite');
    }

    /**
     * testGetCachedInstanceRoute
     *
     * @return void
     */
    public function testGetCachedInstanceRoute()
    {
        $dummyInstanceRoute = new InstanceRoute(
            [
                'url' => 'url',
                'module' => 'module/xpressengine@id',
                'instanceId' => 'instanceId',
                'menuId' => 'basic',
                'site' => 'test',
            ]
        );

        $cache = $this->cache;
        $cache->shouldReceive('has')->andReturn(true);
        $cache->shouldReceive('get')->andReturn(serialize($dummyInstanceRoute));

        $cacheHandler = new InstanceRouteCacheHandler($cache, false);

        $instanceRoute = $cacheHandler->getCachedInstanceRoute('test');

        $this->assertEquals('url', $instanceRoute->url);
        $this->assertEquals('module/xpressengine@id', $instanceRoute->module);
        $this->assertEquals('instanceId', $instanceRoute->instanceId);
        $this->assertEquals('basic', $instanceRoute->menuId);
        $this->assertEquals('test', $instanceRoute->site);
    }

    /**
     * testGetCachedSiteInstanceRoutes
     *
     * @return void
     */
    public function testGetCachedSiteInstanceRoutes()
    {
        $dummyInstanceRoute = new InstanceRoute(
            [
                'url' => 'url',
                'module' => 'module/xpressengine@id',
                'instanceId' => 'instanceId',
                'menuId' => 'basic',
                'site' => 'test',
            ]
        );

        $cache = $this->cache;
        $cache->shouldReceive('has')->andReturn(true);
        $cache->shouldReceive('get')->andReturn(serialize([$dummyInstanceRoute]));

        $cacheHandler = new InstanceRouteCacheHandler($cache, false);

        $instanceRoutes = $cacheHandler->getCachedSiteInstanceRoutes('testSite');

        $instanceRoute = $instanceRoutes[0];

        $this->assertEquals('url', $instanceRoute->url);
        $this->assertEquals('module/xpressengine@id', $instanceRoute->module);
        $this->assertEquals('instanceId', $instanceRoute->instanceId);
        $this->assertEquals('basic', $instanceRoute->menuId);
        $this->assertEquals('test', $instanceRoute->site);
    }

    public function testGetCachedSiteInstanceRoutesThrowException()
    {
        $this->setExpectedException('Xpressengine\Routing\Exceptions\NotFoundInstanceRouteException');

        $cache = $this->cache;
        $cache->shouldReceive('has')->andReturn(false);

        $cacheHandler = new InstanceRouteCacheHandler($cache, true);
        $cacheHandler->getCachedSiteInstanceRoutes('testSite');
    }

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        $cacheMock = m::mock('Illuminate\Cache\Repository');

        $this->cache = $cacheMock;
    }
}
