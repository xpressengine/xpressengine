<?php
/**
 * MenuRepositoryTest
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
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Menu\MenuEntity;
use Xpressengine\Menu\MenuItem;
use Xpressengine\Menu\DBMenuRepository;
use Xpressengine\Support\Tree\TreeCollection;

/**
 * Class MenuRepositoryTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    const MENU_TABLE = 'menu';
    /**
     *
     */
    const MENU_ITEM_TABLE = 'menuItem';
    /**
     *
     */
    const MENU_TREE_PATH_TABLE = 'menuTreePath';
    /**
     *
     */
    const CANNOT_REMOVE_MENU = 'basic';

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
     * Get Menu 테스트
     *
     * @return void
     * @throws \Xpressengine\Menu\Exceptions\NotFoundMenuItemException
     */
    public function testFindMenu()
    {
        $conn = $this->getConnectionMock();
        $keygen = $this->getKeygenMock();

        $repoInstance = new DBMenuRepository($conn, $keygen);
        $menuTableQuery = $this->getQueryBuilderMock();
        $nodeTableQuery = $this->getQueryBuilderMock();

        $conn->shouldReceive('table')->with(self::MENU_TABLE)->andReturn($menuTableQuery);
        $menuTableQuery->shouldReceive('where')->withAnyArgs()->andReturn($menuTableQuery);
        $menuTableQuery->shouldReceive('first')->withAnyArgs()->andReturn(
            [
                'id' => 'main',
                'title' => '기본메뉴',
                'description' => '기본메뉴입니다.'
            ]
        );

        $conn->shouldReceive('table')->with(self::MENU_ITEM_TABLE . ' as t')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('selectRaw')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('join')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('where')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('where')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('groupBy')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('orderBy')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('get')->withAnyArgs()->andReturn(
            new Collection(
                [
                    0 => [
                        "id" => "aboutUs",
                        "menuId" => "main",
                        "parentId" => "main",
                        "title" => " 소개",
                        "url" => "aboutUs",
                        "description" => "ddd",
                        "target" => "_self",
                        "type" => "pluginB@page",
                        "ordering" => 0,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 1,
                        "breadcrumbs" => "main,aboutUs",
                    ],
                    1 => [
                        "id" => "freeboard",
                        "menuId" => "main",
                        "parentId" => "main",
                        "title" => "자유게시판",
                        "url" => "freeboard",
                        "description" => "",
                        "target" => "_self",
                        "type" => "pluginA@board",
                        "ordering" => 0,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 1,
                        "breadcrumbs" => "main,freeboard",
                    ],
                    2 => [
                        "id" => "test",
                        "menuId" => "main",
                        "parentId" => "freeboard",
                        "title" => "test",
                        "url" => "test",
                        "description" => "test",
                        "target" => "_self",
                        "type" => "pluginB@widgetPage",
                        "ordering" => 0,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 2,
                        "breadcrumbs" => "main,freeboard,test",
                    ],
                    3 => [
                        "id" => "notice",
                        "menuId" => "main",
                        "parentId" => "main",
                        "title" => "공지 게시판",
                        "url" => "notice",
                        "description" => "공지사항 게시판입니다.",
                        "target" => "_self",
                        "type" => "pluginA@board",
                        "ordering" => 1,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 1,
                        "breadcrumbs" => "main,notice",
                    ]
                ]
            )
        );

        $menuInstance = $repoInstance->findMenu('main');

        $this->assertEquals('main', $menuInstance->id);
        $this->assertEquals('기본메뉴', $menuInstance->title);
        $this->assertEquals('기본메뉴입니다.', $menuInstance->description);

        $noticeItem = $menuInstance->getItem('notice');

        $this->assertEquals('notice', $noticeItem->id);
        $this->assertEquals('main', $noticeItem->parentId);
        $this->assertEquals(1, $noticeItem->ordering);
        $this->assertEquals(true, $noticeItem->activated);
        $this->assertEquals('pluginA@board', $noticeItem->type);
        $this->assertEquals('공지사항 게시판입니다.', $noticeItem->description);
        $this->assertEquals('notice', $noticeItem->url);

    }

    /**
     * Find Menu 테스트
     *
     * @return void
     * @throws \Xpressengine\Menu\Exceptions\NotFoundMenuItemException
     */
    public function testFindMenuException()
    {
        $this->setExpectedException('Xpressengine\Menu\Exceptions\NotFoundMenuException');
        $conn = $this->getConnectionMock();
        $keygen = $this->getKeygenMock();

        $repoInstance = new DBMenuRepository($conn, $keygen);
        $menuTableQuery = $this->getQueryBuilderMock();

        $conn->shouldReceive('table')->with(self::MENU_TABLE)->andReturn($menuTableQuery);
        $menuTableQuery->shouldReceive('where')->withAnyArgs()->andReturn($menuTableQuery);
        $menuTableQuery->shouldReceive('first')->withAnyArgs()->andReturn(null);

        $repoInstance->findMenu('main');

    }

    /**
     * testFindMenuByItemId
     *
     * @return void
     */
    public function testFindMenuByItemId()
    {
        $conn = $this->getConnectionMock();
        $keygen = $this->getKeygenMock();

        $repoInstance = new DBMenuRepository($conn, $keygen);
        $menuTableQuery = $this->getQueryBuilderMock();
        $itemTableQuery = $this->getQueryBuilderMock();
        $nodeTableQuery = $this->getQueryBuilderMock();

        $conn->shouldReceive('table')->with(self::MENU_TABLE)->andReturn($menuTableQuery);
        $menuTableQuery->shouldReceive('where')->withAnyArgs()->andReturn($menuTableQuery);
        $menuTableQuery->shouldReceive('first')->withAnyArgs()->andReturn(
            [
                'id' => 'main',
                'title' => '기본메뉴',
                'description' => '기본메뉴입니다.'
            ]
        );

        $conn->shouldReceive('table')->with(self::MENU_ITEM_TABLE . ' as t')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('selectRaw')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('join')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('where')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('where')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('groupBy')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('orderBy')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('get')->withAnyArgs()->andReturn(
            new Collection(
                [
                    0 => [
                        "id" => "aboutUs",
                        "menuId" => "main",
                        "parentId" => "main",
                        "title" => " 소개",
                        "url" => "aboutUs",
                        "description" => "ddd",
                        "target" => "_self",
                        "type" => "pluginB@page",
                        "ordering" => 0,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 1,
                        "breadcrumbs" => "main,aboutUs",
                    ],
                    1 => [
                        "id" => "freeboard",
                        "menuId" => "main",
                        "parentId" => "main",
                        "title" => "자유게시판",
                        "url" => "freeboard",
                        "description" => "",
                        "target" => "_self",
                        "type" => "pluginA@board",
                        "ordering" => 0,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 1,
                        "breadcrumbs" => "main,freeboard",
                    ],
                    2 => [
                        "id" => "test",
                        "menuId" => "main",
                        "parentId" => "freeboard",
                        "title" => "test",
                        "url" => "test",
                        "description" => "test",
                        "target" => "_self",
                        "type" => "pluginB@widgetPage",
                        "ordering" => 0,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 2,
                        "breadcrumbs" => "main,freeboard,test",
                    ],
                    3 => [
                        "id" => "notice",
                        "menuId" => "main",
                        "parentId" => "main",
                        "title" => "공지 게시판",
                        "url" => "notice",
                        "description" => "공지사항 게시판입니다.",
                        "target" => "_self",
                        "type" => "pluginA@board",
                        "ordering" => 1,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 1,
                        "breadcrumbs" => "main,notice",
                    ]
                ]
            )
        );

        $conn->shouldReceive('table')->with(self::MENU_ITEM_TABLE)->andReturn($itemTableQuery);
        $itemTableQuery->shouldReceive('where')->andReturn($itemTableQuery);
        $itemTableQuery->shouldReceive('select')->andReturn($itemTableQuery);
        $itemTableQuery->shouldReceive('first')->andReturn(['menuId' => 'main']);

        $conn->shouldReceive('table')->with(self::MENU_TREE_PATH_TABLE)->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('where')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('orderBy')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('select')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('first')->andReturn(['ancestor' => 'main']);

        $menuInstance = $repoInstance->findMenuByItem('notice');

        $this->assertEquals('main', $menuInstance->id);
        $this->assertEquals('기본메뉴', $menuInstance->title);
        $this->assertEquals('기본메뉴입니다.', $menuInstance->description);

        $noticeItem = $menuInstance->getItem('notice');

        $this->assertEquals('notice', $noticeItem->id);
        $this->assertEquals('main', $noticeItem->parentId);
        $this->assertEquals(1, $noticeItem->ordering);
        $this->assertEquals(true, $noticeItem->activated);
        $this->assertEquals('pluginA@board', $noticeItem->type);
        $this->assertEquals('공지사항 게시판입니다.', $noticeItem->description);
        $this->assertEquals('notice', $noticeItem->url);

    }

    /**
     * testFindAllMenuIds
     *
     * @return void
     */
    public function testFindAllMenuIds()
    {
        $conn = $this->getConnectionMock();
        $keygen = $this->getKeygenMock();

        $repoInstance = new DBMenuRepository($conn, $keygen);

        $query = $this->getQueryBuilderMock();

        $siteKey = 'default';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('get')->andReturn(
            [
                ['id' => 'main'],
                ['id' => 'bottom'],
                ['id' => 'side']
            ]
        );

        $menuIds = $repoInstance->findAllMenuIds($siteKey);

        $this->assertEquals(['main', 'bottom', 'side'], $menuIds);

    }

    /**
     * testGetMenuIdByItem
     *
     * @return void
     */
    public function testGetMenuIdByItem()
    {
        $conn = $this->getConnectionMock();
        $keygen = $this->getKeygenMock();
        $nodeTableQuery = $this->getQueryBuilderMock();

        $conn->shouldReceive('table')->with(self::MENU_TREE_PATH_TABLE)->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('where')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('orderBy')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('select')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('first')->andReturn(['ancestor' => 'main']);

        $repoInstance = new DBMenuRepository($conn, $keygen);

        $menuId = $repoInstance->getMenuIdByItem('notice');

        $this->assertEquals('main', $menuId);
    }

    /**
     * testGetMenuIdByItemException
     *
     * @return void
     */
    public function testGetMenuIdByItemException()
    {
        $this->setExpectedException('Xpressengine\Menu\Exceptions\NotFoundMenuException');

        $conn = $this->getConnectionMock();
        $keygen = $this->getKeygenMock();

        $nodeTableQuery = $this->getQueryBuilderMock();

        $conn->shouldReceive('table')->with(self::MENU_TREE_PATH_TABLE)->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('where')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('orderBy')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('select')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('first')->andReturn(null);

        $menuRepo = new DBMenuRepository($conn, $keygen);

        $menuRepo->getMenuIdByItem('notice');
    }

    /**
     * Delete Menu 테스트
     *
     * @return void
     */
    public function testDeleteMenu()
    {
        $conn = $this->getConnectionMock();
        $keygen = $this->getKeygenMock();

        $repoInstance = new DBMenuRepository($conn, $keygen);
        $menuTableQuery = $this->getQueryBuilderMock();
        $itemTableQuery = $this->getQueryBuilderMock();
        $nodeTableQuery = $this->getQueryBuilderMock();
        $treePathQuery = $this->getQueryBuilderMock();

        $conn->shouldReceive('table')->with(self::MENU_TABLE)->andReturn($menuTableQuery);
        $menuTableQuery->shouldReceive('where')->withAnyArgs()->andReturn($menuTableQuery);
        $menuTableQuery->shouldReceive('first')->withAnyArgs()->andReturn(
            [
                'id' => 'main',
                'title' => '기본메뉴',
                'description' => '기본메뉴입니다.'
            ]
        );

        $conn->shouldReceive('table')->with(self::MENU_ITEM_TABLE . ' as t')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('selectRaw')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('join')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('where')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('where')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('groupBy')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('orderBy')->withAnyArgs()->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('get')->withAnyArgs()->andReturn(
            new Collection(
                [
                    0 => [
                        "id" => "aboutUs",
                        "menuId" => "main",
                        "parentId" => "main",
                        "title" => " 소개",
                        "url" => "aboutUs",
                        "description" => "ddd",
                        "target" => "_self",
                        "type" => "pluginB@page",
                        "ordering" => 0,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 1,
                        "breadcrumbs" => "main,aboutUs",
                    ],
                    1 => [
                        "id" => "freeboard",
                        "menuId" => "main",
                        "parentId" => "main",
                        "title" => "자유게시판",
                        "url" => "freeboard",
                        "description" => "",
                        "target" => "_self",
                        "type" => "pluginA@board",
                        "ordering" => 0,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 1,
                        "breadcrumbs" => "main,freeboard",
                    ],
                    2 => [
                        "id" => "test",
                        "menuId" => "main",
                        "parentId" => "freeboard",
                        "title" => "test",
                        "url" => "test",
                        "description" => "test",
                        "target" => "_self",
                        "type" => "pluginB@widgetPage",
                        "ordering" => 0,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 2,
                        "breadcrumbs" => "main,freeboard,test",
                    ],
                    3 => [
                        "id" => "notice",
                        "menuId" => "main",
                        "parentId" => "main",
                        "title" => "공지 게시판",
                        "url" => "notice",
                        "description" => "공지사항 게시판입니다.",
                        "target" => "_self",
                        "type" => "pluginA@board",
                        "ordering" => 1,
                        "activated" => 1,
                        "options" => "",
                        "depth" => 1,
                        "breadcrumbs" => "main,notice",
                    ]
                ]
            )
        );

        $menuInstance = $repoInstance->findMenu('main');

        $conn->shouldReceive('beginTransaction')->andReturn(true);
        $conn->shouldReceive('rollBack')->andReturn(true);
        $conn->shouldReceive('commit')->andReturn(true);

        $conn->shouldReceive('table')->with(self::MENU_TREE_PATH_TABLE)->andReturn($treePathQuery);
        $treePathQuery->shouldReceive('where')->andReturn($treePathQuery);
        $treePathQuery->shouldReceive('delete')->andReturn(true);

        $conn->shouldReceive('table')->with(self::MENU_ITEM_TABLE)->andReturn($itemTableQuery);
        $itemTableQuery->shouldReceive('whereIn')->andReturn($itemTableQuery);
        $itemTableQuery->shouldReceive('delete')->andReturn(true);

        $nodeTableQuery->shouldReceive('where')->andReturn($nodeTableQuery);
        $nodeTableQuery->shouldReceive('delete')->andReturn(true);

        $menuTableQuery->shouldReceive('where')->andReturnNull($menuTableQuery);
        $menuTableQuery->shouldReceive('delete')->andReturnNull(true);

        $repoInstance->deleteMenu($menuInstance);

    }

    /**
     * Delete Menu Throw Exception 테스트
     *
     * @return void
     */
    public function testDeleteMenuThrowException()
    {
        $this->setExpectedException('\Exception');

        $conn = $this->getConnectionMock();
        $keygen = $this->getKeygenMock();

        $menuRepo = new DBMenuRepository($conn, $keygen);

        $conn->shouldReceive('beginTransaction')->andReturn();
        $conn->shouldReceive('rollback')->andReturn();
        $conn->shouldReceive('commit')->andReturn();

        $exception = new \Exception;
        $conn->shouldReceive('table')->andThrow($exception);

        $menu = new MenuEntity([], new TreeCollection([]));

        $menuRepo->deleteMenu($menu);

    }

    /**
     * testInsertMenu 테스트.
     *
     * @return void
     */
    public function testInsertMenu()
    {
        $conn = $this->getConnectionMock();
        $query = $this->getQueryBuilderMock();
        $keygen = $this->getKeygenMock();

        $repoInstance = new DBMenuRepository($conn, $keygen);

        $conn->shouldReceive('table')->with(self::MENU_TABLE)->andReturn($query);
        $query->shouldReceive('insert')->andReturn(true);
        $keygen->shouldReceive('generate')->andReturn('main');


        $menuEntity = new MenuEntity(
            ['title' => 'main title', 'description' => 'main description', 'site' => 'default'],
            new TreeCollection([])
        );

        $menu = $repoInstance->insertMenu($menuEntity);

        $this->assertEquals('main', $menu->id);
        $this->assertEquals('main title', $menu->title);
        $this->assertEquals('main description', $menu->description);

    }

    /**
     * testUpdateMenu
     *
     * @return void
     */
    public function testUpdateMenu()
    {
        $conn = $this->getConnectionMock();
        $query = $this->getQueryBuilderMock();
        $keygen = $this->getKeygenMock();

        $repoInstance = new DBMenuRepository($conn, $keygen);

        $conn->shouldReceive('table')->with(self::MENU_TABLE)->andReturn($query);
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('update')->andReturn(1);

        $menuEntity = m::mock('Xpressengine\Menu\MenuEntity');
        $menuEntity->shouldReceive('__get')->with('id')->andReturn('main');
        $menuEntity->shouldReceive('__get')->with('title')->andReturn('main');
        $menuEntity->shouldReceive('__get')->with('description')->andReturn('main');

        $affectedRow = $repoInstance->updateMenu($menuEntity);

        $this->assertEquals(1, $affectedRow);

    }

    /**
     * testInsertMenuItem
     *
     * @return void
     * @throws \Exception
     */
    public function testInsertMenuItem()
    {
        $conn = $this->getConnectionMock();
        $query = $this->getQueryBuilderMock();
        $keygen = $this->getKeygenMock();

        $conn->shouldReceive('table')->with(self::MENU_ITEM_TABLE)->andReturn($query);
        $query->shouldReceive('insert')->andReturn(true);
        $keygen->shouldReceive('generate')->andReturn('notice');

        $menuItem = new MenuItem(
            [
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => '공지사항',
                'description' => '공지사항 게시판입니다.',
                'url' => 'notice'
            ]
        );

        $menuRepository = new DBMenuRepository($conn, $keygen);
        $insertedItem = $menuRepository->insertItem($menuItem);

        $this->assertEquals('notice', $insertedItem->id);
        $this->assertEquals('main', $insertedItem->parentId);
        $this->assertEquals(1, $insertedItem->ordering);
        $this->assertEquals(true, $insertedItem->activated);
        $this->assertEquals('pluginA@board', $insertedItem->type);
        $this->assertEquals('공지사항', $insertedItem->title);
        $this->assertEquals('공지사항 게시판입니다.', $insertedItem->description);
        $this->assertEquals('notice', $insertedItem->url);

    }

    /**
     * testFindMenuItem
     *
     * @return void
     */
    public function testFindMenuItem()
    {
        $conn = $this->getConnectionMock();
        $query = $this->getQueryBuilderMock();
        $keygen = $this->getKeygenMock();

        $repository = new DBMenuRepository($conn, $keygen);

        $conn->shouldReceive('table')->with(self::MENU_ITEM_TABLE . ' as t')->andReturn($query);
        $query->shouldReceive('selectRaw')->andReturn($query);
        $query->shouldReceive('join')->andReturn($query);
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('groupBy')->andReturn($query);
        $query->shouldReceive('first')->andReturn(
            [
                "id" => "notice",
                "menuId" => "main",
                "parentId" => "freeboard",
                "title" => "공지사항",
                "url" => "notice",
                "description" => "공지사항입니다.",
                "target" => "_self",
                "type" => "pluginB@widgetPage",
                "ordering" => 0,
                "activated" => 1,
                "options" => "",
                "depth" => 0,
                "breadcrumbs" => "main,freeboard,test",
            ]
        );

        $menuItem = $repository->findItem('notice');

        $this->assertEquals('notice', $menuItem->id);
        $this->assertEquals('freeboard', $menuItem->parentId);
        $this->assertEquals(0, $menuItem->ordering);
        $this->assertEquals(true, $menuItem->activated);
        $this->assertEquals('pluginB@widgetPage', $menuItem->type);
        $this->assertEquals('공지사항', $menuItem->title);
        $this->assertEquals('공지사항입니다.', $menuItem->description);
        $this->assertEquals('notice', $menuItem->url);
    }

    /**
     * testFindMenuItem
     *
     * @return void
     */
    public function testFindMenuItemThrowException()
    {
        $this->setExpectedException('Xpressengine\Menu\Exceptions\NotFoundMenuItemException');

        $conn = $this->getConnectionMock();
        $query = $this->getQueryBuilderMock();
        $keygen = $this->getKeygenMock();

        $repository = new DBMenuRepository($conn, $keygen);

        $conn->shouldReceive('table')->with(self::MENU_ITEM_TABLE . ' as t')->andReturn($query);
        $query->shouldReceive('selectRaw')->andReturn($query);
        $query->shouldReceive('join')->andReturn($query);
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('groupBy')->andReturn($query);
        $query->shouldReceive('first')->andReturn(null);

        $repository->findItem('notice');

    }

    /**
     * testUpdateMenuItem
     *
     * @return void
     */
    public function testUpdateMenuItem()
    {
        $conn = $this->getConnectionMock();
        $query = $this->getQueryBuilderMock();
        $keygen = $this->getKeygenMock();

        $repoInstance = new DBMenuRepository($conn, $keygen);

        $conn->shouldReceive('table')->with(self::MENU_ITEM_TABLE)->andReturn($query);
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('update')->andReturn(1);
        $menuItem = new MenuItem(
            [
                'id' => 'notice',
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => true,
                'type' => 'pluginA@board',
                'title' => '공지사항',
                'description' => '공지사항 게시판입니다',
                'url' => 'notice'
            ]
        );

        $affectedCnt = $repoInstance->updateItem($menuItem);
        $this->assertEquals(1, $affectedCnt);

    }

    /**
     * testMenuItem
     *
     * @return void
     */
    public function testDeleteMenuItem()
    {
        $conn = $this->getConnectionMock();
        $query = $this->getQueryBuilderMock();
        $keygen = $this->getKeygenMock();

        $repoInstance = new DBMenuRepository($conn, $keygen);

        $conn->shouldReceive('table')->with(self::MENU_ITEM_TABLE)->andReturn($query);
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('delete')->andReturn(1);
        $conn->shouldReceive('beginTransaction')->andReturn();
        $conn->shouldReceive('rollBack')->andReturn();
        $conn->shouldReceive('commit')->andReturn();

        $menuItem = new MenuItem(
            [
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => '공지사항',
                'description' => '공지사항 게시판입니다.',
                'url' => 'notice'
            ]
        );

        $affectedRow = $repoInstance->deleteItem($menuItem);
        $this->assertEquals(1, $affectedRow);

    }

    /**
     * testCountMenu
     *
     * @return void
     */
    public function testCountMenu()
    {
        $conn = $this->getConnectionMock();
        $query = $this->getQueryBuilderMock();
        $keygen = $this->getKeygenMock();

        $menuRepository = new DBMenuRepository($conn, $keygen);

        $conn->shouldReceive('table')->with(self::MENU_TABLE)->andReturn($query);
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('count')->andReturn(3);

        $count = $menuRepository->countMenu('main');

        $this->assertEquals(3, $count);
    }

    /**
     * testCountMenuItem
     *
     * @return void
     */
    public function testCountMenuItem()
    {
        $conn = $this->getConnectionMock();
        $query = $this->getQueryBuilderMock();
        $keygen = $this->getKeygenMock();

        $conn->shouldReceive('table')->with(self::MENU_ITEM_TABLE)->andReturn($query);
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('count')->andReturn(1);

        $menuRepository = new DBMenuRepository($conn, $keygen);
        $count = $menuRepository->countItem('freeboard');

        $this->assertEquals(1, $count);
    }

    /**
     * getConnectionMock
     *
     * @return m\MockInterface
     */
    protected function getConnectionMock()
    {
        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $conn->shouldReceive('getTablePrefix')->andReturn('');
        return $conn;

    }

    /**
     * getQueryBuilderMock
     *
     * @return m\MockInterface
     */
    protected function getQueryBuilderMock()
    {
        $query = m::mock('Illuminate\Database\Query\Builder');
        return $query;
    }

    /**
     * getKeygenMock
     *
     * @return m\MockInterface
     */
    protected function getKeygenMock()
    {
        $keygen = m::mock('Xpressengine\Keygen\Keygen');
        return $keygen;
    }
}
