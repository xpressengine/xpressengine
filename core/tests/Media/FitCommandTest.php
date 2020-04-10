<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Commands\FitCommand;

class FitCommandTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetName()
    {
        $instance = new FitCommand();

        $this->assertEquals('fit', $instance->getName());
    }

    public function testGetMethod()
    {
        $instance = new FitCommand();

        $this->assertEquals('fit', $instance->getMethod());
    }

    public function testGetExecArgs()
    {
        $instance = new FitCommand();

        $dimension = m::mock('Xpressengine\Media\Coordinators\Dimension');
        $dimension->shouldReceive('getWidth')->andReturn(100);
        $dimension->shouldReceive('getHeight')->andReturn(200);
        $oriDimension = m::mock('Xpressengine\Media\Coordinators\Dimension');
        $oriDimension->shouldReceive('getWidth')->andReturn(150);
        $oriDimension->shouldReceive('getHeight')->andReturn(150);

        $instance->setDimension($dimension);
        $instance->setOriginDimension($oriDimension);
        $instance->setPosition('left');

        $this->assertEquals([100, 150, null, 'left'], $instance->getExecArgs());
    }
}
