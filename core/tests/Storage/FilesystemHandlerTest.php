<?php
namespace Xpressengine\Tests\Storage;

use Mockery as m;
use Xpressengine\Storage\FilesystemHandler;

class FilesystemHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testRead()
    {
        list($filesystem) = $this->getMocks();
        $instance = new FilesystemHandler($filesystem);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getAttribute')->once()->with('disk')->andReturn('local');
        $mockFile->shouldReceive('getPathname')->andReturn('attached/filenamestring');

        $mockFilesystem = m::mock('Illuminate\Contracts\Filesystem\Filesystem');
        $mockFilesystem->shouldReceive('get')->once()->with('attached/filenamestring')->andReturn('content');

        $filesystem->shouldReceive('disk')->once()->with('local')->andReturn($mockFilesystem);

        $this->assertEquals('content', $instance->read($mockFile));
    }

    public function testStore()
    {
        list($filesystem) = $this->getMocks();
        $instance = new FilesystemHandler($filesystem);


        $mockFilesystem = m::mock('Illuminate\Contracts\Filesystem\Filesystem');
        $mockFilesystem->shouldReceive('put')
            ->once()
            ->with('attached/filenamestring', 'content')
            ->andReturn(true);

        $filesystem->shouldReceive('disk')->once()->with('local')->andReturn($mockFilesystem);

        $instance->store('content', 'attached/filenamestring', 'local');
    }

    public function testDelete()
    {
        list($filesystem) = $this->getMocks();
        $instance = new FilesystemHandler($filesystem);


        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getAttribute')->with('disk')->andReturn('local');
        $mockFile->shouldReceive('getPathname')->andReturn('attached/filenamestring');

        $mockFilesystem = m::mock('Illuminate\Contracts\Filesystem\Filesystem');
        $mockFilesystem->shouldReceive('delete')
            ->once()
            ->with('attached/filenamestring')
            ->andReturnNull();
        $mockFilesystem->shouldReceive('exists')
            ->once()
            ->with('attached/filenamestring')
            ->andReturn(true);

        $filesystem->shouldReceive('disk')->with('local')->andReturn($mockFilesystem);

        $instance->delete($mockFile);
    }

    public function testExists()
    {
        list($filesystem) = $this->getMocks();
        $instance = new FilesystemHandler($filesystem);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getAttribute')->once()->with('disk')->andReturn('local');
        $mockFile->shouldReceive('getPathname')->andReturn('attached/filenamestring');

        $mockFilesystem = m::mock('Illuminate\Contracts\Filesystem\Filesystem');
        $mockFilesystem->shouldReceive('exists')
            ->once()
            ->with('attached/filenamestring')
            ->andReturn(true);

        $filesystem->shouldReceive('disk')->once()->with('local')->andReturn($mockFilesystem);

        $this->assertTrue($instance->exists($mockFile));
    }

    private function getMocks()
    {
        return [
            m::mock('Illuminate\Filesystem\FilesystemManager'),
        ];
    }
}
