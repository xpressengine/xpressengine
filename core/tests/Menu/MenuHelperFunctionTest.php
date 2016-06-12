<?php
/**
 * MenuHelperFunctionTest class
 *
 * PHP version 5
 *
 * @category  Test
 * @package   Xpressengine\Tests\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
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
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
