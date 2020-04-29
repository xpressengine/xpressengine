<?php
/**
 * WidgetHandler
 *
 * PHP version 7
 *
 * @category  Widget
 * @package   Xpressengine\Widget
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Widget;

use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\User\Rating;
use Xpressengine\Widget\Exceptions\NotFoundWidgetException;

/**
 * WidgetHandler
 * Widget 을 관리하는 클래스
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class WidgetHandler
{
    /**
     * @var array $displayErrorRatings super and manager can error view on render widget exception occur
     */
    public static $displayErrorRatings = [Rating::SUPER, Rating::MANAGER];

    /**
     * @var PluginRegister plugin registry manager 등록된 Widget 조회하기 위하여 사용됨
     */
    protected $register;
    /**
     * @var Guard
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
     * @param Guard          $guard     guard instance
     * @param Factory        $view      illuminate view factory
     * @param bool           $debugMode debug mode
     */
    public function __construct(
        PluginRegister $register,
        Guard $guard,
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
        try {
            $instance = $this->getInstance($widgetId, $args);

            if (in_array($this->guard->user()->getRating(), $instance::$ratingWhiteList)) {
                $ret = $instance->render();
                if ($ret instanceof Renderable) {
                    $ret = $ret->render();
                }
                return $ret;
            } else {
                return '';
            }
        } catch (Exception $e) {
            return $this->handleError($e);
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
        try {
            $widget = $this->getInstance($widgetId);

            $inputs = $widget->resolveSetting($inputs);

            return $this->generateXml('xe-widget', $inputs);
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Error handle for output
     *
     * @param Exception $e exception
     * @return string
     */
    protected function handleError(Exception $e)
    {
        if (in_array($this->guard->user()->getRating(), static::$displayErrorRatings)) {
            return $this->view->make('widget.error', ['message' => $e->getMessage()])->render();
        }

        return '';
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
        $space = '';//str_repeat('  ', $depth);
        foreach ($inputs as $k => $v) {
            // attribute
            if (strpos($k, '@') === 0) {
                $attr[substr($k, 1)] = (string) $v;
            } elseif (is_array($v)) {
                $children[] = $this->generateXml($k, $v, $depth + 1);
            } elseif (is_numeric($k)) {
                $children[] = sprintf("%s<item>%s</item>", $space, $v);
            } else {
                $children[] = sprintf("%s<%s>%s</%s>", $space, $k, $v, $k);
            }
        }

        $attrStr = '';
        array_walk(
            $attr,
            function ($value, $key) use (&$attrStr) {
                $attrStr .= ' '.$key.'="'.$value.'"';
            }
        );

        $xml = $space.'<'.$element.$attrStr.'>'.implode('', $children).$space.'</'.$element.'>';

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
