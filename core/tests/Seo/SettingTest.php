<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Seo;

use Mockery as m;
use Xpressengine\Seo\Setting;
use Xpressengine\Storage\File;

class SettingTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testExists()
    {
        list($cfg, $storage, $media, $keygen) = $this->getMocks();
        $instance = new Setting($cfg, $storage, $media, $keygen);

        $cfg->shouldReceive('get')->once()->andReturnNull();

        $this->assertFalse($instance->exists());

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $cfg->shouldReceive('get')->once()->andReturn($mockConfig);

        $this->assertTrue($instance->exists());
        $this->assertTrue($instance->exists());
    }

    public function testGet()
    {
        list($cfg, $storage, $media, $keygen) = $this->getMocks();
        $instance = m::mock(Setting::class, [$cfg, $storage, $media, $keygen])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $instance->shouldReceive('exists')->once()->andReturn(false);

        $val = $instance->get('title');

        $this->assertNull($val);
    }

    public function testSet()
    {
        list($cfg, $storage, $media, $keygen) = $this->getMocks();
        $instance = new Setting($cfg, $storage, $media, $keygen);

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->once()->with('uuid')->andReturnNull();

        $keygen->shouldReceive('generate')->once()->andReturn($id);

        $mockConfig->shouldReceive('set')->once()->with('uuid', $id);

        $cfg->shouldReceive('set')->once()->with(
            m::on(function () { return true; }),
            [
                'foo' => 'bar',
                'baz' => 'qux'
            ]
        )->andReturn($mockConfig);

        $cfg->shouldReceive('modify')->once()->with($mockConfig);

        $instance->set([
            'foo' => 'bar',
            'baz' => 'qux'
        ]);
    }

    public function testGetSiteImage()
    {
        list($cfg, $storage, $media, $keygen) = $this->getMocks();
        $instance = m::mock(Setting::class, [$cfg, $storage, $media, $keygen])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $instance->shouldReceive('get')->with('uuid')->andReturn($id);

        $mockFile = m::mock('Xpressengine\Storage\File');
        $mockImage = m::mock('Xpressengine\Media\Models\Image');

        $storage->shouldReceive('fetchByFileable')->with($id)->andReturn([$mockFile]);

        $media->shouldReceive('make')->once()->with($mockFile)->andReturn($mockImage);

        $image = $instance->getSiteImage();

        $this->assertInstanceOf('Xpressengine\Media\Models\Image', $image);
    }

    public function testSetSiteImage()
    {
        list($cfg, $storage, $media, $keygen) = $this->getMocks();
        $instance = m::mock(Setting::class, [$cfg, $storage, $media, $keygen])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

        $mockImage = m::mock('Xpressengine\Media\Models\Image');

        $instance->shouldReceive('get')->with('uuid')->andReturn($id);

        $storage->shouldReceive('unBindAll')->once()->with($id, true);
        $storage->shouldReceive('bind')->once()->with($id, $mockImage);

        $instance->setSiteImage($mockImage);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Config\ConfigManager'),
            m::mock('Xpressengine\Storage\Storage'),
            m::mock('Xpressengine\Media\MediaManager'),
            m::mock('Xpressengine\Keygen\Keygen'),
        ];
    }
}
