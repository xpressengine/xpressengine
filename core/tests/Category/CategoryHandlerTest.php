<?php
namespace Xpressengine\Tests\Category;

use Mockery as m;
use Xpressengine\Category\CategoryHandler;

class CategoryHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGet()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');
        $repo->shouldReceive('find')->once()->with(1)->andReturn($mockEntity);

        $category = $instance->get(1);

        $this->assertInstanceOf('Xpressengine\Category\CategoryEntity', $category);
    }

    public function testAdd()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');

        $repo->shouldReceive('insert')->once()->with($mockEntity)->andReturn($mockEntity);

        $instance->add($mockEntity);
    }

    public function testRemove()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');

        $repo->shouldReceive('delete')->once()->with($mockEntity)->andReturn(1);

        $instance->remove($mockEntity);
    }

    public function testIncrement()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');

        $repo->shouldReceive('increment')->once()->with($mockEntity, 1)->andReturn(1);

        $instance->increment($mockEntity);
    }

    public function testDecrement()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');

        $repo->shouldReceive('decrement')->once()->with($mockEntity, 1)->andReturn(1);

        $instance->decrement($mockEntity);
    }

    public function testGetItem()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');

        $itemRepo->shouldReceive('find')->once()->with(1)->andReturn($mockItemEntity);

        $item = $instance->getItem(1);

        $this->assertInstanceOf('Xpressengine\Category\CategoryItemEntity', $item);
    }

    public function testAddItem()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');
        $mockEntity->count = 0;
        $mockEntity->id = 1;

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity->id = 9;

        $itemRepo->shouldReceive('insert')->once()->with($mockItemEntity)->andReturn($mockItemEntity);
        $itemRepo->shouldReceive('insertHierarchy')->once()->with($mockItemEntity, null)->andReturnNull();

        // parent
        $itemRepo->shouldReceive('fetchAsc')->once()->with($mockItemEntity, 1)->andReturn([]);

        // setOrder
        $itemRepo->shouldReceive('fetchProgenitor')->once()->with(1)->andReturn([$mockItemEntity]);
        $itemRepo->shouldReceive('update')->once()->with($mockItemEntity)->andReturnNull();

        $repo->shouldReceive('increment')->once()->with($mockEntity, 1);

        $item = $instance->addItem($mockEntity, $mockItemEntity);

        $this->assertInstanceOf('Xpressengine\Category\CategoryItemEntity', $item);
    }

    public function testPutItem()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');

        $itemRepo->shouldReceive('update')->once()->with($mockItemEntity)->andReturn($mockItemEntity);

        $item = $instance->putItem($mockItemEntity);

        $this->assertInstanceOf('Xpressengine\Category\CategoryItemEntity', $item);
    }

    public function testRemoveItem()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity->categoryId = 1;

        $itemRepo->shouldReceive('fetchDesc')->once()->with($mockItemEntity, 0, false)->andReturn([$mockItemEntity]);

        $itemRepo->shouldReceive('delete')->once()->with($mockItemEntity)->andReturnNull();
        $itemRepo->shouldReceive('removeHierarchy')->once()->with($mockItemEntity)->andReturnNull();

        $repo->shouldReceive('find')->once()->with(1)->andReturn($mockEntity);
        $repo->shouldReceive('decrement')->once()->with($mockEntity, 1);

        $instance->removeItem($mockItemEntity);
    }

    public function testGetTree()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');
        $mockEntity->id = 1;

        $mockItemEntity1 = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity1->ordering = 0;
        $mockItemEntity1->shouldReceive('hasChild')->andReturn(false);
        $mockItemEntity2 = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity2->ordering = 1;
        $mockItemEntity2->shouldReceive('hasChild')->andReturn(false);

        $mockTreeCollection = m::mock('Xpressengine\Support\Tree\TreeCollection');
        $mockTreeCollection->shouldReceive('getNodes')->once()->andReturn([$mockItemEntity1]);
        $mockTreeCollection->shouldReceive('getNodes')->once()->andReturn([$mockItemEntity2]);

        $itemRepo->shouldReceive('fetchProgenitor')->once()->with(1)->andReturn([$mockItemEntity1, $mockItemEntity2]);
        $itemRepo->shouldReceive('fetchTree')->once()->with($mockItemEntity1)->andReturn($mockTreeCollection);
        $itemRepo->shouldReceive('fetchTree')->once()->with($mockItemEntity2)->andReturn($mockTreeCollection);

        $tree = $instance->getTree($mockEntity);

        $this->assertInstanceOf('Xpressengine\Support\Tree\TreeCollection', $tree);
    }

    public function testParent()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');

        $mockAncestor1 = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockAncestor2 = m::mock('Xpressengine\Category\CategoryItemEntity');

        $itemRepo->shouldReceive('fetchAsc')->once()->with($mockItemEntity, 1)->andReturn([$mockAncestor1, $mockAncestor2]);

        $parent = $instance->parent($mockItemEntity);

        $this->assertEquals($mockAncestor1, $parent);
    }

    public function testChildren()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');

        $mockChild1 = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockChild2 = m::mock('Xpressengine\Category\CategoryItemEntity');

        $itemRepo->shouldReceive('fetchDesc')->once($mockItemEntity, 1)->andReturn([$mockChild1, $mockChild2]);

        $children = $instance->children($mockItemEntity);

        $this->assertEquals(2, count($children));
    }

    public function testMoveToThorwsExceptionWhenGivenParentIsSelf()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity->id = 1;
        $mockParent = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockParent->id = 1;

        try {
            $instance->moveTo($mockItemEntity, $mockParent);


            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Category\Exceptions\UnableMoveToSelfException', $e);
        }
    }

    public function testMoveTo()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockParent = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockParent->id = 1;
        $mockOldParent = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockOldParent->id = 2;

        $itemRepo->shouldReceive('fetchAsc')->once()->with($mockItemEntity, 1)->andReturn([$mockOldParent]);
        $itemRepo->shouldReceive('unlinkHierarchy')->once()->with($mockItemEntity, $mockOldParent)->andReturnNull();
        $itemRepo->shouldReceive('linkHierarchy')->once()->with($mockItemEntity, $mockParent)->andReturnNull();

        $instance->moveTo($mockItemEntity, $mockParent);
    }

    public function testSetOrder()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity->id = 3;
        $mockParent = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockChild1 = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockChild1->id = 1;
        $mockChild1->ordering = 0;
        $mockChild2 = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockChild2->id = 2;
        $mockChild1->ordering = 1;

        $itemRepo->shouldReceive('fetchAsc')->once()->with($mockItemEntity, 1)->andReturn([$mockParent]);
        $itemRepo->shouldReceive('fetchDesc')->once()->with($mockParent, 1)->andReturn([$mockChild1, $mockChild2]);

        $itemRepo->shouldReceive('update')->once()->with($mockChild1)->andReturnNull();
        $itemRepo->shouldReceive('update')->once()->with($mockItemEntity)->andReturnNull();
        $itemRepo->shouldReceive('update')->once()->with($mockChild2)->andReturnNull();


        $instance->setOrder($mockItemEntity, 1);
    }

    public function testUsed()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');

        $targetId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $itemRepo->shouldReceive('existsUsed')->once()->with($targetId, $mockItemEntity)->andReturn(false);
        $itemRepo->shouldReceive('insertUsed')->once()->with($targetId, $mockItemEntity)->andReturnNull();
        $itemRepo->shouldReceive('update')->once()->with($mockItemEntity)->andReturnNull();

        $instance->used($targetId, $mockItemEntity);
    }

    public function testUnused()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockItemEntity = m::mock('Xpressengine\Category\CategoryItemEntity');

        $targetId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $itemRepo->shouldReceive('existsUsed')->once()->with($targetId, $mockItemEntity)->andReturn(true);
        $itemRepo->shouldReceive('deleteUsed')->once()->with($targetId, $mockItemEntity)->andReturnNull();
        $itemRepo->shouldReceive('update')->once()->with($mockItemEntity)->andReturnNull();

        $instance->unused($targetId, $mockItemEntity);
    }

    public function testHasMany()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockItemEntity1 = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity2 = m::mock('Xpressengine\Category\CategoryItemEntity');

        $targetId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $itemRepo->shouldReceive('hasMany')->once()->with($targetId)->andReturn([$mockItemEntity1, $mockItemEntity2]);

        $items = $instance->hasMany($targetId);

        $this->assertEquals(2, count($items));
    }

    public function testCountByCategory()
    {
        list($repo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($repo, $itemRepo);

        $mockEntity = m::mock('Xpressengine\Category\CategoryEntity');
        $mockEntity->id = 1;

        $mockItemEntity1 = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity1->ordering = 0;
        $mockItemEntity2 = m::mock('Xpressengine\Category\CategoryItemEntity');
        $mockItemEntity1->ordering = 1;

        $itemRepo->shouldReceive('fetchProgenitor')->once()->with(1)->andReturn([$mockItemEntity1, $mockItemEntity2]);
        $itemRepo->shouldReceive('count')->once()->with($mockItemEntity1, 1)->andReturn(2);
        $itemRepo->shouldReceive('count')->once()->with($mockItemEntity2, 1)->andReturn(3);


        $count = $instance->countByCategory($mockEntity, 2);

        $this->assertEquals(7, $count);
    }
    
    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Category\CategoryRepository'),
            m::mock('Xpressengine\Category\CategoryItemRepository'),
        ];
    }
}
