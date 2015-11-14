<?php
/**
 * MenuPermissionHandlerTest
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
use Xpressengine\Menu\MenuEntity;
use Xpressengine\Menu\MenuItem;
use Xpressengine\Menu\MenuPermissionHandler;
use Xpressengine\Permission\Action;
use Xpressengine\Permission\Grant;
use Xpressengine\Support\Tree\TreeCollection;

/**
 * Class MenuPermissionHandlerTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuPermissionHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockInterface
     */
    protected $permissionFactory;
    /**
     * @var MockInterface
     */
    protected $groupRepoMock;
    /**
     * @var MockInterface
     */
    protected $memberRepoMock;

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
     * testGetDefaultAccessPermission
     *
     * @return void
     */
    public function testGetDefaultMenuPermission()
    {
        $permissionHandler = new MenuPermissionHandler(
            $this->permissionFactory,
            $this->groupRepoMock,
            $this->memberRepoMock
        );

        $grant = $permissionHandler->getDefaultMenuPermission();

        $accessKey = Action::ACCESS;
        $visibleKey = Action::VISIBLE;
        $accessGrant = $grant->$accessKey;
        $visibleGrant = $grant->$visibleKey;

        $this->assertEquals('guest', $accessGrant['rating']);
        $this->assertEquals([], $accessGrant['group']);
        $this->assertEquals([], $accessGrant['user']);
        $this->assertEquals([], $accessGrant['except']);

        $this->assertEquals('guest', $visibleGrant['rating']);
        $this->assertEquals([], $visibleGrant['group']);
        $this->assertEquals([], $visibleGrant['user']);
        $this->assertEquals([], $visibleGrant['except']);


    }

    /**
     * testGetMenuAccessPermission
     *
     * @return void
     */
    public function testGetMenuAccessPermission()
    {
        $permissionFactory = $this->permissionFactory;
        $permissionFactory->shouldReceive('findRegistered')->andReturn($permissionFactory);
        $permissionFactory->shouldReceive('offsetGet')->andReturn([
            'rating' => 'test rating grant',
            'group' => 'test group grant',
            'user' => 'test user grant',
            'except' => 'test except grant',
        ]);

        $groupRepo = $this->groupRepoMock;
        $memberRepo = $this->memberRepoMock;

        $groupRepo->shouldReceive('findAll')->with('test group grant')->andReturn('test group grant');
        $memberRepo->shouldReceive('findAll')->with('test user grant')->andReturn('test user grant');
        $memberRepo->shouldReceive('findAll')->with('test except grant')->andReturn('test except grant');

        $permissionHandler = new MenuPermissionHandler($permissionFactory, $groupRepo, $memberRepo);

        $menu = $this->getSampleMenuEntity();

        $permission = $permissionHandler->getMenuAccessPermission($menu);

        $this->assertEquals([
            'rating' => 'test rating grant',
            'group' => 'test group grant',
            'user' => 'test user grant',
            'except' => 'test except grant',
        ], $permission);

    }

    /**
     * testGetMenuVisiblePermission
     *
     * @return void
     */
    public function testGetMenuVisiblePermission()
    {
        $permissionFactory = $this->permissionFactory;
        $permissionFactory->shouldReceive('findRegistered')->andReturn($permissionFactory);
        $permissionFactory->shouldReceive('offsetGet')->andReturn([
            'rating' => 'test rating grant',
            'group' => 'test group grant',
            'user' => 'test user grant',
            'except' => 'test except grant',
        ]);

        $groupRepo = $this->groupRepoMock;
        $memberRepo = $this->memberRepoMock;

        $groupRepo->shouldReceive('findAll')->with('test group grant')->andReturn('test group grant');
        $memberRepo->shouldReceive('findAll')->with('test user grant')->andReturn('test user grant');
        $memberRepo->shouldReceive('findAll')->with('test except grant')->andReturn('test except grant');

        $permissionHandler = new MenuPermissionHandler($permissionFactory, $groupRepo, $memberRepo);

        $menu = $this->getSampleMenuEntity();

        $permission = $permissionHandler->getMenuVisiblePermission($menu);

        $this->assertEquals([
            'rating' => 'test rating grant',
            'group' => 'test group grant',
            'user' => 'test user grant',
            'except' => 'test except grant',
        ], $permission);

    }

    /**
     * testRegisterMenuAccessPermission
     *
     * @return void
     */
    public function testRegisterMenuPermission()
    {
        $permissionFactory = $this->permissionFactory;
        $permissionFactory->shouldReceive('register')->andReturn();

        $permissionHandler = new MenuPermissionHandler($permissionFactory, $this->groupRepoMock, $this->memberRepoMock);

        $menu = $this->getSampleMenuEntity();
        $grant = $this->getSampleGrant();

        $permissionHandler->registerMenuPermission($menu, $grant);

    }


    /**
     * testDeleteMenuPermission
     *
     * @return void
     */
    public function testDeleteMenuPermission()
    {
        $permissionFactory = $this->permissionFactory;
        $permissionFactory->shouldReceive('removeRegistered')->andReturn();
        // MenuEntity $menu
        $permissionHandler = new MenuPermissionHandler(
            $this->permissionFactory,
            $this->groupRepoMock,
            $this->memberRepoMock
        );

        $menu = $this->getSampleMenuEntity();

        $permissionHandler->deleteMenuPermission($menu);
    }

    /**
     * testGetItemAccessPermission
     *
     * @return void
     */
    public function testGetItemAccessPermission()
    {
        $permissionFactory = $this->permissionFactory;
        $permissionFactory->shouldReceive('findRegistered')->andReturn($permissionFactory);

        $permissionFactory->shouldReceive('pure')->andReturn(null);
        $permissionFactory->shouldReceive('offsetGet')->andReturn([
            'rating' => 'manager',
            'group' => [],
            'user' => [],
            'except' => [],
        ]);

        $groupRepo = $this->groupRepoMock;
        $memberRepo = $this->memberRepoMock;

        $groupRepo->shouldReceive('findAll')->andReturn([]);
        $memberRepo->shouldReceive('findAll')->andReturn([]);
        $memberRepo->shouldReceive('findAll')->andReturn([]);

        $permissionHandler = new MenuPermissionHandler($permissionFactory, $groupRepo, $memberRepo);

        $item = $this->getSampleMenuItem();


        $itemAccessPermission = $permissionHandler->getItemAccessPermission($item);

        $this->assertEquals('inherit', $itemAccessPermission['mode']);
        $this->assertEquals('manager', $itemAccessPermission['rating']);
        $this->assertEquals([], $itemAccessPermission['group']);
        $this->assertEquals([], $itemAccessPermission['user']);
        $this->assertEquals([], $itemAccessPermission['except']);

    }

    /**
     * testRegisterItemPermission
     *
     * @return void
     */
    public function testRegisterItemPermission()
    {
        $samplGrant = $this->getSampleGrant();
        $sampleItem = $this->getSampleMenuItem();

        $permissionFactory = $this->permissionFactory;
        $permissionFactory->shouldReceive('register')->andReturn(true);

        $permissionHandler = new MenuPermissionHandler($permissionFactory, $this->groupRepoMock, $this->memberRepoMock);

        $result = $permissionHandler->registerItemPermission($sampleItem, $samplGrant);

        $this->assertEquals(true, $result);
    }

    /**
     * testDeleteItemAccessPermission
     *
     * @return void
     */
    public function testDeleteItemAccessPermission()
    {
        $permissionFactory = $this->permissionFactory;
        $permissionFactory->shouldReceive('removeRegistered')->andReturn();
        // MenuItem $item
        $sampleItem = $this->getSampleMenuItem();

        $permissionHandler = new MenuPermissionHandler(
            $this->permissionFactory,
            $this->groupRepoMock,
            $this->memberRepoMock
        );

        $permissionHandler->deleteItemPermission($sampleItem);

    }

    /**
     * testGetItemVisiblePermission
     *
     * @return void
     */
    public function testGetItemVisiblePermission()
    {
        // MenuItem $item
        $sampleItem = $this->getSampleMenuItem();

        $permissionFactory = $this->permissionFactory;
        $permissionFactory->shouldReceive('findRegistered')->andReturn($permissionFactory);
        $permissionFactory->shouldReceive('pure')->andReturn(null);

        $permissionFactory->shouldReceive('offsetGet')->andReturn([
            'rating' => 'test rating',
            'group' => 'test group',
            'user' => 'test user',
            'except' => 'test except',
        ]);

        $permissionHandler = new MenuPermissionHandler($permissionFactory, $this->groupRepoMock, $this->memberRepoMock);

        $visiblePermission = $permissionHandler->getItemVisiblePermission($sampleItem);

        $this->assertEquals('inherit', $visiblePermission['mode']);
        $this->assertEquals('test rating', $visiblePermission['rating']);
        $this->assertEquals('test group', $visiblePermission['group']);
        $this->assertEquals('test user', $visiblePermission['user']);
        $this->assertEquals('test except', $visiblePermission['except']);

    }

    /**
     * testCreateAccessGrant
     *
     * @return void
     */
    public function testCreateAccessGrant()
    {
        $permissionHandler = new MenuPermissionHandler(
            $this->permissionFactory,
            $this->groupRepoMock,
            $this->memberRepoMock
        );

        $inputs = [
            'accessRating' => 'manager',
            'accessGroup' => '',
            'accessUser' => 'user1,user2,user3',
            'accessExcept' => 'user4'
        ];

        $grant = $permissionHandler->createAccessGrant($inputs);

        $key = Action::ACCESS;
        $visibleGrant = $grant->$key;

        $this->assertEquals('manager', $visibleGrant['rating']);
        $this->assertEquals([], $visibleGrant['group']);
        $this->assertEquals(['user1', 'user2', 'user3'], $visibleGrant['user']);
        $this->assertEquals(['user4'], $visibleGrant['except']);

    }

    /**
     * testCreateVisibleGrant
     *
     * @return void
     */
    public function testCreateVisibleGrant()
    {
        $permissionHandler = new MenuPermissionHandler(
            $this->permissionFactory,
            $this->groupRepoMock,
            $this->memberRepoMock
        );

        $inputs = [
            'visibleRating' => 'manager',
            'visibleGroup' => '',
            'visibleUser' => 'user1,user2,user3',
            'visibleExcept' => 'user4'
        ];

        $grant = $permissionHandler->createVisibleGrant($inputs);

        $key = Action::VISIBLE;
        $visibleGrant = $grant->$key;

        $this->assertEquals('manager', $visibleGrant['rating']);
        $this->assertEquals([], $visibleGrant['group']);
        $this->assertEquals(['user1', 'user2', 'user3'], $visibleGrant['user']);
        $this->assertEquals(['user4'], $visibleGrant['except']);

    }

    /**
     * testCreateAccessGrantInherit
     *
     * @return void
     */
    public function testCreateAccessGrantInherit()
    {
        $permissionHandler = new MenuPermissionHandler(
            $this->permissionFactory,
            $this->groupRepoMock,
            $this->memberRepoMock
        );

        $inputs = [
            'accessMode' => 'inherit',
            'accessRating' => 'super',
            'accessGroup' => [],
            'accessUser' => 'user1,user2,user3',
            'accessExcept' => 'user4'
        ];

        $grant = $permissionHandler->createAccessGrant($inputs);

        $key = Action::ACCESS;
        $visibleGrant = $grant->$key;

        $this->assertEquals(null, $visibleGrant['rating']);
        $this->assertEquals(null, $visibleGrant['group']);
        $this->assertEquals(null, $visibleGrant['user']);
        $this->assertEquals(null, $visibleGrant['except']);
    }

    /**
     * testCreateVisibleGrantInherit
     *
     * @return void
     */
    public function testCreateVisibleGrantInherit()
    {
        $permissionHandler = new MenuPermissionHandler(
            $this->permissionFactory,
            $this->groupRepoMock,
            $this->memberRepoMock
        );

        $inputs = [
            'visibleMode' => 'inherit',
            'visibleRating' => 'super',
            'visibleGroup' => [],
            'visibleUser' => 'user1,user2,user3',
            'visibleExcept' => 'user4'
        ];

        $grant = $permissionHandler->createVisibleGrant($inputs);

        $key = Action::VISIBLE;
        $visibleGrant = $grant->$key;

        $this->assertEquals(null, $visibleGrant['rating']);
        $this->assertEquals(null, $visibleGrant['group']);
        $this->assertEquals(null, $visibleGrant['user']);
        $this->assertEquals(null, $visibleGrant['except']);
    }

    /**
     * testMoveItemPermission
     *
     * @return void
     */
    public function testMoveItemPermission()
    {
        $originItem = $this->getSampleMenuItem();
        $movedItem = new MenuItem(
            [
                'id' => 'testboard',
                'parentId' => 'freeboard',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => 'Test 게시판',
                'description' => '테스트 게시판입니다.',
                'url' => 'testboard'
            ]
        );

        $movedItem->setBreadCrumbs(['basic', 'board', 'freeboard']);

        $registered = m::mock('Xpressengine\Permission\Registered');

        $permissionFactory = $this->permissionFactory;
        $permissionFactory->shouldReceive('findRegistered')->andReturn($registered);
        $permissionFactory->shouldReceive('move')->andReturn();

        $permissionHandler = new MenuPermissionHandler($permissionFactory, $this->groupRepoMock, $this->memberRepoMock);

        $permissionHandler->moveItemPermission($originItem, $movedItem);

    }

    /**
     * testGetMenuPermissions
     *
     * @return void
     */
    public function testGetMenuPermissions()
    {
        $permissionHandler = new MenuPermissionHandler(
            $this->permissionFactory,
            $this->groupRepoMock,
            $this->memberRepoMock
        );

        $this->permissionFactory->shouldReceive('makesByType')->andReturn([]);

        $permissions = $permissionHandler->getMenuPermissions();

        $this->assertEquals([], $permissions);
    }

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $permissionFactoryMock = m::mock('Xpressengine\Permission\Factory');
        $groupRepoMock = m::mock('Xpressengine\Member\Repositories\GroupRepositoryInterface');
        $memberRepoMock = m::mock('Xpressengine\Member\Repositories\MemberRepositoryInterface');

        $this->permissionFactory = $permissionFactoryMock;
        $this->groupRepoMock = $groupRepoMock;
        $this->memberRepoMock = $memberRepoMock;
    }

    /**
     * getSampleMenuEntity
     *
     * @return MenuEntity
     */
    protected function getSampleMenuEntity()
    {
        $menu = new MenuEntity(
            ['id' => 'testMenu', 'title' => 'testTitle', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenu'])]
            ),
            new Collection()
        );

        return $menu;
    }

    /**
     * getSampleMenuItem
     *
     * @return MenuItem
     */
    protected function getSampleMenuItem()
    {
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

        return $menuItem;
    }

    /**
     * getSampleGrant
     *
     * @return Grant
     */
    protected function getSampleGrant()
    {
        $grant = new Grant();
        $grant->add(Action::ACCESS, 'manager');
        $grant->add(Action::ACCESS, 'group', []);
        $grant->add(Action::ACCESS, 'user', []);
        $grant->add(Action::ACCESS, 'except', []);

        return $grant;
    }
}
