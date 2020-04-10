<?php
/**
 * MenuHelperFunctionTest class
 *
 * PHP version 5
 *
 * @category  Test
 * @package   Xpressengine\Tests\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Menu;

use Illuminate\Container\Container;
use PHPUnit\Framework\TestCase;
use Mockery as m;
use Xpressengine\Routing\InstanceConfig;

/**
 * MenuHelperFunctionTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MenuHelperFunctionTest extends TestCase
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

        $instanceId = current_instance_id();

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
