<?php
namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Repositories\ImageRepository;

class ImageRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFind()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new ImageRepository($conn);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', $id)->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn([
            'id' => $id,
            'width' => 100,
            'height' => 100,
        ]);

        $meta = $instance->find($id);
        $this->assertInstanceOf('Xpressengine\Media\Meta', $meta);

        $query->shouldReceive('where')->once()->with('id', $id)->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturnNull();

        $this->assertNull($instance->find($id));
    }

    public function testFindByOption()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new ImageRepository($conn);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('originId', $id)->andReturnSelf();
        $query->shouldReceive('where')->once()->with('type', 'letter')->andReturnSelf();
        $query->shouldReceive('where')->once()->with('code', 'S')->andReturnSelf();

        $query->shouldReceive('first')->once()->andReturn([
            'originId' => $id,
            'type' => 'letter',
            'code' => 'S',
        ]);

        $meta = $instance->findByOption([
            'originId' => $id,
            'type' => 'letter',
            'code' => 'S',
        ]);

        $this->assertInstanceOf('Xpressengine\Media\Meta', $meta);


        $query->shouldReceive('where')->once()->with('originId', $id)->andReturnSelf();
        $query->shouldReceive('where')->once()->with('type', 'letter')->andReturnSelf();
        $query->shouldReceive('where')->once()->with('code', 'S')->andReturnSelf();

        $query->shouldReceive('first')->once()->andReturnNull();


        $this->assertNull($instance->findByOption([
            'originId' => $id,
            'type' => 'letter',
            'code' => 'S',
        ]));
    }

    public function testFetch()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new ImageRepository($conn);

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('get')->once()->andReturn([
            [
                'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
                'type' => 'letter',
                'code' => 'S',
            ],
            [
                'id' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxy',
                'type' => 'letter',
                'code' => 'M',
            ],
        ]);

        $data = $instance->fetch([]);

        $this->assertEquals(2, count($data));
    }

    public function testInsert()
    {
        list($conn, $query) = $this->getMocks();
        $instance = m::mock(ImageRepository::class, [$conn])
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
        $instance = new ImageRepository($conn);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockMeta = m::mock('Xpressengine\Media\Meta');
        $mockMeta->id = $id;

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', $id)->andReturnSelf();
        $query->shouldReceive('delete')->once()->withNoArgs();

        $instance->delete($mockMeta);
    }

    public function testDeleteByOriginId()
    {
        list($conn, $query) = $this->getMocks();
        $instance = new ImageRepository($conn);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $conn->shouldReceive('table')->andReturn($query);
        $query->shouldReceive('where')->once()->with('originId', $id)->andReturnSelf();
        $query->shouldReceive('delete')->once()->withNoArgs();

        $instance->deleteByOriginId($id);
    }

    public function getMocks()
    {
        return [
            m::mock('Xpressengine\Database\VirtualConnectionInterface'),
            m::mock('Xpressengine\Database\DynamicQuery'),
        ];
    }
}
