<?php
namespace Xpressengine\Tests\Category;

use Mockery as m;
use Xpressengine\Category\CategoryRepository;

class CategoryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFind()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryRepository($conn);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn([
            'id' => 1,
            'name' => 'cate'
        ]);

        $category = $instance->find(1);

        $this->assertInstanceOf('Xpressengine\Category\CategoryEntity', $category);
        $this->assertEquals(1, $category->id);
        $this->assertEquals('cate', $category->name);
    }

    public function testInsert()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryRepository($conn);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');
        $mockEntity->shouldReceive('getAttributes')->andReturn([
            'name' => 'cate'
        ]);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('insertGetId')->once()->with(m::on(function ($array) {
            return $array['name'] === 'cate';
        }))->andReturn(1);


        $category = $instance->insert($mockEntity);

        $this->assertInstanceOf('Xpressengine\Category\CategoryEntity', $category);
        $this->assertEquals(1, $category->id);
        $this->assertEquals('cate', $category->name);
    }

    public function testUpdate()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryRepository($conn);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');
        $mockEntity->shouldReceive('diff')->andReturn(['name' => 'catecate']);
        $mockEntity->shouldReceive('getOriginal')->andReturn([
            'id' => 1,
            'name' => 'cate'
        ]);
        $mockEntity->id = 1;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $query->shouldReceive('update')->once()->with(m::on(function ($array) {
            return $array['name'] === 'catecate';
        }))->andReturnNull();

        $category = $instance->update($mockEntity);

        $this->assertInstanceOf('Xpressengine\Category\CategoryEntity', $category);
        $this->assertEquals(1, $category->id);
        $this->assertEquals('catecate', $category->name);
    }

    public function testDelete()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryRepository($conn);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');
        $mockEntity->id = 1;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $query->shouldReceive('delete')->andReturn(1);

        $instance->delete($mockEntity);
    }

    public function testIncrement()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryRepository($conn);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');
        $mockEntity->id = 1;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $query->shouldReceive('increment')->once()->with('count', 1)->andReturn(1);

        $instance->increment($mockEntity);
    }

    public function testDecrement()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new CategoryRepository($conn);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');
        $mockEntity->id = 1;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $query->shouldReceive('decrement')->once()->with('count', 1)->andReturn(1);

        $instance->decrement($mockEntity);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnection'),
            m::mock('Xpressengine\Database\DynamicQuery')
        ];
    }
}
