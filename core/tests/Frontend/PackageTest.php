<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Frontend;

use Mockery;
use Xpressengine\Presenter\Html\FrontendHandler;
use Xpressengine\Presenter\Html\Tags\Package;

class PackageTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $p = new Package('mypackage');
        $this->assertInstanceOf('\Xpressengine\Presenter\Html\Tags\Package', $p);
    }

    public function testRegister()
    {
        $p = new Package('mypackage');
        $p->register(function($handler){
        });

        $packages = Package::packages();
        $this->assertCount(1, $packages);
        $this->assertArrayHasKey('mypackage', $packages);

        return $p;
    }

    /**
     * testLoad
     *
     * @param Package $p
     *
     * @depends testRegister
     */
    public function testLoad(Package $p)
    {
        $self = $this;
        $p->register(function($handler) use ($self) {
            $hi = $handler->sayHi();
            $self->assertEquals('hi', $hi);
        });

        $p->load();
    }

    /**
     * testLoadFail
     *
     * @expectedException \Xpressengine\Presenter\Exceptions\PackageNotFoundException
     */
    public function testLoadFail()
    {
        $p = new Package('notregistered');
        $p->load();
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        Package::init();
        Package::setHandler($this->getHandler());
        parent::setUp();
    }

    /**
     * getHandler
     *
     * @return FrontendHandler
     */
    protected function getHandler()
    {
        $handler = Mockery::mock(FrontendHandler::class);
        $handler->shouldReceive('sayHi')->andReturn('hi');
        return $handler;
    }
}
