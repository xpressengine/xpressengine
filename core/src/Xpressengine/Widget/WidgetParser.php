<?php
/**
 * WidgetParser
 *
 * PHP version 5
 *
 * @category  Widget
 * @package   Xpressengine\Widget
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Widget;

use SimpleXMLElement;

/**
 * WidgetParser
 * Widget 코드(custom xml)를 html 로 렌더링 하기 위한 파서
 *
 * ## app binding
 * * xe.widget.parser 으로 바인딩 되어 있음
 * * 별도의 Fade 는 제공하지 않음
 *
 * ## 생성자에서 필요한 항목들
 * * WidgetHandler $widgetHandler - 위젯 핸들러
 *
 * ## 사용법
 *
 * ### content 를 위젯 렌더링 html 로 파싱
 * * content 로 전달하여 내부에 포함된 xml을 파싱하여
 * * widgetHandler 을 통해서 html 로 렌더링
 * ```php
 * $handler->parseXml($content)
 * ```
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class WidgetParser
{
    /**
     * @var WidgetHandler
     */
    protected $widgetHandler;


    /**
     * WidgetParser constructor.
     *
     * @param WidgetHandler $widgetHandler widget handler
     */
    public function __construct(WidgetHandler $widgetHandler)
    {
        $this->widgetHandler = $widgetHandler;
    }

    /**
     * parseXml
     *
     * @param string $content content html include custom widget xml
     *
     * @return mixed
     */
    public function parseXml($content)
    {
        $content = preg_replace_callback('/<xewidget[^>]*>.*?<\/xewidget>/s', [$this, 'parseWidget'], $content);

        return $content;
    }

    /**
     * 주어진 하나의 위젯 코드를 분석하고, 위젯을 출력한다.
     *
     * @param array $matches 위젯 코드
     *
     * @return mixed|string
     */
    protected function parseWidget($matches)
    {
        $widgetHandler = $this->widgetHandler;

        try {
            $widgetXmlString = $matches[0];

            $inputs = $this->parseCode($widgetXmlString);

            $widgetId = array_get($inputs, '@attributes.id');

            $retString = $widgetHandler->render($widgetId, $inputs);
            if ($retString !== null && !empty($retString)) {
                return $retString;
            }
        } catch (\Exception $e) {
            return '';
        }
        return '';
    }

    /**
     * 위젯 코드를 php array로 반환한다.
     *
     * @param string $code 위젯코드 php 배열 데이터로 변환한다.
     *
     * @return array
     */
    public function parseCode($code)
    {
        $simpleXmlObj = simplexml_load_string($code);

        $widgetId = (string) $simpleXmlObj->attributes()->id;

        $inputs = $this->xml2array($simpleXmlObj);

        return $inputs;
    }

    /**
     * xml 데이터를 배열로 변환한다.
     *
     * @param SimpleXMLElement|SimpleXMLElement[] $xmlObject xml object
     * @param array                               $out       변환한 데이터를 답을 배열
     *
     * @return array
     */
    protected function xml2array($xmlObject, $out = [])
    {
        foreach ((array) $xmlObject as $index => $node) {
            $value = (is_object($node)) ? $this->xml2array($node) : $node;
            $out[$index] = $value ? : '';
        }
        return $out;
    }
}
