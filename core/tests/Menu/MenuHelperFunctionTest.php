<?php
/**
 * MenuHelperFunctionTest class
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

use Illuminate\Container\Container;
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Routing\InstanceConfig;

/**
 * MenuHelperFunctionTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuHelperFunctionTest extends PHPUnit_Framework_TestCase
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

    public function testGetCurrentInstanceId()
    {
        /**
         * @var InstanceConfig $instanceConfig
         */
        $instanceConfig = InstanceConfig::instance();
        $instanceConfig->setInstanceId('testInstanceId');

        $instanceId = getCurrentInstanceId();

        $this->assertEquals('testInstanceId', $instanceId);
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
