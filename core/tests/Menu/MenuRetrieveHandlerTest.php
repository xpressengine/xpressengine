<?php
/**
 * MenuRetrieveHandlerTest
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

use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Menu\MenuEntity;
use Xpressengine\Menu\MenuItem;
use Xpressengine\Menu\MenuRetrieveHandler;
use Xpressengine\Support\Tree\TreeCollection;

/**
 * Class MenuRetrieveHandlerTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuRetrieveHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var
     */
    private $menuRepository;
    /**
     * @var
     */
    private $typeHandler;
    /**
     * @var
     */
    private $menuPermissionHandler;
    /**
     * @var
     */
    private $cacheHandler;
    /**
     * @var
     */
    private $menuPermission;

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
     * testGetAllMenu
     *
     * @return void
     */
    public function testGetAllMenu()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $permissionHandler = $this->menuPermissionHandler;
        $cacheHandler = $this->cacheHandler;

        $menuPermission = $this->menuPermission;
        $dummyMenu1 = new MenuEntity(
            ['id' => 'menu1', 'title' => 'testTitle1', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenuItem1'])]
            )
        );
        $dummyMenu2 = new MenuEntity(
            ['id' => 'menu2', 'title' => 'testTitle2', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenuItem2'])]
            )
        );
        $dummyMenu3 = new MenuEntity(
            ['id' => 'menu3', 'title' => 'testTitle3', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenuItem3'])]
            )
        );

        $menuHandler = new MenuRetrieveHandler($menuRepo, $typeHandler, $permissionHandler, $cacheHandler);

        $menuRepo->shouldReceive('findAllMenuIds')->andReturn(['menu1', 'menu2', 'menu3']);
        $cacheHandler->shouldReceive('isExistCachedMenu')->andReturn(false);
        $cacheHandler->shouldReceive('setCachedMenu')->andReturn(false);

        $menuRepo->shouldReceive('findMenu')->with('menu1')->andReturn($dummyMenu1);
        $menuRepo->shouldReceive('findMenu')->with('menu2')->andReturn($dummyMenu2);
        $menuRepo->shouldReceive('findMenu')->with('menu3')->andReturn($dummyMenu3);
        $menuRepo->shouldReceive('findAllMenu')->andReturn(['menu1' => '1', 'menu2' => '2', 'menu3' => '3']);

        $permissionHandler->shouldReceive('getMenuPermissions')->andReturn(
            [
                'menu1' => $menuPermission,
                'menu2' => $menuPermission,
                'menu3' => $menuPermission,
                '' => $menuPermission,
                'testMenuItem1' => $menuPermission,
                'testMenuItem2' => $menuPermission,
                'testMenuItem3' => $menuPermission
            ]
        );

        $testSiteKey = 'default';
        $menus = $menuHandler->getAllMenu($testSiteKey);

        $this->assertEquals(['menu1' => $dummyMenu1, 'menu2' => $dummyMenu2, 'menu3' => $dummyMenu3], $menus);

    }

    /**
     * testGetAllMenuWithCache
     *
     * @return void
     */
    public function testGetAllMenuWithCache()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $permissionHandler = $this->menuPermissionHandler;
        $cacheHandler = $this->cacheHandler;

        $menuPermission = $this->menuPermission;
        $dummyMenu1 = new MenuEntity(
            ['id' => 'menu1', 'title' => 'testTitle1', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenuItem1'])]
            )
        );
        $dummyMenu2 = new MenuEntity(
            ['id' => 'menu2', 'title' => 'testTitle2', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenuItem2'])]
            )
        );
        $dummyMenu3 = new MenuEntity(
            ['id' => 'menu3', 'title' => 'testTitle3', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenuItem3'])]
            )
        );

        $menuHandler = new MenuRetrieveHandler($menuRepo, $typeHandler, $permissionHandler, $cacheHandler);

        $menuRepo->shouldReceive('findAllMenuIds')->andReturn(['menu1', 'menu2', 'menu3']);
        $cacheHandler->shouldReceive('isExistCachedMenu')->andReturn(true);

        $cacheHandler->shouldReceive('getCachedMenu')->with('menu1')->andReturn($dummyMenu1);
        $cacheHandler->shouldReceive('getCachedMenu')->with('menu2')->andReturn($dummyMenu2);
        $cacheHandler->shouldReceive('getCachedMenu')->with('menu3')->andReturn($dummyMenu3);

        $permissionHandler->shouldReceive('getMenuPermissions')->andReturn(
            [
                'menu1' => $menuPermission,
                'menu2' => $menuPermission,
                'menu3' => $menuPermission,
                '' => $menuPermission,
                'testMenuItem1' => $menuPermission,
                'testMenuItem2' => $menuPermission,
                'testMenuItem3' => $menuPermission
            ]
        );

        $testSiteKey = 'default';
        $menus = $menuHandler->getAllMenu($testSiteKey);

        $this->assertEquals(['menu1' => $dummyMenu1, 'menu2' => $dummyMenu2, 'menu3' => $dummyMenu3], $menus);

    }

    /**
     * testGetMenu
     *
     * @return void
     */
    public function testGetMenu()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $permissionHandler = $this->menuPermissionHandler;
        $cacheHandler = $this->cacheHandler;
        $menuPermission = $this->menuPermission;

        $dummyMenu1 = new MenuEntity(
            ['id' => 'main', 'title' => 'testTitle1', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenuItem1'])]
            )
        );

        $menuHandler = new MenuRetrieveHandler($menuRepo, $typeHandler, $permissionHandler, $cacheHandler);

        $cacheHandler->shouldReceive('isExistCachedMenu')->andReturn(false);
        $cacheHandler->shouldReceive('setCachedMenu')->andReturn(false);
        $menuRepo->shouldReceive('findMenu')->andReturn($dummyMenu1);
        $permissionHandler->shouldReceive('getMenuPermissions')->andReturn(
            [
                'main' => $menuPermission,
                '' => $menuPermission,
            ]
        );

        $menu = $menuHandler->getMenu('main');

        $this->assertEquals($dummyMenu1, $menu);

    }

    /**
     * testGetMenuByItem
     *
     * @return void
     */
    public function testGetMenuByItem()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $permissionHandler = $this->menuPermissionHandler;
        $cacheHandler = $this->cacheHandler;
        $menuPermission = $this->menuPermission;

        $menuHandler = new MenuRetrieveHandler($menuRepo, $typeHandler, $permissionHandler, $cacheHandler);

        $dummyMenu1 = new MenuEntity(
            ['id' => 'main', 'title' => 'testTitle1', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenuItem1'])]
            )
        );

        $menuRepo->shouldReceive('getMenuIdByItem')->with('testItem')->andReturn('main');
        $cacheHandler->shouldReceive('isExistCachedMenu')->andReturn(false);
        $cacheHandler->shouldReceive('setCachedMenu')->andReturn(true);
        $cacheHandler->shouldReceive('getMenuMap')->andReturn([]);
        $menuRepo->shouldReceive('findMenu')->andReturn($dummyMenu1);
        $permissionHandler->shouldReceive('getMenuPermissions')->andReturn(
            [
                'main' => $menuPermission,
                '' => $menuPermission,
            ]
        );

        $menu = $menuHandler->getMenuByItem('testItem');

        $this->assertEquals($dummyMenu1, $menu);
    }

    /**
     * testGetItem
     *
     * @return void
     */
    public function testGetItem()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $permissionHandler = $this->menuPermissionHandler;
        $cacheHandler = $this->cacheHandler;
        $menuPermission = $this->menuPermission;

        $dummyMenuItem = new MenuItem(['id' => 'testMenuItem1']);
        $dummyMenu1 = new MenuEntity(
            ['id' => 'main', 'title' => 'testTitle1', 'description' => 'testDescription'],
            new TreeCollection(
                ['testMenuItem1' => $dummyMenuItem]
            )
        );

        $menuHandler = new MenuRetrieveHandler($menuRepo, $typeHandler, $permissionHandler, $cacheHandler);

        $menuRepo->shouldReceive('findItem')->andReturn($dummyMenuItem);
        $menuRepo->shouldReceive('findMenu')->andReturn($dummyMenu1);
        $menuRepo->shouldReceive('getMenuIdByItem')->andReturn($dummyMenu1);
        $cacheHandler->shouldReceive('isExistCachedMenu')->andReturn(true);
        $cacheHandler->shouldReceive('getCachedMenu')->with('main')->andReturn($dummyMenu1);
        $cacheHandler->shouldReceive('getMenuMap')->andReturn(['testMenuItem1' => 'main']);
        $permissionHandler->shouldReceive('getMenuPermissions')->andReturn(
            [
                'testMenuItem1' => $menuPermission,
                '' => $menuPermission,
            ]
        );

        $menuItem = $menuHandler->getItem('testMenuItem1');

        $this->assertEquals($dummyMenuItem, $menuItem);
    }

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $repositoryMock = m::mock('Xpressengine\Menu\MenuRepositoryInterface');
        $typeHandlerMock = m::mock('Xpressengine\Module\ModuleHandler');
        $permissionHandlerMock = m::mock('Xpressengine\Menu\MenuPermissionHandler');
        $cacheHandlerMock = m::mock('Xpressengine\Menu\MenuCacheHandler');
        $menuPermissionMock = m::mock('Xpressengine\Menu\Permission\MenuPermission');

        $this->menuRepository = $repositoryMock;
        $this->typeHandler = $typeHandlerMock;
        $this->menuPermissionHandler = $permissionHandlerMock;
        $this->cacheHandler = $cacheHandlerMock;
        $this->menuPermission = $menuPermissionMock;
    }
}
