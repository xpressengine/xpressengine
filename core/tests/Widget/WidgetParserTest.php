<?php
/**
 * WidgetParserTest
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

use Mockery as m;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Xpressengine\Widget\WidgetParser;

/**
 * Class WidgetParserTest
 *
 * @category Test
 * @package  Xpressengine\Tests\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class WidgetParserTest extends TestCase
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

        $inputs = [
            '@attributes' => [
                'id' => 'xpressengine@iconBar'
            ]
        ];

        $handler->shouldReceive('render')->with('xpressengine@iconBar', $inputs)->andReturn("<p>widget</p>");

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

        $inputs = [
            '@attributes' => [
                'id' => 'xpressengine@iconBar'
            ],
            'title' => '최근 가입회원'
        ];
        $handler->shouldReceive('render')->with('xpressengine@iconBar', $inputs)->andReturn("<p>widget</p>");

        $testString = '<xewidget id="xpressengine@iconBar"><title>최근 가입회원</title></xewidget>';
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
