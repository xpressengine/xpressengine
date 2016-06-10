<?php
/**
 * SiteHandlerTest
 *
 * PHP version 5
 *
 * @category  Test
 * @package   Xpressengine\Tests\Site
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Site;

use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Site\SiteHandler;

/**
 * Class SiteHandlerTest
 *
 * @category Test
 * @package  Xpressengine\Tests\Site
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class SiteHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    public function testAdd()
    {
        list($configs) = $this->getMocks();
        $instance = $this->getMock(SiteHandler::class, ['createModel', 'checkUsableDomain'], [$configs]);

        $mockSite = m::mock('stdClass');
        $mockSite->shouldReceive('save')->once();

        $instance->expects($this->once())->method('checkUsableDomain')->with('myhost.com');
        $instance->expects($this->once())->method('createModel')->willReturn($mockSite);

        $site = $instance->add([
            'host' => 'myhost.com',
            'siteKey' => 'default'
        ]);

        $this->assertEquals('myhost.com', $site->host);
        $this->assertEquals('default', $site->siteKey);
    }

    public function testPut()
    {
        list($configs) = $this->getMocks();
        $instance = new SiteHandler($configs);

        $mockSite = m::mock('Xpressengine\Site\Site');
        $mockSite->shouldReceive('isDirty')->andReturn(true);
        $mockSite->shouldReceive('save')->once();

        $instance->put($mockSite);
    }

    public function testRemove()
    {
        list($configs) = $this->getMocks();
        $instance = $this->getMock(SiteHandler::class, ['createModel'], [$configs]);

        $mockSite = m::mock('stdClass');
        $mockSite->shouldReceive('delete')->once();

        $mockModel = m::mock('stdClass');
        $mockModel->shouldReceive('newQuery')->andReturnSelf();
        $mockModel->shouldReceive('where')->once()->with('host', 'myhost.com')->andReturnSelf();
        $mockModel->shouldReceive('get')->once()->andReturn($mockSite);

        $instance->expects($this->once())->method('createModel')->willReturn($mockModel);

        $instance->remove('myhost.com');
    }

    public function testCheckUsableDomain()
    {
        list($configs) = $this->getMocks();
        $instance = $this->getMock(SiteHandler::class, ['createModel'], [$configs]);

        $mockModel = m::mock('stdClass');
        $mockModel->shouldReceive('newQuery')->andReturnSelf();
        $mockModel->shouldReceive('where')->once()->with('host', 'myhost.com')->andReturnSelf();
        $mockModel->shouldReceive('exists')->once()->andReturn(true);

        $instance->expects($this->once())->method('createModel')->willReturn($mockModel);

        try {
            $this->invokedMethod($instance, 'checkUsableDomain', ['myhost.com']);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Site\Exceptions\CanNotUseDomainException', $e);
        }
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Config\ConfigManager')
        ];
    }

    private function invokedMethod($object, $methodName, $parameters = [])
    {
        $rfc = new \ReflectionClass($object);
        $method = $rfc->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
