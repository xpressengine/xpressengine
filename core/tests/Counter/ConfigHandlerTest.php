<?php
/**
 *
 */
namespace Xpressengine\Tests\Counter;

use Mockery as M;
use PHPUnit_Framework_TestCase;
use Xpressengine\Counter\ConfigHandler;
use Xpressengine\Counter\ConfigEntity;

/**
 * Class ConfigHandlerTest
 * @package Xpressengine\Tests\Counter
 */
class ConfigHandlerTest extends PHPUnit_Framework_TestCase
{
    protected $configManager;

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
        $configManager = m::mock('Xpressengine\Config\ConfigManager');

        $this->configManager = $configManager;
    }

    /**
     * get config entity
     *
     * @return ConfigEntity
     */
    private function getConfigEntity()
    {
        return m::mock('Xpressengine\Config\ConfigEntity');
    }

    /**
     * test get config
     *
     * @return void
     */
    public function testGet()
    {
        $configManager = $this->configManager;

        $configHandler = new ConfigHandler($configManager);

        $configManager->shouldReceive('get')->once()->andReturn($this->getConfigEntity());
        $config = $configHandler->get();

        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);
    }


    /**
     * test get type from counter name's configure
     *
     * @return void
     */
    public function testType()
    {
        $configManager = $this->configManager;

        $configHandler = m::mock('Xpressengine\Counter\ConfigHandler', [$configManager])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $configEntity = $this->getConfigEntity();
        $configEntity->shouldReceive('get')->once()->andReturn(null);

        $configHandler->shouldReceive('get')->andReturn($configEntity);
        $type = $configHandler->getType('id-counter');
        $this->assertEquals(\Xpressengine\Counter\Counter::TYPE_ID, $type);

        // set config entity
        $configEntity->shouldReceive('get')->with('id-counter')->andReturn(\Xpressengine\Counter\Counter::TYPE_ID);
        $configEntity->shouldReceive('get')->with('session-counter')
            ->andReturn(\Xpressengine\Counter\Counter::TYPE_SESSION);

        $configHandler->shouldReceive('get')->andReturn($configEntity);
        $type = $configHandler->getType('id-counter');
        $this->assertEquals(\Xpressengine\Counter\Counter::TYPE_ID, $type);

        $type = $configHandler->getType('session-counter');
        $this->assertEquals(\Xpressengine\Counter\Counter::TYPE_SESSION, $type);
    }

    /**
     * test set config
     *
     * @return void
     */
    public function testSet()
    {
        $configManager = $this->configManager;

        $configHandler = new ConfigHandler($configManager);

        $configEntity = $this->getConfigEntity();
        $configManager->shouldReceive('get')->andReturn($configEntity);

        $configEntity->shouldReceive('set');
        $configEntity->shouldReceive('getPureAll')->andReturn([]);

        $configManager->shouldReceive('put');

        $configHandler->set('id-counter');
    }
}
