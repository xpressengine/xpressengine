<?php
/**
 * Presenter
 *
 * PHP version 5
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Presenter;

use Illuminate\Http\Request;
use Xpressengine\Presenter\Exceptions\InvalidPresenterException;
use Xpressengine\Presenter\Exceptions\NotFoundFormatException;
use Xpressengine\Presenter\Html\HtmlPresenter;
use Xpressengine\Presenter\Json\JsonPresenter;
use Xpressengine\Theme\ThemeHandler;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Settings\SettingsHandler;
use Xpressengine\Routing\InstanceConfig;
use Illuminate\View\Factory as ViewFactory;
use Closure;

/**
 * Presenter
 *
 * @category    Presenter
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Presenter
{
    /**
     * render type
     */
    const RENDER_ALL = 'all';

    /**
     * render type
     */
    const RENDER_POPUP = 'popup';

    /**
     * render type
     */
    const RENDER_CONTENT = 'content';

    /**
     * output id
     *
     * @var string
     */
    protected $id;

    /**
     * Data that should be available to all templates.
     *
     * @var array
     */
    protected $shared = [];

    /**
     * Data that should be available at current presentable
     *
     * @var array
     */
    protected $data = [];
    /**
     * is settings present
     *
     * @var bool
     */
    protected $isSettings = false;

    /**
     * skin class name
     *
     * @var string
     */
    protected $skinTargetId;

    /**
     * @var string
     */
    protected $type = self::RENDER_ALL;

    /**
     * @var ViewFactory
     */
    protected $viewFactory;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ThemeHandler
     */
    protected $themeHandler;

    /**
     * @var SkinHandler
     */
    protected $skinHandler;

    /**
     * @var SettingsHandler
     */
    protected $settingsHandler;

    /**
     * @var InstanceConfig
     */
    protected $instanceConfig;

    /**
     * is support api
     *
     * @var bool
     */
    protected $api = false;

    /**
     * is support html
     *
     * @var bool
     */
    protected $html = true;

    /**
     * registered presentable instance
     *
     * @var array
     */
    protected $presentables = [];

    /**
     * Create a new instance.
     *
     * @param ViewFactory     $viewFactory     view factory
     * @param Request         $request         Request instance
     * @param ThemeHandler    $themeHandler    theme handler
     * @param SkinHandler     $skinHandler     skin handler
     * @param SettingsHandler $settingsHandler manage handler
     * @param InstanceConfig  $instanceConfig  menu config
     */
    public function __construct(
        ViewFactory $viewFactory,
        Request $request,
        $themeHandler,
        $skinHandler,
        SettingsHandler $settingsHandler,
        InstanceConfig $instanceConfig
    ) {
        $this->viewFactory = $viewFactory;
        $this->request = $request;
        $this->themeHandler = $themeHandler;
        $this->skinHandler = $skinHandler;
        $this->settingsHandler = $settingsHandler;
        $this->instanceConfig = $instanceConfig;
    }

    /**
     * get ViewFactory
     *
     * @return ViewFactory
     */
    public function getViewFactory()
    {
        return $this->viewFactory;
    }

    /**
     * get request
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * get menu config
     *
     * @return InstanceConfig
     */
    public function getInstanceConfig()
    {
        return $this->instanceConfig;
    }

    /**
     * get skin handler
     *
     * @return SkinHandler
     */
    public function getSkinHandler()
    {
        return $this->skinHandler;
    }

    /**
     * get theme handler
     *
     * @return ThemeHandler
     */
    public function getThemeHandler()
    {
        return $this->themeHandler;
    }

    /**
     * get settings handler
     *
     * @return SettingsHandler
     * @deprecated
     */
    public function getManageHandler()
    {
        return $this->getSettingsHandler();
    }


    /**
     * get settings handler
     *
     * @return SettingsHandler
     */
    public function getSettingsHandler()
    {
        return $this->settingsHandler;
    }

    /**
     * register presentable classes
     *
     * @param string  $format   format
     * @param Closure $callback closure for get presentable instance
     * @return void
     */
    public function register($format, Closure $callback)
    {
        $this->presentables[$format] = $callback;
    }

    /**
     * get renderer
     *
     * @param string $format renderer format
     * @return Presentable
     */
    public function getPresenter($format)
    {
        return call_user_func_array($this->presentables[$format], [$this]);
    }

    /**
     * set skin class name
     *
     * @param string $skinTargetId skin target id
     * @return void
     */
    public function setSkinTargetId($skinTargetId)
    {
        $this->skinTargetId = $skinTargetId;
    }

    /**
     * set settings skin class name
     *
     * @param string $skinTargetId skin class name
     * @return void
     */
    public function setSettingsSkinTargetId($skinTargetId)
    {
        $this->skinTargetId = $skinTargetId;
        $this->isSettings = true;
    }

    /**
     * render 방식 설정
     * $type [
     *  'all' => theme, skin 처리
     *  'content' => content 만 render
     * ]
     *
     * @param string $type render type
     * @return void
     * @deprecated
     */
    public function renderType($type = self::RENDER_ALL)
    {
        $this->type = $type;
    }

    /**
     * render 방식을 content 로 설정
     *
     * @param bool $partial render to content
     * @return void
     */
    public function htmlRenderPartial($partial = true)
    {
        if ($partial === true) {
            $this->type = self::RENDER_CONTENT;
        } else {
            $this->type = self::RENDER_ALL;
        }
    }

    /**
     * render 방식을 content 로 설정
     *
     * @param bool $popup render to popup
     * @return void
     */
    public function htmlRenderPopup($popup = true)
    {
        if ($popup === true) {
            $this->type = self::RENDER_POPUP;
        } else {
            $this->type = self::RENDER_ALL;
        }
    }

    /**
     * Add a piece of shared data to the environment.
     *
     * @param mixed $key   key(string|array)
     * @param mixed $value value
     * @return null|array
     */
    public function share($key, $value = null)
    {
        if (is_array($key) === false) {
            return $this->shared[$key] = $value;
        }

        foreach ($key as $innerKey => $innerValue) {
            $this->share($innerKey, $innerValue);
        }
        return null;
    }

    /**
     * get shared
     *
     * @return array
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * 출력 처리할 renderer 반환
     * api 지원 안함
     *
     * @param string $id        skin output id
     * @param array  $data      data
     * @param array  $mergeData merge data
     * @param bool   $html      use html
     * @param bool   $api       use api
     * @return RendererInterface
     */
    public function make($id, array $data = [], array $mergeData = [], $html = true, $api = false)
    {
        $this->setUse($html, $api);
        $this->data = array_merge($data, $mergeData);
        $this->id = $id;

        /** @var RendererInterface $renderer */
        return $this->get();
    }

    /**
     * API 지원하는 renderer 반환
     * html 지원 안하지 않고 api만 처리 할 경우 사용
     *
     * @param array $data      data
     * @param array $mergeData merge data
     * @return RendererInterface
     */
    public function makeApi(array $data = [], array $mergeData = [])
    {
        return $this->make(null, $data, $mergeData, false, true);
    }

    /**
     * api, html 모두 지원하는 renderer 반환
     *
     * @param string $id        skin output id
     * @param array  $data      data
     * @param array  $mergeData merge data
     * @return RendererInterface
     */
    public function makeAll($id, array $data = [], array $mergeData = [])
    {
        return $this->make($id, $data, $mergeData, true, true);
    }

    /**
     * xeRedirect() 메소드와 같은 형태의 파라메터 사용
     *
     * @param null  $to      redirect url
     * @param int   $status  status code
     * @param array $headers header
     * @param null  $secure  secure
     * @param array $data    data
     * @return \Xpressengine\Presenter\RedirectResponse|\Xpressengine\Presenter\Redirector
     */
    public function redirect($to = null, $status = 302, $headers = [], $secure = null, $data = [])
    {
        return xeRedirect($to, $status, $headers, $secure, $data);
    }

    /**
     * get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set id
     *
     * @param string $id id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * get shared data
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * set shared data
     *
     * @param array $data data
     * @return void
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * get skin target id
     *
     * @return string
     */
    public function getSkinTargetId()
    {
        return $this->skinTargetId;
    }

    /**
     * get is settings support
     *
     * @return bool
     */
    public function getIsSettings()
    {
        return $this->isSettings;
    }

    /**
     * get render type
     *
     * @return string
     */
    public function getRenderType()
    {
        return $this->type;
    }

    /**
     * Presenter Package 는 JsonRenderer, HtmlRenderer 를 지원한다.
     * Xpressengine 은 Register Container 로 등록된 Renderer 를 사용한다.
     *
     * @return RendererInterface
     */
    protected function get()
    {
        $format = $this->request->format();

        if (isset($this->presentables[$format]) === false) {
            throw new NotFoundFormatException(['name' => $format]);
        }

        if ($format == HtmlPresenter::format() &&
            $this->api === true &&
            $this->html === false) {
            $format = JsonPresenter::format();
        }

        $presenter = $this->getPresenter($format);

        if (is_subclass_of($presenter, RendererInterface::class) === false &&
            is_subclass_of($presenter, Presentable::class) === false) {
            throw new InvalidPresenterException(['name' => get_class($presenter)]);
        }

        return $presenter;
    }

    /**
     * html, api 사용 유무 설정
     *
     * @param bool $html use or disuse
     * @param bool $api  use or disuse
     * @return void
     */
    private function setUse($html, $api)
    {
        $this->setHtml($html);
        $this->setApi($api);
    }

    /**
     * API로 출력 사용 유무 설정
     *
     * @param bool $use use or disuse
     * @return void
     */
    private function setApi($use = true)
    {
        $this->api = $use;
    }

    /**
     * HTML로 출력 사용 유무 설정
     *
     * @param bool $use use or disuse
     * @return void
     */
    private function setHtml($use = true)
    {
        $this->html = $use;
    }

    /**
     * render 할 수 있도록 허용된 요청 fotmat인가?
     *
     * @param string $format request format
     * @return bool
     */
    private function isApproveFormat($format)
    {
        if ($this->html !== true && $format == 'html') {
            return false;
        } elseif ($this->api !== true && $format != 'html') {
            return false;
        }

        return true;
    }
}
