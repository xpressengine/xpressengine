<?php
/**
 * WidgetHelperTest
 *
 * PHP version 5
 *
 * @category  Test
 * @package   Xpressengine\Tests\Widget
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Widget;

use Illuminate\Container\Container;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Widget\WidgetHandler;

/**
 * Class WidgetHelperTest
 *
 * @category Test
 * @package  Xpressengine\Tests\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class WidgetHelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockInterface
     */
    protected $handler;

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * testWidgetHelperFunction
     *
     * @return void
     */
    public function testWidgetHelperFunction()
    {
        $handler = $this->handler;
        $containerMock = m::mock('Illuminate\Contracts\Container\Container');
        $handler->shouldReceive('create')->andReturn('test widget called');
        $containerMock->shouldReceive('make')->andReturn($handler);

        Container::setInstance($containerMock);

        $this->assertSame('test widget called', widget('test@testWidgetId', []));
    }

    /**
     * testSetupWidgetHelperFunction
     *
     * @return void
     */
    public function testSetupWidgetHelperFunction()
    {
        $handler = $this->handler;
        $containerMock = m::mock('Illuminate\Contracts\Container\Container');
        $handler->shouldReceive('setUp')->andReturn('test widget setup form');
        $containerMock->shouldReceive('make')->andReturn($handler);

        Container::setInstance($containerMock);

        $this->assertSame('test widget setup form', setupWidget('test@testWidgetId'));
    }


    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        $handler = m::mock('Xpressengine\Widget\WidgetHandler');

        $this->handler = $handler;
        parent::setUp();
    }
}
