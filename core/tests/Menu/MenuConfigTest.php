<?php
/**
 * MenuConfigTest
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

use PHPUnit\Framework\TestCase;
use Xpressengine\Routing\InstanceConfig;

/**
 * Class MenuConfigTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
