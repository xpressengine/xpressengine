<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Theme;

use Mockery;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\Theme\ThemeEntityInterface;
use Xpressengine\Theme\ThemeHandler;

class ThemeHandlerTest extends \PHPUnit_Framework_TestCase
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
        $id = 'theme/pluginA@blue';
        $theme = $this->getHandler()->getTheme($id);
        $this->assertInstanceOf(ThemeEntityInterface::class, $theme);
        $this->assertEquals('Theme_theme_pluginA_blue', $theme->getClass());

        $id = 'theme/pluginA@red';
        $theme = $this->getHandler()->getTheme($id);
        $this->assertInstanceOf(ThemeEntityInterface::class, $theme);
        $this->assertEquals('Theme_theme_pluginA_red', $theme->getClass());
    }

    public function testGetAllTheme()
    {
        $themes = $this->getHandler()->getAllTheme();

        $this->assertCount(2, $themes);

        $id = 'theme/pluginA@blue';
        $theme = $themes[$id];

        $this->assertEquals($id, $theme->getId());
    }

    public function testGetAllSettingsTheme()
    {
        $themes = $this->getHandler()->getAllSettingsTheme();

        $this->assertCount(2, $themes);

        $id = 'settingsTheme/pluginA@blue';
        $theme = $themes[$id];

        $this->assertEquals($id, $theme->getId());
    }

    public function testSelectedTheme()
    {
        $handler = $this->getHandler();
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

        $container = $this->getRegister();

        $themeClassMock = $this->makeThemeMock('theme/xpressengine@blank');
        $container->shouldReceive('get')->withArgs(['theme/xpressengine@blank'])->once()->andReturn($themeClassMock);

        $handler = $this->getHandler($container);

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
        $themes = $this->getHandler()->getAllThemeSupportingMobile();

        $this->assertCount(2, $themes);

        $id = 'theme/pluginA@blue';
        $theme = $themes[$id];

        $this->assertEquals($id, $theme->getId());
    }

    public function testgetAllThemeSupportingDesktop()
    {
        $themes = $this->getHandler()->getAllThemeSupportingDesktop();

        $this->assertCount(0, $themes);
    }

    protected function getHandler($register = null, $config = null, $blankTheme = 'theme/xpressengine@blank')
    {
        if ($register === null) {
            $register = $this->getRegister();
        }
        if ($config === null) {
            $config = $this->getConfig();
        }

        return new ThemeHandler($register, $config, $blankTheme);
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
            'Xpressengine\Theme\AbstractTheme',
            [
                'getId' => $id,
                'getTitle' => 'skin for test',
                'supportMobile' => true,
                'supportDesktop' => false,
            ]
        );
        return 'Theme_'.$postfix;
    }

    protected function getConfig()
    {
        return Mockery::mock('Xpressengine\Config\ConfigManager');
    }
}

