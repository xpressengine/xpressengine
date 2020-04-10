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
use Xpressengine\DynamicField\ConfigHandler;

/**
 * Class ConfigHandlerTest
 * @package Xpressengine\Tests\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ConfigHandlerTest extends TestCase
{
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
     * test config handler
     *
     * @return void
     */
    public function testHandler()
    {
        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $configManager = m::mock('Xpressengine\Config\ConfigManager');
        $configManager->shouldReceive('get')->once()->andReturn(null);

        $handler = new ConfigHandler($conn, $configManager);

        $handler->getDefault();

        $configManager->shouldReceive('get')->once()->andReturn(
            m::mock('Xpressengine\Config\ConfigEntity')
        );
        $handler->getDefault();
    }

    /**
     * test config add
     *
     * @return void
     */
    public function testAdd()
    {
        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $configManager = m::mock('Xpressengine\Config\ConfigManager');
        $configManager->shouldReceive('add');

        $handler = new ConfigHandler($conn, $configManager);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('group')->andReturn('group');
        $config->shouldReceive('get')->with('id')->andReturn('id');
        $config->shouldReceive('getPureAll')->andReturn([]);

        $handler->add($config);
    }

    /**
     * test config put
     *
     * @return void
     */
    public function testPut()
    {
        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $configManager = m::mock('Xpressengine\Config\ConfigManager');
        $configManager->shouldReceive('put');

        $handler = new ConfigHandler($conn, $configManager);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('group')->andReturn('group');
        $config->shouldReceive('get')->with('id')->andReturn('id');
        $config->shouldReceive('getPureAll')->andReturn([]);

        $handler->put($config);
    }

    /**
     * test config put
     *
     * @return void
     */
    public function testRemove()
    {
        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $configManager = m::mock('Xpressengine\Config\ConfigManager');
        $configManager->shouldReceive('remove');

        $handler = new ConfigHandler($conn, $configManager);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('group')->andReturn('group');
        $config->shouldReceive('get')->with('id')->andReturn('id');

        $handler->remove($config);
    }

    /**
     * test get config
     *
     * @return void
     */
    public function testGet()
    {
        $parent = m::mock('Xpressengine\Config\ConfigEntity');
        $config1 = m::mock('Xpressengine\Config\ConfigEntity');

        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $configManager = m::mock('Xpressengine\Config\ConfigManager');
        $configManager->shouldReceive('get')->with(
            sprintf('%s.%s.%s', ConfigHandler::CONFIG_NAME, 'group', 'id')
        )->andReturn($config1);
        $configManager->shouldReceive('get')->with(
            sprintf('%s.%s', ConfigHandler::CONFIG_NAME, 'group')
        )->andReturn($parent);
        $configManager->shouldReceive('get')->with(
            sprintf('%s.%s', ConfigHandler::CONFIG_NAME, 'group_null')
        )->andReturn(null);
        $configManager->shouldReceive('children')->andReturn([$config1]);

        $handler = new ConfigHandler($conn, $configManager);

        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $handler->get('group', 'id'));

        $this->assertEquals(1, count($handler->gets('group')));
        $this->assertEquals(0, count($handler->gets('group_null')));
    }

    /**
     * test set parent config
     *
     * @return void
     */
    public function testSetParent()
    {
        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $configManager = m::mock('Xpressengine\Config\ConfigManager');
        $configManager->shouldReceive('add');

        $handler = new ConfigHandler($conn, $configManager);

        $handler->setParent('group');
    }

    /**
     * test get values
     *
     * @return void
     */
    public function testGetValues()
    {
        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $conn->shouldReceive('getTablePrefix')->andReturn('prefix');

        $configManager = m::mock('Xpressengine\Config\ConfigManager');
        $configManager->shouldReceive('add');

        $handler = new ConfigHandler($conn, $configManager);

        $handler->setTablePrefix('prefix');

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('group')->andReturn('group');
        $config->shouldReceive('get')->with('id')->andReturn('id');
        $config->shouldReceive('get')->with('tableMethod')->andReturn(ConfigHandler::CREATE_TABLE_METHOD);

        $this->assertEquals('prefix_group_id', $handler->getTableName($config));
        $this->assertEquals('prefix_revision_group_id', $handler->getRevisionTableName($config));
        $this->assertTrue($handler->isTableMethodCreate($config));

    }
}
