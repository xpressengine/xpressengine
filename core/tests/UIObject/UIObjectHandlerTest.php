<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\UIObject;


use Xpressengine\UIObject\UIObjectHandler;

class UIObjectHandlerTest extends \PHPUnit\Framework\TestCase
{
    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $alias     = [];
        $container = $this->getContainer();
        $handler   = new UIObjectHandler($container, $alias);

        return $handler;
    }

    /**
     * @depends testConstruct
     */
    public function testSetAlias(UIObjectHandler $handler)
    {
        $handler->setAlias('phone', 'uiobject|xpressengine@phone');

        $aliases = $this->getPropertyValue($handler, 'aliases');

        $this->assertEquals(['phone'=>'uiobject|xpressengine@phone'], $aliases);

        return $handler;
    }

    /**
     * @depends testSetAlias
     */
    public function testGet(UIObjectHandler $handler)
    {
        $class = $handler->get('uiobject|xpressengine@phone');
        $this->assertEquals('Xpressengine\Tests\UIObject\UIObjectStub', $class);

        $class = $handler->get('uiobject|xpressengine@select');
        $this->assertEquals('Xpressengine\Tests\UIObject\UIObjectStub', $class);

        return $handler;
    }

    /**
     * @depends testGet
     */
    public function testGetAll(UIObjectHandler $handler)
    {
        $uiobjects = $handler->getAll();
        $this->assertEquals(2, count($uiobjects));
        $this->assertArrayHasKey('uiobject|xpressengine@phone', $uiobjects);
        $this->assertArrayHasKey('uiobject|xpressengine@select', $uiobjects);

        return $handler;
    }

    /**
     * @depends testGetAll
     * @expectedException \Xpressengine\UIObject\Exceptions\UIObjectNotFoundException
     */
    public function testCallNotExists(UIObjectHandler $handler)
    {
        $instance = $handler->unknown([]);
    }

    /**
     * @depends testSetAlias
     */
    public function testCall(UIObjectHandler $handler)
    {
        $instance = $handler->phone([]);

        $this->assertInstanceOf('Xpressengine\Tests\UIObject\UIObjectStub', $instance);
    }

    public function getContainer()
    {
        $container = \Mockery::mock('\Xpressengine\Plugin\PluginRegister');
        $container->shouldReceive('get')->withArgs(['uiobject|xpressengine@phone'])
            ->andReturn('Xpressengine\Tests\UIObject\UIObjectStub');
        $container->shouldReceive('get')->withArgs(['uiobject|xpressengine@select'])
            ->andReturn('Xpressengine\Tests\UIObject\UIObjectStub');
        $container->shouldReceive('get')->withArgs(['uiobject'])
            ->andReturn([
                'uiobject|xpressengine@phone' => 'Xpressengine\Tests\UIObject\UIObjectStub',
                'uiobject|xpressengine@select' => 'Xpressengine\Tests\UIObject\UIObjectStub'
            ]);

        $container->shouldReceive('get')->withArgs(['uiobject/unknown'])
            ->andReturnNull();
        return $container;
    }

    protected function makeUIObjectMock($id)
    {
        $postfix = str_replace('@', '_', $id);
        $mock    = \Mockery::mock(
            'alias:UIObject_'.$postfix,
            'Xpressengine\UIObject\AbstractUIObject',
            [
                'getId' => $id,
                'getTitle' => 'skin for test',
            ]
        );
        return 'UIObject_'.$postfix;
    }

    protected function getPropertyValue(UIObjectHandler $handler, $property)
    {
        $refl     = new \ReflectionObject($handler);
        $repoProp = $refl->getProperty($property);
        $repoProp->setAccessible(true);
        return $repoProp->getValue($handler);
    }
}

class UIObjectStub
{

    public function __construct()
    {
    }
}
