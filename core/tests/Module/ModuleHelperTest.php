<?php
/**
 * ModuleHelperTest class
 *
 * @category  Test
 * @package   Xpressengine\Tests\Module
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\Tests\Module;

use Illuminate\Container\Container;
use PHPUnit_Framework_TestCase;
use Mockery as m;

/**
 * ModuleHelperTest
 *
 * @category Module
 * @package  Xpressengine\Module
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class ModuleHelperTest extends PHPUnit_Framework_TestCase
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
     * testFullModuleId
     *
     * @return void
     */
    public function testFullModuleId()
    {
        $fullModuleId1 = fullModuleId('module/xpressengine@test1');
        $fullModuleId2 = fullModuleId('xpressengine@test2');

        $this->assertEquals('module/xpressengine@test1', $fullModuleId1);
        $this->assertEquals('module/xpressengine@test2', $fullModuleId2);
    }

    /**
     * testShortModuleId
     *
     * @return void
     */
    public function testShortModuleId()
    {
        $shortModule1 = shortModuleId('module/xpressengine@test1');
        $this->assertEquals('xpressengine@test1', $shortModule1);
    }

    public function testMenuTypeClass()
    {
        $moduleHandlerMock = m::mock('Xpressengine\Module\ModuleHandler');
        $containerMock = m::mock('Illuminate\Contracts\Container\Container');
        $moduleHandlerMock->shouldReceive('getModuleClassName')->andReturn('testModuleClass');
        $containerMock->shouldReceive('make')->andReturn($moduleHandlerMock);

        Container::setInstance($containerMock);

        $menuTypeClassName = moduleClass('xpressengine@test1');
        $this->assertEquals('testModuleClass', $menuTypeClassName);
    }

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {

    }
}
