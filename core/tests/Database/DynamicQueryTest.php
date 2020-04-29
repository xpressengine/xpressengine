<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Database;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Database\DynamicQuery;

/**
 * Class DynamicQueryTest
 * @package Xpressengine\Tests\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DynamicQueryTest extends TestCase
{
    protected $processor;
    protected $grammar;
    protected $connection;
    protected $connector;

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
    }

    /**
     * get query builder instance
     *
     * @return DynamicQuery
     */
    private function getInstance($proxy = false)
    {
        $processor = m::mock('Illuminate\Database\Query\Processors\Processor');

        $grammar = m::mock('Illuminate\Database\Query\Grammars\Grammar');
        $grammar->shouldReceive('compileSelect')->andReturn('select * from table');

        $connection = m::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getPostProcessor')->andReturn($processor);
        $connection->shouldReceive('getQueryGrammar')->andReturn($grammar);

        $connector = m::mock('Xpressengine\Database\VirtualConnection');
        $connector->shouldReceive('getDefaultConnection')->andReturn($connection);

        $this->processor = $processor;
        $this->grammar = $grammar;
        $this->connection = $connection;
        $this->connector = $connector;

        /** @var \Xpressengine\Database\VirtualConnection $connector */
        $dynamicQuery = m::mock('Xpressengine\Database\DynamicQuery', [$this->connector, $this->grammar, $this->processor])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $dynamicQuery->setProxyOption([]);
        $dynamicQuery->useDynamic(true);
        $dynamicQuery->useProxy($proxy);
        return $dynamicQuery->from('table');
    }

    /**
     * test proxy setting
     *
     * @return void
     */
    public function testSetProxy()
    {
        $query = $this->getInstance();

        $query->useProxy(true);
        $reflection = new \ReflectionClass(get_class($query));
        $propertyProxy = $reflection->getProperty('proxy');
        $propertyProxy->setAccessible(true);
        $proxy = $propertyProxy->getValue($query);
        $propertyDynamic = $reflection->getProperty('dynamic');
        $propertyDynamic->setAccessible(true);
        $dynamic = $propertyDynamic->getValue($query);
        $this->assertTrue($proxy);
        $this->assertTrue($dynamic);

        $query->useProxy(false);
        $proxy = $propertyProxy->getValue($query);
        $this->assertFalse($proxy);
        $query->useDynamic(false);
        $dynamic = $propertyDynamic->getValue($query);
        $this->assertFalse($dynamic);

        $setOptions = ['option1', 'option2'];
        $query->setProxyOption($setOptions);
        $property = $reflection->getProperty('options');
        $property->setAccessible(true);
        $options = $property->getValue($query);
        $this->assertEquals($setOptions, $options);

        $query->useProxy(true);
        $proxyManager = m::mock('Xpressengine\Database\ProxyManager');
        $proxyManager->shouldReceive('set');
        $this->connector->shouldReceive('getProxyManager')->andReturn($proxyManager);
        $this->assertNull($query->getProxyManager());
        $query->useDynamic(true);
        $this->assertInstanceOf('Xpressengine\Database\ProxyManager', $query->getProxyManager());
    }

    /**
     * test query builder interface without proxy, dynamic
     *
     * @return void
     */
    public function testWithoutDynamicAndProxy()
    {
        $processor = m::mock('Illuminate\Database\Query\Processors\Processor');
        $processor->shouldReceive('processSelect')->andReturn([['id'=>1]]);
        $processor->shouldReceive('processInsertGetId')->andReturn(1);

        $grammar = m::mock('Illuminate\Database\Query\Grammars\Grammar');
        $grammar->shouldReceive('compileInsert')->andReturn('insert into table');
        $grammar->shouldReceive('compileInsertGetId')->andReturn('insert into table');
        $grammar->shouldReceive('compileUpdate')->andReturn('update table set');
        $grammar->shouldReceive('compileDelete')->andReturn('delete from table');
        $grammar->shouldReceive('compileSelect')->andReturn('select * from table');
        $grammar->shouldReceive('prepareBindingsForUpdate')->andReturn([]);
        $grammar->shouldReceive('prepareBindingsForDelete')->andReturn([]);

        $connection = m::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getPostProcessor')->andReturn($processor);
        $connection->shouldReceive('getQueryGrammar')->andReturn($grammar);

        $connector = m::mock('Xpressengine\Database\VirtualConnection');
        $connector->shouldReceive('getDefaultConnection')->andReturn($connection);
        $connector->shouldReceive('insert')->andReturn(true);
        $connector->shouldReceive('insertGetId')->andReturn(1);
        $connector->shouldReceive('update')->andReturn(1);
        $connector->shouldReceive('delete')->andReturn(1);
        $connector->shouldReceive('select')->andReturn(1);

        $params = ['some'=>'some'];

        /** @var \Xpressengine\Database\VirtualConnection $connector */
        $query = new DynamicQuery($connector, $grammar, $processor);
        $query->useProxy(false);
        $this->assertEquals(true, $query->insert($params));
        $this->assertEquals(1, $query->insertGetId($params));
        $this->assertEquals(true, $query->update($params));
        $this->assertEquals(true, $query->delete($params));
        $this->assertEquals([['id'=>1]], $query->get()->all());
        $this->assertEquals(['id'=>1], $query->first());
        //$this->assertEquals([], $query->paginate(10));    // 쉽지않음
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $query->where([]));
    }

    /**
     * test query builder interface without proxy, dynamic
     *
     * @return void
     */
    public function testWithDynamicWithoutProxy()
    {
        $params = ['some'=>'some'];

        $processor = m::mock('Illuminate\Database\Query\Processors\Processor');
        $processor->shouldReceive('processSelect')->andReturn([['id'=>1]]);
        $processor->shouldReceive('processInsertGetId')->andReturn(1);

        $grammar = m::mock('Illuminate\Database\Query\Grammars\Grammar');
        $grammar->shouldReceive('compileInsert')->andReturn('insert into table');
        $grammar->shouldReceive('compileInsertGetId')->andReturn('insert into table');
        $grammar->shouldReceive('compileUpdate')->andReturn('update table set');
        $grammar->shouldReceive('compileDelete')->andReturn('delete from table');
        $grammar->shouldReceive('compileSelect')->andReturn('select * from table');
        $grammar->shouldReceive('prepareBindingsForUpdate')->andReturn([]);
        $grammar->shouldReceive('prepareBindingsForDelete')->andReturn([]);

        $schemaBuilder = m::mock('Illuminate\Database\Schema\Builder');
        $schemaBuilder->shouldReceive('getColumnListing')->andReturn(['some']);

        $connection = m::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getPostProcessor')->andReturn($processor);
        $connection->shouldReceive('getQueryGrammar')->andReturn($grammar);
        $connection->shouldReceive('getSchemaBuilder')->andReturn($schemaBuilder);

        $connector = m::mock('Xpressengine\Database\VirtualConnection');
        $connector->shouldReceive('getDefaultConnection')->andReturn($connection);
        $connector->shouldReceive('getSchemaBuilder')->andReturn($schemaBuilder);
        $connector->shouldReceive('insert')->andReturn(true);
        $connector->shouldReceive('insertGetId')->andReturn(1);
        $connector->shouldReceive('update')->andReturn(1);
        $connector->shouldReceive('delete')->andReturn(1);
        $connector->shouldReceive('select')->andReturn(1);
        $connector->shouldReceive('getSchema')->andReturn($params);

        /** @var \Xpressengine\Database\VirtualConnection $connector */
        $query = new DynamicQuery($connector, $grammar, $processor);
        $query->useProxy(false);
        $this->assertEquals(true, $query->insert($params));
        $this->assertEquals(1, $query->insertGetId($params));
        $this->assertEquals(true, $query->update($params));
        $this->assertEquals(true, $query->delete($params));
        $this->assertEquals([['id'=>1]], $query->get()->all());
        $this->assertEquals(['id'=>1], $query->first());
        //$this->assertEquals([], $query->paginate(10));    // 쉽지않음
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $query->where([]));
    }

    /**
     * test query builder interface without proxy, dynamic
     *
     * @return void
     */
    public function testWithDynamicAndProxy()
    {
        $params = ['some'=>'some'];

        $processor = m::mock('Illuminate\Database\Query\Processors\Processor');
        $processor->shouldReceive('processSelect')->andReturn([['id'=>1]]);
        $processor->shouldReceive('processInsertGetId')->andReturn(1);

        $grammar = m::mock('Illuminate\Database\Query\Grammars\Grammar');
        $grammar->shouldReceive('compileInsert')->andReturn('insert into table');
        $grammar->shouldReceive('compileInsertGetId')->andReturn('insert into table');
        $grammar->shouldReceive('compileUpdate')->andReturn('update table set');
        $grammar->shouldReceive('compileDelete')->andReturn('delete from table');
        $grammar->shouldReceive('compileSelect')->andReturn('select * from table');
        $grammar->shouldReceive('prepareBindingsForUpdate')->andReturn([]);
        $grammar->shouldReceive('prepareBindingsForDelete')->andReturn([]);

        $schemaBuilder = m::mock('Illuminate\Database\Schema\Builder');
        $schemaBuilder->shouldReceive('getColumnListing')->andReturn(['some']);

        $connection = m::mock('Illuminate\Database\Connection');
        $connection->shouldReceive('getPostProcessor')->andReturn($processor);
        $connection->shouldReceive('getQueryGrammar')->andReturn($grammar);
        $connection->shouldReceive('getSchemaBuilder')->andReturn($schemaBuilder);

        $proxyManager = m::mock('Xpressengine\Database\ProxyManager');
        $proxyManager->shouldReceive('set');
        $proxyManager->shouldReceive('insert');
        $proxyManager->shouldReceive('update');
        $proxyManager->shouldReceive('delete');
        $proxyManager->shouldReceive('wheres');
        $proxyManager->shouldReceive('orders');


        $connector = m::mock('Xpressengine\Database\VirtualConnection');
        $connector->shouldReceive('getDefaultConnection')->andReturn($connection);
        $connector->shouldReceive('getSchemaBuilder')->andReturn($schemaBuilder);
        $connector->shouldReceive('getProxyManager')->andReturn($proxyManager);
        $connector->shouldReceive('insert')->andReturn(true);
        $connector->shouldReceive('insertGetId')->andReturn(1);
        $connector->shouldReceive('update')->andReturn(1);
        $connector->shouldReceive('delete')->andReturn(1);
        $connector->shouldReceive('select')->andReturn(1);
        $connector->shouldReceive('getSchema')->andReturn($params);

        /** @var \Xpressengine\Database\VirtualConnection $connector */
        $query = new DynamicQuery($connector, $grammar, $processor);
        $query->useProxy(true);
        $this->assertEquals(true, $query->insert($params));
        $this->assertEquals(1, $query->insertGetId($params));
        $this->assertEquals(true, $query->update($params));
        $this->assertEquals(true, $query->delete($params));
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $query->where([]));


        $proxyManager->shouldReceive('get');
        $proxyManager->shouldReceive('first');

        $this->assertEquals([['id'=>1]], $query->get()->all());
        $this->assertEquals(['id'=>1], $query->first());
    }
}
