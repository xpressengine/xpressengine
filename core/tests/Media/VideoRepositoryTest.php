<?php
namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Repositories\VideoRepository;

class VideoRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFind()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new VideoRepository($conn);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', $id)->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn([
            'id' => $id,
            'playtime' => 30
        ]);

        $meta = $instance->find($id);
        $this->assertInstanceOf('Xpressengine\Media\Meta', $meta);

        $query->shouldReceive('where')->once()->with('id', $id)->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturnNull();

        $this->assertNull($instance->find($id));
    }

    public function testInsert()
    {
        list($conn, $query) = $this->getMocks();
        $instance = m::mock(VideoRepository::class, [$conn])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockMeta = m::mock('Xpressengine\Media\Meta');
        $mockMeta->id = $id;
        $mockMeta->shouldReceive('getAttributes')->andReturn([
            'id' => $id,
            'playtime' => 30
        ]);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('insert')->once()->with([
            'id' => $id,
            'playtime' => 30
        ]);

        $instance->shouldReceive('find')->once()->with($id);

        $instance->insert($mockMeta);
    }

    public function testDelete()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new VideoRepository($conn);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockMeta = m::mock('Xpressengine\Media\Meta');
        $mockMeta->id = $id;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', $id)->andReturnSelf();
        $query->shouldReceive('delete')->once()->withNoArgs();

        $instance->delete($mockMeta);
    }

    public function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnectionInterface'),
            m::mock('Xpressengine\Database\DynamicQuery'),
        ];
    }
}
