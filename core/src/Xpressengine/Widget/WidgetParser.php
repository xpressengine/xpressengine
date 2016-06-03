<?php
/**
 * WidgetParser
 *
 * @category  Widget
 * @package   Xpressengine\Widget
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\Widget;

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
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
        $widgetHandler = $this->widgetHandler;

        $content = preg_replace_callback('/<xewidget (.*?)<\/xewidget>/s', function ($matches) use ($widgetHandler) {

            try {
                $widgetXmlString = $matches[0];
                $simpleXmlObj = simplexml_load_string($widgetXmlString);

                $widgetId = (string)$simpleXmlObj->attributes()->id;

                $inputs = [];

                foreach ($simpleXmlObj->param as $param) {
                    $key = (string)$param['title'];
                    $value = (string)$param[0];
                    $inputs[$key] = $value;
                }

                $retString = $widgetHandler->create($widgetId, $inputs);
                if ($retString !== null && !empty($retString)) {
                    return $retString;
                }
            } catch (\Exception $e) {
                return '';
            }
            return '';
        }, $content);

        return $content;
    }
}
