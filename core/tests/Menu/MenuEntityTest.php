<?php
/**
 * MenuEntityTest
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
use Xpressengine\Support\Tree\TreeCollection;

/**
 * Class MenuEntityTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuEntityTest extends PHPUnit_Framework_TestCase
{
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
     * testMenu
     *
     * @return void
     */
    public function testMenu()
    {
        $treeCollection = $this->getTreeCollection();

        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $this->assertEquals('main', $menu->id);
        $this->assertEquals('기본메뉴', $menu->title);
        $this->assertEquals('기본메뉴입니다.', $menu->description);

    }

    /**
     * testMenuCountItem
     *
     * @return void
     */
    public function testMenuCountItem()
    {
        $treeCollection = $this->getTreeCollection();

        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $countItem = $menu->countItem();

        $this->assertEquals(4, $countItem);
    }

    /**
     * testGetItems
     *
     * @return void
     */
    public function testGetItems()
    {
        $treeCollection = $this->getTreeCollection();

        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $items = $menu->getItems();

        $this->assertEquals(3, count($items));
    }

    /**
     * testGetItem
     *
     * @return void
     */
    public function testGetItem()
    {
        $treeCollection = $this->getTreeCollection();

        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $item = $menu->getItem('notice');

        $this->assertEquals('notice', $item->id);
    }

    /**
     * testGetItemThrowException
     *
     * @return void
     */
    public function testGetItemThrowException()
    {
        $this->setExpectedException('\XpressEngine\Menu\Exceptions\NotFoundMenuItemException');

        $treeCollection = $this->getTreeCollection();

        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $menu->getItem('not_in_item_id');
    }

    /**
     * testMenuGetItems
     *
     * @return void
     */
    public function testHasItem()
    {
        $treeCollection = $this->getTreeCollection();

        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $resultTrue = $menu->hasItem('notice');
        $resultFalse = $menu->hasItem('sssss');

        $this->assertEquals(true, $resultTrue);
        $this->assertEquals(false, $resultFalse);
    }

    /**
     * testSetItemSelected
     *
     * @return void
     */
    public function testSetItemSelected()
    {
        $treeCollection = $this->getTreeCollection();

        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $menu->setItemSelected('notice');
    }

    /**
     * testCheckPermission
     *
     * @return void
     */
    public function testCheckPermission()
    {
        $permissionMock = m::mock('Xpressengine\Menu\Permission\MenuPermission');

        $userMock = m::mock('Xpressengine\Member\Entities\MemberEntityInterface');

        $treeCollection = $this->getTreeCollection();

        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $permissionMock->shouldReceive('setUser')->andReturn();
        $permissionMock->shouldReceive('ables')->andReturn(true);

        $menu->applyPermission(
            [
                'main' => $permissionMock,
                'main.aboutUs' => $permissionMock,
                'main.notice' => $permissionMock,
                'main.freeboard.test' => $permissionMock,
                'main.freeboard' => $permissionMock,
            ]
        );

        $accessCheckResult = $menu->checkAccessPermission($userMock);
        $visibleCheckResult = $menu->checkVisiblePermission($userMock);

        $this->assertEquals(true, $accessCheckResult);
        $this->assertEquals(true, $visibleCheckResult);
    }

    /**
     * testJsonSerialize
     *
     * @return void
     */
    public function testJsonSerialize()
    {
        $treeCollection = $this->getTreeCollection();

        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $jsonResult = json_encode($menu);

        $this->assertEquals(
            '{"id":"main","title":"\uae30\ubcf8\uba54\ub274","description":"\uae30\ubcf8\uba54\ub274\uc785\ub2c8\ub2e4.","items":{"aboutUs":{"id":"aboutUs","menuId":"main","parentId":"main","title":" \uc18c\uac1c","url":"aboutUs","description":"ddd","target":"_self","type":"pluginB@page","ordering":0,"activated":1,"options":"","items":[]},"freeboard":{"id":"freeboard","menuId":"main","parentId":"main","title":"\uc790\uc720\uac8c\uc2dc\ud310","url":"freeboard","description":"\uc790\uac8c\uc785\ub2c8\ub2e4.","target":"_self","type":"pluginA@board","ordering":0,"activated":1,"options":"","items":{"test":{"id":"test","menuId":"main","parentId":"freeboard","title":"test","url":"test","description":"test","target":"_self","type":"pluginB@widgetPage","ordering":0,"activated":1,"options":"","items":[]}}},"notice":{"id":"notice","menuId":"main","parentId":"main","title":"\uacf5\uc9c0 \uac8c\uc2dc\ud310","url":"notice","description":"\uacf5\uc9c0\uc0ac\ud56d \uac8c\uc2dc\ud310\uc785\ub2c8\ub2e4.","target":"_self","type":"pluginA@board","ordering":1,"activated":1,"options":"","items":[]}},"entity":"menu","itemCount":4}',
            $jsonResult
        );
    }

    /**
     * testMenuGetRawItems
     *
     * @return void
     */
    public function testMenuGetRawItems()
    {
        $treeCollection = $this->getTreeCollection();

        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $items = $menu->getRawItems();

        $this->assertEquals(4, count($items));
    }

    /**
     * testMenuGetItem
     *
     * @return void
     */
    public function testMenuGetItem()
    {
        $treeCollection = $this->getTreeCollection();

        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $freeboardItem = $menu->getItem('freeboard');

        $this->assertEquals('freeboard', $freeboardItem->id);
        $this->assertEquals('main', $freeboardItem->parentId);
        $this->assertEquals(0, $freeboardItem->ordering);
        $this->assertEquals(true, $freeboardItem->activated);
        $this->assertEquals('pluginA@board', $freeboardItem->type);
        $this->assertEquals('자유게시판', $freeboardItem->title);
        $this->assertEquals('자게입니다.', $freeboardItem->description);
        $this->assertEquals('freeboard', $freeboardItem->url);
    }

    /**
     * testMenuSelected
     *
     * @return void
     */
    public function testMenuSelected()
    {
        $treeCollection = $this->getTreeCollection();


        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

        $menu->setSelected(true);

        $this->assertEquals(true, $menu->isSelected());
    }

    /**
     * testMenuAddItem
     *
     * @return void
     */
    public function testMenuAddItem()
    {
        $treeCollection = $this->getTreeCollection();


        $menu = new MenuEntity([
            'id' => 'main',
            'title' => '기본메뉴',
            'description' => '기본메뉴입니다.'
        ], $treeCollection);

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

        $menu->addItem($menuItem);

        $foundItem = $menu->getItem('qna');

        $this->assertEquals('qna', $foundItem->id);
        $this->assertEquals('main', $foundItem->parentId);
        $this->assertEquals(1, $foundItem->ordering);
        $this->assertEquals(true, $foundItem->activated);
        $this->assertEquals('pluginA@board', $foundItem->type);
        $this->assertEquals('Q & A', $foundItem->title);
        $this->assertEquals('질답 게시판입니다.', $foundItem->description);
        $this->assertEquals('qna', $foundItem->url);

    }


    /**
     * getTreeCollection
     *
     * @return TreeCollection
     */
    private function getTreeCollection()
    {
        $treeRows = [
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
                "description" => "자게입니다.",
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
        ];

        $nodes = [];
        foreach ($treeRows as $row) {
            $node = new MenuItem(array_diff_key($row, array_flip(['depth', 'breadcrumbs'])));
            $node->setdepth($row['depth']);
            $node->setBreadcrumbs(explode(',', $row['breadcrumbs']));
            $nodes[$node->id] = $node;
        }

        return new TreeCollection($nodes);
    }
}
