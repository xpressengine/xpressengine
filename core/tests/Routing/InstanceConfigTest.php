<?php
/**
 * InstanceConfigTest
 *
 * PHP version 5
 *
 * @category    Test
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tests\Routing;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Routing\InstanceConfig;

/**
 * Class InstanceRouteTest
 *
 * @package Xpressengine\Tests\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class InstanceConfigTest extends TestCase
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
