<?php
namespace Xpressengine\Tests\Category;

use Mockery as m;
use Xpressengine\Category\CategoryItemRepository;

class CategoryItemRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFind()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryItemRepository($conn);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn([
            'categoryId' => 1,
            'word' => 'blarblar'
        ]);

        $item = $instance->find(1);

        $this->assertEquals(1, $item->categoryId);
        $this->assertEquals('blarblar', $item->word);
    }

    public function testInsert()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryItemRepository($conn);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity->shouldReceive('getAttributes')->andReturn([
            'categoryId' => 1,
            'word' => 'blarblar'
        ]);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('insertGetId')->once()->with(m::on(function ($array) {
            return $array['categoryId'] === 1
            && $array['word'] === 'blarblar';
        }))->andReturn(2);


        $item = $instance->insert($mockItemEntity);

        $this->assertEquals(2, $item->id);
        $this->assertEquals(1, $item->categoryId);
        $this->assertEquals('blarblar', $item->word);
    }

    public function testUpdate()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryItemRepository($conn);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity->shouldReceive('diff')->andReturn([
            'word' => 'blar'
        ]);
        $mockItemEntity->shouldReceive('getOriginal')->andReturn([
            'id' => 2,
            'categoryId' => 1,
            'word' => 'blarblar'
        ]);
        $mockItemEntity->id = 2;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 2)->andReturnSelf();
        $query->shouldReceive('update')->once()->with(m::on(function ($array) {
            return $array['word'] === 'blar';
        }))->andReturnNull();

        $item = $instance->update($mockItemEntity);

        $this->assertEquals(2, $item->id);
        $this->assertEquals('blar', $item->word);
    }

    public function testDelete()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryItemRepository($conn);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity->id = 2;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 2)->andReturnSelf();
        $query->shouldReceive('delete')->once()->andReturn(1);

        $instance->delete($mockItemEntity);
    }

    public function testFetchProgenitor()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryItemRepository($conn);

        $mockItemEntity1 = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity2 = m::mock('Xpressengine\Category\CategoryItemEntity');

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('whereIn')->once()->with('id', m::on(function ($closure) use ($query) {
            $query->shouldReceive('select')->once()->with('descendant')->andReturnSelf();
            $query->shouldReceive('from')->andReturnSelf();
            $query->shouldReceive('whereIn')->once()->with('ancestor', m::on(function ($closure) use ($query) {
                $query->shouldReceive('select')->once()->with('id')->andReturnSelf();
                $query->shouldReceive('where')->once()->with('categoryId', 1)->andReturnSelf();

                call_user_func($closure, $query);
                return true;
            }))->andReturnSelf();
            $query->shouldReceive('groupBy')->once()->with('descendant')->andReturnSelf();
            $query->shouldReceive('havingRaw')->once()->with('count(*) = 1')->andReturnSelf();

            call_user_func($closure, $query);
            return true;
        }))->andReturnSelf();
        $query->shouldReceive('get')->andReturn([$mockItemEntity1, $mockItemEntity2]);

        $instance->fetchProgenitor(1);
    }

    public function testCount()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryItemRepository($conn);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity->id = 2;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('leftJoin')->andReturnSelf();
        $query->shouldReceive('where')->once()->with(m::on(function () {
            return true;
        }), 2)->andReturnSelf();
        $query->shouldReceive('where')->once()->with(m::on(function () {
            return true;
        }), '<=', 1)->andReturnSelf();
        $query->shouldReceive('where')->once()->with(m::on(function () {
            return true;
        }), '!=', 0)->andReturnSelf();
        $query->shouldReceive('count')->once()->andReturn(3);

        $count = $instance->count($mockItemEntity, 1);

        $this->assertEquals(3, $count);
    }

    public function testExistsUsed()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryItemRepository($conn);

        $targetId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity->id = 2;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('targetId', $targetId)->andReturnSelf();
        $query->shouldReceive('where')->once()->with('itemId', 2)->andReturnSelf();
        $query->shouldReceive('exists')->once()->andReturn(true);


        $this->assertTrue($instance->existsUsed($targetId, $mockItemEntity));
    }

    public function testInsertUsed()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryItemRepository($conn);

        $targetId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity->id = 2;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('insert')->once()->with(m::on(function ($array) use ($targetId) {
            return $array['targetId'] === $targetId
            && $array['itemId'] === 2;
        }));

        $instance->insertUsed($targetId, $mockItemEntity);
    }

    public function testDeleteUsed()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryItemRepository($conn);

        $targetId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity->id = 2;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('targetId', $targetId)->andReturnSelf();
        $query->shouldReceive('where')->once()->with('itemId', 2)->andReturnSelf();
        $query->shouldReceive('delete')->once();

        $instance->deleteUsed($targetId, $mockItemEntity);
    }

    public function testHasMany()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryItemRepository($conn);

        $targetId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $mockItemEntity1 = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity2 = m::mock('Xpressengine\Category\CategoryItemEntity');


        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('leftJoin')->andReturnSelf();
        $query->shouldReceive('where')->once()->with('used.targetId', $targetId)->andReturnSelf();
        $query->shouldReceive('select')->once()->with(['node.*'])->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn([$mockItemEntity1, $mockItemEntity2]);

        $items = $instance->hasMany($targetId);

        $this->assertEquals(2, count($items));
    }

    public function testFetchTargetIdsByIds()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryItemRepository($conn);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('whereIn')->once()->with('itemId', [1, 2, 3])->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn([
            (object)['targetId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxa'],
            (object)['targetId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxb'],
            (object)['targetId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxc'],
            (object)['targetId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxd'],
            (object)['targetId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxe'],
            (object)['targetId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxf'],
        ]);

        $targetIds = $instance->fetchTargetIdsByIds([1, 2, 3]);

        $this->assertEquals([
            'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxa',
            'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxb',
            'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxc',
            'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxd',
            'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxe',
            'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxf',
        ], $targetIds);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnection'),
            m::mock('Xpressengine\Database\DynamicQuery')
        ];
    }
}
