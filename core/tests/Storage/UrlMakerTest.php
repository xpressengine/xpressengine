<?php
namespace Xpressengine\Tests\Storage;

use Mockery as m;
use Xpressengine\Storage\UrlMaker;

class UrlMakerTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testUrl()
    {
        list($urlGenerator, $config) = $this->getMocks();
        $instance = m::mock(UrlMaker::class, [$urlGenerator, $config])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockFile = m::mock('Xpressengine\Storage\File');

        $instance->shouldReceive('getUrl')->once()->with($mockFile)->andReturnNull();
        $instance->shouldReceive('route')->once()->with($mockFile)->andReturn('/url/path');

        $closure = function ($file, &$url) {
            $url .= '/1';
        };

        $url = $instance->url($mockFile, $closure);

        $this->assertEquals('/url/path/1', $url);
    }

    public function testRoute()
    {
        list($urlGenerator, $config) = $this->getMocks();
        $instance = new UrlMaker($urlGenerator, $config);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('hasMacro')->andReturn(false);
        $mockFile->shouldReceive('getAttribute')->once()->with('id')->andReturn(1);

        $urlGenerator->shouldReceive('route')->once()
            ->with(m::on(function () { return true; }), ['id' => 1])
            ->andReturn();

        $instance->route($mockFile);
    }

    public function testGetUrl()
    {
        list($urlGenerator, $config) = $this->getMocks();
        $instance = new UrlMaker($urlGenerator, $config);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('hasMacro')->andReturn(false);
        $mockFile->shouldReceive('getAttribute')->once()->with('disk')->andReturn('local');
        $mockFile->shouldReceive('getPathname')->once()->andReturn('/file/path/name');

        $urlGenerator->shouldReceive('asset')->once()->with('/storage/app/file/path/name')
            ->andReturn('http://domain.com/storage/app/file/path/name');

        $url = $this->invokeMethod($instance, 'getUrl', [$mockFile]);

        $this->assertEquals('http://domain.com/storage/app/file/path/name', $url);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('hasMacro')->andReturn(false);
        $mockFile->shouldReceive('getAttribute')->once()->with('disk')->andReturn('local2');

        $url = $this->invokeMethod($instance, 'getUrl', [$mockFile]);

        $this->assertNull($url);
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
            m::mock('Illuminate\Contracts\Routing\UrlGenerator'),
            [
                'local' => [
                    'driver' => 'local',
                    'root'   => '/root/path',
                    'url'	 => '/storage/app/',
                ],
                'local2' => [
                    'driver' => 'local',
                    'root'   => '/root/path',
                ],
            ]
        ];
    }
}
