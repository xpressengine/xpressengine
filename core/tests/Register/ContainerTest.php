<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Register;

use Xpressengine\Register\Container as Container;

class ContainerTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $container = new Container('\Illuminate\Support\Arr');
    }

    public function testPush()
    {
        $container = new Container('\Illuminate\Support\Arr');

        $container->push('module/board/skin', 'blue', 'My\\Class\\Blue');
        $container->push('module/board/skin', 'white', 'My\\Class\\White');

        $repo = $this->getRepoProperty($container);

        $this->assertEquals(
            ['module/board/skin' => ['blue' => 'My\\Class\\Blue', 'white' => 'My\\Class\\White']], $repo
        );

        return $container;
    }

    /**
     * testHas
     *
     * @depends testPush
     */
    public function testHas($container)
    {
        $this->assertTrue($container->has('module/board/skin'));
    }

    public function testPrepend()
    {
        $container = new Container('\Illuminate\Support\Arr');

        $container->prepend('a/b', 'B');

        $items = $this->getRepoProperty($container);

        $this->assertEquals(['a/b'=>['B']], $items);

        $container->prepend('a/b', 'C');

        $items = $this->getRepoProperty($container);

        $this->assertEquals(['a/b'=>['C', 'B']], $items);
    }

    public function testSet()
    {
        $container = new Container('\Illuminate\Support\Arr');

        $container->set('a/b', 'B');

        $items = $this->getRepoProperty($container);

        $this->assertEquals(['a/b'=>'B'], $items);

        $container->set('a/b', 'C');

        $items = $this->getRepoProperty($container);

        $this->assertEquals(['a/b'=>'C'], $items);
    }

    public function testAdd()
    {
        $container = new Container('\Illuminate\Support\Arr');

        $container->add('a/b', 'B');

        $items = $this->getRepoProperty($container);

        $this->assertEquals(['a/b'=>'B'], $items);

        $container->add('a/b', 'C');

        $items = $this->getRepoProperty($container);

        $this->assertEquals(['a/b'=>'B'], $items);
    }

    public function testPushOnlyValue()
    {
        $container = new Container('\Illuminate\Support\Arr');

        $container->push('module/board/skin', 'My\\Class\\Blue');
        $container->push('module/board/skin', 'My\\Class\\White');

        $repo = $this->getRepoProperty($container);

        $this->assertEquals(
            ['module/board/skin' => ['My\\Class\\Blue', 'My\\Class\\White']], $repo
        );

        return $container;
    }

    public function testAll()
    {
        $container = new Container('\Illuminate\Support\Arr');
        $container->add('a', 'b');
        $this->assertEquals(['a'=>'b'], $container->all());
    }

    protected function getRepoProperty($container)
    {
        $refl     = new \ReflectionObject($container);
        $repoProp = $refl->getProperty('items');
        $repoProp->setAccessible(true);

        return $repoProp->getValue($container);
    }
}
