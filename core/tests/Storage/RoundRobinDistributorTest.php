<?php
namespace Xpressengine\Tests\Storage;

use Mockery as m;
use Xpressengine\Storage\RoundRobinDistributor;

class RoundRobinDistributorTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testAllotReturnsDefaultDiskWhenDivisionNotEnable()
    {
        list($config, $conn) = $this->getMocks();
        $config['division']['enable'] = false;

        $file = m::mock('Symfony\Component\HttpFoundation\File\UploadedFile');

        $instance = new RoundRobinDistributor($config, $conn);
        $disk = $instance->allot($file);

        $this->assertEquals('local', $disk);
    }

    public function testAllotReturnsNextDiskWhenDivisionEnable()
    {
        list($config, $conn) = $this->getMocks();

        $file = m::mock('Symfony\Component\HttpFoundation\File\UploadedFile');

        $conn->shouldReceive('table')->once()->andReturn($conn);
        $conn->shouldReceive('orderBy')->once()->with('created_at', 'desc')->andReturn($conn);
        $conn->shouldReceive('first')->once()->withNoArgs()->andReturn((object)[
            'disk' => 's3'
        ]);

        $instance = new RoundRobinDistributor($config, $conn);
        $disk = $instance->allot($file);

        $this->assertEquals('rackspace', $disk);
    }

    private function getMocks()
    {
        return [
            [
                'default' => 'local',
                'division' => [
                    'enable' => true,
                    'disks' => ['local', 's3', 'rackspace', 'ftp', 'sftp']
                ]
            ],
            m::mock('Xpressengine\Database\VirtualConnectionInterface')
        ];
    }
}