<?php
namespace Xpressengine\Tests\Storage;

use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Storage\DatabaseFileRepository;

class DatabaseFileRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFindReturnsFileObject()
    {
        list($conn) = $this->getMocks();

        $conn->shouldReceive('table')->once()->withAnyArgs()->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('id', 'fileidstring')->andReturn($conn);
        $conn->shouldReceive('first')->once()->withNoArgs()->andReturn((object)[
            'id' => 'fileidstring',
            'disk' => 'local',
            'path' => 'path/to/dir',
            'filename' => 'abcdefghijklmn',
            'clientname' => 'foo.jpg',
            'mime' => 'image/jpeg',
            'size' => '1024',
            'width' => '709',
            'height' => '706',
        ]);

        $instance = new DatabaseFileRepository($conn);

        $file = $instance->find('fileidstring');

        $this->assertInstanceOf('Xpressengine\Storage\File', $file);
        $this->assertEquals('fileidstring', $file->id);
        $this->assertEquals('local', $file->disk);
        $this->assertEquals('path/to/dir', $file->path);
        $this->assertEquals('abcdefghijklmn', $file->filename);
        $this->assertEquals('foo.jpg', $file->clientname);
    }

    public function testInsert()
    {
        list($conn) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->shouldReceive('getAttributes')->andReturn([
            'disk' => 'local',
            'path' => 'path/to/dir',
            'filename' => 'abcdefghijklmn',
            'clientname' => 'foo.jpg',
            'mime' => 'image/jpeg',
            'size' => '1024',
            'width' => '709',
            'height' => '706',
            'id' => 'made-key'
        ]);

        $conn->shouldReceive('table')->once()->withAnyArgs()->andReturn($conn);
        $conn->shouldReceive('insert')->once()->with(m::on(function ($array) {
            return array_diff_key($array, array_flip(['createdAt'])) === [
                'disk' => 'local',
                'path' => 'path/to/dir',
                'filename' => 'abcdefghijklmn',
                'clientname' => 'foo.jpg',
                'mime' => 'image/jpeg',
                'size' => '1024',
                'width' => '709',
                'height' => '706',
                'id' => 'made-key'
            ];
        }))->andReturnNull();

        $instance = new DatabaseFileRepository($conn);
        $file = $instance->insert($mockFile);

        $this->assertInstanceOf('Xpressengine\Storage\File', $file);
        $this->assertEquals('made-key', $file->id);
        $this->assertEquals('local', $file->disk);
        $this->assertEquals('path/to/dir', $file->path);
        $this->assertEquals('abcdefghijklmn', $file->filename);
        $this->assertEquals('foo.jpg', $file->clientname);
    }

    public function testUpdate()
    {
        list($conn) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->id = 'fileidstring';
        $mockFile->shouldReceive('diff')->andReturn(['path' => 'path/to/dir/sub']);
        $mockFile->shouldReceive('getOriginal')->andReturn([
            'id' => 'fileidstring',
            'disk' => 'local',
            'path' => 'path/to/dir',
            'filename' => 'abcdefghijklmn',
            'clientname' => 'foo.jpg',
            'mime' => 'image/jpeg',
            'size' => '1024',
            'width' => '709',
            'height' => '706',
        ]);

        $conn->shouldReceive('table')->once()->withAnyArgs()->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('id', 'fileidstring')->andReturn($conn);
        $conn->shouldReceive('update')->once()->with(['path' => 'path/to/dir/sub'])->andReturnNull();

        $instance = new DatabaseFileRepository($conn);
        $file = $instance->update($mockFile);

        $this->assertInstanceOf('Xpressengine\Storage\File', $file);
        $this->assertEquals('fileidstring', $file->id);
        $this->assertEquals('local', $file->disk);
        $this->assertEquals('path/to/dir/sub', $file->path);
        $this->assertEquals('abcdefghijklmn', $file->filename);
        $this->assertEquals('foo.jpg', $file->clientname);
    }

    public function testFetch()
    {
        list($conn, $query) = $this->getMocks();

        $conn->shouldReceive('table')->once()->withAnyArgs()->andReturn($query);
        $query->shouldReceive('where')->once()->with('disk', 'local')->andReturn($query);
        $query->shouldReceive('where')->once()->with('mime', 'image/jpeg')->andReturn($query);
        $query->shouldReceive('get')->once()->withNoArgs()->andReturn([
            (object)[
                'id' => 'fileidstring1',
                'disk' => 'local',
                'path' => 'path/to/dir/1',
                'filename' => 'abcdefghijklmn',
                'clientname' => 'foo.jpg',
                'mime' => 'image/jpeg',
            ],
            (object)[
                'id' => 'fileidstring2',
                'disk' => 'local',
                'path' => 'path/to/dir/2',
                'filename' => 'abcdefghijklmnopqr',
                'clientname' => 'bar.jpg',
                'mime' => 'image/jpeg',
            ]
        ]);


        $instance = new DatabaseFileRepository($conn);
        $files = $instance->fetch([
            'disk' => 'local',
            'mime' => 'image/jpeg',
        ]);

        $this->assertEquals(2, count($files));

        $this->assertInstanceOf('Xpressengine\Storage\File', $files[0]);
        $this->assertEquals('fileidstring1', $files[0]->id);
        $this->assertEquals('local', $files[0]->disk);
        $this->assertEquals('path/to/dir/1', $files[0]->path);
        $this->assertEquals('abcdefghijklmn', $files[0]->filename);
        $this->assertEquals('foo.jpg', $files[0]->clientname);
        $this->assertEquals('image/jpeg', $files[0]->mime);


        $this->assertInstanceOf('Xpressengine\Storage\File', $files[1]);
        $this->assertEquals('fileidstring2', $files[1]->id);
        $this->assertEquals('local', $files[1]->disk);
        $this->assertEquals('path/to/dir/2', $files[1]->path);
        $this->assertEquals('abcdefghijklmnopqr', $files[1]->filename);
        $this->assertEquals('bar.jpg', $files[1]->clientname);
        $this->assertEquals('image/jpeg', $files[1]->mime);
    }

    public function testFetchByTargetId()
    {
        list($conn, $query) = $this->getMocks();

        $conn->shouldReceive('table')->once()->withAnyArgs()->andReturn($query);
        $query->shouldReceive('leftJoin')
            ->once()
            ->with('files_relation', 'files.id', '=', 'files_relation.filesId')
            ->andReturn($query);
        $query->shouldReceive('where')->once()->with('files_relation.targetId', 'targetidstring')->andReturn($query);
        $query->shouldReceive('get')->once()->with(['files.*'])->andReturn([
            (object)[
                'id' => 'fileidstring1',
                'disk' => 'local',
                'path' => 'path/to/dir/1',
                'filename' => 'abcdefghijklmn',
                'clientname' => 'foo.jpg',
                'mime' => 'image/jpeg',
            ],
            (object)[
                'id' => 'fileidstring2',
                'disk' => 'local',
                'path' => 'path/to/dir/2',
                'filename' => 'abcdefghijklmnopqr',
                'clientname' => 'bar.jpg',
                'mime' => 'image/jpeg',
            ]
        ]);

        $instance = new DatabaseFileRepository($conn);
        $files = $instance->fetchByTargetId('targetidstring');

        $this->assertEquals(2, count($files));

        $this->assertInstanceOf('Xpressengine\Storage\File', $files[0]);
        $this->assertEquals('fileidstring1', $files[0]->id);
        $this->assertEquals('local', $files[0]->disk);
        $this->assertEquals('path/to/dir/1', $files[0]->path);
        $this->assertEquals('abcdefghijklmn', $files[0]->filename);
        $this->assertEquals('foo.jpg', $files[0]->clientname);
        $this->assertEquals('image/jpeg', $files[0]->mime);


        $this->assertInstanceOf('Xpressengine\Storage\File', $files[1]);
        $this->assertEquals('fileidstring2', $files[1]->id);
        $this->assertEquals('local', $files[1]->disk);
        $this->assertEquals('path/to/dir/2', $files[1]->path);
        $this->assertEquals('abcdefghijklmnopqr', $files[1]->filename);
        $this->assertEquals('bar.jpg', $files[1]->clientname);
        $this->assertEquals('image/jpeg', $files[1]->mime);
    }

    public function testDelete()
    {
        list($conn) = $this->getMocks();

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockFile->id = 'fileidstring';

        $query = m::mock('Illuminate\Database\Query\Builder');

        $conn->shouldReceive('beginTransaction')->andReturnNull();
        $conn->shouldReceive('rollBack')->andReturnNull();
        $conn->shouldReceive('commit')->andReturnNull();

        $conn->shouldReceive('table')->once()->withAnyArgs()->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'fileidstring')->andReturn($query);
        $query->shouldReceive('delete')->once()->withNoArgs()->andReturnNull();

        // relation table
        $conn->shouldReceive('table')->once()->withAnyArgs()->andReturn($query);
        $query->shouldReceive('where')->once()->with('filesId', 'fileidstring')->andReturn($query);
        $query->shouldReceive('delete')->once()->withNoArgs()->andReturnNull();

        $instance = new DatabaseFileRepository($conn);
        $instance->delete($mockFile);
    }

    public function testRelating()
    {
        list($conn) = $this->getMocks();

        $conn->shouldReceive('beginTransaction')->andReturnNull();
        $conn->shouldReceive('rollBack')->andReturnNull();
        $conn->shouldReceive('commit')->andReturnNull();

        $conn->shouldReceive('table')->withAnyArgs()->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('targetId', 'targetidstring')->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('filesId', 'fileidstring')->andReturn($conn);
        $conn->shouldReceive('first')->once()->withNoArgs()->andReturnNull();

        $conn->shouldReceive('insert')->once()->with(m::on(function ($array) {
            return $array['targetId'] === 'targetidstring'
            && $array['filesId'] === 'fileidstring';
        }))->andReturnNull();

        $conn->shouldReceive('where')->once()->with('id', 'fileidstring')->andReturn($conn);
        $conn->shouldReceive('orWhere')->once()->with('parentId', 'fileidstring')->andReturn($conn);
        $conn->shouldReceive('increment')->once()->with('useCount')->andReturnNull();

        $instance = new DatabaseFileRepository($conn);
        $instance->relating('targetidstring', 'fileidstring');
    }

    public function testUnRelating()
    {
        list($conn, $query) = $this->getMocks();

        $conn->shouldReceive('beginTransaction')->andReturnNull();
        $conn->shouldReceive('rollBack')->andReturnNull();
        $conn->shouldReceive('commit')->andReturnNull();

        $conn->shouldReceive('table')->withAnyArgs()->andReturn($query);
        $query->shouldReceive('where')->once()->with('targetId', 'targetidstring')->andReturn($query);
        $query->shouldReceive('where')->once()->with('filesId', 'fileidstring')->andReturn($query);
        $query->shouldReceive('first')->once()->withNoArgs()->andReturn((object)[
            'id' => 1,
            'targetId' => 'targetidstring',
            'filesId' => 'fileidstring',
        ]);

        $query->shouldReceive('where')->once()->with('id', 1)->andReturn($query);
        $query->shouldReceive('delete')->once()->withNoArgs()->andReturnNull();

        $query->shouldReceive('where')->once()->with('id', 'fileidstring')->andReturn($query);
        $query->shouldReceive('orWhere')->once()->with('parentId', 'fileidstring')->andReturn($query);
        $query->shouldReceive('decrement')->once()->with('useCount')->andReturnNull();

        $instance = new DatabaseFileRepository($conn);
        $instance->unRelating('targetidstring', 'fileidstring');
    }

    public function testSum()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DatabaseFileRepository($conn);

        $conn->shouldReceive('table')->withAnyArgs()->andReturn($query);
        $query->shouldReceive('sum')->once()->with('someColumn')->andReturn(10);

        $amount = $instance->sum('someColumn');

        $this->assertEquals(10, $amount);
    }

    public function testSumGroupBy()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DatabaseFileRepository($conn);

        $conn->shouldReceive('table')->withAnyArgs()->andReturn($query);
        $query->shouldReceive('selectRaw')->once()->with("`groupByColumn`, sum(`someColumn`) as amount")->andReturnSelf();
        $query->shouldReceive('groupBy')->once()->with('groupByColumn')->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn([
            [
                'groupByColumn' => 'columnName1',
                'amount' => 3
            ],
            [
                'groupByColumn' => 'columnName2',
                'amount' => 5
            ],
        ]);

        $dataArray = $instance->sumGroupBy('someColumn', 'groupByColumn');

        $this->assertEquals(2, count($dataArray));
    }

    public function testCount()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DatabaseFileRepository($conn);

        $conn->shouldReceive('table')->withAnyArgs()->andReturn($query);
        $query->shouldReceive('count')->once()->andReturn(10);

        $count = $instance->count();

        $this->assertEquals(10, $count);
    }

    public function testCountGroupBy()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DatabaseFileRepository($conn);

        $conn->shouldReceive('table')->withAnyArgs()->andReturn($query);
        $query->shouldReceive('selectRaw')->once()->with("`groupByColumn`, count(*) as cnt")->andReturnSelf();
        $query->shouldReceive('groupBy')->once()->with('groupByColumn')->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn([
            [
                'groupByColumn' => 'columnName1',
                'cnt' => 3
            ],
            [
                'groupByColumn' => 'columnName2',
                'cnt' => 5
            ],
        ]);

        $dataArray = $instance->countGroupBy('groupByColumn');

        $this->assertEquals(2, count($dataArray));
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnectionInterface'),
            m::mock('Xpressengine\Database\DynamicQuery'),
        ];
    }
}
