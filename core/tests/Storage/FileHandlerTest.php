<?php
namespace Xpressengine\Tests\Storage;

use Mockery as m;
use Xpressengine\Storage\FileHandler;

class FileHanlderTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testResource()
    {
        list($fsManager, $distributor) = $this->getMocks();

        $resource = file_get_contents(__DIR__ . '/sample.png');

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->disk = 'local';
        $mockFile->shouldReceive('getPathname')->andReturn('attached/filenamestring');

        $mockFilesystem = m::mock('Illuminate\Contracts\Filesystem\Filesystem');
        $mockFilesystem->shouldReceive('get')->once()->with('attached/filenamestring')->andReturn($resource);

        $fsManager->shouldReceive('disk')->once()->with('local')->andReturn($mockFilesystem);

        $instance = new FileHandler($fsManager, $distributor);

        $this->assertEquals($resource, $instance->content($mockFile));
    }

    public function testStore()
    {
        list($fsManager, $distributor) = $this->getMocks();

        $resource = file_get_contents(__DIR__ . '/sample.png');

        $distributor->shouldReceive('allot')->once()->with($resource)->andReturn('local');

        $mockFilesystem = m::mock('Illuminate\Contracts\Filesystem\Filesystem');
        $mockFilesystem->shouldReceive('put')
            ->once()
            ->with('attached/filenamestring', $resource)
            ->andReturnNull();

        $fsManager->shouldReceive('disk')->once()->with('local')->andReturn($mockFilesystem);

        $instance = new FileHandler($fsManager, $distributor);

        $file = $instance->store($resource, 'attached/filenamestring');

        $this->assertInstanceOf('Xpressengine\Storage\File', $file);
        $this->assertEquals('local', $file->disk);
        $this->assertEquals('attached', $file->path);
        $this->assertEquals('image/png', $file->mime);

    }

    public function testDelete()
    {
        list($fsManager, $distributor) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->disk = 'local';
        $mockFile->shouldReceive('getPathname')->andReturn('attached/filenamestring');

        $mockFilesystem = m::mock('Illuminate\Contracts\Filesystem\Filesystem');
        $mockFilesystem->shouldReceive('delete')
            ->once()
            ->with('attached/filenamestring')
            ->andReturnNull();

        $fsManager->shouldReceive('disk')->once()->with('local')->andReturn($mockFilesystem);

        $instance = new FileHandler($fsManager, $distributor);

        $instance->delete($mockFile);
    }

    public function testExists()
    {
        list($fsManager, $distributor) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->disk = 'local';
        $mockFile->shouldReceive('getPathname')->andReturn('attached/filenamestring');

        $mockFilesystem = m::mock('Illuminate\Contracts\Filesystem\Filesystem');
        $mockFilesystem->shouldReceive('exists')
            ->once()
            ->with('attached/filenamestring')
            ->andReturn(true);

        $fsManager->shouldReceive('disk')->once()->with('local')->andReturn($mockFilesystem);

        $instance = new FileHandler($fsManager, $distributor);

        $this->assertTrue($instance->exists($mockFile));
    }

    private function getMocks()
    {
        return [
            m::mock('Illuminate\Filesystem\FilesystemManager'),
            m::mock('Xpressengine\Storage\Distributor'),
        ];
    }
}
