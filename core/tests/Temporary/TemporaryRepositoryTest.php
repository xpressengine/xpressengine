<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Temporary;

use Mockery as m;
use Xpressengine\Temporary\TemporaryRepository;

class TemporaryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFind()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new TemporaryRepository($conn, $keygen);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn([
            'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'key' => 'someKey',
            'val' => 'baz',
            'etc' => 'a:1:{s:3:"foo";s:3:"bar";}'
        ]);

        $temporary = $instance->find('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $array = $temporary->jsonSerialize();
        $this->assertEquals('baz', $array['val']);
        $this->assertEquals('bar', $array['etc']['foo']);
    }

    public function testFetch()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new TemporaryRepository($conn, $keygen);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('userId', 'userId')->andReturnSelf();
        $query->shouldReceive('where')->once()->with('key', 'someKey')->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn([
            [
                'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
                'key' => 'someKey',
                'val' => 'qux',
                'etc' => 'a:1:{s:3:"foo";s:3:"bar";}'
            ],
            [
                'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy',
                'key' => 'someKey',
                'val' => 'qux1',
                'etc' => 'a:1:{s:3:"foo";s:3:"baz";}'
            ]
        ]);

        $temporaries = $instance->fetch(['userId' => 'userId', 'key' => 'someKey']);

        $this->assertEquals(2, count($temporaries));
    }

    public function testInsert()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new TemporaryRepository($conn, $keygen);

        $mockEntity = m::mock('Xpressengine\Temporary\TemporaryEntity');
        $mockEntity->shouldReceive('getAttributes')->andReturn([
            'key' => 'someKey',
            'val' => 'baz',
            'etc' => 'a:1:{s:3:"foo";s:3:"bar";}'
        ]);

        $keygen->shouldReceive('generate')->andReturn('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('insert')->once()->with(m::on(function ($array) {
            return $array['key'] === 'someKey'
            && $array['val'] === 'baz'
            && $array['etc'] === 'a:1:{s:3:"foo";s:3:"bar";}'
            && $array['id'] === 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        }));

        $temporary = $instance->insert($mockEntity);

        $this->assertEquals('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $temporary->id);
        $this->assertEquals('someKey', $temporary->key);
    }

    public function testUpdate()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new TemporaryRepository($conn, $keygen);

        $mockEntity = m::mock('Xpressengine\Temporary\TemporaryEntity');
        $mockEntity->shouldReceive('getDirty')->andReturn(['val' => 'qux', 'etc' => 'a:1:{s:3:"foo";s:3:"baz";}']);
        $mockEntity->shouldReceive('getOriginal')->andReturn([
            'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'key' => 'someKey',
            'val' => 'baz',
            'etc' => 'a:1:{s:3:"foo";s:3:"bar";}'
        ]);
        $mockEntity->shouldReceive('get')->with('id')->andReturn('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnSelf();

        $query->shouldReceive('update')->once()->with(m::on(function ($array) {
            return $array['val'] === 'qux' && $array['etc'] === 'a:1:{s:3:"foo";s:3:"baz";}';
        }));

        $temporary = $instance->update($mockEntity);

        $this->assertEquals('qux', $temporary->val);
        $this->assertEquals('a:1:{s:3:"foo";s:3:"baz";}', $temporary->etc);
    }

    public function testDelete()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new TemporaryRepository($conn, $keygen);

        $mockEntity = m::mock('Xpressengine\Temporary\TemporaryEntity');
        $mockEntity->shouldReceive('get')->with('id')->andReturn('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('delete')->once()->andReturn(1);

        $instance->delete($mockEntity);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnectionInterface'),
            m::mock('Xpressengine\Keygen\Keygen'),
            m::mock('Xpressengine\Database\DynamicQuery')
        ];
    }
}
