<?php
/**
 * MenuAlterHandlerTest
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

use Illuminate\Database\Eloquent\Collection;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Menu\MenuAlterHandler;
use Xpressengine\Menu\MenuEntity;
use Xpressengine\Menu\MenuItem;
use Xpressengine\Routing\InstanceRoute;
use Xpressengine\Support\Tree\TreeCollection;

/**
 * Class MenuAlterHandlerTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuAlterHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockInterface
     */
    private $menuRepository;
    /**
     * @var MockInterface
     */
    private $typeHandler;
    /**
     * @var MockInterface
     */
    private $routeHandler;
    /**
     * @var MockInterface
     */
    private $cacheHandler;

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
     * testAddMenu
     *
     * @return void
     */
    public function testAddMenu()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $inputs = [
            'menuTitle' => '기본메뉴',
            'menuDescription' => '기본메뉴 입니다.',
            'siteKey' => 'default'
        ];

        $menuRepo->shouldReceive('insertMenu')->andReturn(new MenuEntity(
            ['id' => 'basic', 'title' => $inputs['menuTitle'], 'description' => $inputs['menuDescription'],
                 'site' => $inputs['siteKey']
            ],
            new TreeCollection([])
        ));
        $menuRepo->shouldReceive('insertHierarchy')->andReturn(true);

        $menu = $menuHandler->addMenu($inputs);

        $this->assertEquals('기본메뉴', $menu->title);
        $this->assertEquals('기본메뉴 입니다.', $menu->description);
        $this->assertEquals('default', $menu->site);

    }

    /**
     * testPutMenu
     *
     * @return void
     */
    public function testPutMenu()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $menu = new MenuEntity(['id' => 'testMenu', 'title' => 'testTitle', 'description' => 'testDescription']
            , new TreeCollection([new MenuItem(['id' => 'testMenu'])]));

        $inputs = [
            'menuTitle' => 'changedTitle',
            'menuDescription' => 'changedDescription'
        ];

        $menuRepo->shouldReceive('updateMenu')->andReturn(1);

        $result = $menuHandler->putMenu($menu, $inputs);

        $this->assertEquals(1, $result);
        $this->assertEquals('changedTitle', $menu->title);
        $this->assertEquals('changedDescription', $menu->description);

    }

    /**
     * testRemoveMenu
     *
     * @return void
     * @throws \Exception
     */
    public function testRemoveMenu()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $menu = new MenuEntity(['id' => 'testMenu', 'title' => 'testTitle', 'description' => 'testDescription'],
            new TreeCollection([]));

        $menuRepo->shouldReceive('findMenu')->with('basic')->andReturn($menu);
        $menuRepo->shouldReceive('deleteMenu')->andReturn();
        $cacheHandler->shouldReceive('forgetMenuMap')->andReturn();

        $menuHandler->removeMenu($menu);

    }

    /**
     * testRemoveMenuFail
     *
     * @return void
     * @throws \Exception
     */
    public function testRemoveMenuFail()
    {
        $this->setExpectedException('\Exception');

        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $menu = new MenuEntity(['id' => 'testMenu', 'title' => 'testTitle', 'description' => 'testDescription']
            , new TreeCollection([new MenuItem(['id' => 'testMenu'])]));

        $menuItem = new MenuItem(
            [
                'id' => 'qna',
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => 'Q & A',
                'description' => '질답 게시판입니다.',
                'url' => 'qna'
            ]);

        $menu->addItem($menuItem);

        $menuRepo->shouldReceive('findMenu')->with('basic')->andReturn($menu);
        $menuRepo->shouldReceive('deleteMenu')->andReturn();

        $menuHandler->removeMenu($menu);

    }

    /**
     * testAddItem
     *
     * @return void
     */
    public function testAddItem()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $instanceRouteMock = m::mock('Xpressengine\Routing\InstanceRoute');
        $instanceRouteMock->shouldReceive('setUrl')->andReturn();

        $inputs = [
            'itemId' => 'testId',
            'parent' => 'basic',
            'itemTitle' => 'Title',
            'itemUrl' => 'testUrl',
            'itemDescription' => 'testDescription',
            'itemTarget' => '_blank',
            'selectedType' => 'xpressengine@test',
            'itemOrdering' => '1',
            'itemActivated' => '1',
            'siteKey' => 'default'
        ];

        $menuRepo->shouldReceive('insertItem')->andReturn(
            new MenuItem(
                [
                    'id' => $inputs['itemId'],
                    'menuId' => 'basic',
                    'parentId' => $inputs['parent'],
                    'title' => $inputs['itemTitle'],
                    'url' => $inputs['itemUrl'],
                    'description' => $inputs['itemDescription'],
                    'target' => $inputs['itemTarget'],
                    'type' => $inputs['selectedType'],
                    'ordering' => $inputs['itemOrdering'],
                    'activated' => $inputs['itemActivated']
                ]
            )
        );
        $menuRepo->shouldReceive('insertHierarchy')->andReturn(0);

        $dummyMenuEntity = $menu = new MenuEntity(
            [
                'id' => 'basic',
                'title' => 'testTitle',
                'description' => 'testDescription'
            ],
            new TreeCollection(
                [
                    'testMenu' => new MenuItem(['id' => 'basic']),
                ]
            )
        );

        $menuRepo->shouldReceive('findMenu')->andReturn($dummyMenuEntity);
        $menuRepo->shouldReceive('children')->andReturn([]);
        $menuRepo->shouldReceive('updateItem')->andReturn([]);

        $routeHandler->shouldReceive('usableUrl')->andReturn(true);
        $routeHandler->shouldReceive('add')->andReturn();

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $dummyMenuType = m::mock(
            'alias:Theme',
            'Xpressengine\Menu\MenuType\MenuTypeInterface',
            [
                'isRouteAble' => true,
                'getId' => 'dummyId'
            ]
        );
        $dummyMenuType->shouldReceive('storeMenu')->andReturn();

        $typeHandler->shouldReceive('getModuleObject')->andReturn($dummyMenuType);

        $insertedItem = $menuHandler->addItem($dummyMenuEntity, $inputs);

        $this->assertEquals('testId', $insertedItem->id);
        $this->assertEquals('Title', $insertedItem->title);
        $this->assertEquals('testUrl', $insertedItem->url);
        $this->assertEquals('testDescription', $insertedItem->description);
        $this->assertEquals('_blank', $insertedItem->target);
        $this->assertEquals(0, $insertedItem->ordering);
        $this->assertEquals(true, $insertedItem->activated);
    }

    /**
     * testAddItemGenerateNewItemBreadCrumbs
     *
     * @return void
     */
    public function testAddItemGenerateNewItemBreadCrumbs()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $instanceRouteMock = m::mock('Xpressengine\Routing\InstanceRoute');
        $instanceRouteMock->shouldReceive('setUrl')->andReturn();

        $inputs = [
            'itemId' => 'testId',
            'parent' => 'freeboard',
            'itemTitle' => 'Title',
            'itemUrl' => 'testUrl',
            'itemDescription' => 'testDescription',
            'itemTarget' => '_blank',
            'selectedType' => 'xpressengine@test',
            'itemOrdering' => '1',
            'itemActivated' => '1',
            'siteKey' => 'default'
        ];

        $menuRepo->shouldReceive('insertItem')->andReturn(
            new MenuItem(
                [
                    'id' => $inputs['itemId'],
                    'menuId' => 'basic',
                    'parentId' => $inputs['parent'],
                    'title' => $inputs['itemTitle'],
                    'url' => $inputs['itemUrl'],
                    'description' => $inputs['itemDescription'],
                    'target' => $inputs['itemTarget'],
                    'type' => $inputs['selectedType'],
                    'ordering' => $inputs['itemOrdering'],
                    'activated' => $inputs['itemActivated']
                ]
            )
        );
        $menuRepo->shouldReceive('insertHierarchy')->andReturn(0);

        $dummyMenuEntity = $menu = new MenuEntity(
            [
                'id' => 'basic',
                'title' => 'testTitle',
                'description' => 'testDescription'
            ],
            new TreeCollection(
                [
                    'testMenu' => new MenuItem(['id' => 'testMenu']),
                    'freeboard' => new MenuItem(['id' => 'freeboard']),
                ]
            )
        );

        $menuRepo->shouldReceive('findMenu')->andReturn($dummyMenuEntity);
        $menuRepo->shouldReceive('children')->andReturn([]);
        $menuRepo->shouldReceive('updateItem')->andReturn([]);

        $dummyMenuItem = new MenuItem([]);
        $dummyMenuItem->setBreadCrumbs(['basic','freeboard']);

        $menuRepo->shouldReceive('findItem')->andReturn($dummyMenuItem);

        $routeHandler->shouldReceive('usableUrl')->andReturn(true);
        $routeHandler->shouldReceive('add')->andReturn();

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $dummyMenuType = m::mock(
            'alias:Theme',
            'Xpressengine\Menu\MenuType\MenuTypeInterface',
            [
                'isRouteAble' => true,
                'getId' => 'dummyId'
            ]
        );
        $dummyMenuType->shouldReceive('storeMenu')->andReturn();

        $typeHandler->shouldReceive('getModuleObject')->andReturn($dummyMenuType);


        $insertedItem = $menuHandler->addItem($dummyMenuEntity, $inputs);

        $this->assertEquals('testId', $insertedItem->id);
        $this->assertEquals('Title', $insertedItem->title);
        $this->assertEquals('testUrl', $insertedItem->url);
        $this->assertEquals('testDescription', $insertedItem->description);
        $this->assertEquals('_blank', $insertedItem->target);
        $this->assertEquals(0, $insertedItem->ordering);
        $this->assertEquals(true, $insertedItem->activated);
    }

    /**
     * testAddItemFail
     *
     * @return void
     */
    public function testAddItemFail()
    {
        $this->setExpectedException('\Xpressengine\Routing\Exceptions\UnusableUrlException');

        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $instanceRouteMock = m::mock('Xpressengine\Routing\InstanceRoute');
        $instanceRouteMock->shouldReceive('setUrl')->andReturn();

        $menuRepo->shouldReceive('countMenu')->andReturn(0);
        $menuRepo->shouldReceive('countItem')->andReturn(0);

        $inputs = [
            'itemId' => 'testId',
            'parent' => 'basic',
            'itemTitle' => 'Title',
            'itemUrl' => 'testUrl',
            'itemDescription' => 'testDescription',
            'itemTarget' => '_blank',
            'selectedType' => 'xpressengine@test',
            'itemOrdering' => '1',
            'itemActivated' => '1',
            'siteKey' => 'default'
        ];

        $menuRepo->shouldReceive('insertItem')->andReturn(
            new MenuItem(
                [
                    'id' => $inputs['itemId'],
                    'menuId' => 'basic',
                    'parentId' => $inputs['parent'],
                    'title' => $inputs['itemTitle'],
                    'url' => $inputs['itemUrl'],
                    'description' => $inputs['itemDescription'],
                    'target' => $inputs['itemTarget'],
                    'type' => $inputs['selectedType'],
                    'ordering' => $inputs['itemOrdering'],
                    'activated' => $inputs['itemActivated']
                ]
            )
        );
        $menuRepo->shouldReceive('insertHierarchy')->andReturn(0);

        $dummyMenuEntity = $menu = new MenuEntity(
            [
                'id' => 'basic',
                'title' => 'testTitle',
                'description' => 'testDescription'
            ],
            new TreeCollection(
                [
                    'testMenu' => new MenuItem(['id' => 'testMenu'])
                ]
            )
        );

        $menuRepo->shouldReceive('findMenu')->andReturn($dummyMenuEntity);
        $menuRepo->shouldReceive('children')->andReturn([]);
        $menuRepo->shouldReceive('updateItem')->andReturn([]);


        $routeHandler->shouldReceive('usableUrl')->andReturn(false);
        $routeHandler->shouldReceive('add')->andReturn();

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $dummyMenuType = m::mock(
            'alias:Theme',
            'Xpressengine\Menu\MenuType\MenuTypeInterface',
            [
                'isRouteAble' => true,
                'getId' => 'dummyId'
            ]
        );
        $dummyMenuType->shouldReceive('storeMenu')->andReturn();

        $typeHandler->shouldReceive('getModuleObject')->andReturn($dummyMenuType);

        $insertedItem = $menuHandler->addItem($dummyMenuEntity, $inputs);

        $this->assertEquals('testId', $insertedItem->id);
        $this->assertEquals('Title', $insertedItem->title);
        $this->assertEquals('testUrl', $insertedItem->url);
        $this->assertEquals('testDescription', $insertedItem->description);
        $this->assertEquals('_blank', $insertedItem->target);
        $this->assertEquals(1, $insertedItem->ordering);
        $this->assertEquals(true, $insertedItem->activated);
    }

    /**
     * testPutItem
     *
     * @return void
     */
    public function testPutItem()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $instanceRouteMock = m::mock('Xpressengine\Routing\InstanceRoute');
        $instanceRouteMock->shouldReceive('setUrl')->andReturn();

        $menuRepo->shouldReceive('updateItem')->andReturn(1);
        $routeHandler->shouldReceive('getByInstanceId')->andReturn($instanceRouteMock);
        $routeHandler->shouldReceive('put')->andReturn();

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $dummyMenuType = m::mock('alias:Theme', 'Xpressengine\Menu\MenuType\MenuTypeInterface',
            [
                'isRouteAble' => true
            ]
        );

        $dummyMenuType->shouldReceive('updateMenu')->andReturn();

        $typeHandler->shouldReceive('getModuleObject')->andReturn($dummyMenuType);
        $typeHandler->shouldReceive('updateMenu')->andReturn(1);

        $menuItem = new MenuItem(
            [
                'id' => 'qna',
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => 'Q & A',
                'description' => '질답 게시판입니다.',
                'url' => 'qna'
            ]
        );

        $inputs = [
            'itemTitle' => 'newTitle',
            'itemUrl' => 'newUrl',
            'itemDescription' => 'newDescription',
            'itemTarget' => 'newTarget',
            'itemOrdering' => 3,
            'itemActivated' => false,
        ];

        $updatedItem = $menuHandler->putItem($menuItem, $inputs);

        $this->assertEquals('qna', $updatedItem->id);
        $this->assertEquals('newTitle', $updatedItem->title);
        $this->assertEquals('newUrl', $updatedItem->url);
        $this->assertEquals('newDescription', $updatedItem->description);
        $this->assertEquals('newTarget', $updatedItem->target);
        $this->assertEquals(3, $updatedItem->ordering);
        $this->assertEquals(false, $updatedItem->activated);
    }

    /**
     * testRemoveItem
     *
     * @return void
     */
    public function testRemoveItem()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $instanceRouteMock = m::mock('Xpressengine\Routing\InstanceRoute');
        $instanceRouteMock->shouldReceive('setUrl')->andReturn();

        $menuRepo->shouldReceive('countItem')->andReturn(0);
        $menuRepo->shouldReceive('deleteItem')->andReturn();
        $menuRepo->shouldReceive('removeHierarchy')->andReturn();
        $testItem =
            new MenuItem(
                [
                    'menuId' => 'test',
                    'type' => 'testType'
                ]
            );

        $routeHandler->shouldReceive('getByInstanceId')->andReturn(
            new InstanceRoute(
                [
                    'instanceId' => 'test',
                    'site' => 'default'
                ]
            )
        );

        $routeHandler->shouldReceive('remove')->andReturn();

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $dummyMenuType = m::mock('alias:Theme', 'Xpressengine\Menu\MenuType\MenuTypeInterface',
            [
                'isRouteAble' => true
            ]
        );

        $dummyMenuType->shouldReceive('deleteMenu')->andReturn();

        $typeHandler->shouldReceive('getModuleObject')->andReturn($dummyMenuType);
        $typeHandler->shouldReceive('updateMenu')->andReturn(0);

        $menuHandler->removeItem($testItem);
    }

    /**
     * testRemoveItemFail
     *
     * @return void
     */
    public function testRemoveItemFail()
    {
        $this->setExpectedException('Xpressengine\Menu\Exceptions\CanNotDeleteMenuItemHaveChildException');

        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $instanceRouteMock = m::mock('Xpressengine\Routing\InstanceRoute');
        $instanceRouteMock->shouldReceive('setUrl')->andReturn();

        $menuRepo->shouldReceive('countItem')->andReturn(1);
        $menuRepo->shouldReceive('deleteItem')->andReturn();
        $menuRepo->shouldReceive('removeHierarchy')->andReturn();

        $routeHandler->shouldReceive('remove')->andReturn();

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $dummyMenuType = m::mock('alias:Theme', 'Xpressengine\Menu\MenuType\MenuTypeInterface',
            [
                'isRouteAble' => true
            ]
        );

        $testItem =
            new MenuItem(
                [
                    'id' => 'testItem',
                    'type' => 'testType'
                ]
            );

        $testChildItem = new MenuItem(['id' => 'testChild', 'parentId' => 'testItem']);

        $testItem->addChild($testChildItem);

        $dummyMenuType->shouldReceive('deleteMenu')->andReturn();

        $typeHandler->shouldReceive('getModuleObject')->andReturn($dummyMenuType);
        $typeHandler->shouldReceive('updateMenu')->andReturn(0);

        $menuHandler->removeItem($testItem);
    }

    /**
     * testMoveItem
     *
     * @return void
     */
    public function testMoveItem()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $menuItem = new MenuItem(
            [
                'parentId' => 'main',
                'ordering' => 1,
            ]
        );

        $menuRepo->shouldReceive('unlinkHierarchy')->andReturn(1);
        $menuRepo->shouldReceive('linkHierarchy')->andReturn();
        $menuRepo->shouldReceive('updateItem')->andReturn();
        $menuRepo->shouldReceive('findItem')->andReturn($menuItem);
        $menuRepo->shouldReceive('countMenu')->andReturn(0);

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $movedItem = $menuHandler->moveItem($menuItem, 'notice');

        $this->assertEquals('notice', $movedItem->parentId);
        $this->assertEquals('1', $movedItem->ordering);
    }

    /**
     * testMoveItemNewMenuId
     *
     * @return void
     */
    public function testMoveItemNewMenuId()
    {
        $menuRepo = $this->menuRepository;
        $typeHandler = $this->typeHandler;
        $routeHandler = $this->routeHandler;
        $cacheHandler = $this->cacheHandler;

        $menuItem = new MenuItem(
            [
                'parentId' => 'main',
                'ordering' => 1,
            ]
        );

        $menuRepo->shouldReceive('unlinkHierarchy')->andReturn(1);
        $menuRepo->shouldReceive('linkHierarchy')->andReturn();
        $menuRepo->shouldReceive('updateItem')->andReturn();
        $menuRepo->shouldReceive('findItem')->andReturn($menuItem);
        $menuRepo->shouldReceive('countMenu')->andReturn(1);

        $menuHandler = new MenuAlterHandler($menuRepo, $typeHandler, $routeHandler, $cacheHandler);

        $movedItem = $menuHandler->moveItem($menuItem, 'notice');

        $this->assertEquals('notice', $movedItem->parentId);
        $this->assertEquals('1', $movedItem->ordering);
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
        $routeHandlerMock = m::mock('Xpressengine\Routing\InstanceRouteHandler');
        $cacheHandler = m::mock('Xpressengine\Menu\MenuCacheHandler');

        $cacheHandler->shouldReceive('deleteCachedMenu')->andReturn();
        $cacheHandler->shouldReceive('deleteCachedMenuItem')->andReturn();

        $this->menuRepository = $repositoryMock;
        $this->typeHandler = $typeHandlerMock;
        $this->routeHandler = $routeHandlerMock;
        $this->cacheHandler = $cacheHandler;
    }
}

