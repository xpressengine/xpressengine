<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\DynamicField;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\DynamicField\DynamicFieldHandler;

/**
 * Class DatabaseProxyTest
 * @package Xpressengine\Tests\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DynamicFieldHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var m\MockInterface|\Xpressengine\Database\VirtualConnectionInterface
     */
    protected $conn;

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
        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $registerHandler = m::mock('Xpressengine\DynamicField\RegisterHandler');

        $this->conn = $conn;
        $this->configHandler = $configHandler;
        $this->registerHandler = $registerHandler;
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
     * test get property
     *
     * @return void
     */
    public function testGetProperty()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler);

        $this->assertInstanceOf('Xpressengine\DynamicField\ConfigHandler', $handler->getConfigHandler());
        $this->assertInstanceOf('Xpressengine\DynamicField\RegisterHandler', $handler->getRegisterHandler());
        $this->assertInstanceOf('Xpressengine\Database\VirtualConnectionInterface', $handler->connection());
    }

    /**
     * test set connection
     *
     * @return void
     */
    public function testSetConnection()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler);

        $newConn = m::mock('NewConnector', 'Xpressengine\Database\VirtualConnectionInterface');
        $handler->setConnection($newConn);

        $this->assertInstanceOf('NewConnector', $handler->connection());
    }

    /**
     * test create
     *
     * @return void
     */
    public function testCreate()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler);

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('id')->andReturn('fieldId');
        $config->shouldReceive('get')->with('typeId')->andReturn('type');
        $config->shouldReceive('get')->with('group')->andReturn('group-name');
        $config->shouldReceive('set');

        $conn->shouldReceive('beginTransaction');
        $conn->shouldReceive('commit');

        $configHandler->shouldReceive('add');
        $configHandler->shouldReceive('get')->andReturn(null);
        $configHandler->shouldReceive('parent')->andReturn(null);
        $configHandler->shouldReceive('setParent');

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('setConfig');
        $type->shouldReceive('create');
        $registerHandler->shouldReceive('getType')->andReturn($type);

        $handler->create($config);
    }

    /**
     * test create invalid config
     *
     * @expectedException \Xpressengine\DynamicField\Exceptions\InvalidConfigException
     * @return void
     */
    public function testCreateInvalidConfig()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler);
        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('id')->andReturn(null);
        $config->shouldReceive('get')->with('typeId')->andReturn('type');
        $config->shouldReceive('get')->with('group')->andReturn('group-name');

        $handler->create($config);
    }

    /**
     * test create invalid config
     *
     * @expectedException \Xpressengine\DynamicField\Exceptions\AlreadyExistException
     * @return void
     */
    public function testCreateAlreadyExist()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler);
        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('id')->andReturn('id');
        $config->shouldReceive('get')->with('typeId')->andReturn('type');
        $config->shouldReceive('get')->with('group')->andReturn('group-name');

        $configHandler->shouldReceive('get')->andReturn(1);

        $handler->create($config);
    }

    /**
     * test put
     *
     * @return void
     */
    public function testPut()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler);

        $config = $this->getConfigEntity();
        $configHandler->shouldReceive('put');

        $handler->put($config);
    }

    /**
     * test drop
     *
     * @return void
     */
    public function testDrop()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler);

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('typeId')->andReturn('type');

        $configHandler->shouldReceive('remove');

        $conn->shouldReceive('beginTransaction');
        $conn->shouldReceive('commit');

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('setConfig');
        $type->shouldReceive('drop');
        $registerHandler->shouldReceive('getType')->andReturn($type);

        $handler->drop($config);
    }

    /**
     * test gets
     *
     * @return void
     */
    public function testGets()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler', [
            $conn, $configHandler, $registerHandler
        ])->shouldAllowMockingProtectedMethods()->makePartial();

        $group = 'group';

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $handler->shouldReceive('getByConfig')->andReturn($type);

        $config1 = $this->getConfigEntity();
        $config1->shouldReceive('get')->with('id')->andReturn('id');

        $configs = [
            $config1
        ];
        $configHandler->shouldReceive('gets')->andReturn($configs);

        $result = $handler->gets($group);

        $this->assertInstanceOf('Generator', $result);
        foreach ($result as $instance) {
            $this->assertInstanceOf('Xpressengine\DynamicField\AbstractType', $instance);
        }
    }

    /**
     * test get
     *
     * @return void
     */
    public function testGet()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler', [
            $conn, $configHandler, $registerHandler
        ])->shouldAllowMockingProtectedMethods()->makePartial();

        $group = 'group';
        $id = 'id';

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $handler->shouldReceive('getByConfig')->andReturn($type);

        $configHandler->shouldReceive('get')->once()->andReturn(null);
        $result = $handler->get($group, $id);
        $this->assertNull($result);

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('id')->andReturn('id');

        $configHandler->shouldReceive('get')->once()->andReturn($config);
        $result = $handler->get($group, $id);
        $this->assertInstanceOf('Xpressengine\DynamicField\AbstractType', $result);
    }

    /**
     * test has
     *
     * @return void
     */
    public function testHas()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler', [
            $conn, $configHandler, $registerHandler
        ])->shouldAllowMockingProtectedMethods()->makePartial();

        $group = 'group';
        $id = 'id';

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $handler->shouldReceive('getByConfig')->andReturn($type);

        $configHandler->shouldReceive('get')->once()->andReturn(null);
        $result = $handler->has($group, $id);
        $this->assertFalse($result);

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('id')->andReturn('id');

        $configHandler->shouldReceive('get')->once()->andReturn($config);
        $result = $handler->has($group, $id);
        $this->assertTrue($result);
    }

    /**
     * test get by config
     *
     * @return void
     */
    public function testGetByConfig()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler);

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('typeId')->andReturn('type');
        $config->shouldReceive('get')->with('skinId')->andReturn('skin');

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('setConfig');
        $type->shouldReceive('setSkin');

        $skin = m::mock('Skin', 'Xpressengine\DynamicField\AbstractSkin');
        $skin->shouldReceive('setConfig');

        $registerHandler->shouldReceive('getType')->andReturn($type);
        $registerHandler->shouldReceive('getSkin')->andReturn($skin);

        $result = $handler->getByConfig($config);

        $this->assertInstanceOf('Xpressengine\DynamicField\AbstractType', $result);
    }

    /**
     * test get type
     *
     * @return void
     */
    public function testGetType()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler);

        $group = 'group';
        $id = 'id';

        $configHandler->shouldReceive('get')->once()->andReturn(null);
        $result = $handler->getType($group, $id);
        $this->assertNull($result);

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('typeId')->andReturn('type');

        $configHandler->shouldReceive('get')->once()->andReturn($config);

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('setConfig');

        $registerHandler->shouldReceive('getType')->andReturn($type);

        $result = $handler->getType($group, $id);
        $this->assertInstanceOf('Xpressengine\DynamicField\AbstractType', $result);
    }

    /**
     * test get rules
     *
     * @return void
     */
    public function testGetRules()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $registerHandler = $this->registerHandler;

        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler', [
            $conn, $configHandler, $registerHandler
        ])->shouldAllowMockingProtectedMethods()->makePartial();

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->once()->with('required')->andReturn(false);

        $result =$handler->getRules($config);
        $this->assertEquals([], $result);

        $config->shouldReceive('get')->with('id')->andReturn('id');

        $type = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('getRules')->andReturn([
            'column' => 'rule',
        ]);

        $handler->shouldReceive('getByConfig')->andReturn($type);

        $config->shouldReceive('get')->once()->with('required')->andReturn(true);
        $result = $handler->getRules($config);

        $this->assertEquals('rule', $result['idColumn']);
    }
}
