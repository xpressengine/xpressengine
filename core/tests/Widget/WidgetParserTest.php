<?php
/**
 * WidgetParserTest
 *
 * @category  Test
 * @package   Xpressengine\Tests\Widget
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Widget;

use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Widget\WidgetParser;
use Xpressengine\Widget\WidgetHandler;

/**
 * Class WidgetParserTest
 *
 * @category Test
 * @package  Xpressengine\Tests\Widget
 */
class WidgetParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockInterface
     */
    protected $handler;
    /**
     * @var WidgetParser
     */
    protected $parser;

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
     * testParseXml
     *
     * @return void
     */
    public function testParseXml()
    {
        $parser = $this->parser;

        $testString = '';
        $resultString = $parser->parseXml($testString);


        $this->assertEquals($testString, $resultString);
    }

    /**
     * testParseXmlHandlerException
     *
     * @return void
     */
    public function testParseXmlHandlerException()
    {
        $handler = $this->handler;
        $parser = $this->parser;

        $handler->shouldReceive('create')->andThrow(new \Exception);

        $testString = '<xewidget id="xpressengine@iconBar"></xewidget>';
        $resultString = $parser->parseXml($testString);


        $this->assertEquals('', $resultString);
    }

    /**
     * testParseXmlHandlerReplace
     *
     * @return void
     */
    public function testParseXmlHandlerReplace()
    {
        $handler = $this->handler;
        $parser = $this->parser;

        $handler->shouldReceive('create')->andReturn("<p>widget</p>");

        $testString = '<xewidget id="xpressengine@iconBar"></xewidget>';
        $resultString = $parser->parseXml($testString);


        $this->assertEquals("<p>widget</p>", $resultString);
    }

    /**
     * testParseXmlHandlerReplaceIncludeParam
     *
     * @return void
     */
    public function testParseXmlHandlerReplaceIncludeParam()
    {
        $handler = $this->handler;
        $parser = $this->parser;

        $handler->shouldReceive('create')->andReturn("<p>widget</p>");

        $testString = '<xewidget id="xpressengine@iconBar"><param title="title">최근 가입회원</param></xewidget>';
        $resultString = $parser->parseXml($testString);


        $this->assertEquals("<p>widget</p>", $resultString);
    }

    /**
     * testParseXmlHandlerNullRet
     *
     * @return void
     */
    public function testParseXmlHandlerNullRet()
    {
        $handler = $this->handler;
        $parser = $this->parser;

        $handler->shouldReceive('create')->andReturnNull();

        $testString = '<xewidget id="xpressengine@iconBar"></xewidget>';
        $resultString = $parser->parseXml($testString);

        $this->assertEquals('', $resultString);
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
        $this->parser = new WidgetParser($handler);
        parent::setUp();
    }
}
