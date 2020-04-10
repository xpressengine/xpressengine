<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Coordinators\Dimension;
use Xpressengine\Media\MediaManager;
use Xpressengine\Media\Models\Media;

class MediaManagerTest extends \PHPUnit\Framework\TestCase
{
    private $handler;

    public function tearDown()
    {
        m::close();
    }

    public function setUp()
    {
        parent::setUp();

        $this->handler = m::mock('Xpressengine\Media\Handlers\AbstractHandler');
    }

    private function beforeSetUp(MediaManager $manager)
    {
        $manager->extend(Media::TYPE_IMAGE, $this->handler);
    }

    public function testGetHandlerThrownExceptionWhenGivenUnknownType()
    {
        list($storage, $factory, $config) = $this->getMocks();
        $instance = new MediaManager($storage, $factory, $config);
        $this->beforeSetUp($instance);

        try {
            $instance->getHandler('unknown');

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Media\Exceptions\UnknownTypeException', $e);
        }
    }

    public function testGetHandler()
    {
        list($storage, $factory, $config) = $this->getMocks();
        $instance = new MediaManager($storage, $factory, $config);
        $this->beforeSetUp($instance);

        $handler = $instance->getHandler(Media::TYPE_IMAGE);

        $this->assertInstanceOf('Xpressengine\Media\Handlers\AbstractHandler', $handler);
    }

    public function testGetHandlerByFileThrownExceptionWhenGivenFileTypeIsUnknown()
    {
        list($storage, $factory, $config) = $this->getMocks();
        $instance = m::mock(MediaManager::class, [$storage, $factory, $config])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $this->beforeSetUp($instance);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $instance->shouldReceive('getFileType')->once()->with($mockFile)->andReturnNull();

        try {
            $instance->getHandlerByFile($mockFile);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Media\Exceptions\UnknownTypeException', $e);
        }
    }

    public function testGetHandlerByFile()
    {
        list($storage, $factory, $config) = $this->getMocks();
        $instance = m::mock(MediaManager::class, [$storage, $factory, $config])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $this->beforeSetUp($instance);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $instance->shouldReceive('getFileType')->once()->with($mockFile)->andReturn(Media::TYPE_IMAGE);
        $instance->shouldReceive('getHandler')->once()->with(Media::TYPE_IMAGE);

        $instance->getHandlerByFile($mockFile);
    }

    public function testGetFileType()
    {
        list($storage, $factory, $config) = $this->getMocks();
        $instance = new MediaManager($storage, $factory, $config);
        $this->beforeSetUp($instance);

        $mockFile1 = m::mock('Xpressengine\Storage\File');
        $mockFile1->shouldReceive('hasMacro')->andReturn(false);
        $mockFile1->shouldReceive('getAttribute')->once()->with('mime')->andReturn('image/jpeg');

        $this->handler->shouldReceive('isAvailable')->once()->with('image/jpeg')->andReturn(true);

        $this->assertEquals(Media::TYPE_IMAGE, $instance->getFileType($mockFile1));

        $mockFile2 = m::mock('Xpressengine\Storage\File');
        $mockFile2->shouldReceive('hasMacro')->andReturn(false);
        $mockFile2->shouldReceive('getAttribute')->once()->with('mime')->andReturn('text/plain');

        $this->handler->shouldReceive('isAvailable')->once()->with('text/plain')->andReturn(false);

        $this->assertNull($instance->getFileType($mockFile2));
    }

    public function testMake()
    {
        list($storage, $factory, $config) = $this->getMocks();
        $instance = m::mock(MediaManager::class, [$storage, $factory, $config])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $this->beforeSetUp($instance);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $instance->shouldReceive('getHandlerByFile')->once()->with($mockFile)->andReturn($this->handler);
        $this->handler->shouldReceive('make')->once()->with($mockFile);

        $instance->make($mockFile);
    }

    public function testIs()
    {
        list($storage, $factory, $config) = $this->getMocks();
        $instance = new MediaManager($storage, $factory, $config);
        $this->beforeSetUp($instance);

        $mockFile1 = m::mock('Xpressengine\Storage\File');
        $mockFile1->shouldReceive('hasMacro')->andReturn(false);
        $mockFile1->shouldReceive('getAttribute')->once()->with('mime')->andReturn('image/jpeg');

        $this->handler->shouldReceive('isAvailable')->once()->with('image/jpeg')->andReturn(true);

        $this->assertTrue($instance->is($mockFile1));

        $mockFile2 = m::mock('Xpressengine\Storage\File');
        $mockFile2->shouldReceive('hasMacro')->andReturn(false);
        $mockFile2->shouldReceive('getAttribute')->once()->with('mime')->andReturn('text/plain');

        $this->handler->shouldReceive('isAvailable')->once()->with('text/plain')->andReturn(false);

        $this->assertFalse($instance->is($mockFile2));
    }

    public function testCreateThumbnailsReturnsEmptyArrayWhenMediaHasNotPicture()
    {
        list($storage, $factory, $config) = $this->getMocks();
        $instance = m::mock(MediaManager::class, [$storage, $factory, $config])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $this->beforeSetUp($instance);

        $mockMedia = m::mock('Xpressengine\Media\Models\Media');
        $instance->shouldReceive('getHandlerByMedia')->once()->with($mockMedia)->andReturn($this->handler);

        $this->handler->shouldReceive('getPicture')->once()->with($mockMedia)->andReturnNull();

        $this->assertEquals([], $instance->createThumbnails($mockMedia));
    }

    public function testCreateThumbnails()
    {
        list($storage, $factory, $config) = $this->getMocks();
        $instance = m::mock(MediaManager::class, [$storage, $factory, $config])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        $this->beforeSetUp($instance);

        $originId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockMedia = m::mock('Xpressengine\Media\Models\Media');
        $mockMedia->shouldReceive('getOriginKey')->andReturn($originId);

        $instance->shouldReceive('getHandlerByMedia')->once()->with($mockMedia)->andReturn($this->handler);

        $mockImage = m::mock('Xpressengine\Media\Models\Image');
        $this->handler->shouldReceive('getPicture')->once()->with($mockMedia)->andReturn($mockImage);

        $mockCommand = m::mock('Xpressengine\Media\Commands\AbstractCommand');
        $mockCommand->shouldReceive('setDimension')->once()->with(m::on(function ($object) {
            return $object instanceof Dimension && $object->getWidth() == 200 && $object->getHeight() == 200;
        }));
        $mockCommand->shouldReceive('setDimension')->once()->with(m::on(function ($object) {
            return $object instanceof Dimension && $object->getWidth() == 400 && $object->getHeight() == 400;
        }));
        $factory->shouldReceive('make')->twice()->with('fit')->andReturn($mockCommand);

        $instance->shouldReceive('getHandler')->twice()->with(Media::TYPE_IMAGE)->andReturn($this->handler);

        $this->handler->shouldReceive('createThumbnails')->once()
            ->with($mockImage, $mockCommand, 'S', 'local', 'path', $originId, [])->andReturn($mockImage);
        $this->handler->shouldReceive('createThumbnails')->once()
            ->with($mockImage, $mockCommand, 'M', 'local', 'path', $originId, [])->andReturn($mockImage);

        $instance->createThumbnails($mockMedia);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Storage\Storage'),
            m::mock('Xpressengine\Media\CommandFactory'),
            [
                'disk' => 'local',
                'path' => 'path',
                'type' => 'fit',
                'dimensions' => [
                    'S' => ['width' => 200,'height' => 200,],
                    'M' => ['width' => 400,'height' => 400,],
                ],
            ]
        ];
    }
}
