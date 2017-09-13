<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Commands\CropCommand;

class CropCommandTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetName()
    {
        $instance = new CropCommand();

        $this->assertEquals('crop', $instance->getName());
    }

    public function testGetMethod()
    {
        $instance = new CropCommand();

        $this->assertEquals('crop', $instance->getMethod());
    }

    public function testGetExecArgs()
    {
        $instance = new CropCommand();

        $dimension = m::mock('Xpressengine\Media\Coordinators\Dimension');
        $dimension->shouldReceive('getWidth')->andReturn(100);
        $dimension->shouldReceive('getHeight')->andReturn(200);
        $position = m::mock('Xpressengine\Media\Coordinators\Position');
        $position->shouldReceive('getLeft')->andReturn(10);
        $position->shouldReceive('getTop')->andReturn(20);

        $instance->setDimension($dimension);
        $instance->setPosition($position);

        $this->assertEquals([100, 200, 10, 20], $instance->getExecArgs());
    }
}
