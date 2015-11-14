<?php
namespace Xpressengine\Tests\Comment;

use Mockery as m;
use Xpressengine\Comment\CommentHandler;
use Xpressengine\Tests\Member\MemberRepositoryTest;

class CommentHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        \Xpressengine\Comment\CommentEntity::setReplyCharlen(3);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testConfigureThrowsExceptionWhenConfigNotExists()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $information = [
            'division' => true,
            'useApprove' => false,
            'secret' => true,
        ];

        $cfg->shouldReceive('get')->once()->with('comments.instanceId')->andReturnNull();

        try {
            $instance->configure('instanceId', $information);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Comment\Exceptions\NotConfigurationException', $e);
        }
    }

    public function testConfigure()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $information = [
            'division' => true,
            'useApprove' => false,
            'secret' => true,
        ];

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');

        $mockConfig->shouldReceive('set')->once()->with('useAssent', false);
        $mockConfig->shouldReceive('set')->once()->with('useDissent', false);
        $mockConfig->shouldReceive('set')->once()->with('useApprove', false);
        $mockConfig->shouldReceive('set')->once()->with('secret', true);
        $mockConfig->shouldReceive('set')->once()->with('perPage', 20);
        $mockConfig->shouldReceive('set')->once()->with('useWysiwyg', false);
        $mockConfig->shouldReceive('set')->once()->with('removeType', 'batch');
        $mockConfig->shouldReceive('set')->once()->with('reverse', false);

        $cfg->shouldReceive('get')->once()->with('comments.instanceId')->andReturn($mockConfig);
        $cfg->shouldReceive('modify')->once()->with($mockConfig)->andReturnNull();

        $instance->configure('instanceId', $information);
    }

    public function testCreateInstance()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $cfg->shouldReceive('set')->once()->with('comments.instanceId', m::on(function () {
            return true;
        }));

        $repo->shouldReceive('createInstance')->once()->with('instanceId');


        $instance->createInstance('instanceId');
    }

    public function testGetConfig()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('set');

        $cfg->shouldReceive('get')->once()->with('comments.instanceId')->andReturnNull();
        $cfg->shouldReceive('getOrNew')->once()->with('comments.instanceId')->andReturn($mockConfig);

        $config = $instance->getConfig('instanceId');

        $this->assertEquals($mockConfig, $config);
    }

    public function testDrop()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $repo->shouldReceive('dropInstance')->once()->with('instanceId');

        $cfg->shouldReceive('removeByName')->once();

        $instance->drop('instanceId');
    }

    public function testGet()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $repo->shouldReceive('find')->once()->with($id)->andReturn($mockComment);
        $member->shouldReceive('associate')->once()->with($mockComment)->andReturn($mockComment);

        $comment = $instance->get($id);

        $this->assertInstanceOf('Xpressengine\Comment\CommentEntity', $comment);
    }

    public function testGetBaseInstance()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');

        $repo->shouldReceive('findBaseInstanceId')->once()->with('instanceId', $id)->andReturn($mockComment);
        $member->shouldReceive('associate')->once()->with($mockComment)->andReturn($mockComment);

        $comment = $instance->getBaseInstance('instanceId', $id);

        $this->assertInstanceOf('Xpressengine\Comment\CommentEntity', $comment);
    }

    public function testLoadMore()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $offsetHead = 'xxxxxxxxxxxxxxxxxxx';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->with('perPage')->andReturn(3);
        $mockConfig->shouldReceive('get')->with('reverse')->andReturn(false);

        $cfg->shouldReceive('get')->once()->with('comments.instanceId')->andReturn($mockConfig);

        $mockComment1 = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment1->userId = 'id1';
        $mockComment1->shouldReceive('setAuthor');
        $mockComment1->shouldReceive('setTarget');
        $mockComment1->shouldReceive('setPermission');
        $mockComment2 = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment2->userId = 'id2';
        $mockComment2->shouldReceive('setAuthor');
        $mockComment2->shouldReceive('setTarget');
        $mockComment2->shouldReceive('setPermission');

        $repo->shouldReceive('countBaseInstanceId')
            ->once()
            ->with('instanceId', ['targetId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'])
            ->andReturn(10);

        $repo->shouldReceive('fetchBaseInstanceId')
            ->once()
            ->with(
                'instanceId',
                m::on(function ($value) use ($offsetHead) {
                    $closure = $value[0];
                    $mockQuery = m::mock('Xpressengine\Database\DynamicQuery');
                    $mockQuery->shouldReceive('where')->once()->with('head', $offsetHead);
                    $mockQuery->shouldReceive('where')->once()->with('reply', '<', '');
                    $mockQuery->shouldReceive('orWhere')->once()->with('head', '<', $offsetHead);

                    call_user_func($closure, $mockQuery);

                    return true;
                }),
                4,
                ['head' => 'desc', 'reply' => 'desc']
            )->andReturn([$mockComment1, $mockComment2]);

        $member->shouldReceive('associates')->once()
            ->with([$mockComment1, $mockComment2])
            ->andReturn([$mockComment1, $mockComment2]);

        $instance->loadMore('instanceId', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', [], $offsetHead);
    }

    public function testPaginate()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $paginator = m::mock('Illuminate\Pagination\Paginator');
        $repo->shouldReceive('paginate')->once()->with([], 10, m::on(function () { return true; }))->andReturn($paginator);

        $instance->paginate([], 10);
    }

    public function testGetsIn()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $ids = ['xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy'];

        $mockComment1 = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment2 = m::mock('Xpressengine\Comment\CommentEntity');

        $repo->shouldReceive('fetchIn')->once()->with($ids)->andReturn([$mockComment1, $mockComment2]);

        $comments = $instance->getsIn($ids);

        $this->assertEquals(2, count($comments));
    }

    public function testGets()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $repo->shouldReceive('fetch')->once()->with(['var' => 'foo'])->andReturn([]);

        $comments = $instance->gets(['var' => 'foo']);

        $this->assertEquals([], $comments);
    }

    public function testAddThrowsExceptionWhenHasWrongParentId()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->targetId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $mockComment->instanceId = 'instanceId';
        $mockComment->parentId = 'yyyyyyyy-yyyy-yyyy-yyyy-yyyyyyyyyyyy';

        $mockUser = m::mock('Xpressengine\Member\Entities\MemberEntityInterface');
        $mockUser->shouldReceive('getId')->andReturn('userId');
        $mockUser->shouldReceive('getDisplayName')->andReturn('userName');

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('useWysiwyg')->andReturn(true);
        $cfg->shouldReceive('get')->once()->andReturn($mockConfig);

        $auth->shouldReceive('user')->andReturn($mockUser);

        $repo->shouldReceive('find')->once()->with('yyyyyyyy-yyyy-yyyy-yyyy-yyyyyyyyyyyy')->andReturnNull();

        try {
            $instance->add($mockComment);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Comment\Exceptions\UnknownIdentifierException', $e);
        }
    }

    public function testAdd()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->targetId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $mockComment->instanceId = 'instanceId';
        $mockComment->parentId = 'yyyyyyyy-yyyy-yyyy-yyyy-yyyyyyyyyyyy';

        $mockUser = m::mock('Xpressengine\Member\Entities\MemberEntityInterface');
        $mockUser->shouldReceive('getId')->andReturn('userId');
        $mockUser->shouldReceive('getDisplayName')->andReturn('userName');

        $auth->shouldReceive('user')->andReturn($mockUser);

        $mockParent = m::mock('Xpressengine\Comment\CommentEntity');
        $mockParent->head = 'xxxxxxxxxxxxxxxxxxx';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('useWysiwyg')->andReturn(true);
        $cfg->shouldReceive('get')->once()->andReturn($mockConfig);

        $repo->shouldReceive('find')->once()->with('yyyyyyyy-yyyy-yyyy-yyyy-yyyyyyyyyyyy')->andReturn($mockParent);
        $repo->shouldReceive('getLastChildReply')->once()->with($mockParent, 3)->andReturn('000');
        $repo->shouldReceive('insert')->once()->with($mockComment)->andReturn($mockComment);

        $member->shouldReceive('associate')->once()->with($mockParent)->andReturn($mockParent);
        $member->shouldReceive('associate')->once()->with($mockComment)->andReturn($mockComment);

        $comment = $instance->add($mockComment);

        $this->assertEquals('001', $comment->reply);
        $this->assertEquals('xxxxxxxxxxxxxxxxxxx', $comment->head);
        $this->assertEquals('userId', $comment->userId);
        $this->assertEquals('userName', $comment->writer);
    }

    public function testPut()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockTarget = m::mock('Xpressengine\Comment\CommentUsable');
        $mockUser = m::mock('Xpressengine\Member\Entities\MemberEntityInterface');

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->shouldReceive('getAuthor')->andReturn($mockUser);
        $mockComment->shouldReceive('getTarget')->andReturn($mockTarget);

        $mockComment->shouldReceive('setAuthor');
        $mockComment->shouldReceive('setTarget');
        $mockComment->shouldReceive('setPermission');

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('useWysiwyg')->andReturn(true);
        $cfg->shouldReceive('get')->once()->andReturn($mockConfig);

        $repo->shouldReceive('update')->once()->with($mockComment)->andReturn($mockComment);

        $member->shouldReceive('associate')->once()->with($mockComment)->andReturn($mockComment);

        $comment = $instance->put($mockComment);

        $this->assertInstanceOf('Xpressengine\Comment\CommentEntity', $comment);
    }

    public function testRemove()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockComment1 = m::mock('Xpressengine\Comment\CommentEntity');

        $this->assertEquals(0, $instance->remove($mockComment1));


        $mockComment2 = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment2->status = 'trash';
        $mockComment2->display = 'hidden';

        $repo->shouldReceive('delete')->once()->with($mockComment2)->andReturn(1);

        $instance->remove($mockComment2);


        $mockComment3 = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment3->status = 'trash';
        $mockComment3->display = 'blind';

        $repo->shouldReceive('clearDelete')->once()->with($mockComment3)->andReturn(1);

        $instance->remove($mockComment3);
    }

    public function testTrashThrowingDescWhenConfigureSetBatch()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';
        $mockComment->head = 'xxxxxxxxxxxxxxxxxxx';
        $mockComment->reply = '000';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->with('removeType')->andReturn('batch');

        $cfg->shouldReceive('get')->once()->with('comments.instanceId')->andReturn($mockConfig);

        $mockComment1 = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment2 = m::mock('Xpressengine\Comment\CommentEntity');

        $repo->shouldReceive('fetch')->once()->with([
            'head' => 'xxxxxxxxxxxxxxxxxxx',
            'reply' => ['like', '000%']
        ])->andReturn([$mockComment1, $mockComment2]);


        $repo->shouldReceive('softDelete')->once()->with($mockComment1, m::on(function () {
            return true;
        }))->andReturn(1);
        $repo->shouldReceive('softDelete')->once()->with($mockComment2, m::on(function () {
            return true;
        }))->andReturn(1);

        $instance->trash($mockComment);
    }

    public function testTrashBlindCommentWhenConfigureSetBlind()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->with('removeType')->andReturn('blind');

        $cfg->shouldReceive('get')->once()->with('comments.instanceId')->andReturn($mockConfig);

        $repo->shouldReceive('softDelete')->once()->with($mockComment, m::on(function () {
            return true;
        }))->andReturn(1);

        $instance->trash($mockComment);
    }

    public function testTrashThrowsExceptionWhenGivenUnknownConfigValue()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->with('removeType')->andReturn('unknown');

        $cfg->shouldReceive('get')->once()->with('comments.instanceId')->andReturn($mockConfig);

        try {
            $instance->trash($mockComment);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Comment\Exceptions\NotConfigurationException', $e);
        }
    }

    public function testRestoreNotExecutedWhenAlreadyRemoved()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->removed = 1;

        $this->assertNull($instance->restore($mockComment));
    }

    public function testRestoreThrowsExceptionWhenParentIsInvalid()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->removed = 0;
        $mockComment->head = 'xxxxxxxxxxxxxxxxxxx';
        $mockComment->reply = '000000';

        $mockParent = m::mock('Xpressengine\Comment\CommentEntity');
        $mockParent->approved = 'approved';
        $mockParent->display = 'hidden';

        $repo->shouldReceive('fetch')->once()->with([
            'head' => 'xxxxxxxxxxxxxxxxxxx',
            'reply' => '000'
        ])->andReturn([$mockParent]);

        try {
            $instance->restore($mockComment);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Comment\Exceptions\InvalidParentException', $e);
        }
    }

    public function testRestore()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->removed = 0;
        $mockComment->head = 'xxxxxxxxxxxxxxxxxxx';
        $mockComment->reply = '000000';

        $mockParent = m::mock('Xpressengine\Comment\CommentEntity');
        $mockParent->approved = 'approved';
        $mockParent->display = 'visible';

        $repo->shouldReceive('fetch')->once()->with([
            'head' => 'xxxxxxxxxxxxxxxxxxx',
            'reply' => '000'
        ])->andReturn([$mockParent]);

        $repo->shouldReceive('unDelete')->once()->with($mockComment, m::on(function () {
            return true;
        }))->andReturn(1);

        $instance->restore($mockComment);
    }

    public function testMoveByTarget()
    {
        list($member, $auth, $repo, $cfg) = $this->getMocks();
        $instance = new CommentHandler($member, $auth, $repo, $cfg);

        $mockComment1 = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment2 = m::mock('Xpressengine\Comment\CommentEntity');

        $repo->shouldReceive('fetch')
            ->once()
            ->with(['targetId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'])
            ->andReturn([$mockComment1, $mockComment2]);

        $repo->shouldReceive('moveTo')->once()->with($mockComment1, 'instanceId');
        $repo->shouldReceive('moveTo')->once()->with($mockComment2, 'instanceId');

        $instance->moveByTarget('instanceId', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
    }

    private function getMocks()
    {
        return [
            m::mock('\Xpressengine\Member\MemberHandler'),
            m::mock('\Xpressengine\Member\GuardInterface'),
            m::mock('Xpressengine\Comment\Repository'),
            m::mock('Xpressengine\Config\ConfigManager')
        ];
    }
}
