<?php
/**
 * WidgetHandler
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

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\User\GuardInterface;
use Xpressengine\Widget\Exceptions\NotFoundWidgetException;

/**
 * WidgetHandler
 * Widget 을 관리하는 클래스
 *
 * ## app binding
 * * xe.widget 으로 바인딩 되어 있음
 * * Widget Facade 제공
 *
 * ## 생성자에서 필요한 항목들
 * * PluginRegister $register - 등록된 위젯 정보를 획득하기 위한 plugin register
 * * GuardInterface $guard - 위젯을 render 할 때 현재 접속한 사용자의 권한을 확인하기 위한 guard
 * * Factory $view - 렌더링을 하기위한 view factory
 *
 * ## 사용법
 *
 * ### Widget Id 에 해당하는 클래스 이름 획득
 *
 * ```php
 * $handler->getClassName($id)
 * ```
 *
 * ### Widget Id 에 해당하는 위젯 HTML 렌더링 코드 반환
 * * widget id 와 렌러링에 필요한 arguments param array 를 인자로 전달
 *
 * ```php
 * $handler->create($id, $args = [])
 * ```
 *
 * ### Widget Id 에 설정 view form 반환
 * * 위젯 코드를 생성하기 위한 설정 화면에 대한 view form 반환
 *
 * ```php
 * $handler->setUp($id);
 * ```
 *
 * ### 원하는 위젯 class List 반환
 * * filter 를 전달하여 원하는 widget class 정보를 획득한다
 *
 * ```php
 * $handler->getAll(callable $filter = null);
 * ```
 *
 * ### Widget Id 에 해당하는 위젯 코드(custom xml)을 획득한다
 * * widget id 와 렌러링에 필요한 arguments param array 를 인자로 전달
 *
 * ```php
 * $handler->getGeneratedCode($id, array $inputs)
 * ```
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class WidgetHandler
{
    /**
     * @var array $displayErrorRatings super and manager can error view on render widget exception occur
     */
    public static $displayErrorRatings = ['super', 'manager'];
    /**
     * @var PluginRegister plugin registry manager 등록된 Widget 조회하기 위하여 사용됨
     */
    protected $register;
    /**
     * @var GuardInterface
     */
    protected $guard;
    /**
     * @var bool debug mode
     */
    protected $debugMode;
    /**
     * @var Factory
     */
    private $view;

    /**
     * 생성자
     *
     * @param PluginRegister $register  plugin registry manager
     * @param GuardInterface $guard     guard instance
     * @param Factory        $view      illuminate view factory
     * @param bool           $debugMode debug mode
     */
    public function __construct(
        PluginRegister $register,
        GuardInterface $guard,
        Factory $view,
        $debugMode = false
    ) {
        $this->register = $register;
        $this->guard = $guard;
        $this->debugMode = $debugMode;
        $this->view = $view;
    }

    /**
     * 주어진 id로 등록된 Widget 반환한다.
     *
     * @param string $widgetId 반환할 Widget id
     *
     * @return mixed
     */
    public function getClassName($widgetId)
    {
        return $this->register->get($this->fullWidgetId($widgetId));
    }

    /**
     * getInstance
     *
     * @param string $widgetId widget id
     * @param null   $args     widget config data
     *
     * @return AbstractWidget
     */
    protected function getInstance($widgetId, $args = null)
    {
        $className = $this->getClassName($widgetId);
        if ($className === null) {
            throw new NotFoundWidgetException(['id' => $widgetId]);
        }

        $instance = new $className($args);
        return $instance;
    }

    /**
     * create
     *
     * @param string $widgetId widget id
     * @param array  $args     to create widget html arguments
     *
     * @return mixed
     * @throws Exception
     */
    public function render($widgetId, $args = [])
    {
        $currentUserRating = $this->guard->user()->getRating();

        try {
            $instance = $this->getInstance($widgetId, $args);

            if (in_array($currentUserRating, $instance::$ratingWhiteList)) {
                $ret = $instance->render();
                if ($ret instanceof Renderable) {
                    $ret = $ret->render();
                }
                return $ret;
            } else {
                return '';
            }
        } catch (Exception $e) {
            if (in_array($currentUserRating, static::$displayErrorRatings)) {
                return $this->view->make('widget.error', ['message' => $e->getMessage()])->render();
            } else {
                return '';
            }
        }
    }

    /**
     * render widget setting form
     *
     * @param string $widgetId widget id
     * @param array  $configs  widget config data
     *
     * @return mixed
     */
    public function setup($widgetId, $configs = [])
    {
        $instance = $this->getInstance($widgetId);
        return $instance->renderSetting($configs);
    }

    /**
     * retrive all of registered widget
     *
     * @param callable $filter filter
     *
     * @return array
     */
    public function getAll(callable $filter = null)
    {
        $widgets = $this->register->get('widget');
        if ($filter === null) {
            return $widgets;
        } else {
            $widgets = array_filter($widgets, $filter);
            return $widgets;
        }
    }

    /**
     * generate widget code by widget id and config given
     *
     * @param string $widgetId widget id
     * @param array  $inputs   widget config data
     *
     * @return string
     */
    public function generateCode($widgetId, array $inputs)
    {
        $widget = $this->getInstance($widgetId);

        $inputs = $widget->resolveSetting($inputs);

        return $this->generateXml('xewidget', $inputs);
    }

    /**
     * xml string을 생성하여 반환한다. element명과 element의 attr, child elements 정보를 입력받는다.
     *
     * @param string $element xml element명
     * @param array  $inputs  설정값 또는 하위설정 데이터
     * @param int    $depth   들여쓰기 레벨
     *
     * @return string
     */
    public function generateXml($element, $inputs, $depth = 0)
    {
        $attr = [];
        $children = [];
        $space = str_repeat('  ', $depth);
        foreach ($inputs as $k => $v) {
            // attribute
            if (strpos($k, '@') === 0) {
                $attr[substr($k, 1)] = (string) $v;
            } elseif (is_array($v)) {
                $children[] = $this->generateXml($k, $v, $depth + 1);
            } elseif (is_numeric($k)) {
                $children[] = sprintf("  %s<item>%s</item>".PHP_EOL, $space, $v);
            } else {
                $children[] = sprintf("  %s<%s>%s</%s>".PHP_EOL, $space, $k, $v, $k);
            }
        }

        $attrStr = '';
        array_walk(
            $attr,
            function ($value, $key) use (&$attrStr) {
                $attrStr .= ' '.$key.'="'.$value.'"';
            }
        );

        $xml = $space.'<'.$element.$attrStr.'>'.PHP_EOL.implode('', $children).$space.'</'.$element.'>'.PHP_EOL;

        return $xml;
    }

    /**
     * prefix를 포함한 완전한 widget id를 반환한다.
     *
     * @param string $widgetId widget id
     *
     * @return string
     */
    protected function fullWidgetId($widgetId)
    {
        if (stripos($widgetId, 'widget/') !== false) {
            return $widgetId;
        } else {
            return 'widget/'.$widgetId;
        }
    }
}
