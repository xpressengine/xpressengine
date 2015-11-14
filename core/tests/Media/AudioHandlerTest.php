<?php
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
        list($storage, $repo, $reader, $temp) = $this->getMocks();
        $instance = new AudioHandler($storage, $repo, $reader, $temp);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getMime')->once()->andReturn('image/jpeg');

        try {
            $instance->make($mockFile);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Media\Exceptions\NotAvailableException', $e);
        }
    }

    public function testMake()
    {
        list($storage, $repo, $reader, $temp) = $this->getMocks();
        $instance = m::mock(AudioHandler::class, [$storage, $repo, $reader, $temp])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getMime');
        $mockFile->shouldReceive('getId')->andReturn($id);

        $mockMeta = m::mock('Xpressengine\Media\Meta');
        $mockMeta->shouldReceive('dataEncode');

        $instance->shouldReceive('isAvailable')->once()->andReturn(true);
        $repo->shouldReceive('find')->once()->with($id)->andReturnNull();
        $instance->shouldReceive('extractInformation')->once()->with($mockFile)->andReturn($mockMeta);
        $repo->shouldReceive('insert')->once()->with($mockMeta)->andReturn($mockMeta);


        $audio = $instance->make($mockFile);

        $this->assertInstanceOf('Xpressengine\Media\Spec\Audio', $audio);
    }

    public function testExtractInformation()
    {
        list($storage, $repo, $reader, $temp) = $this->getMocks();
        $instance = new AudioHandler($storage, $repo, $reader, $temp);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getId')->andReturn($id);
        $mockFile->shouldReceive('getOriginId')->andReturnNull();

        $temp->shouldReceive('getTempPathname')->once()->andReturn('/tmp/pathname');
        $storage->shouldReceive('read')->once()->with($mockFile)->andReturn('file content');
        $temp->shouldReceive('createFile')->once()->with('/tmp/pathname', 'file content');

        $reader->shouldReceive('analyze')->once()->with('/tmp/pathname')->andReturn([
            'audio' => [
                'streams' => 'some val',
                'another' => 'another val'
            ],
            'playtime_seconds' => 100,
            'bitrate' => 12345
        ]);

        $temp->shouldReceive('remove')->once()->with('/tmp/pathname');

        $meta = $this->invokeMethod($instance, 'extractInformation', [$mockFile]);

        $this->assertEquals(['another' => 'another val'], $meta->audio);
        $this->assertEquals(100, $meta->playtime);
        $this->assertEquals(12345, $meta->bitrate);
    }

    public function testRemove()
    {
        list($storage, $repo, $reader, $temp) = $this->getMocks();
        $instance = new AudioHandler($storage, $repo, $reader, $temp);

        $mockMeta = m::mock('Xpressengine\Media\Meta');

        $mockMedia = m::mock('Xpressengine\Media\Spec\Media');
        $mockMedia->shouldReceive('getMeta')->andReturn($mockMeta);

        $repo->shouldReceive('delete')->once()->with($mockMeta);

        $instance->remove($mockMedia);
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
            m::mock('Xpressengine\Storage\Storage'),
            m::mock('Xpressengine\Media\Repositories\AudioRepository'),
            m::mock('getID3'),
            m::mock('Xpressengine\Media\TempStorage'),
        ];
    }
}
