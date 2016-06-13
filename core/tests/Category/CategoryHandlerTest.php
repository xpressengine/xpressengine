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

    public function testCreate()
    {
        $instance = $this->getMock(CategoryHandler::class, ['createModel']);

        $mockModel = m::mock('Xpressengine\Category\Models\Category');
        $instance->expects($this->once())->method('createModel')->willReturn($mockModel);

        $mockModel->shouldReceive('fill')->once()->with(['word' => 'first']);
        $mockModel->shouldReceive('save')->once();

        $category = $instance->create(['word' => 'first']);

        $this->assertInstanceOf('Xpressengine\Category\Models\Category', $category);
    }

    public function testRemove()
    {
        $instance = m::mock(CategoryHandler::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockItem1 = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem2 = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockModel = m::mock('Xpressengine\Category\Models\Category');
        $mockModel->shouldReceive('getProgenitors')->andReturn([$mockItem1, $mockItem2]);
        $mockModel->shouldReceive('delete')->andReturn(true);

        $instance->shouldReceive('removeItem')->once()->with($mockItem1)->andReturnNull();
        $instance->shouldReceive('removeItem')->once()->with($mockItem2)->andReturnNull();

        $instance->remove($mockModel);
    }

    public function testCreateItem()
    {
        // todo
    }

    public function testPutItem()
    {
        $instance = new CategoryHandler();

        $mockItem = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem->shouldReceive('isDirty')->once()->with('parentId')->andReturn(true);
        $mockItem->shouldReceive('getParentIdName')->andReturn('parentId');
        $mockItem->shouldReceive('getOriginal')->with('parentId')->andReturn(1);
        $mockItem->shouldReceive('setAttribute')->with('parentId', 1);
        $mockItem->shouldReceive('save')->andReturnNull();

        $item = $instance->putItem($mockItem);

        $this->assertInstanceOf('Xpressengine\Category\Models\CategoryItem', $item);
    }

    public function testRemoveItemForceTrue()
    {
        $instance = new CategoryHandler();

        $mockItem = m::mock('Xpressengine\Category\Models\CategoryItem');

        $mockDesc1 = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockDesc1->shouldReceive('getKey')->andReturn(2);
        $mockDesc1->shouldReceive('getDescendantName')->andReturn('descendant');
        $mockDesc1->shouldReceive('getDepthName')->andReturn('depth');

        $mockDesc1->shouldReceive('ancestors')->andReturnSelf();
        $mockDesc1->shouldReceive('descendants')->andReturnSelf();

        $mockDesc1->shouldReceive('detach')->twice()->andReturnNull();

        $mockDesc1->shouldReceive('newPivotStatement')->once()->andReturnSelf();
        $mockDesc1->shouldReceive('where')->once()->with('descendant', 2)->andReturnSelf();
        $mockDesc1->shouldReceive('where')->once()->with('depth', 0)->andReturnSelf();

        $mockDesc1->shouldReceive('delete')->twice()->andReturn(true);

        $mockItem->shouldReceive('getAttribute')->with('descendants')->andReturn([$mockDesc1]);
        $mockItem->shouldReceive('delete')->andReturn(true);

        $mockModel = m::mock('Xpressengine\Category\Models\Category')->shouldAllowMockingProtectedMethods();
        $mockModel->shouldReceive('decrement')->once()->with('count', 2)->andReturnNull();

        $mockItem->shouldReceive('getAttribute')->with('category')->andReturn($mockModel);

        $instance->removeItem($mockItem, true);
    }

    public function testRemoveItemForceFalse()
    {
        $instance = new CategoryHandler();

        $mockItem = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem->shouldReceive('getKey')->andReturn(1);
        $mockItem->shouldReceive('getParent')->andReturnNull();

        $mockDesc1 = m::mock('Xpressengine\Category\Models\CategoryItem')->shouldAllowMockingProtectedMethods();
        $mockDesc1->shouldReceive('getDescendantName')->andReturn('descendant');
        $mockDesc1->shouldReceive('getAncestorName')->andReturn('ancestor');
        $mockDesc1->shouldReceive('getDepthName')->andReturn('depth');
        $mockDesc1->shouldReceive('getParentIdName')->andReturn('parentId');

        $mockDesc1->shouldReceive('getKey')->andReturn(2);
        $mockDesc1->shouldReceive('descendants')->andReturnSelf();
        $mockDesc1->shouldReceive('newPivotStatement')->andReturnSelf();
        $mockDesc1->shouldReceive('where')->once()->with('descendant', 2)->andReturnSelf();
        $mockDesc1->shouldReceive('where')->once()->with('ancestor', '!=', 1)->andReturnSelf();
        $mockDesc1->shouldReceive('where')->once()->with('depth', '>', 0)->andReturnSelf();
        $mockDesc1->shouldReceive('decrement')->once()->with('depth')->andReturnNull();
        $mockDesc1->shouldReceive('save')->once()->andReturnNull();
        $mockDesc1->shouldReceive('setAttribute');

        $mockItem->shouldReceive('getAttribute')->with('descendants')->andReturn([$mockDesc1]);
        $mockItem->shouldReceive('delete')->andReturn(true);

        $mockModel = m::mock('Xpressengine\Category\Models\Category')->shouldAllowMockingProtectedMethods();
        $mockModel->shouldReceive('decrement')->once()->with('count', 1)->andReturnNull();

        $mockItem->shouldReceive('getAttribute')->with('category')->andReturn($mockModel);

        $instance->removeItem($mockItem, false);
    }

    public function testMoveToThorwsExceptionWhenGivenParentIsSelf()
    {
        $instance = new CategoryHandler();

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
        $instance = $this->getMock(CategoryHandler::class, ['linkHierarchy', 'unlinkHierarchy']);

        $mockItem = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem->shouldReceive('getParentIdName')->andReturn('parentId');
        $mockItem->shouldReceive('getKey')->andReturn(1);
        $mockItem->shouldReceive('setAttribute');
        $mockItem->shouldReceive('__unset')->with('ancestors')->andReturn([]);
        $mockItem->shouldReceive('save')->andReturnNull();

        $mockParent = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockParent->shouldReceive('getKey')->andReturn(2);
        $mockOldParent = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockOldParent->shouldReceive('getKey')->andReturn(3);

        $mockItem->shouldReceive('getParent')->andReturn($mockOldParent);

//        $instance->shouldReceive('unlinkHierarchy')->once()->with($mockItem, $mockOldParent)->andReturnNull();
//        $instance->shouldReceive('linkHierarchy')->once()->with($mockItem, $mockParent)->andReturnNull();
        $instance->expects($this->once())->method('unlinkHierarchy')->with($mockItem, $mockOldParent);
        $instance->expects($this->once())->method('linkHierarchy')->with($mockItem, $mockParent);

        $mockItem->shouldReceive('newQuery')->andReturnSelf();
        $mockItem->shouldReceive('find')->once()->with(1)->andReturnSelf();


        $instance->moveTo($mockItem, $mockParent);
    }

    public function testSetOrder()
    {
        $instance = new CategoryHandler();

        $collection = m::mock('Illuminate\Database\Eloquent\Collection');
        $collection->shouldReceive('filter')->once()->with(m::on(function () { return true; }))->andReturnSelf();

        $mockParent = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockParent->shouldReceive('getChildren')->andReturn($collection);

        $mockItem = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockItem->shouldReceive('getParent')->andReturn($mockParent);

        $collection->shouldReceive('slice')->once()->with(0, 1)->andReturnSelf();
        $collection->shouldReceive('slice')->once()->with(1)->andReturnSelf();
        $collection->shouldReceive('merge')->once()->with([$mockItem])->andReturnSelf();
        $collection->shouldReceive('merge')->once()->with($collection)->andReturnSelf();

        $mockSibling = m::mock('Xpressengine\Category\Models\CategoryItem');
        $mockSibling->shouldReceive('getOrderKeyName')->andReturn('ordering');
        $mockSibling->shouldReceive('setAttribute')->once()->with('ordering', 0)->andReturnNull();
        $mockSibling->shouldReceive('save')->once()->andReturnNull();

        $mockItem->shouldReceive('getOrderKeyName')->andReturn('ordering');
        $mockItem->shouldReceive('setAttribute')->once()->with('ordering', 1)->andReturnNull();
        $mockItem->shouldReceive('save')->once()->andReturnNull();

        $collection->shouldReceive('each')->once()->with(m::on(function ($closure) use ($mockItem, $mockSibling) {
            $arr = [$mockSibling, $mockItem];

            foreach ($arr as $idx => $model) {
                $closure($model, $idx);
            }

            return true;
        }))->andReturnSelf();

        $invoke = function (&$object, $methodName, array $parameters = array()) {
            $reflection = new \ReflectionClass(get_class($object));
            $method = $reflection->getMethod($methodName);
            $method->setAccessible(true);

            return $method->invokeArgs($object, $parameters);
        };

        $invoke($instance, 'setOrder', [$mockItem, 1]);
    }
}
