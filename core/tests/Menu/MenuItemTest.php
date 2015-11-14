<?php
/**
 * MenuItemTest
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
use Xpressengine\Menu\MenuItem;

/**
 * Class MenuItemTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuItemTest extends PHPUnit_Framework_TestCase
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
     * testMenuItem
     *
     * @return void
     */
    public function testMenuItem()
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

        $this->assertEquals('qna', $menuItem->id);
        $this->assertEquals('main', $menuItem->parentId);
        $this->assertEquals(1, $menuItem->ordering);
        $this->assertEquals(true, $menuItem->activated);
        $this->assertEquals('pluginA@board', $menuItem->type);
        $this->assertEquals('Q & A', $menuItem->title);
        $this->assertEquals('질답 게시판입니다.', $menuItem->description);
        $this->assertEquals('qna', $menuItem->url);

    }

    /**
     * testMenuParent
     *
     * @return void
     */
    public function testMenuParent()
    {
        $menuItem = new MenuItem(
            [
                'id' => 'qna',
                'parentId' => 'freeboard',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => 'Q & A',
                'description' => '질답 게시판입니다.',
                'url' => 'qna'
            ]
        );

        $parentMenuItem = new MenuItem(
            [
                'id' => 'freeboard',
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => '자유게시판',
                'description' => '자유게시판 게시판입니다.',
                'url' => 'freeboard'
            ]
        );

        $menuItem->setParent($parentMenuItem);

        $foundItem = $menuItem->getParent();

        $this->assertEquals('freeboard', $foundItem->id);
        $this->assertEquals('main', $foundItem->parentId);
        $this->assertEquals(1, $foundItem->ordering);
        $this->assertEquals(true, $foundItem->activated);
        $this->assertEquals('pluginA@board', $foundItem->type);
        $this->assertEquals('자유게시판', $foundItem->title);
        $this->assertEquals('자유게시판 게시판입니다.', $foundItem->description);
        $this->assertEquals('freeboard', $foundItem->url);

    }

    /**
     * testSetSelected
     *
     * @return void
     */
    public function testSetSelected()
    {
        $menuItem = new MenuItem(
            [
                'id' => 'qna',
                'parentId' => 'freeboard',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => 'Q & A',
                'description' => '질답 게시판입니다.',
                'url' => 'qna'
            ]
        );

        $parentMenuItem = new MenuItem(
            [
                'id' => 'freeboard',
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => '자유게시판',
                'description' => '자유게시판 게시판입니다.',
                'url' => 'freeboard'
            ]
        );

        $menuItem->setParent($parentMenuItem);

        $menuItem->setSelected(true, true);

    }

    /**
     * testSetPermission
     *
     * @return void
     */
    public function testPermission()
    {
        $menuItem = new MenuItem(
            [
                'id' => 'freeboard',
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => '자유게시판',
                'description' => '자유게시판 게시판입니다.',
                'url' => 'freeboard'
            ]
        );

        $permissionMock = m::mock('Xpressengine\Menu\Permission\MenuPermission');

        $menuItem->setPermission($permissionMock);

        $menuPermission = $menuItem->getPermission();

        $this->assertEquals($permissionMock, $menuPermission);
    }

    /**
     * testCheckPermission
     *
     * @return void
     */
    public function testCheckPermission()
    {
        $menuItem = new MenuItem(
            [
                'id' => 'freeboard',
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => '자유게시판',
                'description' => '자유게시판 게시판입니다.',
                'url' => 'freeboard'
            ]
        );

        $permissionMock = m::mock('Xpressengine\Menu\Permission\MenuPermission');
        $user = m::mock('Xpressengine\Member\Entities\MemberEntityInterface');

        $permissionMock->shouldReceive('setUser')->andReturn();
        $permissionMock->shouldReceive('ables')->andReturn(true);

        $menuItem->setPermission($permissionMock);

        $accessPermissionAble = $menuItem->checkAccessPermission($user);
        $visiblePermissionAble = $menuItem->checkVisiblePermission($user);

        $this->assertEquals(true, $accessPermissionAble);
        $this->assertEquals(true, $visiblePermissionAble);
    }

    /**
     * testMenuChild
     *
     * @return void
     */
    public function testMenuChild()
    {
        $menuItem = new MenuItem(
            [
                'id' => 'freeboard',
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => '자유게시판',
                'description' => '자유게시판 게시판입니다.',
                'url' => 'freeboard'
            ]
        );

        $childItem = new MenuItem(
            [
                'id' => 'qna',
                'parentId' => 'freeboard',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => 'Q & A',
                'description' => '질답 게시판입니다.',
                'url' => 'qna'
            ]
        );

        $menuItem->addChild($childItem);

        $this->assertEquals(true, $menuItem->hasChild());
        $this->assertEquals(1, $menuItem->countSubItems());

        $children = $menuItem->getChildren();
        /**
         * @var MenuItem $foundItem
         */
        $foundItem = $children['qna'];

        $this->assertEquals('qna', $foundItem->id);
        $this->assertEquals('freeboard', $foundItem->parentId);
        $this->assertEquals(1, $foundItem->ordering);
        $this->assertEquals(true, $foundItem->activated);
        $this->assertEquals('pluginA@board', $foundItem->type);
        $this->assertEquals('Q & A', $foundItem->title);
        $this->assertEquals('질답 게시판입니다.', $foundItem->description);
        $this->assertEquals('qna', $foundItem->url);

    }

    /**
     * testApplyPermission
     *
     * @return void
     */
    public function testApplyPermission()
    {
        $menuItem = new MenuItem(
            [
                'id' => 'freeboard',
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => '자유게시판',
                'description' => '자유게시판 게시판입니다.',
                'url' => 'freeboard'
            ]
        );

        $childItem = new MenuItem(
            [
                'id' => 'qna',
                'parentId' => 'freeboard',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => 'Q & A',
                'description' => '질답 게시판입니다.',
                'url' => 'qna'
            ]
        );

        $menuItem->addChild($childItem);

        $menuItem->setBreadCrumbs(['main', 'freeboard']);
        $childItem->setBreadCrumbs(['main', 'freeboard', 'qna']);

        $permissions = [
            'main.freeboard' => 'parentPermission',
            'main.freeboard.qna' => 'childPermission'
        ];

        $menuItem->applyPermission($permissions);

        $childPermission = $childItem->getPermission();

        $this->assertEquals('childPermission', $childPermission);

    }

    /**
     * testMenuItemSelected
     *
     * @return void
     */
    public function testMenuItemSelected()
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

        $this->assertEquals(false, $menuItem->isSelected());

        $menuItem->setSelected(true);
        $selected = $menuItem->isSelected();

        $this->assertEquals(true, $selected);
    }

    /**
     * testMenuItemDepth
     *
     * @return void
     */
    public function testMenuItemDepth()
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

        $menuItem->setDepth(3);
        $depth = $menuItem->getDepth();

        $this->assertEquals(3, $depth);
    }

    /**
     * testMenuItemBreadCrumbs
     *
     * @return void
     */
    public function testMenuItemBreadCrumbs()
    {
        $menuItem = new MenuItem(
            [
                'id' => 'qna',
                'parentId' => 'freeboard',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => 'Q & A',
                'description' => '질답 게시판입니다.',
                'url' => 'qna'
            ]
        );

        $menuItem->setBreadCrumbs(['main', 'freeboard']);
        $breadCrumbs = $menuItem->getBreadCrumbs();
        $breadCrumbsKeyString = $menuItem->getBreadCrumbsKeyString();

        $this->assertEquals(['main', 'freeboard'], $breadCrumbs);
        $this->assertEquals('main.freeboard', $breadCrumbsKeyString);
    }

    /**
     * testJsonSerialize
     *
     * @return void
     */
    public function testJsonSerialize()
    {
        $menuItem = new MenuItem(
            [
                'id' => 'freeboard',
                'parentId' => 'main',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => '자유게시판',
                'description' => '자유게시판 게시판입니다.',
                'url' => 'freeboard'
            ]
        );

        $childItem = new MenuItem(
            [
                'id' => 'qna',
                'parentId' => 'freeboard',
                'ordering' => 1,
                'activated' => 1,
                'type' => 'pluginA@board',
                'title' => 'Q & A',
                'description' => '질답 게시판입니다.',
                'url' => 'qna'
            ]
        );

        $menuItem->addChild($childItem);

        $menuItemJson = json_encode($menuItem);

        $this->assertEquals(
            '{"id":"freeboard","parentId":"main","ordering":1,"activated":1,"type":"pluginA@board","title":"\uc790\uc720\uac8c\uc2dc\ud310","description":"\uc790\uc720\uac8c\uc2dc\ud310 \uac8c\uc2dc\ud310\uc785\ub2c8\ub2e4.","url":"freeboard","items":{"qna":{"id":"qna","parentId":"freeboard","ordering":1,"activated":1,"type":"pluginA@board","title":"Q & A","description":"\uc9c8\ub2f5 \uac8c\uc2dc\ud310\uc785\ub2c8\ub2e4.","url":"qna","items":[]}}}',
            $menuItemJson
        );

    }
}
