<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Handlers\AudioHandler;

class AudioHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testMakeThrownExceptionWhenNotAvailable()
    {
        list($repo, $reader, $temp) = $this->getMocks();
        $instance = m::mock(AudioHandler::class, [$repo, $reader, $temp])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getAttribute')->with('mime')->andReturn('image/jpeg');

        $instance->shouldReceive('isAvailable')->once()->with('image/jpeg')->andReturn(false);

        try {
            $instance->make($mockFile);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Media\Exceptions\NotAvailableException', $e);
        }
    }

    public function testMake()
    {
        list($repo, $reader, $temp) = $this->getMocks();
        $instance = m::mock(AudioHandler::class, [$repo, $reader, $temp])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getAttribute')->with('mime')->andReturn('audio/wav');

        $mockRelate = m::mock('stdClass');
        $mockRelate->shouldReceive('create')->once()->with([
            'audio' => [
                'streams' => 'some val',
                'another' => 'another val'
            ],
            'playtime' => 100,
            'bitrate' => 12345,
        ])->andReturnSelf();

        $mockAudio = m::mock('Xpressengine\Media\Models\Audio');
        $mockAudio->shouldReceive('getAttribute')->with('meta')->andReturnNull();
        $mockAudio->shouldReceive('meta')->andReturn($mockRelate);
        $mockAudio->shouldReceive('setRelation')->once()->with('meta', $mockRelate)->andReturnSelf();

        $instance->shouldReceive('isAvailable')->once()->andReturn(true);
        $instance->shouldReceive('makeModel')->once()->with($mockFile)->andReturn($mockAudio);
        $instance->shouldReceive('extractInformation')->once()->with($mockAudio)->andReturn([
            ['streams' => 'some val', 'another' => 'another val'], 100, 12345
        ]);

        $audio = $instance->make($mockFile);

        $this->assertInstanceOf('Xpressengine\Media\Models\Audio', $audio);
    }

    public function testExtractInformation()
    {
        list($repo, $reader, $temp) = $this->getMocks();
        $instance = new AudioHandler($repo, $reader, $temp);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockAudio = m::mock('Xpressengine\Media\Models\Audio');
        $mockAudio->shouldReceive('getContent')->andReturn('content');

        $mockTmpFile = m::mock('stdClass');
        $mockTmpFile->shouldReceive('getPathname')->andReturn('/tmp/pathname');
        $mockTmpFile->shouldReceive('destroy')->andReturnNull();
        $temp->shouldReceive('create')->once()->with('content')->andReturn($mockTmpFile);

        $reader->shouldReceive('analyze')->once()->with('/tmp/pathname')->andReturn([
            'audio' => [
                'streams' => 'some val',
                'another' => 'another val'
            ],
            'playtime_seconds' => 100,
            'bitrate' => 12345
        ]);

        $info = $this->invokeMethod($instance, 'extractInformation', [$mockAudio]);

        $this->assertEquals(['another' => 'another val'], $info[0]);
        $this->assertEquals(100, $info[1]);
        $this->assertEquals(12345, $info[2]);
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
            m::mock('Xpressengine\Media\Repositories\AudioRepository'),
            m::mock('getID3'),
            m::mock('Xpressengine\Storage\TempFileCreator'),
        ];
    }
}
