<?php
namespace Xpressengine\Tests\Comment;

use Mockery as m;
use Xpressengine\Comment\Repositories\DivisionRepository;

class DivisionRepositoryTest extends \PHPUnit_Framework_TestCase
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
        list($conn, $query) = $this->getMocks();
        $instance = new DivisionRepository($conn, 'table');

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn([
            'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'instanceId' => 'instanceId',
            'userId' => 'userId',
            'content' => 'content text'
        ]);

        $comment = $instance->find('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $this->assertInstanceOf('Xpressengine\Comment\CommentEntity', $comment);
        $this->assertEquals('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $comment->id);
        $this->assertEquals('instanceId', $comment->instanceId);
    }

    public function testFetch()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DivisionRepository($conn, 'table');

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('limit')->once()->with(3)->andReturnSelf();
        $query->shouldReceive('orderBy')->once()->with('head', 'desc')->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn([
            [
                'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
                'instanceId' => 'instanceId',
                'userId' => 'userId',
                'content' => 'content text1'
            ],
            [
                'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy',
                'instanceId' => 'instanceId',
                'userId' => 'userId',
                'content' => 'content text2'
            ]
        ]);

        $comments = $instance->fetch([], 3, ['head' => 'desc']);

        $this->assertEquals(2, count($comments));
    }

    public function testInsert()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DivisionRepository($conn, 'table');

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->shouldReceive('getAttributes')->andReturn([
            'instanceId' => 'instanceId',
            'userId' => 'userId',
            'content' => 'content text'
        ]);

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('insert')->once()->with([
            'instanceId' => 'instanceId',
            'userId' => 'userId',
            'content' => 'content text'
        ]);

        $comment = $instance->insert($mockComment);

        $this->assertEquals($mockComment, $comment);
    }

    public function testUpdate()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DivisionRepository($conn, 'table');

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $mockComment->shouldReceive('getAttributes')->andReturn([
            'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'instanceId' => 'instanceId',
            'userId' => 'userId',
            'content' => 'content text'
        ]);

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('update')->once()->with([
            'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'instanceId' => 'instanceId',
            'userId' => 'userId',
            'content' => 'content text'
        ]);

        $comment = $instance->update($mockComment);

        $this->assertEquals($mockComment, $comment);
    }

    public function testDelete()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DivisionRepository($conn, 'table');

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('delete')->once()->andReturn(1);

        $instance->delete($mockComment);
    }

    public function testSoftDelete()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DivisionRepository($conn, 'table');

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('update')->once();

        $instance->softDelete($mockComment);
    }

    public function testUnDelete()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DivisionRepository($conn, 'table');

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('update')->once()->with(['deletedAt' => null]);

        $instance->unDelete($mockComment);
    }

    public function testGetLastChildReply()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DivisionRepository($conn, 'table');

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->head = 'xxxxxxxxxxxxxxxxxxx';
        $mockComment->reply = '000';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('head', 'xxxxxxxxxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('where')->once()->with('reply', 'like', '000___')->andReturnSelf();
        $query->shouldReceive('max')->once()->with('reply')->andReturn('000000');

        $replyCode = $instance->getLastChildReply($mockComment);

        $this->assertEquals('000000', $replyCode);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnectionInterface'),
            m::mock('Xpressengine\Database\DynamicQuery'),
        ];
    }
}