<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Category;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Category\CategoryHandler;

class CategoryHandlerTest extends TestCase
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

        $result = $instance->deleteCate($mockModel);

        $this->assertTrue($result);
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
        $mockItem->shouldReceive('hasMacro')->andReturn(false);
        $mockItem->shouldReceive('getAttribute')->with('descendants')->andReturn([$mockDesc1]);

        $itemRepo->shouldReceive('delete')->once()->with($mockDesc1);
        $itemRepo->shouldReceive('delete')->once()->with($mockItem)->andReturn(true);

        $result = $instance->deleteItem($mockItem, true);

        $this->assertTrue($result);
    }

    public function testDeleteItemForceFalse()
    {
        list($cateRepo, $itemRepo) = $this->getMocks();
        $instance = m::mock(CategoryHandler::class, [$cateRepo, $itemRepo])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockItem = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockDesc1 = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem->shouldReceive('hasMacro')->andReturn(false);
        $mockItem->shouldReceive('getAttribute')->with('descendants')->andReturn([$mockDesc1]);

        $mockItem->shouldReceive('getDepth')->withNoArgs()->andReturn(0);
        $mockDesc1->shouldReceive('getDepth')->withNoArgs()->andReturn(1);

        $itemRepo->shouldReceive('setNewParent')->once()->with($mockDesc1, $mockItem);
        $itemRepo->shouldReceive('decrementDepth')->once()->with($mockDesc1, $mockItem);

        $itemRepo->shouldReceive('delete')->once()->with($mockItem)->andReturn(true);

        $result = $instance->deleteItem($mockItem, false);

        $this->assertTrue($result);
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
        $instance = $this->getMockBuilder(CategoryHandler::class)
            ->setConstructorArgs([$cateRepo, $itemRepo])
            ->setMethods(['linkHierarchy', 'unlinkHierarchy'])
            ->getMock();

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
