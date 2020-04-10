<?php
/**
 * HtmlPresenter
 *
 * PHP version 7
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html;

use Xpressengine\Http\Request;
use Xpressengine\Presenter\Presentable;
use Xpressengine\Presenter\Presenter;
use Xpressengine\Presenter\Exceptions\NotFoundSkinException;
use Xpressengine\Seo\SeoHandler;
use Xpressengine\Theme\ThemeEntityInterface;
use Xpressengine\Widget\WidgetParser;

/**
 * HtmlPresenter
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class HtmlPresenter implements Presentable
{
    /**
     * 일반 출력할 때 사용할 wrapper
     *
     * @var string
     */
    protected static $commonHtmlWrapper = '';

    /**
     * 팝업 형식으로 출력할 때 사용할 wrapper
     *
     * @var string
     */
    protected static $popupHtmlWrapper = '';

    /**
     * @var Presenter
     */
    protected $presenter;

    /**
     * @var SeoHandler
     */
    protected $seo;

    /**
     * @var WidgetParser
     */
    protected $parser;

    /**
     * skin class name
     *
     * @var string
     */
    protected $skinName;

    /**
     * skin output id
     *
     * @var string
     */
    protected $id;

    /**
     * The array of view data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $type = Presenter::RENDER_ALL;

    /**
     * Create a new Renderer instance.
     *
     * @param Presenter    $presenter presenter
     * @param SeoHandler   $seo       seo handler
     * @param WidgetParser $parser    widget parser
     */
    public function __construct(Presenter $presenter, SeoHandler $seo, WidgetParser $parser)
    {
        $this->presenter = $presenter;
        $this->seo = $seo;
        $this->parser = $parser;
    }

    /**
     * set common html wrapper
     *
     * @param string $viewName view name
     * @return void
     */
    public static function setCommonHtmlWrapper($viewName)
    {
        self::$commonHtmlWrapper = $viewName;
    }

    /**
     * set popup html wrapper
     *
     * @param string $viewName view name
     * @return void
     */
    public static function setPopupHtmlWrapper($viewName)
    {
        self::$popupHtmlWrapper = $viewName;
    }

    /**
     * Illuminate\Http\Request::initializeFormats() 에서 정의된 formats 에서 하나의 format
     *
     * @return string
     */
    public static function format()
    {
        return 'html';
    }

    /**
     * get presenter
     *
     * @return Presenter
     */
    public function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * set presenter data to html renderer
     *
     * @return $this
     */
    public function setData()
    {
        $this->data = array_merge($this->presenter->getShared(), $this->presenter->getData());
        return $this;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $this->setData();
        $this->seo->import($this->data);
        $viewFactory = $this->presenter->getViewFactory();
        $skinView = $this->renderSkin();

        // return only content(Skin)
        if ($this->presenter->getRenderType() == Presenter::RENDER_CONTENT) {
            $viewContent = $this->presenter->isWidgetParsing() ?
                $this->parser->parseXml($skinView) :
                $skinView;
            return $viewContent;
        }

        // return popup type, without theme
        if ($this->presenter->getRenderType() == Presenter::RENDER_POPUP) {
            $baseTheme = $viewFactory->make(self::$popupHtmlWrapper);
            $viewContent = $this->presenter->isWidgetParsing() ?
                $this->parser->parseXml($skinView) :
                $skinView;
            $baseTheme->content = $viewContent;

            return $baseTheme->render();
        }

        $baseTheme = $viewFactory->make(self::$commonHtmlWrapper);
        $viewContent = $this->presenter->isWidgetParsing() ?
            $this->parser->parseXml($this->renderTheme($skinView)->render()) :
            $this->renderTheme($skinView)->render();
        $baseTheme->content = $viewContent;

        return $baseTheme->render();
    }

    /**
     * render skin
     *
     * @return \Illuminate\View\View
     */
    public function renderSkin()
    {
        $request = $this->presenter->getRequest();
        if ($request instanceof Request) {
            $isMobile = $request->isMobile();
        } else {
            $isMobile = false;
        }
        $instanceConfig = $this->presenter->getInstanceConfig();
        $skinHandler = $this->presenter->getSkinHandler();
        $viewFactory = $this->presenter->getViewFactory();

        $instanceId = $instanceConfig->getInstanceId();

        $skinTargetId = $this->presenter->getSkinTargetId();
        $id = $this->presenter->getId();

        $skinView = null;

        if ($skinTargetId != null && is_string($skinTargetId)) {
            if ($this->presenter->getIsSettings() && $skinTargetId !== 'error') {
                $skin = $skinHandler->getAssignedSettings($skinTargetId);
            } else {
                $skin = $skinHandler->getAssigned([$skinTargetId, $instanceId], $isMobile ? 'mobile' : 'desktop');
            }
            if ($skin === null) {
                throw new NotFoundSkinException(['name' => $skinTargetId]);
            }
            $skinView = $skin->setView($id)->setData($this->data)->render();
        } else {
            $skinView = $viewFactory->make($id, $this->data);
        }

        return $skinView;
    }

    /**
     * render theme
     *
     * @param \Illuminate\View\View $skinView skin view
     * @return \Illuminate\View\View
     */
    public function renderTheme($skinView)
    {
        $themeView = $skinView;

        $themeHandler = $this->presenter->getThemeHandler();

        // get instance theme
        /** @var ThemeEntityInterface $theme */
        $theme = $themeHandler->getSelectedTheme();

        // get site default theme
        if ($theme === null) {
            $themeHandler->selectSiteTheme();
            $theme = $themeHandler->getSelectedTheme();
        }

        if ($theme !== null) {
            // apply theme
            $themeView = $theme->render();
            $themeView->content = $skinView;
        }

        return $themeView;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->presenter->getData();
    }
}
