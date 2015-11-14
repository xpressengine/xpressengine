<?php
/**
 * MenuConfigHandlerTest
 *
 * PHP version 5
 *
 * @category  Test
 * @package   Xpressengine\Tests\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\Tests\Menu;

use Illuminate\Support\Collection;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Menu\MenuConfigHandler;
use Xpressengine\Menu\MenuEntity;
use Xpressengine\Menu\MenuItem;
use Xpressengine\Support\Tree\TreeCollection;

/**
 * Class MenuConfigHandlerTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuConfigHandlerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var MockInterface
     */
    protected $themeHandler;
    /**
     * @var MockInterface
     */
    protected $configManager;

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * testGetMenuTheme
     *
     * @return void
     */
    public function testGetMenuTheme()
    {
        $configManager = $this->configManager;
        $themeHandler = $this->themeHandler;
        $configManager->shouldReceive('get')->andReturn('defaultTheme');

        $dummyMenu = new MenuEntity(
            ['id' => 'testMenu', 'title' => 'testTitle', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenu'])]
            ),
            new Collection()
        );

        $menuConfigHandler = new MenuConfigHandler($configManager, $themeHandler);
        $menuTheme = $menuConfigHandler->getMenuTheme($dummyMenu);
        $this->assertEquals('defaultTheme', $menuTheme);

    }

    /**
     * testSetMenuTheme
     *
     * @return void
     */
    public function testSetMenuTheme()
    {
        // MenuEntity $menu, $theme
        $configManager = $this->configManager;
        $themeHandler = $this->themeHandler;
        $configManager->shouldReceive('add')->andReturn('defaultTheme');

        $dummyMenu = new MenuEntity(
            ['id' => 'testMenu', 'title' => 'testTitle', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenu'])]
            ),
            new Collection()
        );

        $menuConfigHandler = new MenuConfigHandler($configManager, $themeHandler);

        $menuConfigHandler->setMenuTheme($dummyMenu, 'blueTheme', 'mobileTheme');

    }

    /**
     * testUpdateMenuTheme
     *
     * @return void
     */
    public function testUpdateMenuTheme()
    {
        // MenuEntity $menu, $theme

        $configManager = $this->configManager;
        $themeHandler = $this->themeHandler;
        $configManager->shouldReceive('modify')->andReturn('defaultTheme');
        $dummyConfigEntity = m::mock('Xpressengine\Config\ConfigEntity');

        $configManager->shouldReceive('get')->andReturn($dummyConfigEntity);

        $dummyConfigEntity->shouldReceive('set')->andReturn();

        $dummyMenu = new MenuEntity(
            ['id' => 'testMenu', 'title' => 'testTitle', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenu'])]
            ),
            new Collection()
        );

        $menuConfigHandler = new MenuConfigHandler($configManager, $themeHandler);

        $menuConfigHandler->updateMenuTheme($dummyMenu, 'blueTheme', 'blueMobileTheme');
    }

    /**
     * testDeleteMenuTheme
     *
     * @return void
     */
    public function testDeleteMenuTheme()
    {
        // MenuEntity $menu
        $configManager = $this->configManager;
        $themeHandler = $this->themeHandler;
        $configManager->shouldReceive('removeByName')->andReturn();

        $dummyMenu = new MenuEntity(
            ['id' => 'testMenu', 'title' => 'testTitle', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenu'])]
            ),
            new Collection()
        );

        $menuConfigHandler = new MenuConfigHandler($configManager, $themeHandler);
        $menuConfigHandler->deleteMenuTheme($dummyMenu);
    }

    /**
     * testGetMenuItemTheme
     *
     * @return void
     */
    public function testGetMenuItemTheme()
    {
        // MenuItem $item
        $configManager = $this->configManager;
        $themeHandler = $this->themeHandler;
        $configManager->shouldReceive('get')->andReturn('blueTheme');

        $dummyItem = new MenuItem(['id' => 'testMenu']);
        $dummyItem->setBreadCrumbs(['basic', 'notice']);

        $menuConfigHandler = new MenuConfigHandler($configManager, $themeHandler);
        $selectedTheme = $menuConfigHandler->getMenuItemTheme($dummyItem);
        $this->assertEquals('blueTheme', $selectedTheme);

    }

    /**
     * testSetMenuItemTheme
     *
     * @return void
     */
    public function testSetMenuItemTheme()
    {
        // MenuItem $item, $theme
        $configManager = $this->configManager;
        $themeHandler = $this->themeHandler;
        $configManager->shouldReceive('add')->andReturn();

        $dummyItem = new MenuItem(['id' => 'testMenu']);
        $dummyItem->setBreadCrumbs(['basic', 'notice']);

        $menuConfigHandler = new MenuConfigHandler($configManager, $themeHandler);

        $menuConfigHandler->setMenuItemTheme($dummyItem, 'blueTheme', 'mobileTheme');

    }

    /**
     * testUpdateMenuItemTheme
     *
     * @return void
     */
    public function testUpdateMenuItemTheme()
    {
        //MenuItem $item, $theme
        $configManager = $this->configManager;
        $themeHandler = $this->themeHandler;
        $configManager->shouldReceive('add')->andReturn();

        $dummyItem = new MenuItem(['id' => 'testMenu']);
        $dummyItem->setBreadCrumbs(['basic', 'notice']);

        $menuConfigHandler = new MenuConfigHandler($configManager, $themeHandler);

        $menuConfigHandler->setMenuItemTheme($dummyItem, 'blueTheme', 'mobileTheme');

    }

    /**
     * testUpdateMenuItemThemeWithEmpty
     *
     * @return void
     */
    public function testUpdateMenuItemThemeWithEmpty()
    {
        $configManager = $this->configManager;
        $themeHandler = $this->themeHandler;
        $dummyConfigEntity = m::mock('Xpressengine\Config\ConfigEntity');
        $dummyConfigEntity->shouldReceive('set')->andReturn();
        $configManager->shouldReceive('get')->andReturn($dummyConfigEntity);
        $configManager->shouldReceive('modify')->andReturn();

        $dummyItem = new MenuItem(['id' => 'testMenu']);
        $dummyItem->setBreadCrumbs(['basic', 'notice']);

        $menuConfigHandler = new MenuConfigHandler($configManager, $themeHandler);
        $menuConfigHandler->updateMenuItemTheme($dummyItem, 'desktopTheme', 'mobileTheme');

    }

    /**
     * testDeleteMenuItemTheme
     *
     * @return void
     */
    public function testDeleteMenuItemTheme()
    {
        // MenuItem $item
        $configManager = $this->configManager;
        $themeHandler = $this->themeHandler;
        $configManager->shouldReceive('removeByName')->andReturn();

        $dummyItem = new MenuItem(['id' => 'testMenu']);
        $dummyItem->setBreadCrumbs(['basic', 'notice']);

        $menuConfigHandler = new MenuConfigHandler($configManager, $themeHandler);

        $menuConfigHandler->deleteMenuItemTheme($dummyItem);
    }

    /**
     * testMoveItemConfig
     *
     * @return void
     */
    public function testMoveItemConfig()
    {
        // MenuItem $item, MenuItem $movedItem
        $configManager = $this->configManager;
        $themeHandler = $this->themeHandler;

        $dummyConfigEntity = m::mock('Xpressengine\Config\ConfigEntity');

        $configManager->shouldReceive('get')->andReturn($dummyConfigEntity);
        $configManager->shouldReceive('move')->andReturn($dummyConfigEntity);

        $dummyItem = new MenuItem(['id' => 'testMenu']);
        $dummyItem->setBreadCrumbs(['basic', 'board']);

        $dummyMovedItem = new MenuItem(['id' => 'movedTestMenu']);
        $dummyMovedItem->setBreadCrumbs(['basic', 'notice']);

        $menuConfigHandler = new MenuConfigHandler($configManager, $themeHandler);

        $menuConfigHandler->moveItemConfig($dummyItem, $dummyMovedItem);

    }

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $configManagerMock = m::mock('Xpressengine\Config\ConfigManager');
        $themeHandlerMock = m::mock('Xpressengine\Theme\ThemeHandler');

        $this->configManager = $configManagerMock;
        $this->themeHandler = $themeHandlerMock;
    }
}
