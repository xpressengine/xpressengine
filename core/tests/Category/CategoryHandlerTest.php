<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Category;

use Mockery as m;
use Xpressengine\Category\CategoryHandler;

class CategoryHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }
    
    public function testDeleteCate()
    {
        list($cateRepo, $itemRepo) = $this->getMocks();
        $instance = m::mock(CategoryHandler::class, [$cateRepo, $itemRepo])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockItem1 = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem2 = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockModel = m::mock('Xpressengine\Category\Models\Category');
        $mockModel->shouldReceive('getProgenitors')->andReturn([$mockItem1, $mockItem2]);
        $cateRepo->shouldReceive('delete')->once()->with($mockModel)->andReturn(true);

        $instance->shouldReceive('deleteItem')->once()->with($mockItem1)->andReturnNull();
        $instance->shouldReceive('deleteItem')->once()->with($mockItem2)->andReturnNull();

        $instance->deleteCate($mockModel);
    }

    public function testUpdateItem()
    {
        list($cateRepo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($cateRepo, $itemRepo);

        $mockItem = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem->shouldReceive('getParentIdName')->andReturn('parentId');
        $mockItem->shouldReceive('getOriginal')->with('parentId')->andReturn(1);
        $itemRepo->shouldReceive('update')->once()
            ->with($mockItem, ['word' => 'test', 'parentId' => 1])->andReturn($mockItem);

        $item = $instance->updateItem($mockItem, ['word' => 'test']);

        $this->assertInstanceOf('Xpressengine\Category\Models\CategoryItem', $item);
    }

    public function testDeleteItemForceTrue()
    {
        list($cateRepo, $itemRepo) = $this->getMocks();
        $instance = m::mock(CategoryHandler::class, [$cateRepo, $itemRepo])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockItem = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockDesc1 = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem->shouldReceive('getAttribute')->with('descendants')->andReturn([$mockDesc1]);

        $itemRepo->shouldReceive('delete')->once()->with($mockDesc1);
        $itemRepo->shouldReceive('delete')->once()->with($mockItem);

//        $mockModel = m::mock('Xpressengine\Category\Models\Category')->shouldAllowMockingProtectedMethods();
//
//        $mockItem->shouldReceive('getAttribute')->with('category')->andReturn($mockModel);

        $instance->deleteItem($mockItem, true);
    }

    public function testDeleteItemForceFalse()
    {
        list($cateRepo, $itemRepo) = $this->getMocks();
        $instance = m::mock(CategoryHandler::class, [$cateRepo, $itemRepo])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockItem = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockDesc1 = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem->shouldReceive('getAttribute')->with('descendants')->andReturn([$mockDesc1]);

        $itemRepo->shouldReceive('exclude')->once()->with($mockDesc1, $mockItem);
        $itemRepo->shouldReceive('delete')->once()->with($mockItem);

        $instance->deleteItem($mockItem, false);
    }

    public function testMoveToThorwsExceptionWhenGivenParentIsSelf()
    {
        list($cateRepo, $itemRepo) = $this->getMocks();
        $instance = new CategoryHandler($cateRepo, $itemRepo);

        $mockItem = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem->shouldReceive('getKey')->andReturn(1);
        $mockParent = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockParent->shouldReceive('getKey')->andReturn(1);

        $mockItem->shouldReceive('getParent')->andReturnNull();

        try {
            $instance->moveTo($mockItem, $mockParent);

            $this->assertTrue(false);
        } catch (\Exception $e) {

            $this->assertInstanceOf('Xpressengine\Category\Exceptions\UnableMoveToSelfException', $e);
        }
    }

    public function testMoveTo()
    {
        list($cateRepo, $itemRepo) = $this->getMocks();
        $instance = $this->getMock(CategoryHandler::class, ['linkHierarchy', 'unlinkHierarchy'], [$cateRepo, $itemRepo]);

        $mockItem = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem->shouldReceive('getParentIdName')->andReturn('parentId');
        $mockItem->shouldReceive('getKey')->andReturn(1);
        $mockItem->shouldReceive('setAttribute');
        $mockItem->shouldReceive('save')->andReturnNull();

        $mockParent = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockParent->shouldReceive('getKey')->andReturn(2);
        $mockOldParent = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockOldParent->shouldReceive('getKey')->andReturn(3);

        $mockItem->shouldReceive('getParent')->andReturn($mockOldParent);

        $instance->expects($this->once())->method('unlinkHierarchy')->with($mockItem, $mockOldParent);
        $instance->expects($this->once())->method('linkHierarchy')->with($mockItem, $mockParent);

        $mockItem->shouldReceive('newQuery')->andReturnSelf();
        $itemRepo->shouldReceive('find')->once()->with(1)->andReturn($mockItem);


        $instance->moveTo($mockItem, $mockParent);
    }

    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    protected function getMocks()
    {
        return [
            m::mock('Xpressengine\Category\Repositories\CategoryRepository'),
            m::mock('Xpressengine\Category\Repositories\CategoryItemRepository')
        ];
    }
}
