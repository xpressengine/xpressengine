<?php
/**
 * MenuConfigTest
 *
 * @category  Test
 * @package   Xpressengine\Tests\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\Tests\Menu;

use PHPUnit_Framework_TestCase;
use Xpressengine\Routing\InstanceConfig;

/**
 * Class MenuConfigTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * testMenuConfig
     *
     * @return void
     */
    public function testMenuConfig()
    {
        /**
         * @var InstanceConfig $instanceConfig;
         */
        $instanceConfig = InstanceConfig::instance();

        $instanceConfig->setInstanceId('testInstance');
        $instanceConfig->setTheme('bootstrapTheme');
        $instanceConfig->setUrl('test');
        $instanceConfig->setModule('xpressengine@test');

        $this->assertEquals('testInstance', $instanceConfig->getInstanceId());
        $this->assertEquals('bootstrapTheme', $instanceConfig->getTheme());
        $this->assertEquals('test', $instanceConfig->getUrl());
        $this->assertEquals('xpressengine@test', $instanceConfig->getModule());
    }
}
