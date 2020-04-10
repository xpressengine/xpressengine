<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Draft;

use Mockery as m;
use Xpressengine\Draft\DraftRepository;

class DraftRepositoryTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFind()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new DraftRepository($conn, $keygen);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn([
            'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'key' => 'someKey',
            'val' => 'baz',
            'etc' => 'a:1:{s:3:"foo";s:3:"bar";}'
        ]);

        $draft = $instance->find('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');

        $array = $draft->jsonSerialize();
        $this->assertEquals('baz', $array['val']);
        $this->assertEquals('bar', $array['etc']['foo']);
    }

    public function testFetch()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new DraftRepository($conn, $keygen);

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

        $drafts = $instance->fetch(['userId' => 'userId', 'key' => 'someKey']);

        $this->assertEquals(2, count($drafts));
    }

    public function testInsert()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new DraftRepository($conn, $keygen);

        $mockEntity = m::mock('Xpressengine\Draft\DraftEntity');
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

        $draft = $instance->insert($mockEntity);

        $this->assertEquals('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $draft->id);
        $this->assertEquals('someKey', $draft->key);
    }

    public function testUpdate()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new DraftRepository($conn, $keygen);

        $mockEntity = m::mock('Xpressengine\Draft\DraftEntity');
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

        $draft = $instance->update($mockEntity);

        $this->assertEquals('qux', $draft->val);
        $this->assertEquals('a:1:{s:3:"foo";s:3:"baz";}', $draft->etc);
    }

    public function testDelete()
    {
        list($conn, $keygen, $query) = $this->getMocks();
        $instance = new DraftRepository($conn, $keygen);

        $mockEntity = m::mock('Xpressengine\Draft\DraftEntity');
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
