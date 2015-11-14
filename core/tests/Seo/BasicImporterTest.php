<?php
/**
 * Created by PhpStorm.
 * User: jhyeon
 * Date: 15. 10. 7.
 * Time: 오후 4:03
 */

namespace Xpressengine\Tests\Seo;

use Mockery as m;
use Xpressengine\Seo\Importers\BasicImporter;

class BasicImporterTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testExec()
    {
        list($frontend, $request) = $this->getMocks();
        $instance = new BasicImporter($frontend, $request);

        $frontend->shouldReceive('html')->once()->with('canonical')->andReturnSelf();

        $request->shouldReceive('fullUrl')->twice()->andReturn('http://domain.com');

        $content = $this->invokeMethod($instance, 'makeCanonical', ['http://domain.com']);
        $frontend->shouldReceive('content')->once()->with($content)->andReturnSelf();
        $frontend->shouldReceive('appendTo')->once()->with('head')->andReturnSelf();
        $frontend->shouldReceive('load');

        $frontend->shouldReceive('meta')->andReturnSelf();
        $frontend->shouldReceive('property')->once()->with('keywords')->andReturnSelf();
        $frontend->shouldReceive('content')->once()->with('test,keyword')->andReturnSelf();

        $frontend->shouldReceive('property')->once()->with('description')->andReturnSelf();
        $frontend->shouldReceive('content')->once()->with('sample description')->andReturnSelf();

        $instance->exec([
            'keywords' => 'test,keyword',
            'description' => 'sample description'
        ]);
    }

    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Presenter\Html\FrontendHandler'),
            m::mock('Illuminate\Http\Request')
        ];
    }
}
