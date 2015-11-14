<?php
namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Commands\HeightenCommand;

class HeightenCommandTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetName()
    {
        $instance = new HeightenCommand();

        $this->assertEquals('heighten', $instance->getName());
    }

    public function testGetMethod()
    {
        $instance = new HeightenCommand();

        $this->assertEquals('heighten', $instance->getMethod());
    }

    public function testGetExecArgs()
    {
        $instance = new HeightenCommand();

        $dimension = m::mock('Xpressengine\Media\Coordinators\Dimension');
        $dimension->shouldReceive('getHeight')->andReturn(200);

        $instance->setDimension($dimension);

        $this->assertEquals([200], $instance->getExecArgs());
    }
}
