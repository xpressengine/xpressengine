<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Media;

use Mockery as m;
use Xpressengine\Media\Coordinators\Dimension;
use Xpressengine\Media\Thumbnailer;

class ThumbnailerTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGenerateThrownExceptionWhenCommandNotSets()
    {
        list($manager) = $this->getMocks();
        Thumbnailer::setManager($manager);
        $instance = new Thumbnailer();

        try {
            $instance->generate();

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Media\Exceptions\PropertyNotSetException', $e);
        }
    }

    public function testGenerate()
    {
        list($manager) = $this->getMocks();
        Thumbnailer::setManager($manager);
        $instance = new Thumbnailer();

        $imageContent = file_get_contents(__DIR__ . '/sample.png');
        $mockCommand = m::mock('Xpressengine\Media\Commands\CommandInterface');

        $mockCommand->shouldReceive('getName')->andReturn('letter');
        $mockCommand->shouldReceive('setOriginDimension')->once()->with(m::on(function ($object) {
            return $object instanceof Dimension;
        }));
        $mockCommand->shouldReceive('getMethod')->andReturn('resize');
        $mockCommand->shouldReceive('getExecArgs')->andReturn([100, 100]);

        $mockItvImage = m::mock('Intervention\Image\Image');
        $mockItvImage->shouldReceive('resize')->once()->with(100, 100)->andReturnSelf();
        $mockItvImage->shouldReceive('encode')->once()->andReturnSelf();
        $mockItvImage->shouldReceive('getEncoded')->once();
        $manager->shouldReceive('make')->once()->with($imageContent)->andReturn($mockItvImage);

        $instance->setOrigin($imageContent)->addCommand($mockCommand)->generate();
    }

    private function getMocks()
    {
        return [
            m::mock('Intervention\Image\ImageManager')
        ];
    }
}
