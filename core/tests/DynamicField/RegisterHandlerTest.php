<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\DynamicField;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\DynamicField\RegisterHandler;

/**
 * Class RegisterHandlerTest
 * @package Xpressengine\Tests\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class RegisterHandlerTest extends TestCase
{
    /**
     * @var m\MockInterface|\Xpressengine\Plugin\PluginRegister
     */
    protected $pluginRegister;

    /**
     * @var m\MockInterface|\Illuminate\Events\Dispatcher
     */
    protected $dispatcher;

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
        $pluginRegister = m::mock('Xpressengine\Plugin\PluginRegister');
        $this->pluginRegister = $pluginRegister;

        $dispatcher = m::mock('Illuminate\Events\Dispatcher');
        $this->dispatcher = $dispatcher;
    }

    /**
     * test add
     *
     * @return void
     */
    public function testAdd()
    {
        $pluginRegister = $this->pluginRegister;
        $dispatcher = $this->dispatcher;

        $handler = new RegisterHandler($pluginRegister, $dispatcher);

        $class = m::mock('Type', 'Xpressengine\DynamicField\AbstractType');
        $class->shouldReceive('boot');

        $pluginRegister->shouldReceive('add');

        $handler->add($class);
    }

    /**
     * test get type
     *
     * @return void
     */
    public function testGetType()
    {
        $pluginRegister = $this->pluginRegister;
        $dispatcher = $this->dispatcher;

        $handler = m::mock('Xpressengine\DynamicField\RegisterHandler', [$pluginRegister, $dispatcher])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $id = 'id';
        $dfHandler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');

        $class = m::mock('Xpressengine\DynamicField\AbstractType');
        $class->shouldReceive('__construct');
        $class->shouldReceive('setColumns');
        $class->shouldReceive('setRules');
        $class->shouldReceive('setSettingsRules');

        $handler->shouldReceive('get')->andReturn($class);

        $result = $handler->getType($dfHandler, $id);
        $this->assertInstanceOf('Xpressengine\DynamicField\AbstractType', $result);
    }

    /**
     * test get skin
     *
     * @return void
     */
    public function testGetSkin()
    {
        $pluginRegister = $this->pluginRegister;
        $dispatcher = $this->dispatcher;

        $handler = m::mock('Xpressengine\DynamicField\RegisterHandler', [$pluginRegister, $dispatcher])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $id = 'id';
        $dfHandler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');

        $class = m::mock('Xpressengine\DynamicField\AbstractSkin');
        $class->shouldReceive('__construct');
        $class->shouldReceive('setSettingsRules');

        $handler->shouldReceive('get')->andReturn($class);

        $result = $handler->getSkin($dfHandler, $id);

        $this->assertInstanceOf('Xpressengine\DynamicField\AbstractSkin', $result);
    }

    /**
     * test get types
     *
     * @return void
     */
    public function testGetTypes()
    {
        $pluginRegister = $this->pluginRegister;
        $dispatcher = $this->dispatcher;

        $handler = new RegisterHandler($pluginRegister, $dispatcher);

        $dfHandler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');

        $type = m::mock('TypeClass');
        $type->shouldReceive('__construct');

        $types = [
            $type
        ];
        $pluginRegister->shouldReceive('get')->andReturn($types);

        $result = $handler->getTypes($dfHandler);
        $this->assertInstanceOf('Generator', $result);
    }

    /**
     * test get skins
     *
     * @return void
     */
    public function testGetSkins()
    {
        $pluginRegister = $this->pluginRegister;
        $dispatcher = $this->dispatcher;

        $handler = new RegisterHandler($pluginRegister, $dispatcher);

        $dfHandler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');

        $skin = m::mock('SkinClass');
        $skin->shouldReceive('__construct');

        $types = [
            'type' => 'notuse',
        ];

        $skins = [
            $skin
        ];
        $pluginRegister->shouldReceive('get')->with(RegisterHandler::FIELD_TYPE)->andReturn($types);
        $pluginRegister->shouldReceive('get')->with(
            'type|' . RegisterHandler::FIELD_TYPE
        )->andReturn($skins);

        $result = $handler->getSkins($dfHandler);
        $this->assertInstanceOf('Generator', $result);
    }

    /**
     * test get skins by type
     *
     * @return void
     */
    public function testGetSkinsByType()
    {
        $pluginRegister = $this->pluginRegister;
        $dispatcher = $this->dispatcher;

        $handler = new RegisterHandler($pluginRegister, $dispatcher);

        $dfHandler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');

        $id = 'id';

        $skin = m::mock('SkinClass');
        $skin->shouldReceive('__construct');

        $skins = [
            $skin
        ];
        $pluginRegister->shouldReceive('get')->andReturn($skins);

        $result = $handler->getSkinsByType($dfHandler, $id);
        $this->assertInstanceOf('Generator', $result);
    }
}
