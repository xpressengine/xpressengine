<?php
namespace Xpressengine\Tests\Comment;

use Mockery as m;
use Xpressengine\Comment\Repositories\CommentRepository;

class CommentRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        \Xpressengine\Comment\CommentEntity::setReplyCharlen(3);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testFind()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new CommentRepository($conn, $keygen);

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'commentId')->andReturn($query);
        $query->shouldReceive('first')->once()->withNoArgs()->andReturn((object)[
            'id' => 'commentId',
            'instanceId' => 'instanceId',
            'userId' => 'userId',
        ]);

        $query->shouldReceive('where')->once()->with('id', 'unknownId')->andReturn($query);
        $query->shouldReceive('first')->once()->withNoArgs()->andReturnNull();


        $comment = $instance->find('commentId');
        $this->assertInstanceOf('Xpressengine\Comment\CommentEntity', $comment);
        $this->assertEquals('commentId', $comment->id);

        $comment = $instance->find('unknownId');
        $this->assertNull($comment);
    }

    public function testFetchBaseInstanceId()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new CommentRepository($conn, $keygen);

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->once()->with('instanceId', 'instanceId')->andReturn($query);

        $query->shouldReceive('limit')->once()->with('10')->andReturn($query);
        $query->shouldReceive('get')->once()->withNoArgs()->andReturn([
            (object)[
                'id' => 'commentId1',
                'instanceId' => 'instanceId',
                'userId' => 'userId1',
            ],
            (object)[
                'id' => 'commentId2',
                'instanceId' => 'instanceId',
                'userId' => 'userId2',
            ],
        ]);

        $comments = $instance->fetchBaseInstanceId('instanceId', [], 10);
        $this->assertEquals(2, count($comments));
        $this->assertEquals('commentId1', $comments[0]->id);
        $this->assertEquals('commentId2', $comments[1]->id);
    }

    public function testPaginate()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new CommentRepository($conn, $keygen);

        $mockPaginator = m::mock('Illuminate\Contracts\Pagination\LengthAwarePaginator');

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('orderBy')->once()->with('createdAt', 'desc');
        $query->shouldReceive('paginate')->once()->with(3)->andReturn($mockPaginator);

        $instance->paginate([], 3, ['createdAt' => 'desc']);
    }

    public function testFetchIn()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new CommentRepository($conn, $keygen);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('whereIn')
            ->once()
            ->with('id', ['xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy'])
            ->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn([
            [
                'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
                'instanceId' => 'instanceId',
                'userId' => 'userId1',
            ],
            [
                'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy',
                'instanceId' => 'instanceId',
                'userId' => 'userId2',
            ],
        ]);


        $comments = $instance->fetchIn(['xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy']);

        $this->assertEquals(2, count($comments));
    }

    public function testInsert()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new CommentRepository($conn, $keygen);

        $timestamp = time();

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->shouldReceive('getAttributes')->andReturn([
            'instanceId' => 'instanceId',
            'userId' => 'userId',
        ]);

        $keygen->shouldReceive('generate')->andReturn('uniqueId');

        $conn->shouldReceive('dynamic')->andReturn($query);

        $query->shouldReceive('insert')->once()->with(m::on(function ($array) {
            return $array['instanceId'] === 'instanceId'
            && $array['userId'] === 'userId'
            && $array['id'] === 'uniqueId';
        }))->andReturnNull();

        $query->shouldReceive('where')->once()->with('id', 'uniqueId')->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn([
            'instanceId' => 'instanceId',
            'userId' => 'userId',
            'id' => 'uniqueId'
        ]);

        $comment = $instance->insert($mockComment);

        $this->assertInstanceOf('Xpressengine\Comment\CommentEntity', $comment);
    }

    public function testUpdate()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new CommentRepository($conn, $keygen);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->shouldReceive('diff')->andReturn(['content' => 'content text']);
        $mockComment->shouldReceive('getAttributes')->andReturn([
            'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'instanceId' => 'instanceId',
            'userId' => 'userId',
            'content' => 'content text'
        ]);
        $mockComment->id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturn($query);
        $query->shouldReceive('update')->once()->with(m::on(function ($array) {
            return $array['content'] === 'content text';
        }))->andReturnNull();


        $comment = $instance->update($mockComment);

        $this->assertInstanceOf('Xpressengine\Comment\CommentEntity', $comment);
        $this->assertEquals('content text', $comment->content);
    }

    public function testDelete()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new CommentRepository($conn, $keygen);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturn($query);
        $query->shouldReceive('delete')->once()->andReturn(1);

        $instance->delete($mockComment);
    }

    public function testSoftDelete()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new CommentRepository($conn, $keygen);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $mockComment->shouldReceive('getOriginal')->andReturn([
            'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'instanceId' => 'instanceId',
            'userId' => 'userId',
            'content' => 'content previous text'
        ]);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturn($query);
        $query->shouldReceive('update')->once();

        $instance->softDelete($mockComment);
    }

    public function testUnDelete()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new CommentRepository($conn, $keygen);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $mockComment->shouldReceive('getOriginal')->andReturn([
            'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'instanceId' => 'instanceId',
            'userId' => 'userId',
            'content' => 'content previous text'
        ]);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('update')->once()->with(['deletedAt' => null]);

        $instance->unDelete($mockComment);
    }

    public function testMoveTo()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new CommentRepository($conn, $keygen);


        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->shouldReceive('diff')->andReturn(['instanceId' => 'anotherInstance']);
        $mockComment->shouldReceive('getOriginal')->andReturn([
            'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'instanceId' => 'instanceId',
            'userId' => 'userId',
            'content' => 'content text'
        ]);
        $mockComment->id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturn($query);

        $query->shouldReceive('update')->once()->with(m::on(function ($array) {
            return $array['instanceId'] === 'anotherInstance';
        }))->andReturnNull();


        $comment = $instance->moveTo($mockComment, 'anotherInstance');

        $this->assertInstanceOf('Xpressengine\Comment\CommentEntity', $comment);
        $this->assertEquals('anotherInstance', $comment->instanceId);
    }

    public function testGetLastChildReply()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new CommentRepository($conn, $keygen);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->head = 'xxxxxxxxxxxxxxxxxxx';
        $mockComment->reply = '000';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('head', 'xxxxxxxxxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('where')->once()->with('reply', 'like', '000___')->andReturnSelf();
        $query->shouldReceive('max')->once()->andReturn('000000');

        $this->assertEquals('000000', $instance->getLastChildReply($mockComment));
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnectionInterface'),
            m::mock('Xpressengine\Keygen\Keygen'),
            m::mock('Xpressengine\Database\DynamicQuery')
        ];
    }
}
