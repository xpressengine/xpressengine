<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Commands\WidenCommand;

class WidenCommandTest extends \PHPUnit\Framework\TestCase
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
