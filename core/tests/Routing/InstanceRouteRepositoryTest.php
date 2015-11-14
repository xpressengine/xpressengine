<?php namespace Xpressengine\Tests\Routing;

use Illuminate\Cache\CacheManager;
use Mockery as m;
use Illuminate\Support\Collection;
use PHPUnit_Framework_TestCase;
use \Xpressengine\Routing\InstanceRoute;
use \Xpressengine\Routing\Exceptions\NotFoundInstanceRouteException;
use \Xpressengine\Routing\Exceptions\UnusableUrlException;
use \Xpressengine\Routing\Exceptions\UnusableInstanceIdException;
use \Xpressengine\Routing\InstanceRouteRepository;

/**
 * Class InstanceRouteRepositoryTest
 *
 * @package Xpressengine\Tests\Routing
 */
class InstanceRouteRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    const ROUTE_TABLE = 'instanceRoute';

    /**
     * @var \Mockery\MockInterface
     */
    protected $conn;
    /**
     * @var \Mockery\MockInterface
     */
    protected $query;

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
     * testAll
     *
     * @return void
     */
    public function testAll()
    {

        $repo = new InstanceRouteRepository($this->conn);
        $testSiteKey = 'default';
        $this->assertEquals(4, sizeof($repo->all($testSiteKey)));
    }

    /**
     * testFind
     *
     * @return void
     */
    public function testFind()
    {

        $repo = new InstanceRouteRepository($this->conn);
        $query = $this->query;

        $query->shouldReceive('first')->andReturn(
            [
                'instanceId' => 'freeboard',
                'url' => 'freeboard',
                'module' => 'module/pluginA@board',
                'menuId' => 'main',
                'site' => 'default',
            ]
        );

        $instanceRoute = $repo->find('freeboard');

        $this->assertEquals($instanceRoute->url, 'freeboard');
        $this->assertEquals($instanceRoute->module, 'module/pluginA@board');
        $this->assertEquals($instanceRoute->instanceId, 'freeboard');
        $this->assertEquals($instanceRoute->menuId, 'main');
        $this->assertEquals($instanceRoute->site, 'default');
    }

    /**
     * testFindException
     *
     * @return void
     */
    public function testFindException()
    {
        $this->setExpectedException('Xpressengine\Routing\Exceptions\NotFoundInstanceRouteException');
        $repo = new InstanceRouteRepository($this->conn);
        $query = $this->query;

        $query->shouldReceive('first')->andReturn(null);

        $repo->find('freeboard');

    }

    /**
     * testFindByInstanceId
     *
     * @return void
     */
    public function testFindByInstanceId()
    {

        $repo = new InstanceRouteRepository($this->conn);
        $query = $this->query;

        $query->shouldReceive('first')->andReturn(
            [
                'instanceId' => 'qna',
                'url' => 'qna',
                'module' => 'module/pluginA@board',
                'menuId' => 'main',
                'site' => 'default',
            ]
        );
        $instanceRoute = $repo->find('qna');

        $this->assertEquals($instanceRoute->url, 'qna');
        $this->assertEquals($instanceRoute->module, 'module/pluginA@board');
        $this->assertEquals($instanceRoute->instanceId, 'qna');
        $this->assertEquals($instanceRoute->menuId, 'main');
        $this->assertEquals($instanceRoute->site, 'default');
    }

    /**
     * testFindException
     *
     * @return void
     */
    public function testFindByInstanceIdException()
    {
        $this->setExpectedException('Xpressengine\Routing\Exceptions\NotFoundInstanceRouteException');
        $repo = new InstanceRouteRepository($this->conn);
        $query = $this->query;

        $query->shouldReceive('first')->andReturn(null);

        $repo->find('freeboard');

    }

    /**
     * testFindBySiteAndUrl
     *
     * @return void
     */
    public function testFindBySiteAndUrl()
    {

        $repo = new InstanceRouteRepository($this->conn);
        $query = $this->query;

        $query->shouldReceive('first')->andReturn(
            [
                'instanceId' => 'freeboard',
                'url' => 'freeboard',
                'module' => 'module/pluginA@board',
                'menuId' => 'main',
                'site' => 'default',
            ]
        );

        $instanceRoute = $repo->findBySiteAndUrl('default', 'freeboard');

        $this->assertEquals($instanceRoute->url, 'freeboard');
        $this->assertEquals($instanceRoute->module, 'module/pluginA@board');
        $this->assertEquals($instanceRoute->instanceId, 'freeboard');
        $this->assertEquals($instanceRoute->menuId, 'main');
        $this->assertEquals($instanceRoute->site, 'default');
    }

    /**
     * testFindBySiteAndUrlExpectException
     *
     * @return void
     */
    public function testFindBySiteAndUrlExpectException()
    {
        $this->setExpectedException('Xpressengine\Routing\Exceptions\NotFoundInstanceRouteException');
        $repo = new InstanceRouteRepository($this->conn);
        $query = $this->query;

        $query->shouldReceive('first')->andReturn(null);

        $repo->findBySiteAndUrl('default', 'freeboard');
    }

    /**
     * testFetch
     *
     * @return void
     */
    public function testFetch()
    {

        $repo = new InstanceRouteRepository($this->conn);
        $filter = function ($query) {
            return $query->where('instanceId', '=', 'qna');
        };

        $instanceRoutes = $repo->fetch($filter);

        $this->assertEquals(4, sizeof($instanceRoutes));
    }


    /**
     * testInsert
     *
     * @return void
     */
    public function testInsert()
    {
        $repo = new InstanceRouteRepository($this->conn);

        $query = $this->query;

        $instanceRoute = new InstanceRoute(
            [
                'url' => 'testUrl',
                'module' => 'module/xpressengine@test',
                'instanceId' => 'testInstanceId',
                'menuId' => 'basic',
                'site' => 'default'
            ]
        );

        $query->shouldReceive('insert')->andReturn(true);

        $result = $repo->insert($instanceRoute);

        $this->assertEquals(true, $result);

    }

    /**
     * testUpdateOneAliasRoute
     *
     * @return void
     */
    public function testUpdateOneAliasRoute()
    {
        /**
         * @var InstanceRoute           $instanceRoute
         * @var InstanceRouteRepository $repo
         * @var InstanceRoute           $newFindedAliasRoute
         */
        $repo = new InstanceRouteRepository($this->conn);

        $query = $this->query;
        $query->shouldReceive('update')->andReturn(1);
        $query->shouldReceive('where')->andReturn($query);

        $query->shouldReceive('first')->andReturn(
            [
                'instanceId' => 'qna',
                'url' => 'qna',
                'module' => 'module/pluginA@board',
                'menuId' => 'main',
                'site' => 'default',
            ]
        );

        $instanceRoute = $repo->find('qna');

        $affected = $repo->update($instanceRoute);

        $this->assertEquals(1, $affected);

    }

    /**
     * testDeleteOneAliasRoute
     *
     * @return void
     */
    public function testDeleteOneAliasRoute()
    {
        $repo = new InstanceRouteRepository($this->conn);

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('delete')->andReturn(1);

        $affected = $repo->delete('freeboard');

        $this->assertEquals(1, $affected);
    }

    /**
     * countByUrl
     *
     * @return void
     */
    public function testCountByUrl()
    {
        $repo = new InstanceRouteRepository($this->conn);

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('count')->andReturn(1);
        $dummyFilter = function ($query) {
            return $query->where('id', '=', 'test');
        };

        $affected = $repo->countByUrl('defaultSiteKey', 'freeboard', $dummyFilter);

        $this->assertEquals(1, $affected);
    }

    /**
     * testCountByInstanceId
     *
     * @return void
     */
    public function testCountByInstanceId()
    {
        $repo = new InstanceRouteRepository($this->conn);

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('count')->andReturn(1);
        $dummyFilter = function ($query) {
            return $query->where('id', '=', 'test');
        };

        $affected = $repo->countByInstanceId('freeboard', $dummyFilter);

        $this->assertEquals(1, $affected);
    }

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        /**
         * @var InstanceRoute           $instanceRoute
         * @var InstanceRouteRepository $repo
         * @var CacheManager            $cache
         */
        $connMock = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $queryMock = m::mock('Illuminate\Database\Query\Builder');

        $this->conn = $connMock;
        $this->query = $queryMock;

        $conn = $connMock;
        $query = $queryMock;

        $conn->shouldReceive('table')->with(self::ROUTE_TABLE)->andReturn($query);
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('get')->withAnyArgs()->andReturn(
            new Collection([
                [
                    'url' => 'introduce',
                    'module' => 'module/pluginB@page',
                    'instanceId' => 'introduce',
                    'menuId' => 'main',
                    'site' => 'default'
                ],
                [
                    'url' => 'aboutus',
                    'module' => 'module/pluginB@page',
                    'instanceId' => 'aboutus',
                    'menuId' => 'main',
                    'site' => 'default'
                ],
                [
                    'url' => 'qna',
                    'module' => 'module/pluginA@board',
                    'instanceId' => 'qna',
                    'menuId' => 'main',
                    'site' => 'default'
                ],
                [
                    'url' => 'freeboard',
                    'module' => 'module/pluginA@board',
                    'instanceId' => 'freeboard',
                    'menuId' => 'main',
                    'site' => 'default'
                ],
            ])
        );

        parent::setUp();
    }
}
