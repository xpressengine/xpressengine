<?php
namespace Xpressengine\Tests\Storage;

use Mockery as m;
use Xpressengine\Storage\Storage;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testUploadReturnsFileInstanceWhenFileIsValid()
    {
        list($repo, $handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($repo, $handler, $auth, $keygen, $distributor, $temps);

        $mockFile = m::mock('Xpressengine\Storage\File');

        $resource = file_get_contents(__DIR__ . '/sample.png');

        $mockGuest = m::mock('Xpressengine\Member\Entities\Guest');
        $mockGuest->shouldReceive('getId')->andReturnNull();
        $auth->shouldReceive('user')->andReturn($mockGuest);

        $uploaded = m::mock('Symfony\Component\HttpFoundation\File\UploadedFile');
        $uploaded->shouldReceive('isValid')->andReturn(true);
        $uploaded->shouldReceive('getClientOriginalName')->andReturn('foo.jpg');
        $uploaded->shouldReceive('getPathname')->andReturn(__DIR__ . '/sample.png');
        $uploaded->shouldReceive('getMimeType')->andReturn('image/png');
        $uploaded->shouldReceive('getSize')->andReturn(123456);
        $uploaded->shouldReceive('getClientOriginalExtension')->andReturn('png');

        $distributor->shouldReceive('allot')->once()->with($uploaded)->andReturn('local');

        $keygen->shouldReceive('generate')->once()->andReturn('made-key');

        $handler->shouldReceive('store')
            ->once()
            ->with($resource, m::on(function () { return true; }), 'local')
            ->andReturn(true);

        $repo->shouldReceive('create')->once()->with(m::on(function ($args) {
            $arr = [
                'userId' => null,
                'clientname' => 'foo.jpg',
                'mime' => 'image/png',
                'size' => 123456,
            ];
            $args = array_intersect_key($args, $arr);

            return $args['userId'] === null
                && $args['clientname'] === 'foo.jpg'
                && $args['mime'] === 'image/png'
                && $args['size'] === 123456;
        }), 'made-key')->andReturn($mockFile);

        $file = $instance->upload($uploaded, 'attached');

        $this->assertInstanceOf('Xpressengine\Storage\File', $file);
    }

    public function testUploadThrownExceptionWhenFileIsInvalid()
    {
        list($repo, $handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($repo, $handler, $auth, $keygen, $distributor, $temps);

        $uploaded = m::mock('Symfony\Component\HttpFoundation\File\UploadedFile');
        $uploaded->shouldReceive('isValid')->andReturn(false);
        $uploaded->shouldReceive('getClientOriginalName')->andReturn('filename.jpg');
        $uploaded->shouldReceive('getErrorMessage')->andReturn('exceeds your upload_max_filesize ini directive');


        try {
            $instance->upload($uploaded, 'attached');
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Storage\Exceptions\InvalidFileException', $e);
        }
    }

    public function testUploadThrownExceptionWhenWritingFail()
    {
        list($repo, $handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($repo, $handler, $auth, $keygen, $distributor, $temps);

        $resource = file_get_contents(__DIR__ . '/sample.png');

        $mockGuest = m::mock('Xpressengine\Member\Entities\Guest');
        $mockGuest->shouldReceive('getId')->andReturnNull();
        $auth->shouldReceive('user')->andReturn($mockGuest);

        $uploaded = m::mock('Symfony\Component\HttpFoundation\File\UploadedFile');
        $uploaded->shouldReceive('isValid')->andReturn(true);
        $uploaded->shouldReceive('getClientOriginalName')->andReturn('foo.jpg');
        $uploaded->shouldReceive('getPathname')->andReturn(__DIR__ . '/sample.png');
        $uploaded->shouldReceive('getClientOriginalExtension')->andReturn('png');

        $keygen->shouldReceive('generate')->once()->andReturn('made-key');

        $distributor->shouldReceive('allot')->once()->with($uploaded)->andReturn('local');

        $handler->shouldReceive('store')
            ->once()
            ->with($resource, m::on(function () { return true; }), 'local')
            ->andReturn(false);

        try {
            $instance->upload($uploaded, 'attached');
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Storage\Exceptions\WritingFailException', $e);
        }
    }

    public function testCreate()
    {
        list($repo, $handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($repo, $handler, $auth, $keygen, $distributor, $temps);

        $mockFile = m::mock('Xpressengine\Storage\File');

        $mockGuest = m::mock('Xpressengine\Member\Entities\Guest');
        $mockGuest->shouldReceive('getId')->andReturnNull();
        $auth->shouldReceive('user')->andReturn($mockGuest);

        $mockTempFile = m::mock('Symfony\Component\HttpFoundation\File\File');
        $mockTempFile->shouldReceive('getMimeType')->andReturn('image/png');
        $mockTempFile->shouldReceive('getSize')->andReturn(123456);

        $keygen->shouldReceive('generate')->andReturn('made-key');
        $temps->shouldReceive('create')->once()->with('file_get_content')->andReturn($mockTempFile);

        $handler->shouldReceive('store')->once()->with('file_get_content', m::on(function () {
            return true;
        }), 'local')->andReturn(true);

        $mockTempFile->shouldReceive('destroy')->andReturnNull();

        $repo->shouldReceive('create')->once()->with(m::on(function ($args) {
            $arr = [
                'userId' => null,
                'mime' => 'image/png',
                'size' => 123456,
            ];
            $args = array_intersect_key($args, $arr);

            return $args['userId'] === null
                && $args['mime'] === 'image/png'
                && $args['size'] === 123456;
        }), 'made-key')->andReturn($mockFile);

        $file = $instance->create('file_get_content', 'path/to', 'filename', 'local', 'origin-key');

        $this->assertInstanceOf('Xpressengine\Storage\File', $file);
    }

    public function testDownloadThrownExceptionWhenFileNotExists()
    {
        list($repo, $handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($repo, $handler, $auth, $keygen, $distributor, $temps);

        $mockFile = m::mock('Xpressengine\Storage\File');

        $handler->shouldReceive('exists')->once()->with($mockFile)->andReturn(false);

        try {
            $instance->download($mockFile);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Storage\Exceptions\FileDoesNotExistException', $e);
        }
    }

    public function testDelete()
    {
        list($repo, $handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($repo, $handler, $auth, $keygen, $distributor, $temps);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getAttribute')->with('id')->andReturn('foo');
        $mockFile->shouldReceive('getAttribute')->with('originId')->andReturnNull();

        $mockChild = m::mock('Xpressengine\Storage\File');
        $mockChild->shouldReceive('getAttribute')->with('id')->andReturn('bar');
        $mockChild->shouldReceive('getAttribute')->with('originId')->andReturn('foo');

        $mockFile->shouldReceive('getRawDerives')->andReturn([$mockChild]);

        $conn = m::mock('stdClass');
        $conn->shouldReceive('table')->andReturnSelf();
        $conn->shouldReceive('where')->once()->with('fileId', 'foo')->andReturnSelf();
        $conn->shouldReceive('where')->once()->with('fileId', 'bar')->andReturnSelf();
        $conn->shouldReceive('delete')->twice();

        $mockFile->shouldReceive('getConnection')->andReturn($conn);
        $mockFile->shouldReceive('getFileableTable')->andReturn('fileableTable');
        $mockChild->shouldReceive('getConnection')->andReturn($conn);
        $mockChild->shouldReceive('getFileableTable')->andReturn('fileableTable');

        $handler->shouldReceive('delete')->once()->with($mockChild)->andReturnNull();
        $handler->shouldReceive('delete')->once()->with($mockFile)->andReturnNull();

        $repo->shouldReceive('delete')->once()->with($mockFile)->andReturn(true);
        $repo->shouldReceive('delete')->once()->with($mockChild)->andReturn(true);

        $result = $instance->delete($mockFile);

        $this->assertTrue($result);
    }

    public function testBind()
    {
        list($repo, $handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($repo, $handler, $auth, $keygen, $distributor, $temps);

        $mockFile = m::mock('Xpressengine\Storage\File')->shouldAllowMockingProtectedMethods();
        $mockConn = m::mock('stdClass');

        $mockFile->shouldReceive('getConnection')->andReturn($mockConn);
        $mockFile->shouldReceive('getFileableTable')->andReturn('fileable_table');
        $mockFile->shouldReceive('getKey')->andReturn('file-id');

        $mockConn->shouldReceive('table')->once()->with('fileable_table')->andReturnSelf();
        $mockConn->shouldReceive('insert')->once()->with(m::on(function ($args) {
            return $args['fileId'] == 'file-id' && $args['fileableId'] == 'fileable-id';
        }))->andReturnSelf();

        $repo->shouldReceive('increment')->andReturn(true);


        $instance->bind('fileable-id', $mockFile);
    }

    public function testUnBindNotRemovedFileWhenFlagFalse()
    {
        list($repo, $handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($repo, $handler, $auth, $keygen, $distributor, $temps);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockConn = m::mock('stdClass');

        $mockFile->shouldReceive('getConnection')->andReturn($mockConn);
        $mockFile->shouldReceive('getFileableTable')->andReturn('fileable_table');
        $mockFile->shouldReceive('getKey')->andReturn('file-id');

        $mockConn->shouldReceive('table')->once()->with('fileable_table')->andReturnSelf();
        $mockConn->shouldReceive('where')->once()->with('fileId', 'file-id')->andReturnSelf();
        $mockConn->shouldReceive('where')->once()->with('fileableId', 'fileable-id')->andReturnSelf();
        $mockConn->shouldReceive('delete')->once()->andReturn(1);

        $mockFile->shouldReceive('getAttribute')->with('useCount')->andReturn(1);
        $repo->shouldReceive('decrement')->andReturn(true);

        $instance->unBind('fileable-id', $mockFile);
    }

    public function testUnBindWillRemovedFileWhenFlagTrue()
    {
        list($repo, $handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = $this->getMock(Storage::class, ['delete'], [$repo, $handler, $auth, $keygen, $distributor, $temps]);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockConn = m::mock('stdClass');

        $mockFile->shouldReceive('getConnection')->andReturn($mockConn);
        $mockFile->shouldReceive('getFileableTable')->andReturn('fileable_table');
        $mockFile->shouldReceive('getKey')->andReturn('file-id');

        $mockConn->shouldReceive('table')->once()->with('fileable_table')->andReturnSelf();
        $mockConn->shouldReceive('where')->once()->with('fileId', 'file-id')->andReturnSelf();
        $mockConn->shouldReceive('where')->once()->with('fileableId', 'fileable-id')->andReturnSelf();
        $mockConn->shouldReceive('delete')->once()->andReturn(1);

        $mockFile->shouldReceive('getAttribute')->with('useCount')->andReturn(1);

        $instance->expects($this->once())->method('delete')->with($mockFile)->willReturn(true);

        $instance->unBind('fileable-id', $mockFile, true);
    }

    public function getMocks()
    {
        return [
            m::mock('Xpressengine\Storage\FileRepository'),
            m::mock('Xpressengine\Storage\FilesystemHandler'),
            m::mock('Xpressengine\User\GuardInterface'),
            m::mock('Xpressengine\Keygen\Keygen'),
            m::mock('Xpressengine\Storage\Distributor'),
            m::mock('Xpressengine\Storage\TempFileCreator'),
        ];
    }
}
