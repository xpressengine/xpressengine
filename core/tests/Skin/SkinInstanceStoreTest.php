<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Skin;

use Mockery;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Skin\SkinInstanceStore as Store;

class SkinInstanceStoreTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Store
     */
    protected $store;

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testGetSelectedSkin()
    {
        $key = 'module/board';

        $ret = $this->store->getSelectedSkin($key);
        $this->assertCount(2, $ret);
        $this->assertContains('desktopSkin', $ret);
        $this->assertContains('mobileSkin', $ret);

        $ret = $this->store->getSelectedSkin($key, Store::SKIN_MODE_MOBILE);
        $this->assertEquals('mobileSkin', $ret);

        $ret = $this->store->getSelectedSkin($key, Store::SKIN_MODE_DESKTOP);
        $this->assertEquals('desktopSkin', $ret);
    }

    public function testSetSelectedSkin()
    {
        $key = 'module/board';

        $manager = $this->getConfigManager();
        $manager->shouldReceive('setVal')->withArgs(['skins.selected.module/board.'.Store::SKIN_MODE_MOBILE, 'mobileSkin'])->twice()->andReturnNull();
        $manager->shouldReceive('setVal')->withArgs(['skins.selected.module/board.'.Store::SKIN_MODE_DESKTOP, 'desktopSkin'])->twice()->andReturnNull();
        $this->store->setStore($manager);

        $value = [Store::SKIN_MODE_DESKTOP => 'desktopSkin', Store::SKIN_MODE_MOBILE => 'mobileSkin'];
        $this->store->setSelectedSkin($key, $value);
        $this->store->setSelectedSkin($key, Store::SKIN_MODE_DESKTOP, $value[Store::SKIN_MODE_DESKTOP]);
        $this->store->setSelectedSkin($key, Store::SKIN_MODE_MOBILE, $value[Store::SKIN_MODE_MOBILE]);
    }

    public function testGetConfigs()
    {
        $key = 'module/board';

        $ret = $this->store->getConfigs($key);

        $this->assertCount(2, $ret);
        $this->assertContains(['desktopSkinConfig'], $ret);
        $this->assertContains(['mobileSkinConfig'], $ret);

        $ret = $this->store->getConfigs($key, 'desktopSkin');
        $this->assertEquals(['desktopSkinConfig'], $ret);

        $ret = $this->store->getConfigs($key, 'mobileSkin');
        $this->assertEquals(['mobileSkinConfig'], $ret);
    }


    public function testSetConfigs()
    {
        $key = 'module/board';

        $manager = $this->getConfigManager();
        $manager->shouldReceive('set')->withArgs(['skins.configs.module/board', []])->once()->andReturnNull();
        $manager->shouldReceive('setVal')->withArgs(['skins.configs.module/board.desktopSkin', []])->once()->andReturnNull();
        $this->store->setStore($manager);

        $value = [Store::SKIN_MODE_DESKTOP => 'desktopSkin', Store::SKIN_MODE_MOBILE => 'mobileSkin'];
        $this->store->setConfigs($key, []);
        $this->store->setConfigs($key, 'desktopSkin', []);
    }

    protected function setUp()
    {
        $this->store = new Store($this->getConfigManager());
        parent::setUp();
    }

    /**
     * getConfigManager
     *
     * @return ConfigManager
     */
    protected function getConfigManager()
    {
        $manager = Mockery::mock('Xpressengine\Config\ConfigManager');

        // for skin info
        $skinConfig = Mockery::mock('Xpressengine\Config\ConfigEntity');
        $skins = [Store::SKIN_MODE_DESKTOP => 'desktopSkin', Store::SKIN_MODE_MOBILE => 'mobileSkin'];
        $skinConfig->shouldReceive('getPureAll')->withNoArgs()->andReturn(
            $skins
        );
        $manager->shouldReceive('get')->withArgs(['skins.selected.module/board'])->andReturn($skinConfig);
        $manager->shouldReceive('getPureVal')
            ->withArgs(['skins.selected.module/board.'.Store::SKIN_MODE_DESKTOP])
            ->andReturn($skins[Store::SKIN_MODE_DESKTOP]);
        $manager->shouldReceive('getPureVal')
            ->withArgs(['skins.selected.module/board.'.Store::SKIN_MODE_MOBILE])
            ->andReturn($skins[Store::SKIN_MODE_MOBILE]);

        // for config
        $cofigConfig = Mockery::mock('Xpressengine\Config\ConfigEntity');
        $configs = ['desktopSkin' => ['desktopSkinConfig'], 'mobileSkin' => ['mobileSkinConfig']];
        $cofigConfig->shouldReceive('getPureAll')->withNoArgs()->andReturn(
            $configs
        );
        $manager->shouldReceive('get')->withArgs(['skins.configs.module/board'])->andReturn($cofigConfig);
        $manager->shouldReceive('getPureVal')
            ->withArgs(['skins.configs.module/board.desktopSkin', []])
            ->andReturn($configs['desktopSkin']);
        $manager->shouldReceive('getPureVal')
            ->withArgs(['skins.configs.module/board.mobileSkin', []])
            ->andReturn($configs['mobileSkin']);
        return $manager;
    }
}
