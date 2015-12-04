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
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $resource = file_get_contents(__DIR__ . '/sample.png');

        $mockGuest = m::mock('Xpressengine\Member\Entities\Guest');
        $mockGuest->shouldReceive('getId')->andReturnNull();
        $auth->shouldReceive('user')->andReturn($mockGuest);

        $uploaded = m::mock('Symfony\Component\HttpFoundation\File\UploadedFile');
        $uploaded->shouldReceive('isValid')->andReturn(true);
        $uploaded->shouldReceive('getClientOriginalName')->andReturn('foo.jpg');
        $uploaded->shouldReceive('getPathname')->andReturn(__DIR__ . '/sample.png');

        $keygen->shouldReceive('generate')->once()->andReturn('made-key');

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->mime = 'image/jpeg';

//        $makedFilename = date('YmdHis') . hash('sha1', 'foo.jpg');
        $handler->shouldReceive('store')
            ->once()
            ->with($resource, m::on(function () { return true; }), null)
            ->andReturn($mockFile);

        $repo->shouldReceive('insert')->once()->with($mockFile)->andReturn($mockFile);

        $instance = new Storage($handler, $repo, $auth, $keygen);
        $file = $instance->upload($uploaded, 'attached');

        $this->assertInstanceOf('Xpressengine\Storage\File', $file);
    }

    public function testUploadThrownExceptionWhenFileIsInvalid()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $uploaded = m::mock('Symfony\Component\HttpFoundation\File\UploadedFile');
        $uploaded->shouldReceive('isValid')->andReturn(false);
        $uploaded->shouldReceive('getClientOriginalName')->andReturn('foo.jpg');

        $instance = new Storage($handler, $repo, $auth, $keygen);

        try {
            $instance->upload($uploaded, 'attached');
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Storage\Exceptions\InvalidFileException', $e);
        }
    }

    public function testCreate()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();
        $instance = new Storage($handler, $repo, $auth, $keygen);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $keygen->shouldReceive('generate')->andReturn('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
        $handler->shouldReceive('store')->once()->with(m::on(function () {
            return true;
        }), m::on(function () {
            return true;
        }), 'local')->andReturn($mockFile);

        $repo->shouldReceive('insert')->once()->with($mockFile)->andReturn($mockFile);

        $file = $instance->create('file_get_content', 'path/to', 'filename', 'local', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy');

        $this->assertInstanceOf('Xpressengine\Storage\File', $file);
    }

    public function testDownloadThrownExceptionWhenFileNotExists()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');

        $handler->shouldReceive('exists')->once()->with($mockFile)->andReturn(false);

        $instance = new Storage($handler, $repo, $auth, $keygen);

        try {
            $instance->download($mockFile);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Storage\Exceptions\FileDoesNotExistException', $e);
        }
    }

    public function testRead()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $resource = file_get_contents(__DIR__ . '/sample.png');

        $mockFile = m::mock('Xpressengine\Storage\File');

        $handler->shouldReceive('content')->once()->with($mockFile)->andReturn($resource);

        $instance = new Storage($handler, $repo, $auth, $keygen);

        $this->assertEquals($resource, $instance->read($mockFile));
    }

    public function testGet()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');

        $repo->shouldReceive('find')->once()->with('fileidstring')->andReturn($mockFile);

        $instance = new Storage($handler, $repo, $auth, $keygen);

        $file = $instance->get('fileidstring');

        $this->assertInstanceOf('Xpressengine\Storage\File', $file);
    }

    public function testGetsIn()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();
        $instance = new Storage($handler, $repo, $auth, $keygen);

        $mockFile1 = m::mock('Xpressengine\Storage\File');
        $mockFile2 = m::mock('Xpressengine\Storage\File');

        $repo->shouldReceive('fetchIn')->once()->with(['id_1', 'id_2'])->andReturn([$mockFile1, $mockFile2]);

        $files = $instance->getsIn(['id_1', 'id_2']);

        $this->assertEquals(2, count($files));
    }
    
    public function testGetsByTargetId()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $mockFile1 = m::mock('Xpressengine\Storage\File');
        $mockFile2 = m::mock('Xpressengine\Storage\File');

        $repo->shouldReceive('fetchByTargetId')->once()->with('targetidstring')->andReturn([$mockFile1, $mockFile2]);

        $instance = new Storage($handler, $repo, $auth, $keygen);

        $files = $instance->getsByTargetId('targetidstring');

        $this->assertEquals(2, count($files));
    }

    public function testPaginate()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();
        $instance = new Storage($handler, $repo, $auth, $keygen);

        $paginator = m::mock('Illuminate\Contracts\Pagination\LengthAwarePaginator');
        $repo->shouldReceive('paginate')->once()->with(['var' => 'foo'], 10)->andReturn($paginator);

        $files = $instance->paginate(['var' => 'foo'], 10);

        $this->assertInstanceOf('Illuminate\Contracts\Pagination\LengthAwarePaginator', $files);
    }

    public function testModify()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');

        $repo->shouldReceive('update')->once()->with($mockFile)->andReturn($mockFile);

        $instance = new Storage($handler, $repo, $auth, $keygen);

        $file = $instance->modify($mockFile);

        $this->assertInstanceOf('Xpressengine\Storage\File', $file);
    }

    public function testModifyContent()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();
        $instance = new Storage($handler, $repo, $auth, $keygen);

        $content = 'new file content';
        $mockFile = m::mock('Xpressengine\Storage\File');

        $handler->shouldReceive('change')->once()->with($mockFile, $content)->andReturn($mockFile);
        $repo->shouldReceive('update')->once()->with($mockFile)->andReturn($mockFile);

        $file = $instance->modifyContent($mockFile, $content);

        $this->assertInstanceOf('Xpressengine\Storage\File', $file);
    }
    
    public function testRemove()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->id = 'fileidentifier';

        $mockChild = m::mock('Xpressengine\Storage\File');
        $mockChild->id = 'filechildidentifier';
        $mockChild->parentId = 'fileidentifier';

        $repo->shouldReceive('fetch')->once()->with(['parentId' => 'fileidentifier'])->andReturn([$mockChild]);

        $handler->shouldReceive('delete')->once()->with($mockChild)->andReturnNull();
        $repo->shouldReceive('delete')->once()->with($mockChild)->andReturnNull();

        $handler->shouldReceive('delete')->once()->with($mockFile)->andReturnNull();
        $repo->shouldReceive('delete')->once()->with($mockFile)->andReturnNull();

        $instance = new Storage($handler, $repo, $auth, $keygen);

        $instance->remove($mockFile);
    }

    public function testRemoveAll()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $mockFile1 = m::mock('Xpressengine\Storage\File');
        $mockFile1->id = 'fileidstring1';
        $mockFile1->use_count = 2;
        $mockFile2 = m::mock('Xpressengine\Storage\File');
        $mockFile2->id = 'fileidstring2';
        $mockFile2->use_count = 2;

        $repo->shouldReceive('fetchByTargetId')->once()->with('targetidstring')->andReturn([$mockFile1, $mockFile2]);

        $repo->shouldReceive('unRelating')->once()->with('targetidstring', 'fileidstring1')->andReturnNull();
        $repo->shouldReceive('unRelating')->once()->with('targetidstring', 'fileidstring2')->andReturnNull();

        $repo->shouldReceive('fetch')->once()->with(['parentId' => 'fileidstring1'])->andReturn([]);
        $repo->shouldReceive('fetch')->once()->with(['parentId' => 'fileidstring2'])->andReturn([]);

        $repo->shouldReceive('delete')->once()->with($mockFile1)->andReturnNull();
        $repo->shouldReceive('delete')->once()->with($mockFile2)->andReturnNull();

        $handler->shouldReceive('delete')->once()->with($mockFile1)->andReturnNull();
        $handler->shouldReceive('delete')->once()->with($mockFile2)->andReturnNull();

        $instance = new Storage($handler, $repo, $auth, $keygen);

        $instance->removeAll('targetidstring');
    }

    public function testBind()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->id = 'fileidstring';

        $repo->shouldReceive('relating')->once()->with('targetidstring', 'fileidstring')->andReturnNull();

        $instance = new Storage($handler, $repo, $auth, $keygen);

        $instance->bind('targetidstring', $mockFile);
    }

    public function testUnBindNotRemovedFileWhenFlagFalse()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->id = 'fileidstring';

        $repo->shouldReceive('unRelating')->once()->with('targetidstring', 'fileidstring')->andReturnNull();

        $instance = new Storage($handler, $repo, $auth, $keygen);

        $instance->unBind('targetidstring', $mockFile);
    }

    public function testChildren()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->id = 'fileidstring';

        $mockChild1 = m::mock('Xpressengine\Storage\File');
        $mockChild2 = m::mock('Xpressengine\Storage\File');

        $repo->shouldReceive('fetch')
            ->once()
            ->with(['parentId' => 'fileidstring'])
            ->andReturn([$mockChild1, $mockChild2]);

        $instance = new Storage($handler, $repo, $auth, $keygen);

        $children = $instance->children($mockFile);

        $this->assertEquals(2, count($children));
    }

    public function testBytes()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();
        $instance = new Storage($handler, $repo, $auth, $keygen);

        $repo->shouldReceive('sum')->twice()->andReturn(15116107);

        $bytes = $instance->bytes([], false);

        $this->assertEquals(15116107, $bytes);

        $bytes = $instance->bytes();

        $this->assertEquals(15116107, $bytes);
    }

    public function testBytesByMime()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();
        $instance = new Storage($handler, $repo, $auth, $keygen);

        $repo->shouldReceive('sumGroupBy')->twice()->andReturn([
            'image/jpeg' => 15116107,
            'image/gif' => 14008053
        ]);

        $data = $instance->bytesByMime([], false);

        $this->assertEquals(15116107 + 14008053, array_sum($data));

        $data = $instance->bytesByMime();

        $this->assertEquals(15116107, reset($data));
        $this->assertEquals(14008053, next($data));
    }

    public function testCount()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();
        $instance = new Storage($handler, $repo, $auth, $keygen);

        $repo->shouldReceive('count')->andReturn(10);

        $this->assertEquals(10, $instance->count());
    }

    public function testCountByMime()
    {
        list($handler, $repo, $auth, $keygen) = $this->getMocks();
        $instance = new Storage($handler, $repo, $auth, $keygen);

        $repo->shouldReceive('countGroupBy')->andReturn(10);

        $this->assertEquals(10, $instance->countByMime());
    }

    public function getMocks()
    {
        return [
            m::mock('Xpressengine\Storage\FileHandler'),
            m::mock('Xpressengine\Storage\FileRepository'),
            m::mock('Xpressengine\Member\GuardInterface'),
            m::mock('Xpressengine\Keygen\Keygen')
        ];
    }
}
