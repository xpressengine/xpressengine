<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Document;

use Mockery as M;
use PHPUnit\Framework\TestCase;
use Xpressengine\Document\ConfigHandler;

/**
 * Class ProxyManagerTest
 * @package Xpressengine\Tests\Document
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
     * test get config
     *
     * @return void
     */
    public function testGetConfig()
    {
        $parentConfig = m::mock('Xpressengine\Config\ConfigEntity');

        $instanceConfig1 = m::mock('Xpressengine\Config\ConfigEntity');
        $instanceConfig1->shouldReceive('get')->with('instanceId')->andReturn('1');

        $instanceConfig2 = m::mock('Xpressengine\Config\ConfigEntity');

        $configManager = m::mock('Xpressengine\Config\ConfigManager');
        $configManager->shouldReceive('get')->with(ConfigHandler::CONFIG_NAME)->andReturn($parentConfig);
        $configManager->shouldReceive('get')
            ->with(sprintf('%s.instance1', ConfigHandler::CONFIG_NAME))->andReturn($instanceConfig1);
        $configManager->shouldReceive('children')->with($parentConfig)->andReturn([
            $instanceConfig1, $instanceConfig2
        ]);

        /** @var \Xpressengine\Config\ConfigManager $configManager */
        $configHandler = new ConfigHandler($configManager);

        $this->assertInstanceOf('Xpressengine\Config\ConfigManager', $configHandler->getConfigManager());

        $config = $configHandler->getDefault();
        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);

        $configs = $configHandler->gets();
        $this->assertEquals(2, count($configs));

        $config = $configHandler->get();
        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);

        $config = $configHandler->get('instance1');
        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);
        $this->assertEquals('1', $config->get('instanceId'));
    }

    /**
     * test add config
     *
     * @return void
     */
    public function testAddConfig()
    {
        $instanceConfig1Params = [
            'instanceId' => 'instance1',
            'instanceName' => 'instance1Name',
            'param1' => 'param1',
        ];
        $instanceConfig1 = m::mock('Xpressengine\Config\ConfigEntity');
        $instanceConfig1->shouldReceive('get')->with('instanceId')->andReturn('instance1');
        $instanceConfig1->shouldReceive('getPureAll')->andReturn($instanceConfig1Params);
        $instanceConfig1->shouldReceive('diff')->andReturn([]);

        $configManager = m::mock('Xpressengine\Config\ConfigManager');
        $configManager->shouldReceive('add')->with(
            sprintf('%s.instance1', ConfigHandler::CONFIG_NAME),
            $instanceConfig1Params
        )->andReturn($instanceConfig1);
        $configManager->shouldReceive('put')->with(
            sprintf('%s.instance1', ConfigHandler::CONFIG_NAME),
            $instanceConfig1Params
        )->andReturn($instanceConfig1);
        $configManager->shouldReceive('remove');
        $configManager->shouldReceive('get')
            ->with(sprintf('%s.instance1', ConfigHandler::CONFIG_NAME))->andReturn($instanceConfig1);

        /** @var \Xpressengine\Config\ConfigManager $configManager */
        $configHandler = new ConfigHandler($configManager);

        $params = ['param1'=>'param1'];
        $config = $configHandler->make('instance1', $params);
        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);


        /** @var \Xpressengine\Config\ConfigEntity $instanceConfig1 */
        $configHandler->add($instanceConfig1);

        $configHandler->put($instanceConfig1);

        $configHandler->remove($instanceConfig1);
    }

    /**
     * test put exception
     *
     * @expectedException \Xpressengine\Document\Exceptions\ConfigNotFoundException
     * @return void
     */
    public function testPutEmptyConfigException()
    {
        $instanceConfig1 = m::mock('Xpressengine\Config\ConfigEntity');
        $instanceConfig1->shouldReceive('get')->with('instanceId')->andReturn('instance1');

        $configManager = m::mock('Xpressengine\Config\ConfigManager');
        $configManager->shouldReceive('get')->andReturn(null);

        /** @var \Xpressengine\Config\ConfigManager $configManager */
        $configHandler = new ConfigHandler($configManager);

        /** @var \Xpressengine\Config\ConfigEntity $instanceConfig1 */
        $configHandler->put($instanceConfig1);
    }

    /**
     * test put exception
     *
     * @expectedException \Xpressengine\Document\Exceptions\ConfigNotFoundException
     * @return void
     */
    public function testPutChangedInstanceIdException()
    {
        $instanceConfig1 = m::mock('Xpressengine\Config\ConfigEntity');
        $instanceConfig1->shouldReceive('get')->with('instanceId')->andReturn('instance1');
        $instanceConfig1->shouldReceive('diff')->andReturn(['instance1' => 'changed']);

        $configManager = m::mock('Xpressengine\Config\ConfigManager');
        $configManager->shouldReceive('get')->andReturn(null);

        /** @var \Xpressengine\Config\ConfigManager $configManager */
        $configHandler = new ConfigHandler($configManager);

        /** @var \Xpressengine\Config\ConfigEntity $instanceConfig1 */
        $configHandler->put($instanceConfig1);
    }
}
