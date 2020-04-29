<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Commands\StretchCommand;

class StretchCommandTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetName()
    {
        $instance = new StretchCommand();

        $this->assertEquals('stretch', $instance->getName());
    }

    public function testGetMethod()
    {
        $instance = new StretchCommand();

        $this->assertEquals('resize', $instance->getMethod());
    }

    public function testGetExecArgs()
    {
        $instance = new StretchCommand();

        $dimension = m::mock('Xpressengine\Media\Coordinators\Dimension');
        $dimension->shouldReceive('getWidth')->andReturn(150);
        $dimension->shouldReceive('getHeight')->andReturn(150);

        $instance->setDimension($dimension);

        $this->assertEquals([150, 150], $instance->getExecArgs());
    }
}
