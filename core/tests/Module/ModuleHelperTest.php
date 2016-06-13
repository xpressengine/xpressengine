<?php
/**
 * ModuleHelperTest class
 *
 * PHP version 5
 *
 * @category  Test
 * @package   Xpressengine\Tests\Module
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
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
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
