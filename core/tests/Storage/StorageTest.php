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
        list($handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = $this->getMock(Storage::class, ['createModel'], [$handler, $auth, $keygen, $distributor, $temps]);

        $mockFile = m::mock('stdClass');

        $instance->expects($this->once())->method('createModel')->willReturn($mockFile);
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

        $mockFile->shouldReceive('save')->andReturn(true);

        $file = $instance->upload($uploaded, 'attached');

        $this->assertEquals('local', $file->disk);
        $this->assertEquals('foo.jpg', $file->clientname);
        $this->assertEquals('image/png', $file->mime);
        $this->assertEquals(123456, $file->size);
    }

    public function testUploadThrownExceptionWhenFileIsInvalid()
    {
        list($handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($handler, $auth, $keygen, $distributor, $temps);

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
        list($handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($handler, $auth, $keygen, $distributor, $temps);

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
        list($handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = $this->getMock(Storage::class, ['createModel'], [$handler, $auth, $keygen, $distributor, $temps]);

        $mockFile = m::mock('stdClass');

        $instance->expects($this->once())->method('createModel')->willReturn($mockFile);

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

        $mockFile->shouldReceive('save')->andReturn(true);
        $mockTempFile->shouldReceive('destroy')->andReturnNull();

        $file = $instance->create('file_get_content', 'path/to', 'filename', 'local', 'origin-key');

        $this->assertEquals('local', $file->disk);
        $this->assertEquals('filename', $file->clientname);
        $this->assertEquals('image/png', $file->mime);
        $this->assertEquals(123456, $file->size);
        $this->assertEquals('origin-key', $file->originId);
    }

    public function testDownloadThrownExceptionWhenFileNotExists()
    {
        list($handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($handler, $auth, $keygen, $distributor, $temps);

        $mockFile = m::mock('Xpressengine\Storage\File');

        $handler->shouldReceive('exists')->once()->with($mockFile)->andReturn(false);

        try {
            $instance->download($mockFile);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Storage\Exceptions\FileDoesNotExistException', $e);
        }
    }

    public function testRemove()
    {
        list($handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($handler, $auth, $keygen, $distributor, $temps);

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

        $mockFile->shouldReceive('delete')->once()->andReturn(true);
        $mockChild->shouldReceive('delete')->once()->andReturn(true);

        $result = $instance->remove($mockFile);

        $this->assertTrue($result);
    }

    public function testBind()
    {
        list($handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($handler, $auth, $keygen, $distributor, $temps);

        $mockFile = m::mock('Xpressengine\Storage\File')->shouldAllowMockingProtectedMethods();
        $mockConn = m::mock('stdClass');

        $mockFile->shouldReceive('getConnection')->andReturn($mockConn);
        $mockFile->shouldReceive('getFileableTable')->andReturn('fileable_table');
        $mockFile->shouldReceive('getKey')->andReturn('file-id');

        $mockConn->shouldReceive('table')->once()->with('fileable_table')->andReturnSelf();
        $mockConn->shouldReceive('insert')->once()->with(m::on(function ($args) {
            return $args['fileId'] == 'file-id' && $args['fileableId'] == 'fileable-id';
        }))->andReturnSelf();

        $mockFile->shouldReceive('increment')->andReturn(true);


        $instance->bind('fileable-id', $mockFile);
    }

    public function testUnBindNotRemovedFileWhenFlagFalse()
    {
        list($handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = new Storage($handler, $auth, $keygen, $distributor, $temps);

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
        $mockFile->shouldReceive('setAttribute')->once()->with('useCount', 0)->andSet('useCount', 0);
        $mockFile->shouldReceive('save')->andReturn(true);


        $instance->unBind('fileable-id', $mockFile);
    }

    public function testUnBindWillRemovedFileWhenFlagTrue()
    {
        list($handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = $this->getMock(Storage::class, ['remove'], [$handler, $auth, $keygen, $distributor, $temps]);

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
        $mockFile->shouldReceive('setAttribute')->once()->with('useCount', 0)->andSet('useCount', 0);

        $instance->expects($this->once())->method('remove')->with($mockFile)->willReturn(true);

        $instance->unBind('fileable-id', $mockFile, true);
    }

    public function testBytesByMime()
    {
        list($handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = $this->getMock(Storage::class, ['createModel'], [$handler, $auth, $keygen, $distributor, $temps]);

        $mockModel = m::mock('stdClass');
        $mockConn = m::mock('stdClass');

        $instance->expects($this->once())->method('createModel')->willReturn($mockModel);

        $mockModel->shouldReceive('getConnection')->andReturn($mockConn);
        $mockModel->shouldReceive('getTable')->andReturn('file_table');

        $mockConn->shouldReceive('table')->once()->with('file_table')->andReturnSelf();
        $mockConn->shouldReceive('groupBy')->andReturnSelf();
        $mockConn->shouldReceive('select')->andReturnSelf();
        $mockConn->shouldReceive('get')->andReturn([
            ['mime' => 'image/jpeg', 'amount' => 15116107],
            ['mime' => 'image/png', 'amount' => 14008053]
        ]);

        $data = $instance->bytesByMime();

        $this->assertEquals(15116107, reset($data));
        $this->assertEquals(14008053, next($data));
    }

    public function testCountByMime()
    {
        list($handler, $auth, $keygen, $distributor, $temps) = $this->getMocks();
        $instance = $this->getMock(Storage::class, ['createModel'], [$handler, $auth, $keygen, $distributor, $temps]);

        $mockModel = m::mock('stdClass');
        $mockConn = m::mock('stdClass');

        $instance->expects($this->once())->method('createModel')->willReturn($mockModel);

        $mockModel->shouldReceive('getConnection')->andReturn($mockConn);
        $mockModel->shouldReceive('getTable')->andReturn('file_table');

        $mockConn->shouldReceive('table')->once()->with('file_table')->andReturnSelf();
        $mockConn->shouldReceive('groupBy')->andReturnSelf();
        $mockConn->shouldReceive('select')->andReturnSelf();
        $mockConn->shouldReceive('get')->andReturn([
            ['mime' => 'image/jpeg', 'cnt' => 5],
            ['mime' => 'image/png', 'cnt' => 4]
        ]);

        $data = $instance->countByMime();

        $this->assertEquals(5, reset($data));
        $this->assertEquals(4, next($data));
    }

    public function getMocks()
    {
        return [
            m::mock('Xpressengine\Storage\FilesystemHandler'),
            m::mock('Xpressengine\User\GuardInterface'),
            m::mock('Xpressengine\Keygen\Keygen'),
            m::mock('Xpressengine\Storage\Distributor'),
            m::mock('Xpressengine\Storage\TempFileCreator'),
        ];
    }
}
