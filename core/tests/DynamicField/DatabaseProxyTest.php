<?php
/**
 *
 */
namespace Xpressengine\Tests\DynamicField;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\DynamicField\DatabaseProxy;

/**
 * Class DatabaseProxyTest
 * @package Xpressengine\Tests\DynamicField
 */
class DatabaseProxyTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var m\MockInterface|\Xpressengine\DynamicField\DynamicFieldHandler
     */
    protected $handler;

    /**
     * @var m\MockInterface|\Xpressengine\DynamicField\ConfigHandler
     */
    protected $configHandler;

    /**
     * @var m\MockInterface|\Xpressengine\DynamicField\RegisterHandler
     */
    protected $registerHandler;

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
        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');
        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $registerHandler = m::mock('Xpressengine\DynamicField\RegisterHandler');

        $handler->shouldReceive('setConnection');
        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
        $handler->shouldReceive('getRegisterHandler')->andReturn($registerHandler);


        $this->handler = $handler;
        $this->configHandler = $configHandler;
        $this->registerHandler = $registerHandler;
    }

    /**
     * invoked method
     *
     * @param mixed  $object     object
     * @param string $methodName method name
     * @param array  $parameters parameters
     * @return mixed
     */
    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * get config entity
     *
     * @return m\MockInterface|\Xpressengine\Config\ConfigEntity
     */
    private function getConfigEntity()
    {
        return m::mock('Xpressengine\Config\ConfigEntity');
    }

    /**
     * test private method
     *
     * @return void
     */
    public function testPrivateMethod()
    {
        $handler = $this->handler;

        $proxy = new DatabaseProxy($handler);

        $this->configHandler->shouldReceive('gets')->andReturn([]);
        $result = $this->invokeMethod($proxy, 'getConfigs');
        $this->assertEquals([], $result);

        $config = $this->getConfigEntity();
        $this->configHandler->shouldReceive('isTableMethodCreate')->andReturn(true);
        $result = $this->invokeMethod($proxy, 'isTableMethodCreate', [$config]);
        $this->assertTrue($result);

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $this->registerHandler->shouldReceive('getType')->andReturn($type);
        $result = $this->invokeMethod($proxy, 'getType', ['id']);
        $this->assertInstanceOf('Xpressengine\DynamicField\AbstractType', $result);
    }

    /**
     * test set
     *
     * @return void
     */
    public function testSet()
    {
        $handler = $this->handler;

        $proxy = m::mock('Xpressengine\DynamicField\DatabaseProxy', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');

        $proxy->set($conn, [
            'table' => 'table',
            'id' => 'id',
            'group' => 'group',
        ]);
    }

    /**
     * test set without table option
     *
     * @expectedException \Xpressengine\DynamicField\Exceptions\InvalidOptionException
     * @return void
     */
    public function testSetWithoutTableOption()
    {
        $handler = $this->handler;

        $proxy = m::mock('Xpressengine\DynamicField\DatabaseProxy', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');

        $proxy->set($conn, [
            'id' => 'id',
            'group' => 'group',
        ]);
    }

    /**
     * test insert
     *
     * @return void
     */
    public function testInsert()
    {
        $handler = $this->handler;

        $proxy = m::mock('Xpressengine\DynamicField\DatabaseProxy', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('typeId')->andReturn('id');
        $config->shouldReceive('get')->with('use')->andReturn(true);

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('setConfig');
        $type->shouldReceive('insert');

        $this->configHandler->shouldReceive('gets')->andReturn([$config]);
        $this->registerHandler->shouldReceive('getType')->andReturn($type);

        $proxy->insert([]);
    }

    /**
     * test update
     *
     * @return void
     */
    public function testUpdate()
    {
        $handler = $this->handler;

        $proxy = m::mock('Xpressengine\DynamicField\DatabaseProxy', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('typeId')->andReturn('id');
        $config->shouldReceive('get')->with('use')->andReturn(true);

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('setConfig');
        $type->shouldReceive('update');

        $this->configHandler->shouldReceive('gets')->andReturn([$config]);
        $this->registerHandler->shouldReceive('getType')->andReturn($type);

        $proxy->update([]);
    }

    /**
     * test delete
     *
     * @return void
     */
    public function testDelete()
    {
        $handler = $this->handler;

        $proxy = m::mock('Xpressengine\DynamicField\DatabaseProxy', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('typeId')->andReturn('id');
        $config->shouldReceive('get')->with('use')->andReturn(true);

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('setConfig');
        $type->shouldReceive('delete');

        $this->configHandler->shouldReceive('gets')->andReturn([$config]);
        $this->registerHandler->shouldReceive('getType')->andReturn($type);

        $proxy->delete([]);
    }

    /**
     * test get
     *
     * @return void
     */
    public function testGet()
    {
        $handler = $this->handler;

        $proxy = m::mock('Xpressengine\DynamicField\DatabaseProxy', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('typeId')->andReturn('id');
        $config->shouldReceive('get')->with('use')->andReturn(true);

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('setConfig');
        $type->shouldReceive('get');

        $this->configHandler->shouldReceive('isTableMethodCreate')->andReturn(true);
        $this->configHandler->shouldReceive('gets')->andReturn([$config]);
        $this->registerHandler->shouldReceive('getType')->andReturn($type);

        $query = m::mock('Illuminate\Database\Query\Builder');
        $result = $proxy->get($query);
        $this->assertInstanceOf('Illuminate\Database\Query\Builder', $result);
    }

    /**
     * test first
     *
     * @return void
     */
    public function testFirst()
    {
        $handler = $this->handler;

        $proxy = m::mock('Xpressengine\DynamicField\DatabaseProxy', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('typeId')->andReturn('id');
        $config->shouldReceive('get')->with('use')->andReturn(true);

        $query = m::mock('Illuminate\Database\Query\Builder');

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('setConfig');
        $type->shouldReceive('first')->andReturn($query);

        $this->configHandler->shouldReceive('isTableMethodCreate')->andReturn(true);
        $this->configHandler->shouldReceive('gets')->andReturn([$config]);
        $this->registerHandler->shouldReceive('getType')->andReturn($type);

        $result = $proxy->first($query);
        $this->assertInstanceOf('Illuminate\Database\Query\Builder', $result);
    }

    /**
     * test wheres
     *
     * @return void
     */
    public function testWheres()
    {
        $handler = $this->handler;

        $proxy = m::mock('Xpressengine\DynamicField\DatabaseProxy', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('typeId')->andReturn('id');
        $config->shouldReceive('get')->with('use')->andReturn(true);

        $query = m::mock('Illuminate\Database\Query\Builder');

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('setConfig');
        $type->shouldReceive('wheres')->andReturn($query);

        $this->configHandler->shouldReceive('gets')->andReturn([$config]);
        $this->registerHandler->shouldReceive('getType')->andReturn($type);

        $result = $proxy->wheres($query, []);
        $this->assertInstanceOf('Illuminate\Database\Query\Builder', $result);
    }

    /**
     * test orders
     *
     * @return void
     */
    public function testOrders()
    {
        $handler = $this->handler;

        $proxy = m::mock('Xpressengine\DynamicField\DatabaseProxy', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('typeId')->andReturn('id');
        $config->shouldReceive('get')->with('use')->andReturn(true);

        $query = m::mock('Illuminate\Database\Query\Builder');

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('setConfig');
        $type->shouldReceive('orders')->andReturn($query);

        $this->configHandler->shouldReceive('gets')->andReturn([$config]);
        $this->registerHandler->shouldReceive('getType')->andReturn($type);

        $result = $proxy->orders($query, []);
        $this->assertInstanceOf('Illuminate\Database\Query\Builder', $result);
    }


//
//    /**
//     * test set connection and options
//     *
//     * @expectedException \Xpressengine\DynamicField\Exceptions\InvalidOptionException
//     * @return void
//     */
//    public function testSet()
//    {
//        $connector = m::mock('Xpressengine\Database\VirtualConnectionInterface');
//        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');
//        $handler->shouldReceive('setConnection');
//
//        $proxy = new DatabaseProxy($handler);
//
//        $proxy->set($connector, ['table'=>'table']);
//
//        $proxy->set($connector, ['table'=>'table', 'id' => 'id']);
//
//        $proxy->set($connector, ['table'=>'table', 'group' => 'group']);
//
//        $proxy->set($connector, []);
//    }
//
//    /**
//     * test insert
//     *
//     * @return void
//     */
//    public function testInsert()
//    {
//        $type = m::mock('Xpressengine\DynamicField\TypeInterface');
//        $type->shouldReceive('insert');
//
//        $config = m::mock('Xpressengine\Config\ConfigEntity');
//        $config->shouldReceive('get')->with('use')->andReturn(true);
//        $config->shouldReceive('get')->with('typeId')->andReturn('type');
//
//        $connector = m::mock('Xpressengine\Database\VirtualConnectionInterface');
//
//        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
//        $configHandler->shouldReceive('gets')->andReturn([$config]);
//
//        $registerHandler = m::mock('Xpressengine\DynamicField\RegisterHandler');
//        $registerHandler->shouldReceive('getType')->andReturn($type);
//
//        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');
//        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
//        $handler->shouldReceive('getRegisterHandler')->andReturn($registerHandler);
//        $handler->shouldReceive('setConnection');
//
//        $proxy = new DatabaseProxy($handler);
//
//        $proxy->insert(['data'=>'data']);
//    }
//
//    /**
//     * test update
//     *
//     * @return void
//     */
//    public function testUpdate()
//    {
//        $type = m::mock('Xpressengine\DynamicField\TypeInterface');
//        $type->shouldReceive('update');
//
//        $config = m::mock('Xpressengine\Config\ConfigEntity');
//        $config->shouldReceive('get')->with('use')->andReturn(true);
//        $config->shouldReceive('get')->with('typeId')->andReturn('type');
//
//        $connector = m::mock('Xpressengine\Database\VirtualConnectionInterface');
//
//        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
//        $configHandler->shouldReceive('gets')->andReturn([$config]);
//
//        $registerHandler = m::mock('Xpressengine\DynamicField\RegisterHandler');
//        $registerHandler->shouldReceive('getType')->andReturn($type);
//
//        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');
//        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
//        $handler->shouldReceive('getRegisterHandler')->andReturn($registerHandler);
//        $handler->shouldReceive('setConnection');
//
//        $proxy = new DatabaseProxy($handler);
//
//        $proxy->update(['data'=>'data'], []);
//    }
//
//    /**
//     * test delete
//     *
//     * @return void
//     */
//    public function testDelete()
//    {
//        $type = m::mock('Xpressengine\DynamicField\TypeInterface');
//        $type->shouldReceive('delete');
//
//        $config = m::mock('Xpressengine\Config\ConfigEntity');
//        $config->shouldReceive('get')->with('use')->andReturn(true);
//        $config->shouldReceive('get')->with('typeId')->andReturn('type');
//
//        $connector = m::mock('Xpressengine\Database\VirtualConnectionInterface');
//
//        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
//        $configHandler->shouldReceive('gets')->andReturn([$config]);
//
//        $registerHandler = m::mock('Xpressengine\DynamicField\RegisterHandler');
//        $registerHandler->shouldReceive('getType')->andReturn($type);
//
//        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');
//        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
//        $handler->shouldReceive('getRegisterHandler')->andReturn($registerHandler);
//        $handler->shouldReceive('setConnection');
//
//        $proxy = new DatabaseProxy($handler);
//
//        $proxy->delete(['data'=>'data']);
//    }
//
//
//    /**
//     * test delete
//     *
//     * @return void
//     */
//    public function testGet()
//    {
//        $query = m::mock('Illuminate\Database\Query\Builder');
//
//        $type = m::mock('Xpressengine\DynamicField\TypeInterface');
//        $type->shouldReceive('get')->andReturn($query);
//        $type->shouldReceive('first')->andReturn($query);
//
//        $config = m::mock('Xpressengine\Config\ConfigEntity');
//        $config->shouldReceive('get')->with('use')->andReturn(true);
//        $config->shouldReceive('get')->with('typeId')->andReturn('type');
//
//        $connector = m::mock('Xpressengine\Database\VirtualConnectionInterface');
//
//        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
//        $configHandler->shouldReceive('gets')->andReturn([$config]);
//        $configHandler->shouldReceive('isTableMethodCreate')->andReturn(true);
//
//        $registerHandler = m::mock('Xpressengine\DynamicField\RegisterHandler');
//        $registerHandler->shouldReceive('getType')->andReturn($type);
//
//        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');
//        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
//        $handler->shouldReceive('getRegisterHandler')->andReturn($registerHandler);
//        $handler->shouldReceive('setConnection');
//
//        $proxy = new DatabaseProxy($handler);
//
//        $this->assertInstanceOf('Illuminate\Database\Query\Builder', $proxy->get($query));
//        $this->assertInstanceOf('Illuminate\Database\Query\Builder', $proxy->first($query));
//
//        $configHandler->shouldReceive('isTableMethodCreate')->andReturn(false);
//        $this->assertInstanceOf('Illuminate\Database\Query\Builder', $proxy->get($query));
//        $this->assertInstanceOf('Illuminate\Database\Query\Builder', $proxy->first($query));
//    }
//
//    /**
//     * test wheres and orders
//     *
//     * @return void
//     */
//    public function testWheresOrders()
//    {
//        $query = m::mock('Illuminate\Database\Query\Builder');
//
//        $type = m::mock('Xpressengine\DynamicField\TypeInterface');
//        $type->shouldReceive('wheres')->andReturn($query);
//        $type->shouldReceive('orders')->andReturn($query);
//
//        $config = m::mock('Xpressengine\Config\ConfigEntity');
//        $config->shouldReceive('get')->with('use')->andReturn(true);
//        $config->shouldReceive('get')->with('typeId')->andReturn('type');
//
//        $connector = m::mock('Xpressengine\Database\VirtualConnectionInterface');
//
//        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
//        $configHandler->shouldReceive('gets')->andReturn([$config]);
//
//        $registerHandler = m::mock('Xpressengine\DynamicField\RegisterHandler');
//        $registerHandler->shouldReceive('getType')->andReturn($type);
//
//        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');
//        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
//        $handler->shouldReceive('getRegisterHandler')->andReturn($registerHandler);
//        $handler->shouldReceive('setConnection');
//
//        $proxy = new DatabaseProxy($handler);
//
//        $this->assertInstanceOf('Illuminate\Database\Query\Builder', $proxy->wheres($query, ['data'=>'data']));
//        $this->assertInstanceOf('Illuminate\Database\Query\Builder', $proxy->orders($query, ['data'=>'data']));
//    }
}
