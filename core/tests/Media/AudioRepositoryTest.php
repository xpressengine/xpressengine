<?php
/**
 * Created by PhpStorm.
 * User: jhyeon
 * Date: 15. 10. 6.
 * Time: 오후 8:25
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Repositories\AudioRepository;

class AudioRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFind()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new AudioRepository($conn);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $conn->shouldReceive('table')->once()->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', $id)->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn((object)[
            'foo' => 'bar',
            'baz' => 'qux'
        ]);

        $meta = $instance->find($id);
        $this->assertEquals('bar', $meta['foo']);
        $this->assertEquals('qux', $meta->baz);
    }

    public function testInsert()
    {
        list($conn, $query) = $this->getMocks();
        $instance = m::mock(AudioRepository::class, [$conn])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockMeta = m::mock('Xpressengine\Media\Meta');
        $mockMeta->id = $id;
        $mockMeta->shouldReceive('getAttributes')->andReturn([
            'id' => $id,
            'foo' => 'bar',
            'baz' => 'qux'
        ]);

        $conn->shouldReceive('table')->once()->andReturn($query);
        $query->shouldReceive('insert')->once()->with([
            'id' => $id,
            'foo' => 'bar',
            'baz' => 'qux'
        ]);

        $instance->shouldReceive('find')->once()->with($id)->andReturn($mockMeta);

        $meta = $instance->insert($mockMeta);

        $this->assertInstanceOf('Xpressengine\Media\Meta', $meta);
    }

    public function testDelete()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new AudioRepository($conn);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockMeta = m::mock('Xpressengine\Media\Meta');
        $mockMeta->id = $id;

        $conn->shouldReceive('table')->once()->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', $id)->andReturnSelf();
        $query->shouldReceive('delete')->once()->andReturn(1);

        $instance->delete($mockMeta);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnectionInterface'),
            m::mock('Xpressengine\Database\DynamicQuery')
        ];
    }
}
