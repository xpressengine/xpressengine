<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Seo;

use Mockery as m;
use Xpressengine\Seo\Importers\OpenGraphImporter;

class OpenGraphImporterTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testExec()
    {
        list($frontend, $urlRoot, $urlGenerator) = $this->getMocks();
        $instance = new OpenGraphImporter($frontend, $urlRoot);
        OpenGraphImporter::setUrlGenerator($urlGenerator);

        $urlGenerator->shouldReceive('to')->once()->with('http://domain.com/path/name')
            ->andReturn('http://domain.com/path/name');

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
            m::mock('Illuminate\Http\Request'),
            m::mock('Illuminate\Contracts\Routing\UrlGenerator'),
        ];
    }
}
