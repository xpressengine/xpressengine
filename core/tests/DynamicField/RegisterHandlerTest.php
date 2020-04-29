<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\DynamicField;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\RegisterHandler;
use Xpressengine\Plugin\PluginRegister;

/**
 * Class RegisterHandlerTest
 * @package Xpressengine\Tests\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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

        $handler = m::mock('Xpressengine\DynamicField\RegisterHandler', [$pluginRegister, $dispatcher])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $dfHandler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');

        $type = m::mock(AbstractType::class);
        $type->shouldReceive('__construct');

        $types = [
            $type
        ];

        $pluginRegister->shouldReceive('get')->andReturn($types);

        $type->shouldReceive('getId')->andReturn('id');
        $handler->shouldReceive('getType')->with($dfHandler, 'id')->andReturn($type);

        $result = $handler->getTypes($dfHandler);

        $this->assertInstanceOf(AbstractType::class, $result[0]);
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

        $handler = m::mock('Xpressengine\DynamicField\RegisterHandler', [$pluginRegister, $dispatcher])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $dfHandler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');

        $skin = m::mock(AbstractSkin::class);
        $skin->shouldReceive('__construct');

        $types = [
            'type' => 'notuse',
        ];

        $skins = [
            $skin
        ];

        $pluginRegister->shouldReceive('get')->with(RegisterHandler::FIELD_TYPE)->andReturn($types);

        $pluginRegister->shouldReceive('get')->with(
            'type'  . PluginRegister::KEY_DELIMITER. RegisterHandler::FIELD_SKIN
        )->andReturn($skins);

        $skin->shouldReceive('getId')->andReturn('id');
        $handler->shouldReceive('getType')->with($dfHandler, 'id')->andReturn($skin);

        $result = $handler->getSkins($dfHandler);
        $this->assertInstanceOf(AbstractSkin::class, $result[0]);
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

        $handler = m::mock('Xpressengine\DynamicField\RegisterHandler', [$pluginRegister, $dispatcher])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $dfHandler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');

        $id = 'id';
        $skinId = 'skin_id';

        $skin = m::mock(AbstractSkin::class);
        $skin->shouldReceive('__construct');
        $skin->shouldReceive('getId')->andReturn($skinId);

        $skins = [
            $skin
        ];

        $pluginRegister->shouldReceive('get')->with($id . PluginRegister::KEY_DELIMITER . RegisterHandler::FIELD_SKIN)
            ->andReturn($skins);

        $handler->shouldReceive('getSkin')->with($dfHandler, $skinId)->andReturn($skin);

        $result = $handler->getSkinsByType($dfHandler, $id);

        $this->assertInstanceOf(AbstractSkin::class, $result[0]);
    }
}
