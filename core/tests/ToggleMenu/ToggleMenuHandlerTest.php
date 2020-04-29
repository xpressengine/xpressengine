<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\ToggleMenu;

use Mockery as m;
use Xpressengine\ToggleMenu\AbstractToggleMenu;
use Xpressengine\ToggleMenu\ToggleMenuHandler;

class ToggleMenuHandlerTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetItems()
    {
        list($register, $cfg, $container) = $this->getMocks();
        $instance = new ToggleMenuHandler($register, $cfg, $container);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')
            ->once()
            ->with('activate', [])
            ->andReturn(['someTypemenu/xe@somemenu1', 'someTypemenu/xe@somemenu2']);

        $cfg->shouldReceive('getOrNew')->once()->with('toggleMenu@someType.someInstance')->andReturn($mockConfig);

        $register->shouldReceive('get')->once()->andReturn([
            'someTypemenu/xe@somemenu1' => ItemClass::class,
            'someTypemenu/xe@somemenu2' => ItemClass::class,
            'someTypemenu/xe@somemenu3' => ItemClass::class,
        ]);

        $container->shouldReceive('make')->times(2)->with(ItemClass::class)->andReturn(new ItemClass());

        $items = $instance->getItems('someType', 'someInstance');

        $this->assertEquals(2, count($items));
    }

    public function testGetItemsThrowsExceptionWhenNotInstanceOfAbstractToggleMenu()
    {
        list($register, $cfg, $container) = $this->getMocks();
        $instance = new ToggleMenuHandler($register, $cfg, $container);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')
            ->once()
            ->with('activate', [])
            ->andReturn(['someTypemenu/xe@somemenu1', 'someTypemenu/xe@somemenu2']);

        $cfg->shouldReceive('getOrNew')->once()->with('toggleMenu@someType.someInstance')->andReturn($mockConfig);

        $register->shouldReceive('get')->once()->andReturn([
            'someTypemenu/xe@somemenu1' => ItemClass::class,
            'someTypemenu/xe@somemenu2' => NonItemClass::class,
            'someTypemenu/xe@somemenu3' => ItemClass::class,
        ]);

        $container->shouldReceive('make')->once()->with(ItemClass::class)->andReturn(new ItemClass());
        $container->shouldReceive('make')->once()->with(NonItemClass::class)->andReturn(new NonItemClass());

        try {
            $instance->getItems('someType', 'someInstance');

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\ToggleMenu\Exceptions\WrongInstanceException', $e);
        }
    }

    public function testGetDeactivated()
    {
        list($register, $cfg, $container) = $this->getMocks();
        $instance = new ToggleMenuHandler($register, $cfg, $container);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')
            ->once()
            ->with('activate', [])
            ->andReturn(['someTypemenu/xe@somemenu1', 'someTypemenu/xe@somemenu2']);

        $cfg->shouldReceive('getOrNew')->once()->with('toggleMenu@someType.someInstance')->andReturn($mockConfig);

        $register->shouldReceive('get')->twice()->andReturn([
            'someTypemenu/xe@somemenu1' => ItemClass::class,
            'someTypemenu/xe@somemenu2' => ItemClass::class,
            'someTypemenu/xe@somemenu3' => ItemClass::class,
        ]);

        $deactivated = $instance->getDeactivated('someType', 'someInstance');
        $keys = array_keys($deactivated);

        $this->assertEquals('someTypemenu/xe@somemenu3', current($keys));
    }

    public function getMocks()
    {
        return [
            m::mock('Xpressengine\Plugin\PluginRegister'),
            m::mock('Xpressengine\Config\ConfigManager'),
            m::mock('Illuminate\Contracts\Container\Container'),
        ];
    }
}

class ItemClass extends AbstractToggleMenu
{
    public static function getName()
    {

    }

    public static function getDescription()
    {

    }

    public function getText()
    {

    }

    public function getType()
    {

    }

    public function getAction()
    {

    }

    public function getScript()
    {

    }
}

class NonItemClass
{

}
