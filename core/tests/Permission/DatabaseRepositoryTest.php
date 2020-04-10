<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Permission;

use Mockery as m;
use Xpressengine\Permission\Repositories\DatabaseRepository;

class DatabaseRepositoryTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFindByTypeAndNameReturnsRegistered()
    {
        list($conn, $query) = $this->getMocks();

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('site_key', 'default')->andReturn($query);
        $query->shouldReceive('where')->once()->with('name', 'board.notice')->andReturn($query);
        $query->shouldReceive('first')->once()->withNoArgs()->andReturn((object)[
            'id' => 1,
            'name' => 'board.notice',
            'grants' => '{"access":{"type":"power","value":"guest"},"create":{"type":"power","value":"user"},"read":{"type":"power","value":"guest"},"update":{"type":"group","value":["group_id_1","group_id_2"]},"delete":{"type":"group","value":["group_id_1","group_id_2"]}}',
        ]);

        $instance = new DatabaseRepository($conn);
        $registered = $instance->findByName('default', 'board.notice');

        $this->assertInstanceOf('Xpressengine\Permission\Permission', $registered);
        $this->assertEquals(['type' => 'power', 'value' => 'guest'], $registered['access']);
        $this->assertEquals('board.notice', $registered->name);
        $this->assertTrue(isset($registered['create']));

        $keys = '';
        $comma = '';
        foreach ($registered as $key => $value) {
            $keys .= $comma . $key;
            $comma = ',';
        }

        $this->assertEquals('access,create,read,update,delete', $keys);
    }

    public function testInsert()
    {
        list($conn, $query) = $this->getMocks();

        $mockRegistered = m::mock('Xpressengine\Permission\Permission');
        $mockRegistered->shouldReceive('getOriginal')->andReturn([]);
        $mockRegistered->shouldReceive('getAttributes')->andReturn([
            'name' => 'board.notice',
            'grants' => '{"access":{"type":"power","value":"guest"},"create":{"type":"power","value":"user"}}',
        ]);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('insertGetId')->once()->with(m::on(function ($array) {
            return $array['name'] === 'board.notice'
            && $array['grants'] === '{"access":{"type":"power","value":"guest"},"create":{"type":"power","value":"user"}}';
        }))->andReturn(1);

        $instance = new DatabaseRepository($conn);
        $registered = $instance->insert($mockRegistered);

        $this->assertEquals(1, $registered->id);
        $this->assertEquals(['type' => 'power', 'value' => 'guest'], $registered['access']);
        $this->assertEquals('board.notice', $registered->name);
    }

    public function testUpdate()
    {
        list($conn, $query) = $this->getMocks();

        $mockRegistered = m::mock('Xpressengine\Permission\Permission');
        $mockRegistered->shouldReceive('get')->with('id')->andReturn(1);
        $mockRegistered->shouldReceive('getOriginal')->andReturn([
            'id' => 1,
            'type' => 'instance',
            'name' => 'board.notice',
            'grants' => '{"access":{"type":"power","value":"guest"},"create":{"type":"power","value":"super"}}',
        ]);
        $mockRegistered->shouldReceive('getDirty')->andReturn([
            'grants' => '{"access":{"type":"power","value":"guest"},"create":{"type":"power","value":"user"}}',
        ]);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 1)->andReturn($query);

        $query->shouldReceive('update')->once()->with(m::on(function ($array) {
            return $array['grants'] === '{"access":{"type":"power","value":"guest"},"create":{"type":"power","value":"user"}}';
        }))->andReturnNull();

        $instance = new DatabaseRepository($conn);
        $registered = $instance->update($mockRegistered);

        $this->assertEquals(1, $registered->id);
        $this->assertEquals(['type' => 'power', 'value' => 'user'], $registered['create']);
        $this->assertEquals('board.notice', $registered->name);
        $this->assertEquals('instance', $registered->type);
    }

    public function testDelete()
    {
        list($conn, $query) = $this->getMocks();

        $mockRegistered = m::mock('Xpressengine\Permission\Permission');
        $mockRegistered->shouldReceive('get')->with('id')->andReturn(1);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 1)->andReturn($query);
        $query->shouldReceive('delete')->once()->withNoArgs()->andReturnNull();

        $instance = new DatabaseRepository($conn);
        $instance->delete($mockRegistered);
    }

    public function testFetchAncestor()
    {
        list($conn, $query) = $this->getMocks();

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('site_key', 'default')->andReturn($query);
        $query->shouldReceive('whereRaw')->once()->with("'board.notice.b1' like concat(`name`, '.', '%')")->andReturn($query);
        $query->shouldReceive('where')->once()->with('name', '<>', 'board.notice.b1')->andReturn($query);
        $query->shouldReceive('get')->once()->withNoArgs()->andReturn((object)[
            [
                'id' => 1,
                'type' => 'instance',
                'name' => 'board',
                'grants' => '{"access":{"type":"power","value":"guest"},"create":{"type":"power","value":"user"}}',
            ],
            [
                'id' => 2,
                'type' => 'instance',
                'name' => 'board.notice',
                'grants' => '{"access":{"type":"power","value":"guest"},"create":{"type":"power","value":"super"}}',
            ]
        ]);

        $instance = new DatabaseRepository($conn);
        $registereds = $instance->fetchAncestor('default', 'board.notice.b1');

        $this->assertEquals(2, count($registereds));

        $this->assertEquals(['type' => 'power', 'value' => 'user'], $registereds[0]['create']);
        $this->assertEquals('board', $registereds[0]->name);

        $this->assertEquals(['type' => 'power', 'value' => 'super'], $registereds[1]['create']);
        $this->assertEquals('board.notice', $registereds[1]->name);
    }

    public function testFoster()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DatabaseRepository($conn);

        $mockRegistered = m::mock('Xpressengine\Permission\Permission');
        $mockRegistered->shouldReceive('get')->with('site_key')->andReturn('default');
        $mockRegistered->shouldReceive('get')->with('name')->andReturn('prev.from');

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->twice()->with('site_key', 'default')->andReturnSelf();
        $query->shouldReceive('where')->twice()->with(m::on(function ($closure) use ($query) {
            $query->shouldReceive('where')->once()->with('name', 'prev.from')->andReturnSelf();
            $query->shouldReceive('orWhere')->once()->with('name', 'like', 'prev.from.%')->andReturnSelf();

            call_user_func($closure, $query);

            return true;
        }))->andReturnSelf();


        $conn->shouldReceive('raw')->once()->with("substr(`name`, length('prev') + 2)")->andReturn('newName');
        $query->shouldReceive('update')->once();

        $instance->foster($mockRegistered, null);

        $conn->shouldReceive('raw')->once()->with("concat('valid.to', substr(`name`, length('prev') + 1))")->andReturn('newName');
        $query->shouldReceive('update')->once();

        $instance->foster($mockRegistered, 'valid.to');
    }

    public function testAffiliate()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new DatabaseRepository($conn);

        $mockRegistered = m::mock('Xpressengine\Permission\Permission');
        $mockRegistered->shouldReceive('get')->with('site_key')->andReturn('default');
        $mockRegistered->shouldReceive('get')->with('name')->andReturn('prev.from');

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('site_key', 'default')->andReturnSelf();
        $query->shouldReceive('where')->once()->with(m::on(function ($closure) use ($query) {
            $query->shouldReceive('where')->once()->with('name', 'prev.from')->andReturnSelf();
            $query->shouldReceive('orWhere')->once()->with('name', 'like', 'prev.from.%')->andReturnSelf();

            call_user_func($closure, $query);

            return true;
        }))->andReturnSelf();

        $conn->shouldReceive('raw')->once()->with("concat('valid.to', '.', `name`)")->andReturn('newName');
        $query->shouldReceive('update')->once();

        $instance->affiliate($mockRegistered, 'valid.to');
    }


    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnectionInterface'),
            m::mock('Xpressengine\Database\DynamicQuery')
        ];
    }
}
