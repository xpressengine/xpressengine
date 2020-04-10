<?php
/**
 * ModuleHandlerTest.php
 *
 * PHP version 5
 *
 * @category    Test
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tests\Menu;

use Mockery as m;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Xpressengine\Menu\AbstractModule;
use Xpressengine\Menu\ModuleHandler;

/**
 * Class ModuleHandlerTest
 *
 * @category Module
 * @package  Xpressengine\Module
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ModuleHandlerTest extends TestCase
{
    /**
     * @var MockInterface $register
     */
    protected $register;

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
     * testGetAll
     *
     * @return void
     */
    public function testGetAll()
    {
        $module = m::mock('\stdClass', 'Xpressengine\Menu\AbstractModule');
        $module->shouldReceive('getId')->andReturn('id');
        $module->shouldReceive('getComponentInfo')->with('name')->andReturn('title');
        $module->shouldReceive('getComponentInfo')->with('description')->andReturn('description');
        $module->shouldReceive('getComponentInfo')->with('screenshot')->andReturn('screenshot');

        $register = $this->register;
        $register->shouldReceive('get')->andReturn([$module]);

        $moduleHandler = new ModuleHandler($register);

        $modules = $moduleHandler->getAll();

        $this->assertInstanceOf(AbstractModule::class, $modules[0]);
    }

    /**
     * testGetAllModuleInfo
     *
     * @return void
     */
    public function testGetAllModuleInfo()
    {
        $module = m::mock('\stdClass');
        $module->shouldReceive('getId')->andReturn('id');
        $module->shouldReceive('getComponentInfo')->with('name')->andReturn('title');
        $module->shouldReceive('getComponentInfo')->with('description')->andReturn('description');
        $module->shouldReceive('getComponentInfo')->with('screenshot')->andReturn('screenshot');

        $register = $this->register;
        $register->shouldReceive('get')->andReturn([$module]);
        $moduleHandler = new ModuleHandler($register);

        $modules = $moduleHandler->getAllModuleInfo();

        $count = 0;
        foreach ($modules as $key => $value) {
            $count++;
        }

        $this->assertEquals(1, $count);
    }

    /**
     * testGetModuleClassName
     *
     * @return void
     */
    public function testGetModuleClassName()
    {
        $module = m::mock('\stdClass');
        $module->shouldReceive('getId')->andReturn('id');
        $module->shouldReceive('getComponentInfo')->with('name')->andReturn('title');
        $module->shouldReceive('getComponentInfo')->with('description')->andReturn('description');
        $module->shouldReceive('getComponentInfo')->with('screenshot')->andReturn('screenshot');

        $register = $this->register;
        $register->shouldReceive('get')->andReturn($module);
        $moduleHandler = new ModuleHandler($register);

        $moduleClassName = $moduleHandler->getModuleClassName('module/xpressengine@test');

        $this->assertEquals($module, $moduleClassName);
    }

    /**
     * testGetModuleObject
     *
     * @return void
     */
    public function testGetModuleObject()
    {
        $module = m::mock('\stdClass');
        $module->shouldReceive('getId')->andReturn('id');
        $module->shouldReceive('getComponentInfo')->with('name')->andReturn('title');
        $module->shouldReceive('getComponentInfo')->with('description')->andReturn('description');
        $module->shouldReceive('getComponentInfo')->with('screenshot')->andReturn('screenshot');

        $register = $this->register;
        $register->shouldReceive('get')->andReturn($module);
        $moduleHandler = new ModuleHandler($register);

        $moduleObj = $moduleHandler->getModuleObject('module/xpressengine@test');

        $result = $moduleObj instanceof \stdClass;

        $this->assertEquals(true, $result);
    }

    /**
     * testGetModuleObjectThrowException
     *
     * @return void
     *
     * @expectedException \XpressEngine\Menu\Exceptions\NotFoundModuleException
     */
    public function testGetModuleObjectThrowException()
    {
        $register = $this->register;
        $register->shouldReceive('get')->andReturn(null);
        $moduleHandler = new ModuleHandler($register);
        $moduleHandler->getModuleObject('module/xpressengine@test');
    }

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $registerMock = m::mock('Xpressengine\Plugin\PluginRegister');

        $this->register = $registerMock;
    }
}
