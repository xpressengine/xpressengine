<?php namespace Xpressengine\Tests\Routing;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Config\Repository;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Illuminate\Support\Collection;

use \Xpressengine\Routing\InstanceRoute;
use Xpressengine\Routing\Exceptions\NotFoundInstanceRouteException;
use Xpressengine\Routing\InstanceRouteCacheHandler;
use \Xpressengine\Routing\InstanceRouteRepository;
use \Xpressengine\Routing\InstanceRouteHandler;

/**
 * Class InstanceRouteHandlerTest
 *
 * @package Xpressengine\Tests\Routing
 */
class InstanceRouteHandlerTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     */
    const ROUTE_TABLE = 'instanceRoute';

    /**
     * @var
     */
    protected $conn;
    /**
     * @var
     */
    protected $query;

    /**
     * @var
     */
    protected $container;
    /**
     * @var
     */
    protected $instanceRoute;
    /**
     * @var MockInterface
     */
    protected $repo;

    /**
     * @var MockInterface
     */
    protected $illuminateConfig;

    /**
     * @var MockInterface
     */
    protected $cache;

    /**
     * @var InstanceRouteHandler $instanceRouteHandler
     */
    protected $instanceRouteHandler;

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
     * testGetsBySite
     * cache hit test
     *
     * @return void
     */
    public function testGetsBySiteWithCache()
    {
        /**
         * @var InstanceRoute[]      $instanceRoutes
         * @var InstanceRouteHandler $handler
         */
        $handler = $this->instanceRouteHandler;
        $cache = $this->cache;
        $cache->shouldReceive('isExistCachedSiteInstanceRoutes')->andReturn(true);
        $cache->shouldReceive('getCachedSiteInstanceRoutes')->andReturn(
            [
                'test' => new InstanceRoute(
                    [
                        'instanceId' => 'test',
                        'module' => 'module/xpressengine@test',
                        'url' => 'testing',
                        'menuId' => 'main',
                        'site' => 'default'
                    ]
                )
            ]
        );

        $testSiteKey = 'default';
        $instanceRoutes = $handler->getsBySite($testSiteKey);

        $instanceRoute = $instanceRoutes['test'];

        $this->assertEquals(1, count($instanceRoutes));
        $this->assertEquals('test', $instanceRoute->instanceId);
        $this->assertEquals('testing', $instanceRoute->url);
        $this->assertEquals('module/xpressengine@test', $instanceRoute->module);
        $this->assertEquals('main', $instanceRoute->menuId);
        $this->assertEquals('default', $instanceRoute->site);

    }

    /**
     * testGetsBySiteNoCache
     * cache miss test
     *
     * @return void
     */
    public function testGetsBySiteNoCache()
    {
        /**
         * @var InstanceRoute[]      $instanceRoutes
         * @var InstanceRouteHandler $handler
         */


        $handler = $this->instanceRouteHandler;
        $cache = $this->cache;
        $repo = $this->repo;
        $testSiteKey = 'default';

        $cache->shouldReceive('isExistCachedSiteInstanceRoutes')->andReturn(false);
        $cache->shouldReceive('setSiteInstanceCache')->andReturn();
        $repo->shouldReceive('fetch')->with(m::on(function ($closure) {
            return true;
        }
        ))->andReturn(
            [
                'test' => new InstanceRoute(
                    [
                        'instanceId' => 'test',
                        'module' => 'module/xpressengine@test',
                        'url' => 'testing',
                        'menuId' => 'main',
                        'site' => 'default'
                    ]
                )
            ]
        );


        $instanceRoutes = $handler->getsBySite($testSiteKey);

        $instanceRoute = $instanceRoutes['test'];

        $this->assertEquals(1, count($instanceRoutes));
        $this->assertEquals('test', $instanceRoute->instanceId);
        $this->assertEquals('testing', $instanceRoute->url);
        $this->assertEquals('module/xpressengine@test', $instanceRoute->module);
        $this->assertEquals('main', $instanceRoute->menuId);
        $this->assertEquals('default', $instanceRoute->site);

    }

    /**
     * testGetByUrl
     *
     * @return void
     */
    public function testGetByUrl()
    {
        /**
         * @var InstanceRoute        $instanceRoute
         * @var InstanceRouteHandler $handler
         */
        $handler = $this->instanceRouteHandler;

        $cache = $this->cache;
        $cache->shouldReceive('isExistCachedSiteInstanceRoutes')->andReturn(true);
        $cache->shouldReceive('getCachedSiteInstanceRoutes')->andReturn(
            [
                'test' =>
                    new InstanceRoute(
                        [
                            'instanceId' => 'test',
                            'module' => 'module/xpressengine@test',
                            'url' => 'testing',
                            'menuId' => 'main',
                            'site' => 'default'
                        ]
                    )
            ]
        );


        $instanceRoute = $handler->getByUrl('default', 'testing');

        $this->assertEquals($instanceRoute->url, 'testing');
        $this->assertEquals($instanceRoute->module, 'module/xpressengine@test');
        $this->assertEquals($instanceRoute->instanceId, 'test');
        $this->assertEquals($instanceRoute->menuId, 'main');
        $this->assertEquals($instanceRoute->site, 'default');
    }

    /**
     * testGetByInstanceIdNoCache
     *
     * @return void
     */
    public function testGetByInstanceIdNoCache()
    {
        /**
         * @var InstanceRoute        $instanceRoute
         * @var InstanceRouteHandler $handler
         */
        $handler = $this->instanceRouteHandler;
        $cache = $this->cache;
        $cache->shouldReceive('isExistCachedInstanceRoute')->andReturn(false);
        $cache->shouldReceive('setInstanceRouteCache')->andReturn(false);

        $repo = $this->repo;
        $repo->shouldReceive('find')->andReturn(
            new InstanceRoute(
                [
                    'instanceId' => 'test',
                    'module' => 'module/xpressengine@test',
                    'url' => 'testing',
                    'menuId' => 'main',
                    'site' => 'default'
                ]
            )
        );

        $instanceRoute = $handler->getByInstanceId('test');

        $this->assertEquals($instanceRoute->url, 'testing');
        $this->assertEquals($instanceRoute->module, 'module/xpressengine@test');
        $this->assertEquals($instanceRoute->instanceId, 'test');
        $this->assertEquals($instanceRoute->menuId, 'main');
        $this->assertEquals($instanceRoute->site, 'default');
    }

    /**
     * testGetByInstanceIdWithCache
     *
     * @return void
     */
    public function testGetByInstanceIdWithCache()
    {
        /**
         * @var InstanceRoute        $instanceRoute
         * @var InstanceRouteHandler $handler
         */
        $handler = $this->instanceRouteHandler;
        $cache = $this->cache;
        $cache->shouldReceive('isExistCachedInstanceRoute')->andReturn(true);
        $cache->shouldReceive('getCachedInstanceRoute')->andReturn(
            new InstanceRoute(
                [
                    'instanceId' => 'test',
                    'module' => 'module/xpressengine@test',
                    'url' => 'testing',
                    'menuId' => 'main',
                    'site' => 'default'
                ]
            )
        );

        $instanceRoute = $handler->getByInstanceId('test');

        $this->assertEquals($instanceRoute->url, 'testing');
        $this->assertEquals($instanceRoute->module, 'module/xpressengine@test');
        $this->assertEquals($instanceRoute->instanceId, 'test');
        $this->assertEquals($instanceRoute->menuId, 'main');
        $this->assertEquals($instanceRoute->site, 'default');
    }

    /**
     * testGetsByModule
     *
     * @return void
     */
    public function testGetsByModule()
    {
        /**
         * @var InstanceRoute        $instanceRoute
         * @var InstanceRouteHandler $handler
         */
        $handler = $this->instanceRouteHandler;
        $repo = $this->repo;
        $repo->shouldReceive('fetch')->andReturn(
            [
                'test' => new InstanceRoute(
                    [
                        'instanceId' => 'test',
                        'module' => 'module/tester@page',
                        'url' => 'testing',
                        'menuId' => 'main',
                        'site' => 'default'
                    ]
                )
            ]
        );

        $instanceRoutes = $handler->getsByModule('module/tester@page');

        $this->assertEquals(1, sizeof($instanceRoutes));

    }

    /**
     * testAdd
     *
     * @return void
     */
    public function testAdd()
    {
        /**
         * @var InstanceRoute        $instanceRoute
         * @var InstanceRouteHandler $handler
         * @var InstanceRoute        $foundInstanceRoute
         */

        $handler = $this->instanceRouteHandler;
        $repo = $this->repo;
        $cache = $this->cache;
        $cache->shouldReceive('deleteCachedInstanceRoute')->andReturn();
        $cache->shouldReceive('deleteCachedSiteInstanceRoutes')->andReturn();

        $repo->shouldReceive('insert')->andReturn(true);
        $instanceRoute = new InstanceRoute(
            [
                'url' => 'testUrl',
                'module' => 'testPlugin/module@test',
                'instanceId' => 'test',
                'menuId' => 'basic',
                'site' => 'default'
            ]
        );
        $addedInstanceRoute = $handler->add($instanceRoute);
        $this->assertEquals('test', $addedInstanceRoute->instanceId);
        $this->assertEquals('testPlugin/module@test', $addedInstanceRoute->module);
        $this->assertEquals('test', $addedInstanceRoute->instanceId);
        $this->assertEquals('basic', $addedInstanceRoute->menuId);
        $this->assertEquals('default', $addedInstanceRoute->site);

    }

    /**
     * testPut
     *
     * @return void
     */
    public function testPut()
    {
        $handler = $this->instanceRouteHandler;

        $cache = $this->cache;
        $cache->shouldReceive('isExistCachedInstanceRoute')->andReturn(true);
        $cache->shouldReceive('getCachedInstanceRoute')->andReturn(
            new InstanceRoute(
                [
                    'url' => 'testUrl',
                    'module' => 'testPlugin/module@test',
                    'instanceId' => 'test',
                    'menuId' => 'basic',
                    'site' => 'default'
                ]
            )
        );

        $cache->shouldReceive('deleteCachedInstanceRoute')->andReturn();
        $cache->shouldReceive('deleteCachedSiteInstanceRoutes')->andReturn();

        $instanceRoute = $handler->getByInstanceId('freeboard');

        $repo = $this->repo;
        $repo->shouldReceive('update')->andReturn($instanceRoute);

        $resultInstanceRoute = $handler->put($instanceRoute);

        $this->assertEquals('testUrl', $resultInstanceRoute->url);
        $this->assertEquals('basic', $resultInstanceRoute->menuId);
        $this->assertEquals('default', $resultInstanceRoute->site);
        $this->assertEquals('test', $resultInstanceRoute->instanceId);
        $this->assertEquals('testPlugin/module@test', $resultInstanceRoute->module);

    }

    /**
     * testRemove
     *
     * @return void
     */
    public function testRemove()
    {
        $repo = $this->repo;
        $cache = $this->cache;

        $repo->shouldReceive('delete')->andReturn(1);
        $cache->shouldReceive('deleteCachedInstanceRoute')->andReturn();
        $cache->shouldReceive('deleteCachedSiteInstanceRoutes')->andReturn();

        $handler = $this->instanceRouteHandler;

        $result = $handler->remove(new InstanceRoute(
            [
                'url' => 'testUrl',
                'module' => 'testPlugin/module@test',
                'instanceId' => 'test',
                'menuId' => 'basic',
                'site' => 'default'
            ]
        ));
        $this->assertEquals(1, $result);
    }

    /**
     * testUsableUrlDisable
     *
     * @return void
     */
    public function testUsableUrlDisable()
    {
        /**
         * @var InstanceRouteHandler $handler
         */

        $handler = $this->instanceRouteHandler;

        $repo = $this->repo;
        $repo->shouldReceive('countByUrl')->andReturn(0);
        $this->illuminateConfig->shouldReceive('get')->with('xe.routing.fixedPrefix')->andReturn('fixed');
        $this->illuminateConfig->shouldReceive('get')->with('xe.routing.settingsPrefix')->andReturn('manage');

        $this->assertEquals(false, $handler->usableUrl('default', 'fixed'));
        $this->assertEquals(false, $handler->usableUrl('default', 'manage'));
        $this->assertEquals(true, $handler->usableUrl('default', 'sampleurl'));

    }

    /**
     * testUsableUrlDisable2
     *
     * @return void
     */
    public function testUsableUrlDisable2()
    {
        /**
         * @var InstanceRouteHandler $handler
         */

        $handler = $this->instanceRouteHandler;
        $repo = $this->repo;
        $repo->shouldReceive('countByUrl')->andReturn(1);

        $this->illuminateConfig->shouldReceive('get')->with('xe.routing.fixedPrefix')->andReturn('fixed');
        $this->illuminateConfig->shouldReceive('get')->with('xe.routing.settingsPrefix')->andReturn('manage');

        $this->assertEquals(false, $handler->usableUrl('default', 'member'));

    }

    /**
     * testUsableUrlAble
     *
     * @return void
     */
    public function testUsableUrlAble()
    {
        /**
         * @var InstanceRouteHandler $handler
         */

        $handler = $this->instanceRouteHandler;
        $repo = $this->repo;
        $repo->shouldReceive('countByUrl')->andReturn(0);

        $this->illuminateConfig->shouldReceive('get')->with('xe.routing.fixedPrefix')->andReturn('fixed');
        $this->illuminateConfig->shouldReceive('get')->with('xe.routing.settingsPrefix')->andReturn('manage');

        $this->assertEquals(true, $handler->usableUrl('default', 'freeboard'));

    }


    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        /**
         * @var InstanceRouteRepository   $repo
         * @var InstanceRouteCacheHandler $cache
         * @var Repository                $illuminateConfig
         */
        $repo = m::mock('Xpressengine\Routing\InstanceRouteRepository');
        $cache = m::mock('Xpressengine\Routing\InstanceRouteCacheHandler');

        $illuminateConfig = m::mock('Illuminate\Contracts\Config\Repository');

        $this->repo = $repo;
        $this->illuminateConfig = $illuminateConfig;
        $this->cache = $cache;

        $this->instanceRouteHandler = new InstanceRouteHandler($repo, $cache, $illuminateConfig);
        parent::setUp();
    }
}
