<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Handlers\VideoHandler;

class VideoHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetPictureThrownExceptionWhenGivenMediaIsNotVideo()
    {
        list($repo, $reader, $temp, $extension, $fromSecond) = $this->getMocks();
        $instance = new VideoHandler($repo, $reader, $temp, $extension, $fromSecond);

        $mockImage = m::mock('Xpressengine\Media\Models\Image');

        try {
            $instance->getPicture($mockImage);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Media\Exceptions\WrongInstanceException', $e);
        }
    }

    public function testGetPicture()
    {
        list($repo, $reader, $temp, $extension, $fromSecond) = $this->getMocks();
        $instance = new VideoHandler($repo, $reader, $temp, $extension, $fromSecond);

        $mockVideo = m::mock('Xpressengine\Media\Models\Video');
        $mockVideo->shouldReceive('getContent')->andReturn('content');

        $extension->shouldReceive('getSnapshot')->once()->with('content', $fromSecond)->andReturn('snapshot content');

        $instance->getPicture($mockVideo);
    }

    public function testMakeThrownExceptionWhenGivenFileNotAvailable()
    {
        list($repo, $reader, $temp, $extension, $fromSecond) = $this->getMocks();
        $instance = m::mock(VideoHandler::class, [$repo, $reader, $temp, $extension, $fromSecond])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getAttribute')->with('mime')->andReturn('text/plain');

        $instance->shouldReceive('isAvailable')->once()->with('text/plain')->andReturn(false);

        try {
            $instance->make($mockFile);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Media\Exceptions\NotAvailableException', $e);
        }
    }

    public function testMake()
    {
        list($repo, $reader, $temp, $extension, $fromSecond) = $this->getMocks();
        $instance = m::mock(VideoHandler::class, [$repo, $reader, $temp, $extension, $fromSecond])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getAttribute')->with('mime')->andReturn('video/mp4');

        $mockRelate = m::mock('stdClass');
        $mockRelate->shouldReceive('create')->once()->with([
            'audio' => [
                'streams' => true
            ],
            'video' => [
                'var1' => 'val1',
                'var2' => 'val2'
            ],
            'playtime' => 30,
            'bitrate' => 123456
        ])->andReturnSelf();

        $mockVideo = m::mock('Xpressengine\Media\Models\Video');
        $mockVideo->shouldReceive('getAttribute')->with('meta')->andReturnNull();
        $mockVideo->shouldReceive('meta')->andReturn($mockRelate);
        $mockVideo->shouldReceive('setRelation')->once()->with('meta', $mockRelate)->andReturnSelf();

        $instance->shouldReceive('isAvailable')->once()->with('video/mp4')->andReturn(true);
        $instance->shouldReceive('makeModel')->once()->with($mockFile)->andReturn($mockVideo);
        $instance->shouldReceive('extractInformation')->once()->with($mockVideo)->andReturn([
            ['streams' => true],
            ['var1' => 'val1', 'var2' => 'val2' ],
            30,
            123456
        ]);

        $video = $instance->make($mockFile);

        $this->assertInstanceOf('Xpressengine\Media\Models\Video', $video);

    }

    public function testExtractInformation()
    {
        list($repo, $reader, $temp, $extension, $fromSecond) = $this->getMocks();
        $instance = new VideoHandler($repo, $reader, $temp, $extension, $fromSecond);

        $mockVideo = m::mock('Xpressengine\Media\Models\Video');
        $mockVideo->shouldReceive('getContent')->andReturn('content');

        $mockTmpFile = m::mock('stdClass');
        $mockTmpFile->shouldReceive('getPathname')->andReturn('/tmp/pathname');
        $mockTmpFile->shouldReceive('destroy')->andReturnNull();

        $temp->shouldReceive('create')->once()->with('content')->andReturn($mockTmpFile);

        $reader->shouldReceive('analyze')->once()->with('/tmp/pathname')->andReturn([
            'audio' => [
                'streams' => true
            ],
            'video' => [
                'var1' => 'val1',
                'var2' => 'val2'
            ],
            'playtime_seconds' => 30,
            'bitrate' => 123456
        ]);

        $info = $this->invokeMethod($instance, 'extractInformation', [$mockVideo]);

        $this->assertFalse(isset($info[0]['streams']));
        $this->assertEquals(['var1' => 'val1', 'var2' => 'val2'], $info[1]);
        $this->assertEquals(30, $info[2]);
        $this->assertEquals(123456, $info[3]);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Media\Repositories\VideoRepository'),
            m::mock('getID3'),
            m::mock('Xpressengine\Storage\TempFileCreator'),
            m::mock('Xpressengine\Media\Extensions\ExtensionInterface'),
            10
        ];
    }

    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
