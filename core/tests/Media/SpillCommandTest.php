<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Commands\SpillCommand;

class SpillCommandTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetName()
    {
        $instance = new SpillCommand();

        $this->assertEquals('spill', $instance->getName());
    }

    public function testGetMethod()
    {
        $instance = new SpillCommand();

        $this->assertEquals('resize', $instance->getMethod());
    }

    public function testGetExecArgs()
    {
        $instance = new SpillCommand();

        $dimension = m::mock('Xpressengine\Media\Coordinators\Dimension');
        $dimension->shouldReceive('getWidth')->andReturn(150);
        $dimension->shouldReceive('getHeight')->andReturn(150);
        $oriDimension = m::mock('Xpressengine\Media\Coordinators\Dimension');
        $oriDimension->shouldReceive('getWidth')->andReturn(200);
        $oriDimension->shouldReceive('getHeight')->andReturn(300);

        $instance->setDimension($dimension);
        $instance->setOriginDimension($oriDimension);

        $this->assertEquals([150, 225], $instance->getExecArgs());
    }
}
