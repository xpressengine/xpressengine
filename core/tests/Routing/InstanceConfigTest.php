<?php
/**
 * InstanceConfigTest
 *
 * PHP version 5
 *
 * @category    Test
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Tests\Routing;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\Routing\InstanceConfig;

/**
 * Class InstanceRouteTest
 *
 * @package Xpressengine\Tests\Routing
 */
class InstanceConfigTest extends PHPUnit_Framework_TestCase
{

    /**
     * testInstanceConfig
     *
     * @return void
     */
    public function testInstanceConfig()
    {
        /**
         * @var InstanceConfig $instanceConfig
         */
        $instanceConfig = InstanceConfig::instance();

        $instanceConfig->setInstanceId('test');
        $instanceConfig->setModule('module/xpressengine@board');
        $instanceConfig->setTheme('defaultTheme');
        $instanceConfig->setUrl('freeboard');

        $this->assertEquals('freeboard', $instanceConfig->getUrl());
        $this->assertEquals('module/xpressengine@board', $instanceConfig->getModule());
        $this->assertEquals('test', $instanceConfig->getInstanceId());
        $this->assertEquals('defaultTheme', $instanceConfig->getTheme());
    }
}
