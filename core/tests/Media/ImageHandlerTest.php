<?php
namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Handlers\ImageHandler;

class ImageHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetThumbnail()
    {
        list($storage, $repo) = $this->getMocks();
        $instance = new ImageHandler($storage, $repo);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $originId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy';

        $mockMedia = m::mock('Xpressengine\Media\Spec\Media');
        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockMedia->shouldReceive('getFile')->andReturn($mockFile);
        $mockFile->shouldReceive('getId')->andReturn($originId);

        $repo->shouldReceive('findByOption')->once()->with([
            'originId' => $originId,
            'type' => 'letter',
            'code' => 'S'
        ])->andReturnNull();

        $this->assertEquals($mockMedia, $instance->getThumbnail($mockMedia, 'letter', 'S'));


        $mockMeta = m::mock('Xpressengine\Media\Meta');
        $mockMeta->id = $id;

        $repo->shouldReceive('findByOption')->once()->with([
            'originId' => $originId,
            'type' => 'letter',
            'code' => 'S'
        ])->andReturn($mockMeta);

        $mockThumbFile = m::mock('Xpressengine\Storage\File');
        $storage->shouldReceive('get')->once()->with($id)->andReturn($mockThumbFile);

        $image = $instance->getThumbnail($mockMedia, 'letter', 'S');

        $this->assertInstanceOf('Xpressengine\Media\Spec\Image', $image);
    }

    public function testGetThumbnails()
    {
        list($storage, $repo) = $this->getMocks();
        $instance = new ImageHandler($storage, $repo);

        $originId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $id1 = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy';
        $id2 = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxz';

        $mockMedia = m::mock('Xpressengine\Media\Spec\Media');
        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockMedia->shouldReceive('getFile')->andReturn($mockFile);
        $mockFile->shouldReceive('getId')->andReturn($originId);

        $mockMeta1 = m::mock('Xpressengine\Media\Meta');
        $mockMeta1->id = $id1;
        $mockMeta2 = m::mock('Xpressengine\Media\Meta');
        $mockMeta2->id = $id2;
        $repo->shouldReceive('fetch')->once()
            ->with(['originId' => $originId, 'type' => 'letter'])->andReturn([$mockMeta1, $mockMeta2]);

        $mockThumbFile1 = m::mock('Xpressengine\Storage\File');
        $mockThumbFile1->shouldReceive('getId')->andReturn($id1);
        $mockThumbFile2 = m::mock('Xpressengine\Storage\File');
        $mockThumbFile2->shouldReceive('getId')->andReturn($id2);
        $storage->shouldReceive('children')->once()->with($mockFile)->andReturn([$mockThumbFile1, $mockThumbFile2]);

        $images = $instance->getThumbnails($mockMedia, 'letter');

        $this->assertEquals(2, count($images));
    }

    public function testGetPictureThrownExceptionWhenNotImage()
    {
        list($storage, $repo) = $this->getMocks();
        $instance = new ImageHandler($storage, $repo);

        $mockMedia = m::mock('Xpressengine\Media\Spec\Media');

        try {
            $instance->getPicture($mockMedia);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Media\Exceptions\WrongInstanceException', $e);
        }
    }

    public function testGetPicture()
    {
        list($storage, $repo) = $this->getMocks();
        $instance = new ImageHandler($storage, $repo);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockImage = m::mock('Xpressengine\Media\Spec\Image');
        $mockImage->shouldReceive('getFile')->once()->andReturn($mockFile);

        $storage->shouldReceive('read')->once()->with($mockFile);

        $instance->getPicture($mockImage);
    }

    public function testCreateThumbnails()
    {
        list($storage, $repo) = $this->getMocks();
        $instance = m::mock(ImageHandler::class, [$storage, $repo])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $imageContent = 'some image content';

        $mockCommand = m::mock('Xpressengine\Media\Commands\CommandInterface');
        $mockCommand->shouldReceive('getName')->andReturn('letter');

        $mockDimension = m::mock('Xpressengine\Media\Coordinators\Dimension');
        $mockDimension->shouldReceive('getWidth')->andReturn(100);
        $mockDimension->shouldReceive('getHeight')->andReturn(100);
        $mockCommand->shouldReceive('getDimension')->andReturn($mockDimension);

        $thumbnailer = m::mock('Xpressengine\Media\Thumbnailer');
        $instance->shouldReceive('makeThumbnailer')->andReturn($thumbnailer);
        $thumbnailer->shouldReceive('setOrigin')->once()->with($imageContent)->andReturnSelf();
        $thumbnailer->shouldReceive('addCommand')->once()->with($mockCommand)->andReturnSelf();
        $thumbnailer->shouldReceive('generate')->once()->andReturn('content string');

        $mockThumbFile = m::mock('Xpressengine\Storage\File');
        $storage->shouldReceive('create')->once()->with(
            'content string',
            '',
            m::on(function () { return true; }),
            null,
            null
        )->andReturn($mockThumbFile);

        $instance->shouldReceive('make')->once()->with($mockThumbFile, ['type' => 'letter', 'code' => null]);

        $instance->createThumbnails($imageContent, $mockCommand);
    }

    public function testRemoveThumbnails()
    {
        list($storage, $repo) = $this->getMocks();
        $instance = new ImageHandler($storage, $repo);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockMeta = m::mock('Xpressengine\Media\Meta');

        $mockImage = m::mock('Xpressengine\Media\Spec\Image', [$mockFile, $mockMeta]);
        $mockImage->id = $id;

        $repo->shouldReceive('deleteByOriginId')->once()->with($id)->andReturn(1);

        $instance->removeThumbnails($mockImage);
    }

    public function testMakeThrownExceptionWhenGivenFileIsNotAvailable()
    {
        list($storage, $repo) = $this->getMocks();
        $instance = new ImageHandler($storage, $repo);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getMime')->andReturn('text/plain');

        try {
            $instance->make($mockFile);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Media\Exceptions\NotAvailableException', $e);
        }
    }

    public function testMake()
    {
        list($storage, $repo) = $this->getMocks();
        $instance = m::mock(ImageHandler::class, [$storage, $repo])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getMime')->andReturn('image/jpeg');
        $mockFile->shouldReceive('getId')->andReturn('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $repo->shouldReceive('find')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnNull();

        $mockMeta = m::mock('Xpressengine\Media\Meta');
        $instance->shouldReceive('extractInformation')->once()->with($mockFile)->andReturn($mockMeta);

        $repo->shouldReceive('insert')->once()->with($mockMeta)->andReturn($mockMeta);

        $instance->make($mockFile, ['type' => 'test']);
    }

    public function testRemove()
    {
        list($storage, $repo) = $this->getMocks();
        $instance = new ImageHandler($storage, $repo);

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
            m::mock('Xpressengine\Media\Repositories\ImageRepository'),
            m::mock('Intervention\Image\ImageManager'),
        ];
    }
}
