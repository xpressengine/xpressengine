<?php
namespace Xpressengine\Tests\Comment;

use Mockery as m;
use Xpressengine\Comment\CommentHandler;
use Xpressengine\Comment\Repositories\DivisionDecorator as Origin;

class DivisionDecoratorTest extends \PHPUnit_Framework_TestCase
{
    protected $prefix = CommentHandler::PREFIX;

    public static $division;

    public static function setDivision()
    {
        static::$division = m::mock('Xpressengine\Comment\Repositories\DivisionRepository');
    }

    public static function unsetDivision()
    {
        static::$division = null;
    }

    public function setUp()
    {
        static::setDivision();
    }

    public function tearDown()
    {
        static::unsetDivision();
        m::close();
    }

    public function testFind()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $repo->shouldReceive('find')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $instance->find('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
    }

    public function testFindBaseInstanceIdUsedDivisionWhenEnabled()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(true);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $mockConn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $repo->shouldReceive('getConnection')->andReturn($mockConn);

        static::$division->shouldReceive('find')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $instance->findBaseInstanceId('instanceId', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
    }

    public function testFindBaseInstanceIdUnusedDivisionWhenDisabled()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(false);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);


        $repo->shouldReceive('findBaseInstanceId')
            ->once()
            ->with('instanceId', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $instance->findBaseInstanceId('instanceId', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
    }

    public function testFetch()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $repo->shouldReceive('fetch')->once()->with([], 10, []);

        $instance->fetch([], 10);
    }

    public function testFetchBaseInstanceIdUsedDivisionWhenEnabled()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(true);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $mockConn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $repo->shouldReceive('getConnection')->andReturn($mockConn);

        static::$division->shouldReceive('fetch')->once()->with([], 10, []);

        $instance->fetchBaseInstanceId('instanceId', [], 10);
    }

    public function testFetchBaseInstanceIdUnusedDivisionWhenDisabled()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(false);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $repo->shouldReceive('fetchBaseInstanceId')->once()->with('instanceId', [], 10, []);

        $instance->fetchBaseInstanceId('instanceId', [], 10);
    }

    public function testCount()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $repo->shouldReceive('count')->once()->with([]);

        $instance->count([]);
    }

    public function testCountBaseInstanceIdUsedDivisionWhenEnabled()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(true);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $mockConn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $repo->shouldReceive('getConnection')->andReturn($mockConn);

        static::$division->shouldReceive('count')->once()->with([]);

        $instance->countBaseInstanceId('instanceId', []);
    }

    public function testCountBaseInstanceIdUnusedDivisionWhenDisabled()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(false);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $repo->shouldReceive('countBaseInstanceId')->once()->with('instanceId', []);

        $instance->countBaseInstanceId('instanceId', []);
    }

    public function testPaginate()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $repo->shouldReceive('paginate')->once()->with([], 10, []);

        $instance->paginate([], 10);
    }

    public function testFetchIn()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $repo->shouldReceive('fetchIn')->once()->with([]);

        $instance->fetchIn([]);
    }

    public function testInsert()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';
        $repo->shouldReceive('insert')->once()->with($mockComment)->andReturn($mockComment);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(true);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $mockConn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $repo->shouldReceive('getConnection')->andReturn($mockConn);

        static::$division->shouldReceive('insert')->once()->with($mockComment);

        $comment = $instance->insert($mockComment);

        $this->assertEquals($mockComment, $comment);
    }

    public function testUpdate()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';
        $repo->shouldReceive('update')->once()->with($mockComment)->andReturn($mockComment);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(true);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $mockConn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $repo->shouldReceive('getConnection')->andReturn($mockConn);

        static::$division->shouldReceive('update')->once()->with($mockComment);

        $comment = $instance->update($mockComment);

        $this->assertEquals($mockComment, $comment);
    }

    public function testDelete()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(true);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $mockConn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $repo->shouldReceive('getConnection')->andReturn($mockConn);

        static::$division->shouldReceive('delete')->once()->with($mockComment);

        $repo->shouldReceive('delete')->once()->with($mockComment);

        $instance->delete($mockComment);
    }

    public function testSoftDelete()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(true);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $mockConn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $repo->shouldReceive('getConnection')->andReturn($mockConn);

        static::$division->shouldReceive('softDelete')->once()->with($mockComment, []);

        $repo->shouldReceive('softDelete')->once()->with($mockComment, []);

        $instance->softDelete($mockComment);
    }

    public function testUnDelete()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(true);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $mockConn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $repo->shouldReceive('getConnection')->andReturn($mockConn);

        static::$division->shouldReceive('unDelete')->once()->with($mockComment, []);

        $repo->shouldReceive('unDelete')->once()->with($mockComment, []);

        $instance->unDelete($mockComment);
    }

    public function testClearDelete()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(true);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $mockConn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $repo->shouldReceive('getConnection')->andReturn($mockConn);

        static::$division->shouldReceive('clearDelete')->once()->with($mockComment);

        $repo->shouldReceive('clearDelete')->once()->with($mockComment);

        $instance->clearDelete($mockComment);
    }

    public function testMoveToReturnGivenObject()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';

        $comment = $instance->moveTo($mockComment, 'instanceId');

        $this->assertEquals($mockComment, $comment);
    }

    public function testMoveTo()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';

        $mockConn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $mockConn->shouldReceive('beginTransaction')->once();
        $mockConn->shouldReceive('commit')->once();
        $repo->shouldReceive('getConnection')->andReturn($mockConn);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->twice()->with('division')->andReturn(true);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId2')->andReturn($mockConfig);

        $repo->shouldReceive('update')->once()->with($mockComment)->andReturn($mockComment);

        static::$division->shouldReceive('delete')->once()->with($mockComment);
        static::$division->shouldReceive('insert')->once()->with($mockComment);

        $instance->moveTo($mockComment, 'instanceId2');
    }

    public function testGetLastChildReplyUsedDivisionWhenEnabled()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(true);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $mockConn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $repo->shouldReceive('getConnection')->andReturn($mockConn);

        static::$division->shouldReceive('getLastChildReply')->once()->with($mockComment);

        $instance->getLastChildReply($mockComment);
    }

    public function testGetLastChildReplyUnusedDivisionWhenDisabled()
    {
        list($repo, $schema, $closure, $cfg) = $this->getMocks();
        $instance = new DivisionDecorator($repo, $schema, $closure, $cfg);

        $mockComment = m::mock('Xpressengine\Comment\CommentEntity');
        $mockComment->instanceId = 'instanceId';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('division')->andReturn(false);
        $cfg->shouldReceive('get')->once()->with($this->prefix . '.instanceId')->andReturn($mockConfig);

        $repo->shouldReceive('getLastChildReply')->andReturn($mockConfig);

        $instance->getLastChildReply($mockComment);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Comment\Repository'),
            m::mock('Illuminate\Database\Schema\Builder'),
            function () {},
            m::mock('Xpressengine\Config\ConfigManager')
        ];
    }
}

class DivisionDecorator extends Origin
{
    protected function createRepository($conn, $table)
    {
        return DivisionDecoratorTest::$division;
    }
}