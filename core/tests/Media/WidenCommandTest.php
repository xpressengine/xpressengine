<?php
namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Commands\WidenCommand;

class WidenCommandTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetName()
    {
        $instance = new WidenCommand();

        $this->assertEquals('widen', $instance->getName());
    }

    public function testGetMethod()
    {
        $instance = new WidenCommand();

        $this->assertEquals('widen', $instance->getMethod());
    }

    public function testGetExecArgs()
    {
        $instance = new WidenCommand();

        $dimension = m::mock('Xpressengine\Media\Coordinators\Dimension');
        $dimension->shouldReceive('getWidth')->andReturn(200);

        $instance->setDimension($dimension);

        $this->assertEquals([200], $instance->getExecArgs());
    }
}
