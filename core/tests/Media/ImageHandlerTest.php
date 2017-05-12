<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Handlers\ImageHandler;

class ImageHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetPictureThrownExceptionWhenNotImage()
    {
        list($repo, $storage) = $this->getMocks();
        $instance = new ImageHandler($repo, $storage);

        $mockMedia = m::mock('Xpressengine\Media\Models\Media');

        try {
            $instance->getPicture($mockMedia);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Media\Exceptions\WrongInstanceException', $e);
        }
    }

    public function testGetPicture()
    {
        list($repo, $storage) = $this->getMocks();
        $instance = new ImageHandler($repo, $storage);

        $mockImage = m::mock('Xpressengine\Media\Models\Image');
        $mockImage->shouldReceive('getContent')->andReturn('content');

        $this->assertEquals('content', $instance->getPicture($mockImage));
    }

    public function testCreateThumbnails()
    {
        list($repo, $storage) = $this->getMocks();
        $instance = m::mock(ImageHandler::class, [$repo, $storage])
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

        $mockThumbImg = m::mock('Xpressengine\Media\Models\Image');

        $instance->shouldReceive('makeModel')->once()->with($mockThumbFile)->andReturn($mockThumbImg);
        $instance->shouldReceive('setMetaData')->once()->with($mockThumbImg, ['type' => 'letter', 'code' => null]);

        $instance->createThumbnails($imageContent, $mockCommand);
    }

    public function testMakeThrownExceptionWhenGivenFileIsNotAvailable()
    {
        list($repo, $storage) = $this->getMocks();
        $instance = m::mock(ImageHandler::class, [$repo, $storage])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getAttribute')->with('mime')->once()->andReturn('text/plain');

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
        list($repo, $storage) = $this->getMocks();
        $instance = m::mock(ImageHandler::class, [$repo, $storage])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getAttribute')->once()->with('mime')->andReturn('image/jpeg');
        $instance->shouldReceive('isAvailable')->with('image/jpeg')->andReturn(true);

        $mockImage = m::mock('Xpressengine\Media\Models\Image');

        $instance->shouldReceive('makeModel')->with($mockFile)->andReturn($mockImage);
        $instance->shouldReceive('setMetaData')->with($mockImage);

        $instance->make($mockFile);
    }

    public function testSetMetaData()
    {
        list($repo, $storage) = $this->getMocks();
        $instance = m::mock(ImageHandler::class, [$repo, $storage])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockImage = m::mock('Xpressengine\Media\Models\Image');

        $mockMeta = m::mock('stdClass');
        $mockMeta->shouldReceive('create')->once()->with([
            'width' => 200,
            'height' => 300,
            'type' => 'test'
        ])->andReturnSelf();

        $mockImage->shouldReceive('getAttribute')->with('meta')->andReturnNull();
        $mockImage->shouldReceive('meta')->andReturn($mockMeta);
        $mockImage->shouldReceive('setRelation')->once()->with('meta', $mockMeta)->andReturnSelf();

        $instance->shouldReceive('extractDimension')->once()->with($mockImage)->andReturn([200, 300]);

        $this->invokeMethod($instance, 'setMetaData', [$mockImage, ['type' => 'test']]);
    }

    private function invokeMethod($object, $method, $arguments)
    {
        $rfm = new \ReflectionMethod($object, $method);
        $rfm->setAccessible(true);

        return $rfm->invokeArgs($object, $arguments);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Media\Repositories\ImageRepository'),
            m::mock('Xpressengine\Storage\Storage'),
        ];
    }
}
