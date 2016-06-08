<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\ToggleMenu;

use Mockery as m;
use Xpressengine\ToggleMenu\ItemInterface;
use Xpressengine\ToggleMenu\ToggleMenuHandler;

class ToggleMenuHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetItems()
    {
        list($register, $cfg) = $this->getMocks();
        $instance = new ToggleMenuHandler($register, $cfg);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')
            ->once()
            ->with('activate', [])
            ->andReturn(['someTypemenu/xe@somemenu1', 'someTypemenu/xe@somemenu2']);

        $cfg->shouldReceive('get')->once()->with('toggleMenu@someType')->andReturnNull();
        $cfg->shouldReceive('set')->once()->with('toggleMenu@someType', []);

        $cfg->shouldReceive('get')->once()->with('toggleMenu@someType.someInstance')->andReturnNull();
        $cfg->shouldReceive('set')
            ->once()
            ->with('toggleMenu@someType.someInstance', ['activate' => []])
            ->andReturn($mockConfig);

        $register->shouldReceive('get')->once()->andReturn([
            'someTypemenu/xe@somemenu1' => ItemClass::class,
            'someTypemenu/xe@somemenu2' => ItemClass::class,
            'someTypemenu/xe@somemenu3' => ItemClass::class,
        ]);

        $items = $instance->getItems('someType', 'someInstance');

        $this->assertEquals(2, count($items));
    }

    public function testGetItemsThrowsExceptionWhenNotInstanceOfItemInterface()
    {
        list($register, $cfg) = $this->getMocks();
        $instance = new ToggleMenuHandler($register, $cfg);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')
            ->once()
            ->with('activate', [])
            ->andReturn(['someTypemenu/xe@somemenu1', 'someTypemenu/xe@somemenu2']);

        $cfg->shouldReceive('get')->once()->with('toggleMenu@someType')->andReturnNull();
        $cfg->shouldReceive('set')->once()->with('toggleMenu@someType', []);

        $cfg->shouldReceive('get')->once()->with('toggleMenu@someType.someInstance')->andReturnNull();
        $cfg->shouldReceive('set')
            ->once()
            ->with('toggleMenu@someType.someInstance', ['activate' => []])
            ->andReturn($mockConfig);

        $register->shouldReceive('get')->once()->andReturn([
            'someTypemenu/xe@somemenu1' => ItemClass::class,
            'someTypemenu/xe@somemenu2' => NonItemClass::class,
            'someTypemenu/xe@somemenu3' => ItemClass::class,
        ]);

        try {
            $instance->getItems('someType', 'someInstance');

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\ToggleMenu\Exceptions\WrongInstanceException', $e);
        }
    }

    public function testGetDeactivated()
    {
        list($register, $cfg) = $this->getMocks();
        $instance = new ToggleMenuHandler($register, $cfg);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')
            ->once()
            ->with('activate', [])
            ->andReturn(['someTypemenu/xe@somemenu1', 'someTypemenu/xe@somemenu2']);

        $cfg->shouldReceive('get')->once()->with('toggleMenu@someType')->andReturnNull();
        $cfg->shouldReceive('set')->once()->with('toggleMenu@someType', []);

        $cfg->shouldReceive('get')->once()->with('toggleMenu@someType.someInstance')->andReturnNull();
        $cfg->shouldReceive('set')
            ->once()
            ->with('toggleMenu@someType.someInstance', ['activate' => []])
            ->andReturn($mockConfig);

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
            m::mock('Xpressengine\Config\ConfigManager')
        ];
    }
}

class ItemClass implements ItemInterface
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

    public function getIcon()
    {

    }
}

class NonItemClass
{

}
