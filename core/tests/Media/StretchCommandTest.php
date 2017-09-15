<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
