<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Menu;

use Mockery as m;
use Xpressengine\Menu\MenuHandler;

class MenuHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testCreate()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = new MenuHandler($repo, $configs, $modules,  $routes);


        $mockMenu = m::mock('Xpressengine\Menu\Models\Menu');
        $mockMenu->shouldReceive('fill')->once()->with([
            'title' => 'test title',
            'description' => 'test description'
        ]);
        $repo->shouldReceive('createModel')->andReturn($mockMenu);
        $repo->shouldReceive('insert')->with($mockMenu)->andReturn($mockMenu);

        $menu = $instance->create([
            'title' => 'test title',
            'description' => 'test description'
        ]);
    }

    public function testPut()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = new MenuHandler($repo, $configs, $modules,  $routes);

        $mockMenu = m::mock('Xpressengine\Menu\Models\Menu');
        $repo->shouldReceive('update')->with($mockMenu)->andReturn($mockMenu);

        $instance->put($mockMenu);
    }

    public function testRemove()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['deleteMenuTheme'], [$repo, $configs, $modules,  $routes]);

        $collection = m::mock('stdClass');
        $collection->shouldReceive('count')->andReturn(0);

        $mockMenu = m::mock('Xpressengine\Menu\Models\Menu');
        $mockMenu->shouldReceive('getAttribute')->with('items')->andReturn($collection);

        $instance->expects($this->once())->method('deleteMenuTheme');

        $repo->shouldReceive('delete')->with($mockMenu)->andReturn(true);

        $instance->remove($mockMenu);
    }

    public function testRemoveThrowsExceptionWhenHasItem()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['deleteMenuTheme'], [$repo, $configs, $modules,  $routes]);

        $collection = m::mock('stdClass');
        $collection->shouldReceive('count')->andReturn(1);

        $mockMenu = m::mock('Xpressengine\Menu\Models\Menu');
        $mockMenu->shouldReceive('getAttribute')->with('items')->andReturn($collection);

        try {
            $instance->remove($mockMenu);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Menu\Exceptions\CanNotDeleteMenuEntityHaveChildException', $e);
        }
    }

    public function testCreateItem()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(
            MenuHandler::class,
            ['setHierarchy', 'setOrder', 'storeMenuType'],
            [$repo, $configs, $modules,  $routes]
        );

        $mockMenu = m::mock('Xpressengine\Menu\Models\Menu')->shouldAllowMockingProtectedMethods();
        $mockMenu->shouldReceive('getKey')->andReturn('menuKey');

        $mockMenuItem = m::mock('Xpressengine\Menu\Models\MenuItem');
        $mockMenuItem->shouldReceive('fill')->with([
            'parentId' => 'pid',
            'title' => 'test title',
            'url' => 'test_url',
            'ordering' => 1,
        ]);
        $mockMenuItem->shouldReceive('getAggregatorKeyName')->andReturn('menuId');
        $mockMenuItem->shouldReceive('setAttribute')->once()->with('menuId', 'menuKey');

        $repo->shouldReceive('createItemModel')->with($mockMenu)->andReturn($mockMenuItem);
        $repo->shouldReceive('insertItem')->once()->with($mockMenuItem)->andReturn($mockMenuItem);

        $instance->expects($this->once())->method('setHierarchy')->with($mockMenuItem);
        $instance->expects($this->once())->method('setOrder')->with($mockMenuItem);
        $instance->expects($this->once())->method('storeMenuType')->with($mockMenuItem, ['foo' => 'var']);

        $item = $instance->createItem($mockMenu, [
            'parentId' => 'pid',
            'title' => 'test title',
            'url' => 'test_url',
            'ordering' => 1,
        ], ['foo' => 'var']);

        $this->assertInstanceOf('Xpressengine\Menu\Models\MenuItem', $item);
    }

    public function testPutItem()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(
            MenuHandler::class,
            ['updateMenuType'],
            [$repo, $configs, $modules,  $routes]
        );

        $mockMenuItem = m::mock('Xpressengine\Menu\Models\MenuItem');
        $mockMenuItem->shouldReceive('isDirty')->once()->with('parentId')->andReturn(true);
        $mockMenuItem->shouldReceive('getParentIdName')->andReturn('parentId');
        $mockMenuItem->shouldReceive('getOriginal')->with('parentId')->andReturn('1');
        $mockMenuItem->shouldReceive('setAttribute')->once()->with('parentId', '1');

        $repo->shouldReceive('updateItem')->once()->with($mockMenuItem)->andReturn($mockMenuItem);

        $instance->expects($this->once())->method('updateMenuType')->with($mockMenuItem, ['foo' => 'var']);

        $instance->putItem($mockMenuItem, ['foo' => 'var']);
    }

    public function testRemoveItem()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(
            MenuHandler::class,
            ['destroyMenuType'],
            [$repo, $configs, $modules,  $routes]
        );

        $mockMenuItem = m::mock('Xpressengine\Menu\Models\MenuItem');
        $mockMenuItem->shouldReceive('getDescendantCount')->andReturn(0);

        $mockRelate = m::mock('stdClass');
        $mockRelate->shouldReceive('detach')->once();

        $mockMenuItem->shouldReceive('ancestors')->once()->with(false)->andReturn($mockRelate);
        $repo->shouldReceive('deleteItem')->once()->with($mockMenuItem)->andReturn(true);

        $instance->expects($this->once())->method('destroyMenuType')->with($mockMenuItem);

        $instance->removeItem($mockMenuItem);
    }

    public function testRemoveItemThrowsExceptionWhenHasItem()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = new MenuHandler($repo, $configs, $modules,  $routes);

        $mockMenuItem = m::mock('Xpressengine\Menu\Models\MenuItem');
        $mockMenuItem->shouldReceive('getDescendantCount')->andReturn(1);

        try {
            $instance->removeItem($mockMenuItem);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Menu\Exceptions\CanNotDeleteMenuItemHaveChildException', $e);
        }
    }

    public function testSetOrder()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = new MenuHandler($repo, $configs, $modules,  $routes);

        $collection = m::mock('stdClass');
        $collection->shouldReceive('filter')->andReturn($collection);

        $mockMenuItemParent = m::mock('Xpressengine\Menu\Models\MenuItem');
        $mockMenuItemParent->shouldReceive('getChildren')->andReturn($collection);

        $mockMenuItem = m::mock('Xpressengine\Menu\Models\MenuItem');
        $mockMenuItem->shouldReceive('getParent')->andReturn($mockMenuItemParent);

        $collection->shouldReceive('slice')->once()->with(0, 1)->andReturnSelf();
        $collection->shouldReceive('merge')->once()->with([$mockMenuItem])->andReturnSelf();
        $collection->shouldReceive('slice')->once()->with(1)->andReturnSelf();
        $collection->shouldReceive('merge')->once()->with($collection)->andReturnSelf();

        $collection->shouldReceive('each')->once();


        $instance->setOrder($mockMenuItem, 1);
    }

    public function testMoveItem()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['unlinkHierarchy', 'linkHierarchy'], [$repo, $configs, $modules,  $routes]);

        $mockMenu = m::mock('Xpressengine\Menu\Models\Menu');
        $mockMenu->shouldReceive('getKey')->andReturn('menuKey');

        $mockMenuItem = m::mock('Xpressengine\Menu\Models\MenuItem');
        $mockMenuItem->shouldReceive('getParentIdName')->andReturn('parentId');
        $mockMenuItem->shouldReceive('getAttribute')->with('parentId')->andReturn('pid');
        $mockMenuItem->shouldReceive('getKey')->andReturn('itemKey');
        $mockMenuItem->shouldReceive('getAttribute')->with('menu')->andReturn($mockMenu);
        $mockMenuItem->shouldReceive('getAggregatorKeyName')->andReturn('menuId');
        $mockMenuItem->shouldReceive('setRelation')->with('menu', $mockMenu);

        $mockMenuItemNewParent = m::mock('Xpressengine\Menu\Models\MenuItem');
        $mockMenuItemNewParent->shouldReceive('getAttribute')->with('menu')->andReturn($mockMenu);
        $mockMenuItemNewParent->shouldReceive('getKey')->andReturn('pnid');

        $mockMenuItem->shouldReceive('setAttribute')->with('parentId', 'pnid');

        $mockMenuItemOldParent = m::mock('Xpressengine\Menu\Models\MenuItem');

        $repo->shouldReceive('findItem')->once()->with('pid')->andReturn($mockMenuItemOldParent);
        $instance->expects($this->once())->method('unlinkHierarchy')->with($mockMenuItem, $mockMenuItemOldParent);

        $mockMenuItem->shouldReceive('setAttribute')->with('parentId', null);

        $instance->expects($this->once())->method('linkHierarchy')->with($mockMenuItem, $mockMenuItemNewParent);

        $repo->shouldReceive('update')->once();

        $mockMenuItem->shouldReceive('setAttribute')->with('menuId', 'menuKey');
        $repo->shouldReceive('updateItem')->once()->with($mockMenuItem)->andReturn($mockMenuItem);
        
        $repo->shouldReceive('findItem')->once()->with('itemKey')->andReturn($mockMenuItem);

        $instance->moveItem($mockMenu, $mockMenuItem, $mockMenuItemNewParent);
    }

    public function testSetMenuTheme()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['menuKeyString'], [$repo, $configs, $modules,  $routes]);

        $mockMenu = m::mock('Xpressengine\Menu\Models\Menu');
        $mockMenu->shouldReceive('getKey')->andReturn('menuKey');

        $instance->expects($this->once())->method('menuKeyString')->with('menuKey')->willReturn('configMenuKey');

        $configs->shouldReceive('add')->once()->with('configMenuKey', [
            'desktopTheme' => 'theme1',
            'mobileTheme' => 'theme2'
        ]);

        $instance->setMenuTheme($mockMenu, 'theme1', 'theme2');
    }

    public function testGetMenuTheme()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['menuKeyString'], [$repo, $configs, $modules,  $routes]);

        $mockMenu = m::mock('Xpressengine\Menu\Models\Menu');
        $mockMenu->shouldReceive('getKey')->andReturn('menuKey');

        $instance->expects($this->once())->method('menuKeyString')->with('menuKey')->willReturn('configMenuKey');

        $configs->shouldReceive('get')->once()->with('configMenuKey')->andReturn('config');

        $config = $instance->getMenuTheme($mockMenu);

        $this->assertEquals('config', $config);
    }

    public function testUpdateMenuTheme()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['menuKeyString'], [$repo, $configs, $modules,  $routes]);

        $mockMenu = m::mock('Xpressengine\Menu\Models\Menu');
        $mockMenu->shouldReceive('getKey')->andReturn('menuKey');

        $instance->expects($this->once())->method('menuKeyString')->with('menuKey')->willReturn('configMenuKey');

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('set')->once()->with('desktopTheme', 'theme1');
        $mockConfig->shouldReceive('set')->once()->with('mobileTheme', 'theme2');

        $configs->shouldReceive('get')->once()->with('configMenuKey')->andReturn($mockConfig);

        $configs->shouldReceive('modify')->once()->with($mockConfig);

        $instance->updateMenuTheme($mockMenu, 'theme1', 'theme2');
    }

    public function testDeleteMenuTheme()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['menuKeyString'], [$repo, $configs, $modules,  $routes]);

        $mockMenu = m::mock('Xpressengine\Menu\Models\Menu');
        $mockMenu->shouldReceive('getKey')->andReturn('menuKey');

        $instance->expects($this->once())->method('menuKeyString')->with('menuKey')->willReturn('configMenuKey');

        $configs->shouldReceive('removeByName')->once()->with('configMenuKey');

        $instance->deleteMenuTheme($mockMenu);
    }

    public function testSetMenuItemTheme()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['menuKeyString'], [$repo, $configs, $modules,  $routes]);

        $mockMenuItem = m::mock('Xpressengine\Menu\Models\MenuItem');

        $instance->expects($this->once())->method('menuKeyString')->with($mockMenuItem)->willReturn('configMenuItemKey');

        $configs->shouldReceive('add')->once()->with('configMenuItemKey', [
            'desktopTheme' => 'theme1',
            'mobileTheme' => 'theme2'
        ]);

        $instance->setMenuItemTheme($mockMenuItem, 'theme1', 'theme2');
    }

    public function testGetMenuItemTheme()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['menuKeyString'], [$repo, $configs, $modules,  $routes]);

        $mockMenuItem = m::mock('Xpressengine\Menu\Models\MenuItem');

        $instance->expects($this->once())->method('menuKeyString')->with($mockMenuItem)->willReturn('configMenuItemKey');

        $configs->shouldReceive('get')->once()->with('configMenuItemKey')->andReturn('config');

        $config = $instance->getMenuItemTheme($mockMenuItem);

        $this->assertEquals('config', $config);
    }

    public function testUpdateMenuItemTheme()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['menuKeyString'], [$repo, $configs, $modules,  $routes]);

        $mockMenuItem = m::mock('Xpressengine\Menu\Models\MenuItem');

        $instance->expects($this->once())->method('menuKeyString')->with($mockMenuItem)->willReturn('configMenuItemKey');

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('set')->once()->with('desktopTheme', 'theme1');
        $mockConfig->shouldReceive('set')->once()->with('mobileTheme', 'theme2');

        $configs->shouldReceive('get')->once()->with('configMenuItemKey')->andReturn($mockConfig);

        $configs->shouldReceive('modify')->once()->with($mockConfig);

        $instance->updateMenuItemTheme($mockMenuItem, 'theme1', 'theme2');
    }

    public function testDeleteMenuItemTheme()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['menuKeyString'], [$repo, $configs, $modules,  $routes]);

        $mockMenuItem = m::mock('Xpressengine\Menu\Models\MenuItem');

        $instance->expects($this->once())->method('menuKeyString')->with($mockMenuItem)->willReturn('configMenuItemKey');

        $configs->shouldReceive('removeByName')->once()->with('configMenuItemKey');

        $instance->deleteMenuItemTheme($mockMenuItem);
    }

    public function testMoveItemConfig()
    {
        list($repo, $configs, $modules,  $routes) = $this->getMocks();
        $instance = $this->getMock(MenuHandler::class, ['menuKeyString'], [$repo, $configs, $modules,  $routes]);

        $mockBefore = m::mock('Xpressengine\Menu\Models\MenuItem');
        $mockAfter = m::mock('Xpressengine\Menu\Models\MenuItem');

        $map = [
            [$mockBefore, 'configBeforeKey'],
            [$mockAfter, 'configAfter.Key']
        ];

        $instance->expects($this->any())->method('menuKeyString')->will($this->returnValueMap($map));

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');

        $configs->shouldReceive('get')->once()->with('configBeforeKey')->andReturn($mockConfig);
        $configs->shouldReceive('move')->once()->with($mockConfig, 'configAfter');

        $instance->moveItemConfig($mockBefore, $mockAfter);
    }

    private function invokedMethod($object, $methodName, $parameters = [])
    {
        $rfc = new \ReflectionClass($object);
        $method = $rfc->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Menu\MenuRepository'),
            m::mock('Xpressengine\Config\ConfigManager'),
            m::mock('Xpressengine\Menu\ModuleHandler'),
            m::mock('Xpressengine\Routing\RouteRepository')
        ];
    }
}
