<?php
/**
 * MenuCacheHandlerTest
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

namespace Xpressengine\tests\Menu;

use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Menu\MenuCacheHandler;
use Xpressengine\Menu\MenuEntity;
use Xpressengine\Menu\MenuItem;
use Xpressengine\Menu\MenuType\MenuTypeInterface;
use Xpressengine\Module\ModuleHandler;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Support\Tree\TreeCollection;

/**
 * Class MenuCacheHandlerTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuCacheHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockInterface $register
     */
    protected $cache;

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
     * testIsExistCachedMenu
     *
     * @return void
     */
    public function testIsExistCachedMenu()
    {
        $cache = $this->cache;
        $cache->shouldReceive('has')->andReturn(true);
        $menuCacheHandler = new MenuCacheHandler($cache, false);
        $exist = $menuCacheHandler->isExistCachedMenu('testMenuId');
        $this->assertEquals(true, $exist);
    }

    /**
     * testIsExistCachedMenuDebugTrue
     *
     * @return void
     */
    public function testIsExistCachedMenuDebugTrue()
    {
        $cache = $this->cache;
        $cache->shouldReceive('has')->andReturn(true);
        $menuCacheHandler = new MenuCacheHandler($cache, true);
        $exist = $menuCacheHandler->isExistCachedMenu('testMenuId');
        $this->assertEquals(false, $exist);
    }

    /**
     * testIsExistCachedMenu
     *
     * @return void
     */
    public function testGetCachedMenu()
    {
        $cache = $this->cache;

        $cache->shouldReceive('has')->andReturn(true);

        $dummyMenu = new MenuEntity(
            ['id' => 'testMenu', 'title' => 'testTitle1', 'description' => 'testDescription'],
            new TreeCollection(
                [new MenuItem(['id' => 'testMenuItem1'])]
            )
        );
        $cache->shouldReceive('get')->andReturn(serialize($dummyMenu));
        $menuCacheHandler = new MenuCacheHandler($cache, false);
        $menu = $menuCacheHandler->getCachedMenu('testMenuId');
        $this->assertEquals('testMenu', $menu->id);
    }

    /**
     * testGetCachedMenuThrowException
     *
     * @return void
     */
    public function testGetCachedMenuThrowException()
    {
        $this->setExpectedException('\XpressEngine\Menu\Exceptions\NotFoundMenuException');
        $cache = $this->cache;
        $cache->shouldReceive('has')->andReturn(false);
        $menuCacheHandler = new MenuCacheHandler($cache, false);
        $menuCacheHandler->getCachedMenu('testMenuId');
    }

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $cacheMock = m::mock('Illuminate\Cache\Repository');

        $this->cache = $cacheMock;
    }
}
