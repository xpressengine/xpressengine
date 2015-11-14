<?php
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
        list($storage, $repo, $reader, $temp, $extension) = $this->getMocks();
        $instance = new VideoHandler($storage, $repo, $reader, $temp, $extension);

        $mockImage = m::mock('Xpressengine\Media\Spec\Image');

        try {
            $instance->getPicture($mockImage);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Media\Exceptions\InstanceNotMatchException', $e);
        }
    }

    public function testGetPicture()
    {
        list($storage, $repo, $reader, $temp, $extension) = $this->getMocks();
        $instance = new VideoHandler($storage, $repo, $reader, $temp, $extension);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getPath')->andReturn('/some/dir/path');
        $mockFile->shouldReceive('getOriginId')->andReturn('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $mockVideo = m::mock('Xpressengine\Media\Spec\Video');
        $mockVideo->shouldReceive('getFile')->andReturn($mockFile);

        $storage->shouldReceive('read')->once()->with($mockFile)->andReturn('content string');
        $extension->shouldReceive('getSnapshot')->once()->with('content string')->andReturn('snapshot content');
        
        $instance->getPicture($mockVideo);
    }

    public function testMakeThrownExceptionWhenGivenFileNotAvailable()
    {
        list($storage, $repo, $reader, $temp, $extension) = $this->getMocks();
        $instance = m::mock(VideoHandler::class, [$storage, $repo, $reader, $temp, $extension])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getMime')->andReturn('text/plain');

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
        list($storage, $repo, $reader, $temp, $extension) = $this->getMocks();
        $instance = m::mock(VideoHandler::class, [$storage, $repo, $reader, $temp, $extension])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getMime')->andReturn('video/mp4');
        $mockFile->shouldReceive('getId')->andReturn('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $instance->shouldReceive('isAvailable')->once()->with('video/mp4')->andReturn(true);

        $repo->shouldReceive('find')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnNull();

        $mockMeta = m::mock('Xpressengine\Media\Meta');
        $mockMeta->shouldReceive('dataEncode')->once();
        $instance->shouldReceive('extractInformation')->once()->with($mockFile)->andReturn($mockMeta);

        $repo->shouldReceive('insert')->once()->with($mockMeta)->andReturn($mockMeta);

        $video = $instance->make($mockFile);

        $this->assertInstanceOf('Xpressengine\Media\Spec\Video', $video);

    }

    public function testExtractInformation()
    {
        list($storage, $repo, $reader, $temp, $extension) = $this->getMocks();
        $instance = new VideoHandler($storage, $repo, $reader, $temp, $extension);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getId')->andReturn('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
        $mockFile->shouldReceive('getOriginId')->andReturn('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy');

        $storage->shouldReceive('read')->once()->with($mockFile)->andReturn('content string');
        $temp->shouldReceive('getTempPathname')->andReturn('/some/temp/path/filename');
        $temp->shouldReceive('createFile')->once()->with('/some/temp/path/filename', 'content string');
        $temp->shouldReceive('remove')->once()->with('/some/temp/path/filename');

        $reader->shouldReceive('analyze')->once()->with('/some/temp/path/filename')->andReturn([
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

        $meta = $this->invokeMethod($instance, 'extractInformation', [$mockFile]);

        $this->assertFalse(isset($meta->audio['streams']));
        $this->assertEquals(30, $meta->playtime);
        $this->assertEquals(123456, $meta->bitrate);
    }

    public function testRemove()
    {
        list($storage, $repo, $reader, $temp, $extension) = $this->getMocks();
        $instance = new VideoHandler($storage, $repo, $reader, $temp, $extension);

        $mockMedia = m::mock('Xpressengine\Media\Spec\Media');
        $mockMeta = m::mock('Xpressengine\Media\Meta');
        $mockMedia->shouldReceive('getMeta')->andReturn($mockMeta);

        $repo->shouldReceive('delete')->once()->with($mockMeta);

        $instance->remove($mockMedia);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Storage\Storage'),
            m::mock('Xpressengine\Media\Repositories\VideoRepository'),
            m::mock('getID3'),
            m::mock('Xpressengine\Media\TempStorage'),
            m::mock('Xpressengine\Media\Extensions\ExtensionInterface'),
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
