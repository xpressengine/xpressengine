<?php
/**
 * MenuConfigTest
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

use PHPUnit\Framework\TestCase;
use Xpressengine\Routing\InstanceConfig;

/**
 * Class MenuConfigTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class MenuConfigTest extends TestCase
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
