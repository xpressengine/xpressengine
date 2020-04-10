<?php
/**
 * WidgetController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use App\Http\Sections\WidgetSection;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Support\JsonException;
use Xpressengine\Widget\WidgetHandler;
use Xpressengine\Widget\WidgetParser;

/**
 * Class WidgetController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class WidgetController extends Controller
{
    /**
     * Show list of widget.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index()
    {
        $widgetSectionView = new WidgetSection('__xe_content');

        return XePresenter::make('widget.index', [
            'widgetSectionView' => $widgetSectionView
        ]);
    }

    /**
     * Generate custom markup code of the widget.
     *
     * @param Request       $request       request
     * @param WidgetHandler $widgetHandler WidgetHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function generate(Request $request, WidgetHandler $widgetHandler)
    {
        $inputs = $request->except('_token');
        $widget = array_get($inputs, '@id');

        $code = $widgetHandler->generateCode($widget, $inputs);

        return XePresenter::makeApi([
            'code' => $code,
        ]);

    }

    /**
     * Show the skins of the widget.
     *
     * @param Request       $request     request
     * @param SkinHandler   $skinHandler SkinHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function skin(Request $request, SkinHandler $skinHandler)
    {
        $this->validate($request, [
            'widget' => 'required'
        ]);

        $widget = $request->get('widget');
        $code = $request->get('code');
        try {
            $code = json_dec($code, true);
        } catch (JsonException $e) {
            $code = null;
        }

        $skins = $skinHandler->getList($widget);

        return api_render('widget.skins', compact('widget', 'skins', 'code'));
    }

    /**
     * 주어진 위젯과 스킨에 대한 설정 폼을 반환한다.
     *
     * @param Request       $request       request
     * @param WidgetHandler $widgetHandler WidgetHandler instance
     * @param SkinHandler   $skinHandler   SkinHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function form(Request $request, WidgetParser $widgetParser, WidgetHandler $widgetHandler, SkinHandler $skinHandler)
    {
        $this->validate($request, [
            'widget' => 'required',
        ]);

        $widget = $request->get('widget');
        $skin = $request->get('skin');

        $code = $request->get('code');
        // widget form
        try {
            $inputs = json_dec($code, true);
        } catch (JsonException $e) {
            $inputs = $widgetParser->parseCode($code);
        }

        $widgetForm = $widgetHandler->setup($widget, $inputs);

        // skin form
        $skinForm = null;
        if($skin !== null) {
            $skin = $skinHandler->get($skin);
            $skinForm = $skin->renderSetting();
        }

        $title = array_get($inputs, '@attributes.title', '');

        return api_render('widget.form', compact('widget', 'skin', 'widgetForm', 'skinForm', 'code', 'title'));
    }

    /**
     * Show inputs for setup by given code.
     *
     * @param Request       $request       request
     * @param WidgetParser  $widgetParser  WidgetParser instance
     * @param WidgetHandler $widgetHandler WidgetHandler instance
     * @param SkinHandler   $skinHandler   SkinHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function setup(Request $request, WidgetParser $widgetParser, WidgetHandler $widgetHandler, SkinHandler $skinHandler)
    {
        $widgetSelector = null;
        $skinSelector = null;

        $this->validate($request, ['code' => 'required']);

        $code = $request->get('code');

        try {
            $inputs = json_dec($code, true);
        } catch (JsonException $e) {
            $inputs = $widgetParser->parseCode($code);
        }

        $widget = array_get($inputs, '@attributes.id');

        $title = array_get($inputs, '@attributes.title', '');

        // widget list
        $widgetList = $widgetHandler->getAll();
        $widgets = [];
        $widgets[''] = xe_trans('xe::selectWidget');
        foreach ($widgetList as $id => $class) {
            $widgets[$id] = $class::getTitle();
        }

        // skin list
        $skins = $skinHandler->getList($widget);

        // widget form
        $widgetForm = $widgetHandler->setup($widget, $inputs);

        // skin form
        $skin = array_get($inputs, '@attributes.skin-id');
        $skin = $skinHandler->get($skin);
        $skinForm = $skin->renderSetting($inputs);

        return api_render('widget.setup', compact('widgets', 'widget', 'title', 'skins', 'skin', 'widgetSelector', 'skinSelector', 'widgetForm', 'skinForm', 'code'));
    }

    /**
     * Render widget.
     *
     * @param Request       $request       request
     * @param WidgetHandler $widgetHandler WidgetHandler instance
     * @return \Xpressengine\Presenter\Presentable
     * @throws \Exception
     */
    public function render(Request $request, WidgetHandler $widgetHandler)
    {
        $id = $request->get('widget');
        $args = $request->except('widget');

        $render = $widgetHandler->render($id, $args);

        return $render;
    }
}
