<?php
namespace Xpressengine\Tests\Register;

use Xpressengine\Register\Container as Container;

class ContainerTest extends \PHPUnit_Framework_TestCase
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
     *
     * @depends testPush
     */
    public function testHas($container)
    {
        $this->assertTrue($container->has('module/board/skin'));
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

    public function testAdd()
    {
        $container = new Container('\Illuminate\Support\Arr');

        $key = 'uiobject/xpressengine@select';

        $container->add($key, 'My\\Class\\Select');

        $this->assertEquals('My\\Class\\Select', $container->get($key));
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
