<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Config;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Config\Repositories\DatabaseRepository;

class DatabaseRepositoryTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFindReturnsConfig()
    {
        list($conn) = $this->getMocks();

        $instance = new DatabaseRepository($conn);

        $conn->shouldReceive('table')->once()->withAnyArgs()->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('site_key', 'default')->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('name', 'board.instance1')->andReturn($conn);
        $conn->shouldReceive('first')->once()->withNoArgs()->andReturn((object)[
            'name' => 'board.instance1',
            'vars' => '{"limit":20,"perPage":10}'
        ]);

        $config = $instance->find('default', 'board.instance1');

        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);
        $this->assertEquals(20, $config->get('limit'));
        $this->assertEquals(10, $config->get('perPage'));
    }

    public function testFetchAncestorReturnsConfigArray()
    {
        list($conn) = $this->getMocks();

        $instance = new DatabaseRepository($conn);

        $conn->shouldReceive('table')->once()->withAnyArgs()->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('site_key', 'default')->andReturn($conn);
        $conn->shouldReceive('whereRaw')->once()->with("'board.instance1' like concat(`name`, '.', '%')")->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('name', '<>', 'board.instance1')->andReturn($conn);
        $conn->shouldReceive('get')->once()->withNoArgs()->andReturn([
            (object)[
                'name' => 'board',
                'vars' => '{"limit":10,"perPage":5}'
            ]
        ]);

        $configs = $instance->fetchAncestor('default', 'board.instance1');

        $this->assertEquals(1, count($configs));

        $this->assertEquals('board', $configs[0]->name);
        $this->assertEquals(10, $configs[0]->get('limit'));
        $this->assertEquals(5, $configs[0]->get('perPage'));
    }

    public function testFetchDescendantReturnsConfigArray()
    {
        list($conn) = $this->getMocks();

        $instance = new DatabaseRepository($conn);

        $conn->shouldReceive('table')->once()->withAnyArgs()->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('site_key', 'default')->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('name', 'like', 'board.%')->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('name', '<>', 'board')->andReturn($conn);
        $conn->shouldReceive('get')->once()->withNoArgs()->andReturn([
            (object)[
                'name' => 'board.instance1',
                'vars' => '{"limit":20,"perPage":10}'
            ]
        ]);

        $configs = $instance->fetchDescendant('default', 'board');

        $this->assertEquals(1, count($configs));

        $this->assertEquals('board.instance1', $configs[0]->name);
        $this->assertEquals(20, $configs[0]->get('limit'));
        $this->assertEquals(10, $configs[0]->get('perPage'));
    }

    public function testSaveCallInsertWhenNotExists()
    {
        list($conn) = $this->getMocks();

        $instance = new DatabaseRepository($conn);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.instance1';
        $mockConfig->shouldReceive('getAttributes')->andReturn([
            'name' => 'board.instance1',
            'vars' => '{"limit":20,"perPage":10}'
        ]);

        $conn->shouldReceive('table')->withAnyArgs()->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('site_key', 'default')->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('name', 'board.instance1')->andReturn($conn);
        $conn->shouldReceive('first')->once()->withNoArgs()->andReturnNull();

        $conn->shouldReceive('insert')->once()->with([
            'name' => 'board.instance1',
            'vars' => '{"limit":20,"perPage":10}'
        ])->andReturnNull();

        $config = $instance->save($mockConfig);

        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);
        $this->assertEquals(20, $config->get('limit'));
        $this->assertEquals(10, $config->get('perPage'));
    }

    public function testSaveCallUpdateWhenAlreadyExists()
    {
        list($conn) = $this->getMocks();

        $instance = new DatabaseRepository($conn);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.instance1';
        $mockConfig->shouldReceive('getDirty')->andReturn([
            'vars' => '{"limit":25,"perPage":5}'
        ]);
        $mockConfig->shouldReceive('getOriginal')->andReturn([
            'name' => 'board.instance1',
            'vars' => '{"limit":20,"perPage":10}'
        ]);

        $conn->shouldReceive('table')->withAnyArgs()->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('site_key', 'default')->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('name', 'board.instance1')->andReturn($conn);
        $conn->shouldReceive('first')->once()->withNoArgs()->andReturn((object)[
            'name' => 'board.instance1',
            'vars' => '{"limit":20,"perPage":10}'
        ]);

        $conn->shouldReceive('where')->once()->with('site_key', 'default')->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('name', 'board.instance1')->andReturn($conn);
        $conn->shouldReceive('update')->once()->with([
            'vars' => '{"limit":25,"perPage":5}'
        ])->andReturn($conn);

        $config = $instance->save($mockConfig);

        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);
        $this->assertEquals(25, $config->get('limit'));
        $this->assertEquals(5, $config->get('perPage'));
    }

    public function testClearLike()
    {
        list($conn) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.instance1';

        $conn->shouldReceive('table')->withAnyArgs()->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('site_key', 'default')->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('name', 'like', 'board.instance1%')->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('name', '<>', 'board.instance1')->andReturn($conn);
        $conn->shouldReceive('where')->once()->with('name', 'not like', 'board.instance1.sub2%')->andReturn($conn);
        $conn->shouldReceive('update')->once()->with(['vars' => '[]'])->andReturnNull();

        $instance = new DatabaseRepository($conn);

        $instance->clearLike($mockConfig, ['board.instance1.sub2']);
    }

    public function testRemove()
    {
        list($conn) = $this->getMocks();

        $query = m::mock('Illuminate\Database\Query\Builder');

        $conn->shouldReceive('table')->withAnyArgs()->andReturn($query);
        $query->shouldReceive('where')->once()->with('site_key', 'default')->andReturn($query);
        $query->shouldReceive('where')->once()->with(m::on(function ($closure) use ($query) {
            $query->shouldReceive('where')->once()->with('name', 'like', 'board.instance1.%')->andReturn($query);
            $query->shouldReceive('orWhere')->once()->with('name', 'board.instance1')->andReturn($query);

            call_user_func($closure, $query);

            return true;
        }))->andReturn($query);
        $query->shouldReceive('delete')->once()->withNoArgs()->andReturnNull();

        $instance = new DatabaseRepository($conn);

        $instance->remove('default', 'board.instance1');
    }

    public function testFoster()
    {
        list($conn) = $this->getMocks();
        $query = m::mock('Illuminate\Database\Query\Builder');
        $instance = new DatabaseRepository($conn);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.instance1';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->twice()->with('site_key', 'default')->andReturnSelf();
        $query->shouldReceive('where')->twice()->with(m::on(function ($closure) use ($query) {
            $query->shouldReceive('where')->once()->with('name', 'board.instance1')->andReturnSelf();
            $query->shouldReceive('orWhere')->once()->with('name', 'like', 'board.instance1.%')->andReturnSelf();

            call_user_func($closure, $query);

            return true;
        }))->andReturnSelf();



        $conn->shouldReceive('raw')->once()->with("substr(`name`, length('board') + 2)")->andReturn('toNull');
        $query->shouldReceive('update')->once()->with(['name' => 'toNull']);

        $instance->foster($mockConfig, null);

        $conn->shouldReceive('raw')->once()->with("concat('to', substr(`name`, length('board') + 1))")->andReturn('notToNull');
        $query->shouldReceive('update')->once()->with(['name' => 'notToNull']);

        $instance->foster($mockConfig, 'to');
    }

    public function testAffiliate()
    {
        list($conn) = $this->getMocks();
        $query = m::mock('Illuminate\Database\Query\Builder');
        $instance = new DatabaseRepository($conn);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.instance1';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('site_key', 'default')->andReturnSelf();
        $query->shouldReceive('where')->once()->with(m::on(function ($closure) use ($query) {
            $query->shouldReceive('where')->once()->with('name', 'board.instance1')->andReturnSelf();
            $query->shouldReceive('orWhere')->once()->with('name', 'like', 'board.instance1.%')->andReturnSelf();

            call_user_func($closure, $query);

            return true;
        }))->andReturnSelf();


        $conn->shouldReceive('raw')->once()->with("concat('to', '.', `name`)")->andReturn('toName');
        $query->shouldReceive('update')->once()->with(['name' => 'toName']);

        $instance->affiliate($mockConfig, 'to');
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnectionInterface')
        ];
    }
}
