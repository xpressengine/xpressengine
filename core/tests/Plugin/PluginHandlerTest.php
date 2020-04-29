<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Plugin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Mockery;
use Xpressengine\Plugin\PluginCollection;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginRegister;

class PluginHandlerTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $handler = $this->getHandler();
        $this->assertInstanceOf('\Xpressengine\Plugin\PluginHandler', $handler);
    }

    public function testIsActivated()
    {
        $pluginId = 'plugin_sample';

        $repo = $this->makeRepository();
        $repo->shouldReceive('load')->once()->andReturn([]);

        $handler = $this->getHandler($repo);
        $this->assertFalse($handler->isActivated($pluginId));

        $entity = $this->makeEntity();
        $entity->shouldReceive('isActivated')->once()->withNoArgs()->andReturn(true);

        $repo = $this->makeRepository();
        $repo->shouldReceive('load')->once()->andReturn(['plugin_sample' => $entity]);

        $handler = $this->getHandler($repo);
        $this->assertTrue($handler->isActivated($pluginId));
    }

    /**
     * @expectedException \Xpressengine\Plugin\Exceptions\PluginNotFoundException
     *
     * @return void
     */
    public function testActivatePluginFailIfNoEntityFound()
    {
        $pluginId = 'plugin_sample';

        $repo = $this->makeRepository();
        $repo->shouldReceive('load')->once()->andReturn([]);

        $handler = $this->getHandler($repo);

        $handler->activatePlugin($pluginId);
    }

    /**
     * @expectedException \Xpressengine\Plugin\Exceptions\PluginAlreadyActivatedException
     *
     * @return void
     */
    public function testActivatePluginFailIfEntityWasActivated()
    {
        $pluginId = 'plugin_sample';

        $entity = $this->makeEntity();
        $entity->shouldReceive('getStatus')->once()->withNoArgs()->andReturn(PluginHandler::STATUS_ACTIVATED);

        $repo = $this->makeRepository();
        $repo->shouldReceive('load')->once()->andReturn(['plugin_sample' => $entity]);

        $handler = $this->getHandler($repo);

        $handler->activatePlugin($pluginId);
    }

    /**
     *
     * @return void
     */
    public function testActivatePluginSuccess()
    {
        $pluginId = 'plugin_sample';

        $plugin = Mockery::mock('\Xpressengine\Plugin\AbstractPlugin');
        $plugin->shouldReceive('register')->withNoArgs()->andReturnNull();


        $entity = $this->makeEntity();
        $entity->shouldReceive('getStatus')->once()->withNoArgs()->andReturn(PluginHandler::STATUS_DEACTIVATED);
        $entity->shouldReceive('setStatus')->once()->withArgs(['activated'])->andReturnNull();
        $entity->shouldReceive('setInstalledVersion')->once()->with('1.0')->andReturnNull();
        $entity->shouldReceive('getObject')->withNoArgs()->andReturn($plugin);
        $entity->shouldReceive('getVersion')->withNoArgs()->andReturn('1.0');
        $entity->shouldReceive('getInstalledVersion')->withNoArgs()->andReturn('0.9');
        $entity->shouldReceive('checkInstalled')->withNoArgs()->andReturn(true);
        $entity->shouldReceive('checkUpdated')->with('0.9')->andReturn(true);
        $entity->shouldReceive('activate')->with('0.9')->andReturn(true);
        $entity->shouldReceive('getId')->withNoArgs()->andReturn($pluginId);


        $repo = $this->makeRepository();
        $repo->shouldReceive('load')->once()->andReturn([$pluginId => $entity]);

        $app = Mockery::mock('\Xpressengine\Foundation\Application');
        $app->shouldReceive('offsetGet')->with('path.plugins')->andReturn(__DIR__.'/plugins');
        $app->shouldReceive('instance')->andReturnNull();
        $handler = $this->getHandler($repo, null, null, null, $app);
        $config = $this->setConfig($handler);
        $config->shouldReceive('getVal')->with('plugin.list', [])->once()->andReturn([
           $pluginId => []
        ]);
        $config->shouldReceive('setVal')->withAnyArgs()->once()->andReturnNull();

        $handler->activatePlugin($pluginId);
    }

    /**
     * @expectedException \Xpressengine\Plugin\Exceptions\PluginAlreadyDeactivatedException
     *
     * @return void
     */
    public function testDeactivatePluginFailIfEntityWasNotActivated()
    {
        $pluginId = 'plugin_sample';

        $entity = $this->makeEntity();
        $entity->shouldReceive('getStatus')->once()->withNoArgs()->andReturn(PluginHandler::STATUS_DEACTIVATED);

        $repo = $this->makeRepository();
        $repo->shouldReceive('load')->once()->andReturn(['plugin_sample' => $entity]);

        $handler = $this->getHandler($repo);

        $handler->deactivatePlugin($pluginId);
    }

    /**
     *
     * @return void
     */
    public function testDeactivatePluginSuccess()
    {
        $pluginId = 'plugin_sample';

        $plugin = Mockery::mock('\Xpressengine\Plugin\AbstractPlugin');
        $plugin->shouldReceive('deactivate')->once()->andReturnNull();

        $entity = $this->makeEntity();
        $entity->shouldReceive('getStatus')->withNoArgs()->andReturn(PluginHandler::STATUS_ACTIVATED);
        $entity->shouldReceive('setStatus')->once()->withArgs(['deactivated'])->andReturn();
        $entity->shouldReceive('getMetaData')->once()->with('require')->andReturn([]);
        $entity->shouldReceive('getObject')->once()->withNoArgs()->andReturn($plugin);
        $entity->shouldReceive('getInstalledVersion')->withNoArgs()->andReturn('0.9');


        $repo = $this->makeRepository();
        $repo->shouldReceive('load')->once()->andReturn([$pluginId => $entity]);

        $handler = $this->getHandler($repo);
        $config = $this->setConfig($handler);
        $config->shouldReceive('getVal')->with('plugin.list', [])->once()->andReturn(
            [
                $pluginId => []
            ]
        );
        $config->shouldReceive('setVal')->withAnyArgs()->once()->andReturnNull();

        $handler->deactivatePlugin($pluginId);
    }

    /**
     * makeCollection
     *
     * @return PluginCollection
     */
    private function makeRepository()
    {
        return Mockery::mock('\Xpressengine\Plugin\PluginRepository');
    }

    /**
     * @return Factory
     */
    private function makeViewFactory()
    {
        return Mockery::mock('\Illuminate\View\Factory', [
            'addNamespace' => null
        ]);

    }

    /**
     * makeRegister
     *
     * @return PluginRegister
     */
    private function makeRegister()
    {
        return Mockery::mock('\Xpressengine\Plugin\PluginRegister', [
            'addByEntity' => null
        ]);
    }

    /**
     * @return Application
     */
    private function makeApp()
    {
        return Mockery::mock('\Xpressengine\Foundation\Application', [
            'singleton' => null,
            'instance' => null,
        ]);
    }

    private function makeEntity()
    {
        return Mockery::mock('\Xpressengine\Plugin\PluginEntity');
    }

    private function makeProvider()
    {
        return Mockery::mock(\Xpressengine\Plugin\PluginProvider::class);
    }

    private function setConfig($handler)
    {
        $config = Mockery::mock('\Xpressengine\Config\ConfigManager');
        $handler->setConfig($config);
        return $config;
    }

    private function getHandler($repo = null, $provider = null, $factory = null, $register = null, $app = null)
    {
        if($repo === null) $repo = $this->makeRepository();
        if($provider === null) $provider = $this->makeProvider();
        if($factory === null) $factory = $this->makeViewFactory();
        if($register === null) $register = $this->makeRegister();
        if($app === null) $app = $this->makeApp();
        return new PluginHandler($repo, $provider, $factory, $register, $app);
    }
}
