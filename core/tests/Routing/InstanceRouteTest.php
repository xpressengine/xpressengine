<?php namespace Xpressengine\Tests\Routing;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\Routing\InstanceRoute;

/**
 * Class InstanceRouteTest
 *
 * @package Xpressengine\Tests\Routing
 */
class InstanceRouteTest extends PHPUnit_Framework_TestCase
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
