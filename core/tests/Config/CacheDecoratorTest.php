<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Config;

use Mockery as m;
use Xpressengine\Config\Repositories\CacheDecorator;

class CacheDecoratorTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }
    
    public function testFind()
    {
        list($repo, $cache) = $this->getMocks();
        $instance = $this->getMock(CacheDecorator::class, ['getData'], [$repo, $cache]);

        $instance->expects($this->at(0))->method('getData')->with('default', 'foo')->willReturn([
            'foo' => [
                'value' => new \stdClass,
                'children' => [
                    'foo.bar' => [
                        'value' => m::mock('Xpressengine\Config\ConfigEntity'),
                        'children' => []
                    ]
                ]
            ]
        ]);
        $instance->expects($this->at(1))->method('getData')->with('default', 'baz')->willReturn([
            'baz' => [
                'value' => new \stdClass,
                'children' => []
            ]
        ]);

        $config = $instance->find('default', 'foo.bar');
        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);

        $config = $instance->find('default', 'baz.qux');
        $this->assertNull($config);
    }

    public function testFetchParent()
    {
        list($repo, $cache) = $this->getMocks();
        $instance = $this->getMock(CacheDecorator::class, ['getData'], [$repo, $cache]);

        $instance->expects($this->once())->method('getData')->with('default', 'foo')->willReturn([
            'foo' => [
                'value' => new \stdClass,
                'children' => [
                    'foo.bar' => [
                        'value' => m::mock('Xpressengine\Config\ConfigEntity'),
                        'children' => []
                    ]
                ]
            ]
        ]);

        $ancestor = $instance->fetchParent('default', 'foo.bar');
        $this->assertInstanceOf('stdClass', $ancestor[0]);
    }

    public function testFetchChildren()
    {
        list($repo, $cache) = $this->getMocks();
        $instance = $this->getMock(CacheDecorator::class, ['getData'], [$repo, $cache]);

        $instance->expects($this->exactly(2))->method('getData')->with('default', 'foo')->willReturn([
            'foo' => [
                'value' => m::mock('Xpressengine\Config\ConfigEntity'),
                'children' => [
                    'foo.bar' => [
                        'value' => m::mock('Xpressengine\Config\ConfigEntity'),
                        'children' => [
                            'foo.bar.baz' => [
                                'value' => m::mock('Xpressengine\Config\ConfigEntity'),
                                'children' => []
                            ],
                            'foo.bar.qux' => [
                                'value' => m::mock('Xpressengine\Config\ConfigEntity'),
                                'children' => []
                            ]
                        ]
                    ],
                ]
            ]
        ]);

        $descendant = $instance->fetchChildren('default', 'foo.bar');
        $this->assertEquals(2, count($descendant));

        $descendant = $instance->fetchChildren('default', 'foo');
        $this->assertEquals(3, count($descendant));
    }

    public function testMake()
    {
        list($repo, $cache) = $this->getMocks();
        $instance = new CacheDecorator($repo, $cache);

        $mockParent = m::mock('Xpressengine\Config\ConfigEntity');
        $mockParent->shouldReceive('getDepth')->andReturn(1);
        $mockParent->name = 'foo';

        $mockCfg1 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockCfg1->shouldReceive('getDepth')->andReturn(2);
        $mockCfg1->name = 'foo.bar';

        $mockCfg2 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockCfg2->shouldReceive('getDepth')->andReturn(3);
        $mockCfg2->name = 'foo.bar.baz';

        $mockCfg3 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockCfg3->shouldReceive('getDepth')->andReturn(3);
        $mockCfg3->name = 'foo.bar.qux';

        $mockCfg4 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockCfg4->shouldReceive('getDepth')->andReturn(3);
        $mockCfg4->name = 'foo.bar.var';

        $data = $this->invokeMethod($instance, 'make', [$mockParent, [$mockCfg1, $mockCfg2, $mockCfg3, $mockCfg4]]);

        $this->assertEquals('foo', array_keys($data)[0]);
        $data = array_shift($data);
        $this->assertEquals('foo.bar', array_keys($data['children'])[0]);
        $data = array_shift($data['children']);
        $this->assertEquals(3, count($data['children']));
    }

    private function invokeMethod($object, $method, $parameters)
    {
        $rfc = new \ReflectionClass($object);
        $method = $rfc->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
    
    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Config\Repositories\RepositoryInterface'),
            m::mock('Xpressengine\Support\CacheInterface'),
        ];
    }
}
