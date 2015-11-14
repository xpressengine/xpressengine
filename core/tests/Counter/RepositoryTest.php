<?php
/**
 *
 */
namespace Xpressengine\Tests\Counter;

use Mockery as M;
use PHPUnit_Framework_TestCase;
use Xpressengine\Counter\Repository;

/**
 * Class RepositoryTest
 * @package Xpressengine\Tests\Counter
 */
class RepositoryTest extends PHPUnit_Framework_TestCase
{
    protected $conn;
    protected $query;

    /**
     * tear down
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * set up
     *
     * @return void
     */
    public function setUp()
    {
        $query = m::mock('Xpressengine\Database\DynamicQuery');

        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $conn->shouldReceive('table')->andReturn($query);

        $this->conn = $conn;
        $this->query = $query;
    }

    /**
     * test insert
     *
     * @return void
     */
    public function testInsert()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = new Repository($conn);

        $query->shouldReceive('insert');
        $repo->insert('name', 'option', 'targetId', 'userId', '127.0.0.1', 1);
    }

    /**
     * test delete
     *
     * @return void
     */
    public function testDelete()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = new Repository($conn);

        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('delete');
        $repo->delete('name', 'option', 'targetId', 'userId');
    }

    /**
     * test wheres
     *
     * @return void
     */
    public function testWheres()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = new Repository($conn);

        $query->shouldReceive('where')->andReturn($query);

        $wheres = [
            'id' => 'id',
            'counterName' => 'counterName',
            'counterOption' => 'counterOption',
            'targetId' => 'targetId',
            'userId' => 'userId',
        ];
        $query = $repo->wheres($query, $wheres);
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $query);
    }

    /**
     * test orders
     *
     * @return void
     */
    public function testOrders()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = new Repository($conn);

        $query->shouldReceive('orderBy')->andReturn($query);

        $query = $repo->orders($query, []);
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $query);

        $orders = [
            'createdAt' => 'createdAt',
        ];
        $query = $repo->orders($query, $orders);
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $query);
    }

    /**
     * test get count
     *
     * @return void
     */
    public function testCount()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = new Repository($conn);

        $query->shouldReceive('wheres')->andReturn($query);
        $query->shouldReceive('count')->andReturn(0);

        $result = $repo->count([]);
        $this->assertEquals(0, $result);
    }

    /**
     * test get count group by option
     *
     * @return void
     */
    public function testCountByOption()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = new Repository($conn);

        $query->shouldReceive('wheres')->andReturn($query);
        $query->shouldReceive('groupBy')->andReturn($query);
        $query->shouldReceive('raw');
        $query->shouldReceive('get')->andReturn([0, 1]);

        $result = $repo->countsByOption([]);
        $this->assertEquals([0, 1], $result);
    }

    /**
     * test get point sum
     *
     * @return void
     */
    public function testGetPoint()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = new Repository($conn);

        $query->shouldReceive('wheres')->andReturn($query);
        $query->shouldReceive('sum')->andReturn(0);

        $result = $repo->getPoint([]);
        $this->assertEquals(0, $result);
    }

    /**
     * test get point sum group by option
     *
     * @return void
     */
    public function testGetPointByOption()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = new Repository($conn);

        $query->shouldReceive('wheres')->andReturn($query);
        $query->shouldReceive('groupBy')->andReturn($query);
        $query->shouldReceive('raw');
        $query->shouldReceive('get')->andReturn([0, 1]);

        $result = $repo->getPointByOption([]);
        $this->assertEquals([0, 1], $result);
    }

    /**
     * test find
     *
     * @return void
     */
    public function testFind()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = new Repository($conn);

        $query->shouldReceive('wheres')->andReturn($query);
        $query->shouldReceive('first')->andReturn(['result']);

        $result = $repo->find([]);
        $this->assertEquals(['result'], $result);
    }

    /**
     * test fetch
     *
     * @return void
     */
    public function testFetch()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = m::mock('Xpressengine\Counter\Repository', [$conn])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repo->shouldReceive('wheres')->andReturn($query);
        $repo->shouldReceive('orders')->andReturn($query);

        $query->shouldReceive('wheres')->andReturn($query);
        $query->shouldReceive('take')->andReturn($query);
        $query->shouldReceive('get')->andReturn([['result']]);

        $result = $repo->fetch([], []);
        $this->assertEquals([['result']], $result);


        $result = $repo->fetch([], [], 10);
        $this->assertEquals([['result']], $result);
    }

    /**
     * test paginate
     *
     * @return void
     */
    public function testPaginate()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = m::mock('Xpressengine\Counter\Repository', [$conn])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repo->shouldReceive('wheres')->andReturn($query);
        $repo->shouldReceive('orders')->andReturn($query);

        $query->shouldReceive('wheres')->andReturn($query);
        $query->shouldReceive('paginate')->andReturn([['result']]);

        $result = $repo->paginate([], [], 10);
        $this->assertEquals([['result']], $result);
    }

    /**
     * test fetch by user ids
     *
     * @return void
     */
    public function testFetchByUserIds()
    {
        $conn = $this->conn;
        $query = $this->query;

        $repo = m::mock('Xpressengine\Counter\Repository', [$conn])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repo->shouldReceive('wheres')->andReturn($query);
        $repo->shouldReceive('orders')->andReturn($query);

        $query->shouldReceive('wheres')->andReturn($query);
        $query->shouldReceive('take')->andReturn($query);
        $query->shouldReceive('lists')->andReturn(['userId']);

        $result = $repo->fetchByUserIds([], []);
        $this->assertEquals(['userId'], $result);

        $result = $repo->fetchByUserIds([], [], 10);
        $this->assertEquals(['userId'], $result);
    }
}
