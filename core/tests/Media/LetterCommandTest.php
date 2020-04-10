<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Commands\LetterCommand;

class LetterCommandTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetName()
    {
        $instance = new LetterCommand();

        $this->assertEquals('letter', $instance->getName());
    }

    public function testGetMethod()
    {
        $instance = new LetterCommand();

        $this->assertEquals('resize', $instance->getMethod());
    }

    public function testGetExecArgs()
    {
        $instance = new LetterCommand();

        $dimension = m::mock('Xpressengine\Media\Coordinators\Dimension');
        $dimension->shouldReceive('getWidth')->andReturn(150);
        $dimension->shouldReceive('getHeight')->andReturn(150);
        $oriDimension = m::mock('Xpressengine\Media\Coordinators\Dimension');
        $oriDimension->shouldReceive('getWidth')->andReturn(100);
        $oriDimension->shouldReceive('getHeight')->andReturn(200);

        $instance->setDimension($dimension);
        $instance->setOriginDimension($oriDimension);

        $this->assertEquals([75, 150], $instance->getExecArgs());
    }
}
