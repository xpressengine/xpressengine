<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Routing;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Routing\InstanceRoute;

/**
 * Class InstanceRouteTest
 *
 * @package Xpressengine\Tests\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class InstanceRouteTest extends TestCase
{

    /**
     * testInstanceRoute
     *
     * @return void
     */
    public function testInstanceRoute()
    {
        $instanceRoute = new InstanceRoute(
            [
                'instanceId' => 'board',
                'module' => 'module/xpressengine@board',
                'url' => 'freeboard',
                'menuId' => 'basic',
                'site' => 'default'
            ]
        );

        $this->assertEquals('freeboard', $instanceRoute->url);
        $this->assertEquals('module/xpressengine@board', $instanceRoute->module);
        $this->assertEquals('board', $instanceRoute->instanceId);
        $this->assertEquals('basic', $instanceRoute->menuId);
        $this->assertEquals('default', $instanceRoute->site);
    }
}
