<?php
/**
 * ModuleHandlerTest.php
 *
 * PHP version 5
 *
 * @category    Test
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Tests\Module;

use Mockery as m;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Xpressengine\Menu\MenuType\MenuTypeInterface;
use Xpressengine\Module\ModuleHandler;
use Xpressengine\tests\Menu\FakeMenuTypeClass;

/**
 * Class ModuleHandlerTest
 *
 * @category Module
 * @package  Xpressengine\Module
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class ModuleHandlerTest extends PHPUnit_Framework_TestCase
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
        $register = $this->register;
        $register->shouldReceive('get')->andReturn([MenuTypeInterface::class]);

        $moduleHandler = new ModuleHandler($register);

        $modules = $moduleHandler->getAll();

        $this->assertEquals([MenuTypeInterface::class], $modules);

    }

    /**
     * testGetAllModuleInfo
     *
     * @return void
     */
    public function testGetAllModuleInfo()
    {

        $register = $this->register;
        $register->shouldReceive('get')->andReturn([FakeMenuTypeClass::class]);
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
        $register = $this->register;
        $register->shouldReceive('get')->andReturn(FakeMenuTypeClass::class);
        $moduleHandler = new ModuleHandler($register);

        $moduleClassName = $moduleHandler->getModuleClassName('module/xpressengine@test');

        $this->assertEquals(FakeMenuTypeClass::class, $moduleClassName);
    }

    /**
     * testGetModuleObject
     *
     * @return void
     */
    public function testGetModuleObject()
    {
        $register = $this->register;
        $register->shouldReceive('get')->andReturn(FakeMenuTypeClass::class);
        $moduleHandler = new ModuleHandler($register);

        $moduleObj = $moduleHandler->getModuleObject('module/xpressengine@test');

        $result = $moduleObj instanceof FakeMenuTypeClass;

        $this->assertEquals(true, $result);
    }

    /**
     * testGetModuleObjectThrowException
     *
     * @return void
     */
    public function testGetModuleObjectThrowException()
    {
        $this->setExpectedException('\XpressEngine\Module\Exceptions\NotFoundModuleException');

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
