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
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\DynamicField\AbstractType;
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
     * @var m\MockInterface|\Illuminate\View\Factory
     */
    protected $view;

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
        $view = m::mock('Illuminate\View\Factory');

        $this->conn = $conn;
        $this->configHandler = $configHandler;
        $this->registerHandler = $registerHandler;
        $this->view = $view;
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
        $view = $this->view;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler, $view);

        $this->assertInstanceOf('Xpressengine\DynamicField\ConfigHandler', $handler->getConfigHandler());
        $this->assertInstanceOf('Xpressengine\DynamicField\RegisterHandler', $handler->getRegisterHandler());
        $this->assertInstanceOf('Xpressengine\Database\VirtualConnectionInterface', $handler->connection());
        $this->assertInstanceOf('Illuminate\View\Factory', $handler->getViewFactory());
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
        $view = $this->view;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler, $view);

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
        $view = $this->view;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler, $view);

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
        $view = $this->view;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler, $view);
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
        $view = $this->view;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler, $view);
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
        $view = $this->view;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler, $view);

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
        $view = $this->view;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler, $view);

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
        $view = $this->view;

        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler', [
            $conn, $configHandler, $registerHandler, $view
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
        $view = $this->view;

        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler', [
            $conn, $configHandler, $registerHandler, $view
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
        $view = $this->view;

        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler', [
            $conn, $configHandler, $registerHandler, $view
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
        $view = $this->view;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler, $view);

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
        $view = $this->view;

        $handler = new DynamicFieldHandler($conn, $configHandler, $registerHandler, $view);

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
        $view = $this->view;

        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler', [
            $conn, $configHandler, $registerHandler, $view
        ])->shouldAllowMockingProtectedMethods()->makePartial();

        $id = 'id';
        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('required')->andReturn(false);
        $config->shouldReceive('get')->with('typeId')->andReturn(TestType2::getId());
        $config->shouldReceive('get')->with('skinId')->andReturn(TestSkin2::getId());
        $config->shouldReceive('get')->with('id')->andReturn($id);

        $type2 = new TestType2($handler);
        $skin2 = new TestSkin2($handler);
        $registerHandler->shouldReceive('getType')->andReturn($type2);
        $registerHandler->shouldReceive('getSkin')->andReturn($skin2);

        $result =$handler->getRules($config);
        $this->assertEquals('required', $result[$id . 'F1']);
    }
}

class TestType2 extends AbstractType
{
    static protected $id = 'typeId';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'name';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return 'description';
    }

    /**
     * return columns
     *
     * @return \Xpressengine\DynamicField\ColumnEntity[]
     */
    public function getColumns()
    {
        $column = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $column->shouldReceive('add');
        $column->shouldReceive('get')->with('name')->andReturn('id');
        $column->shouldReceive('drop');

        return [$column];
    }

    /**
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        return [
            'f1' => 'required',
        ];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return ['settings_rules'];
    }

    /**
     * Dynamic Field 설정 페이지에서 각 fieldType 에 필요한 설정 등록 페이지 반환
     * return html tag string
     *
     * @param ConfigEntity $config config entity
     * @return string
     */
    public function getSettingsView(ConfigEntity $config = null)
    {
        return '';
    }
}

class TestSkin2 extends AbstractSkin
{
    static protected $id = 'skinId';

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'skin_name';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'skin_path';
    }

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return ['skin_setting_rules'];
    }
}

