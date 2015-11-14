<?php
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
        $instance = new CacheDecorator($repo, $cache);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->siteKey = 'default';
        $mockConfig->name = 'top.child';

        $cache->shouldReceive('get')->twice()->with('config@default:top')->andReturn([
            'default:top' => [
                'value' => null,
                'children' => [
                    'another1' => [],
                    'another2' => []
                ]
            ]
        ]);
        $cache->shouldReceive('put')->once()->with('config@default:top', [
            'default:top' => [
                'value' => null,
                'children' => [
                    'another1' => [],
                    'another2' => [],
                    'child' => [
                        'value' => $mockConfig,
                        'children' => []
                    ]
                ]
            ]
        ]);

        $repo->shouldReceive('find')->once()->with('default', 'top.child')->andReturn($mockConfig);


        $config = $instance->find('default', 'top.child');

        $this->assertEquals($mockConfig, $config);
    }

    public function testSave()
    {
        list($repo, $cache) = $this->getMocks();
        $instance = new CacheDecorator($repo, $cache);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->siteKey = 'default';
        $mockConfig->name = 'top.child';

        $cache->shouldReceive('get')->once()->with('config@default:top')->andReturnNull();
        $cache->shouldReceive('put')->once()->with('config@default:top', [
            'default:top' => [
                'value' => null,
                'children' => [
                    'child' => [
                        'value' => $mockConfig,
                        'children' => []
                    ]
                ]
            ]
        ]);

        $repo->shouldReceive('save')->once()->with($mockConfig)->andReturn($mockConfig);

        $config = $instance->save($mockConfig);

        $this->assertEquals($mockConfig, $config);
    }

    public function testRemove()
    {
        list($repo, $cache) = $this->getMocks();
        $instance = new CacheDecorator($repo, $cache);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');

        $repo->shouldReceive('remove')->once()->with('default', 'top.child');
        $cache->shouldReceive('get')->once()->with('config@default:top')->andReturn([
            'default:top' => [
                'value' => null,
                'children' => [
                    'child' => [
                        'value' => $mockConfig,
                        'children' => []
                    ]
                ]
            ]
        ]);
        $cache->shouldReceive('put')->once()->with('config@default:top', [
            'default:top' => [
                'value' => null,
                'children' => []
            ]
        ]);

        $instance->remove('default', 'top.child');


        $repo->shouldReceive('remove')->once()->with('default', 'top');
        $cache->shouldReceive('forget')->once()->with('config@default:top');

        $instance->remove('default', 'top');
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Config\Repositories\RepositoryInterface'),
            m::mock('Xpressengine\Support\CacheInterface')
        ];
    }
}
