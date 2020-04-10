<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */
namespace Xpressengine\Tests\Theme;

require_once 'TestTheme.php';

use Mockery;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\Plugins\OfficialHomepage\Theme\Theme;
use Xpressengine\Theme\ThemeEntity;
use Xpressengine\Theme\ThemeEntityInterface;
use Xpressengine\Theme\ThemeHandler;

class ThemeHandlerTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var ThemeHandler
     */
    protected $handler;

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testGetTheme()
    {

        $config = $this->getConfig();
        $config->shouldReceive('get')
            ->with('theme.settings.theme/pluginA@blue', true)
            ->once()
            ->andReturnNull();
        $config->shouldReceive('get')
            ->with('theme.settings.theme/pluginA@red', true)
            ->once()
            ->andReturnNull();

        $id = 'theme/pluginA@blue';
        $handler = $this->getHandler(null, $config);
        $theme = $handler->getTheme($id);
        $this->assertInstanceOf(ThemeEntityInterface::class, $theme);
        $this->assertEquals('Theme_theme_pluginA_blue', $theme->getClass());

        $id = 'theme/pluginA@red';
        $theme = $handler->getTheme($id);
        $this->assertInstanceOf(ThemeEntityInterface::class, $theme);
        $this->assertEquals('Theme_theme_pluginA_red', $theme->getClass());
    }

    public function testGetAllTheme()
    {
        $config = $this->getConfig();
        $config->shouldReceive('get')
            ->andReturnNull();
        $handler = $this->getHandler(null, $config);
        $themes = $handler->getAllTheme();

        $this->assertCount(2, $themes);

        $id = 'theme/pluginA@blue';
        $theme = $themes[$id];

        $this->assertEquals($id, $theme->getId());
    }

    public function testGetAllSettingsTheme()
    {
        $config = $this->getConfig();
        $config->shouldReceive('get')
            ->andReturnNull();
        $handler = $this->getHandler(null, $config);
        $themes = $handler->getAllSettingsTheme();

        $this->assertCount(2, $themes);

        $id = 'settingsTheme/pluginA@blue';
        $theme = $themes[$id];

        $this->assertEquals($id, $theme->getId());
    }

    public function testSelectedTheme()
    {
        $config = $this->getConfig();
        $config->shouldReceive('get')
            ->andReturnNull();
        $handler = $this->getHandler(null, $config);
        $currentTheme = $handler->getSelectedTheme();

        $this->assertNull($currentTheme);

        $id = 'theme/pluginA@blue';
        $handler->selectTheme($id);
        $currentTheme = $handler->getSelectedTheme();

        $this->assertEquals($id, $currentTheme->getId());

        $id = 'settingsTheme/pluginA@blue';
        $handler->selectTheme($id);
        $currentTheme = $handler->getSelectedTheme();

        $this->assertEquals($id, $currentTheme->getId());
    }

    public function testDeselectTheme()
    {

        $config = $this->getConfig();
        $config->shouldReceive('get')
            ->andReturnNull();
        $container = $this->getRegister();

        $themeClassMock = $this->makeThemeMock('theme/xpressengine@blank');
        $container->shouldReceive('get')->withArgs(['theme/xpressengine@blank'])->once()->andReturn($themeClassMock);

        $handler = $this->getHandler($container, $config);

        // set
        $id = 'theme/pluginA@blue';
        $handler->selectTheme($id);

        // unset
        $handler->deselectTheme();
        $this->assertInstanceOf('\Xpressengine\Theme\ThemeEntity', $handler->getSelectedTheme());
        $this->assertEquals('theme/xpressengine@blank', $handler->getSelectedTheme()->getId());
    }

    public function testSetSiteTheme()
    {
        $config = $this->getConfig();
        $config->shouldReceive('setVal')
            ->with('theme.setting.siteTheme.desktop', 'theme/pluginA@blue')
            ->once()
            ->andReturnNull();
        $config->shouldReceive('setVal')
            ->with('theme.setting.siteTheme.mobile', 'theme/pluginA@blue')
            ->once()
            ->andReturnNull();

        $this->getHandler(null, $config)->setSiteTheme('theme/pluginA@blue');
        $this->getHandler(null, $config)->setSiteTheme('theme/pluginA@blue', 'mobile');

    }

    public function testGetSiteTheme()
    {
        $config = $this->getConfig();
        $config->shouldReceive('getVal')
            ->with('theme.setting.siteTheme')
            ->times(3)
            ->andReturn(['desktop'=>'theme/pluginA@blue', 'mobile'=>'theme/pluginA@red']);

        $this->assertEquals('theme/pluginA@blue', $this->getHandler(null, $config)->getSiteThemeId('desktop'));
        $this->assertEquals('theme/pluginA@red', $this->getHandler(null, $config)->getSiteThemeId('mobile'));
        $this->assertCount(2, $this->getHandler(null, $config)->getSiteThemeId());
    }

    public function testGetThemeConfig()
    {
        $config = $this->getConfig();
        $config->shouldReceive('get')
            ->with('theme.settings.theme/pluginA@blue', true)
            ->once()
            ->andReturn(['config']);

        $this->assertEquals(['config'], $this->getHandler(null, $config)->getThemeConfig('theme/pluginA@blue'));
    }

    public function testSetThemeConfig()
    {
        $config = $this->getConfig();
        $config->shouldReceive('set')
            ->with('theme.settings.theme/pluginA@blue', ['config'])
            ->once()
            ->andReturnNull();

        $this->getHandler(null, $config)->setThemeConfig('theme/pluginA@blue', ['config']);
    }

    public function testSetThemeConfigValue()
    {
        $config = $this->getConfig();
        $config->shouldReceive('setVal')
            ->with('theme.settings.theme/pluginA@blue.mainmenu', 'config')
            ->once()
            ->andReturnNull();

        $this->getHandler(null, $config)->setThemeConfig('theme/pluginA@blue', 'mainmenu', 'config');
    }

    public function testGetAllThemeSupportingMobile()
    {
        $config = $this->getConfig();
        $config->shouldReceive('get')
            ->andReturnNull();
        $handler = $this->getHandler(null, $config);
        $themes = $handler->getAllThemeSupportingMobile();

        $this->assertCount(2, $themes);

        $id = 'theme/pluginA@blue';
        $theme = $themes[$id];

        $this->assertEquals($id, $theme->getId());
    }

    public function testgetAllThemeSupportingDesktop()
    {
        $config = $this->getConfig();
        $config->shouldReceive('get')
            ->andReturnNull();
        $handler = $this->getHandler(null, $config);
        $themes = $handler->getAllThemeSupportingDesktop();

        $this->assertCount(0, $themes);
    }

    protected function getHandler($register = null, $config = null, $view = null, $blankTheme = 'theme/xpressengine@blank')
    {
        if ($register === null) {
            $register = $this->getRegister();
        }
        if ($config === null) {
            $config = $this->getConfig();
        }
        if ($view === null) {
            $view = $this->getViewFactory();
        }

        return new ThemeHandlerStub($register, $config, $view, $blankTheme);
    }

    /**
     * @param $id
     * @param $type
     */
    protected function getRegister()
    {
        /*
         * 'theme/pluginA@blue',
         * 'theme/pluginA@red',
         */
        $container = Mockery::mock(PluginRegister::class);

        // register blue theme
        $id1 = 'theme/pluginA@blue';
        $themeClassMock1 = $this->makeThemeMock($id1);
        $container->shouldReceive('get')->withArgs([$id1])->andReturn($themeClassMock1);

        // register red theme
        $id2 = 'theme/pluginA@red';
        $themeClassMock2 = $this->makeThemeMock($id2);
        $container->shouldReceive('get')->withArgs([$id2])->andReturn($themeClassMock2);

        $container->shouldReceive('get')->withArgs(['theme'])->andReturn(
            [$id1 => $themeClassMock1, $id2 => $themeClassMock2]
        );

        // register blue settingsTheme
        $id1 = 'settingsTheme/pluginA@blue';
        $manage_themeClassMock1 = $this->makeThemeMock($id1);
        $container->shouldReceive('get')->withArgs([$id1])->andReturn($manage_themeClassMock1);

        // register red manage_theme
        $id2 = 'settingsTheme/pluginA@red';
        $manage_themeClassMock2 = $this->makeThemeMock($id2);
        $container->shouldReceive('get')->withArgs([$id2])->andReturn($manage_themeClassMock2);

        $container->shouldReceive('get')->withArgs(['settingsTheme'])->andReturn(
            [$id1 => $manage_themeClassMock1, $id2 => $manage_themeClassMock2]
        );

        return $container;
    }

    protected function makeThemeMock($id)
    {
        $postfix = str_replace(['/', '@'], '_', $id);
        $mock = \Mockery::mock(
            'alias:Theme_'.$postfix,
            'Xpressengine\Tests\Theme\TestTheme',
            [
                'getId' => $id,
                'getTitle' => 'skin for test',
                'supportMobile' => true,
                'supportDesktop' => false,
            ]
        );
        $mock->shouldReceive('setting')->andReturnNull();
        return 'Theme_'.$postfix;
    }

    protected function getConfig()
    {
        $config = Mockery::mock('Xpressengine\Config\ConfigManager');
        return $config;
    }

    protected function getViewFactory()
    {
        return Mockery::mock('\Illuminate\Contracts\View\Factory');
    }
}

class ThemeHandlerStub extends ThemeHandler {
    /**
     * make and return ThemeEntity
     *
     * @param $id
     * @param $class
     *
     * @return ThemeEntity
     */
    protected function makeEntity($id, $class)
    {
        return new ThemeEntityStub($id, $class);
    }
}

class ThemeEntityStub extends ThemeEntity {
    /**
     * get and set config
     *
     * @param ConfigEntity $config
     *
     * @return null
     */
    public function setting(ConfigEntity $config = null)
    {
        return null;
    }

}

