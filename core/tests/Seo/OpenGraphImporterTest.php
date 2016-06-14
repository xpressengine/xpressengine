<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Seo;

use Mockery as m;
use Xpressengine\Seo\Importers\OpenGraphImporter;

class OpenGraphImporterTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testExec()
    {
        list($frontend, $urlRoot) = $this->getMocks();
        $instance = new OpenGraphImporter($frontend, $urlRoot);


        $frontend->shouldReceive('meta')->andReturnSelf();
        $frontend->shouldReceive('property')->once()->with('og:type')->andReturnSelf();
        $frontend->shouldReceive('content')->once()->with('article')->andReturnSelf();

        $frontend->shouldReceive('property')->once()->with('og:url')->andReturnSelf();
        $frontend->shouldReceive('content')->once()->with('http://domain.com/path/name')->andReturnSelf();

        $frontend->shouldReceive('property')->once()->with('og:site_name')->andReturnSelf();
        $frontend->shouldReceive('content')->once()->with('site name')->andReturnSelf();

        $frontend->shouldReceive('property')->once()->with('og:title')->andReturnSelf();
        $frontend->shouldReceive('content')->once()->with('site title')->andReturnSelf();

        $frontend->shouldReceive('load');


        $instance->exec([
            'type' => 'article',
            'url' => 'http://domain.com/path/name',
            'siteName' => 'site name',
            'title' => 'site title'
        ]);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Presenter\Html\FrontendHandler'),
            m::mock('Illuminate\Http\Request')
        ];
    }
}
