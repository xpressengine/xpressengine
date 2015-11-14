<?php
namespace Xpressengine\Tests\Tag;

use Mockery as m;
use Xpressengine\Tag\TagRepository;

class TagRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFindByInstanceIdAndWordReturnsTagWhenExists()
    {
        list($conn, $query) = $this->getMocks();

        $instance = new TagRepository($conn);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('instanceId', 'freeboard')->andReturn($query);
        $query->shouldReceive('where')->once()->with('word', 'app')->andReturn($query);
        $query->shouldReceive('first')->once()->withNoArgs()->andReturn((object)[
            'instanceId' => 'freeboard',
            'word' => 'app'
        ]);

        $tag = $instance->findByInstanceIdAndWord('freeboard', 'app');

        $this->assertEquals('freeboard', $tag->instanceId);
        $this->assertEquals('app', $tag->word);
    }

    public function testFindByInstanceIdAndWordReturnsNullWhenNotExists()
    {
        list($conn, $query) = $this->getMocks();

        $instance = new TagRepository($conn);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('instanceId', 'freeboard')->andReturn($query);
        $query->shouldReceive('where')->once()->with('word', 'app')->andReturn($query);
        $query->shouldReceive('first')->once()->withNoArgs()->andReturnNull();

        $tag = $instance->findByInstanceIdAndWord('freeboard', 'app');

        $this->assertNull($tag);
    }

    public function testHasMany()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new TagRepository($conn);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('leftJoin')->once()->andReturnSelf();
        $query->shouldReceive('where')->once()->with('used.targetId', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('select')->once()->with(['item.*'])->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn([
            [
                'id' => 1,
                'instanceId' => 'freeboard',
                'word' => 'app'
            ],
            [
                'id' => 2,
                'instanceId' => 'freeboard',
                'word' => 'cms'
            ]
        ]);

        $tags = $instance->hasMany('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $this->assertEquals(2, count($tags));
    }

    public function testInsert()
    {
        list($conn, $query) = $this->getMocks();

        $instance = new TagRepository($conn);

        $entity = m::mock('Xpressengine\Tag\TagEntity');
        $entity->shouldReceive('getAttributes')->andReturn([
            'instanceId' => 'freeboard',
            'word' => 'app'
        ]);

        $conn->shouldReceive('table')->andReturn($query);

        $query->shouldReceive('insertGetId')->once()->with(m::on(function ($array) {
            return $array['instanceId'] === 'freeboard'
            && $array['word'] === 'app';
        }))->andReturn(1);

        $tag = $instance->insert($entity);

        $this->assertEquals('freeboard', $tag->instanceId);
        $this->assertEquals('app', $tag->word);
    }

    public function testIncrement()
    {
        list($conn, $query) = $this->getMocks();

        $instance = new TagRepository($conn);

        $entity = m::mock('Xpressengine\Tag\TagEntity');
        $entity->id = 999;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 999)->andReturn($query);
        $query->shouldReceive('increment')->once()->with('count', 1)->andReturnNull();

        $instance->increment($entity, 1);
    }

    public function testDecrement()
    {
        list($conn, $query) = $this->getMocks();

        $instance = new TagRepository($conn);

        $entity = m::mock('Xpressengine\Tag\TagEntity');
        $entity->id = 999;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 999)->andReturn($query);
        $query->shouldReceive('decrement')->once()->with('count', 1)->andReturnNull();

        $instance->decrement($entity, 1);
    }

    public function testExistsUsed()
    {
        list($conn, $query) = $this->getMocks();

        $instance = new TagRepository($conn);

        $entity = m::mock('Xpressengine\Tag\TagEntity');
        $entity->id = 999;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('targetId', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturn($query);
        $query->shouldReceive('where')->once()->with('itemId', 999)->andReturn($query);
        $query->shouldReceive('exists')->once()->withNoArgs()->andReturn(true);

        $bool = $instance->existsUsed('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $entity);

        $this->assertTrue($bool);
    }

    public function testInsertUsed()
    {
        list($conn, $query) = $this->getMocks();

        $instance = new TagRepository($conn);

        $entity = m::mock('Xpressengine\Tag\TagEntity');
        $entity->id = 999;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('insert')->once()->with(m::on(function ($array) {
            return $array['targetId'] === 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'
            && $array['itemId'] === 999;
        }))->andReturnNull();

        $instance->insertUsed('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $entity);
    }

    public function testDeleteUsed()
    {
        list($conn, $query) = $this->getMocks();

        $instance = new TagRepository($conn);

        $entity = m::mock('Xpressengine\Tag\TagEntity');
        $entity->id = 999;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('targetId', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturn($query);
        $query->shouldReceive('where')->once()->with('itemId', 999)->andReturn($query);
        $query->shouldReceive('delete')->once()->withNoArgs()->andReturnNull();

        $instance->deleteUsed('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $entity);
    }

    public function testFetchSimilar()
    {
        list($conn, $query) = $this->getMocks();

        $instance = new TagRepository($conn);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('instanceId', 'freeboard')->andReturn($query);
        $query->shouldReceive('where')->once()->with('decomposed', 'like', 'ap%')->andReturn($query);
        $query->shouldReceive('orderBy')->once()->with('count', 'desc')->andReturn($query);
        $query->shouldReceive('take')->once()->with(3)->andReturn($query);
        $query->shouldReceive('get')->once()->withNoArgs()->andReturn([
            (object)[
                'instanceId' => 'freeboard',
                'word' => 'app',
            ],
            (object)[
                'instanceId' => 'freeboard',
                'word' => 'application',
            ],
            (object)[
                'instanceId' => 'freeboard',
                'word' => 'apollo',
            ]
        ]);

        $tags = $instance->fetchSimilar('ap', 'freeboard', 3);

        $this->assertEquals(3, count($tags));
        $this->assertEquals('app', $tags[0]->word);
        $this->assertEquals('application', $tags[1]->word);
        $this->assertEquals('apollo', $tags[2]->word);
    }

    public function testPopular()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new TagRepository($conn);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('leftJoin')->once()->andReturnSelf();
        $query->shouldReceive('selectRaw')->once()->andReturnSelf();
        $query->shouldReceive('where')->once()->with('item.instanceId', 'freeboard')->andReturnSelf();
        $query->shouldReceive('groupBy')->once()->with('item.word')->andReturnSelf();
        $query->shouldReceive('orderBy')->once()->andReturnSelf();
        $query->shouldReceive('take')->once()->with(2)->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn([
            (object)[
                'instanceId' => 'freeboard',
                'word' => 'app',
                'cnt' => 2
            ],
            (object)[
                'instanceId' => 'freeboard',
                'word' => 'application',
                'cnt' => 3
            ],
        ]);

        $tags = $instance->popular('freeboard', null, null, 2);

        $this->assertEquals(2, current($tags)->count);
        $this->assertEquals(3, next($tags)->count);
    }

    public function testPeriodWhere()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new TagRepository($conn);

        $query->shouldReceive('whereBetween')->once()->with('used.createdAt', ['2000-01-01 00:00:00', '2000-01-01 23:59:59']);
        $this->invokeMethod($instance, 'periodWhere', [&$query, '2000-01-01 00:00:00', '2000-01-01 23:59:59']);

        $query->shouldReceive('where')->once()->with('used.createdAt', '>', '2000-01-01 00:00:00');
        $this->invokeMethod($instance, 'periodWhere', [&$query, '2000-01-01 00:00:00', null]);

        $query->shouldReceive('where')->once()->with('used.createdAt', '<', '2000-01-01 23:59:59');
        $this->invokeMethod($instance, 'periodWhere', [&$query, null, '2000-01-01 23:59:59']);
    }

    public function testCount()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new TagRepository($conn);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('leftJoin')->once()->andReturnSelf();
        $query->shouldReceive('where')->once()->with('item.instanceId', 'freeboard')->andReturnSelf();
        $query->shouldReceive('where')->once()->with('item.word', 'app')->andReturnSelf();
        $query->shouldReceive('count')->once()->andReturn(3);

        $count = $instance->count('freeboard', 'app', null, null);

        $this->assertEquals(3, $count);
    }

    public function testGetUsed()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new TagRepository($conn);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('leftJoin')->once()->andReturnSelf();
        $query->shouldReceive('select')->once()->andReturnSelf();
        $query->shouldReceive('where')->once()->with('item.word', 'app')->andReturnSelf();
        $query->shouldReceive('where')->once()->with('item.instanceId', 'freeboard')->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn([
            [
                'instanceId' => 'freeboard',
                'targetId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'
            ],
            [
                'instanceId' => 'freeboard',
                'targetId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy'
            ]
        ]);

        $data = $instance->getUsed('app', 'freeboard');

        $this->assertEquals(['xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy'], $data);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnectionInterface'),
            m::mock('Xpressengine\Database\DynamicQuery')
        ];
    }

    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
