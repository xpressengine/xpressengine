<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use App\Http\Sections\WidgetSection;
use Illuminate\Http\Request;
use Input;
use View;
use XePresenter;
use Xpressengine\Skin\SkinEntity;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Widget\WidgetHandler;
use Xpressengine\Widget\WidgetParser;

class WidgetController extends Controller {


    /**
     * index
     *
     * @return mixed
     */
    public function index()
    {
        $widgetSectionView = new WidgetSection('__xe_content');

        return XePresenter::make('widget.index', [
            'widgetSectionView' => $widgetSectionView
        ]);
    }

    public function generate(Request $request, WidgetHandler $widgetHandler)
    {
        $data = $request->getContent();

        $data = json_decode($data);

        $inputs = [];
        foreach ($data as $item) {
            if(is_array($item->value)) {
                $value = [];
                foreach ($item->value as $sub) {
                    $value[$sub->name] = e($sub->value);
                }
                $item->value = $value;
            } else {
                $inputs[$item->name] = e($item->value);
            }
        }

        $widget = $inputs['@id'];

        $code = $widgetHandler->generateCode($widget, $inputs);
        return XePresenter::makeApi([
            'code' => $code,
        ]);

    }

    /**
     * 주어진 위젯의 스킨 목록을 반환한다.
     *
     * @param Request       $request
     * @param WidgetHandler $widgetHandler
     * @param SkinHandler   $skinHandler
     *
     * @return void
     */
    public function skin(Request $request, WidgetHandler $widgetHandler, SkinHandler $skinHandler)
    {
        $this->validate($request, [
            'widget' => 'required'
        ]);

        $widget = $request->get('widget');

        $skins = $skinHandler->getList($widget);

        return apiRender('widget.skins', compact('widget', 'skins'));
    }

    /**
     * 주어진 위젯과 스킨에 대한 설정 폼을 반환한다.
     *
     * @param Request       $request
     * @param WidgetHandler $widgetHandler
     *
     * @param SkinHandler   $skinHandler
     *
     * @return View
     */
    public function setup(Request $request, WidgetHandler $widgetHandler, SkinHandler $skinHandler)
    {
        $this->validate($request, [
            'widget' => 'required',
        ]);

        $widget = $request->get('widget');
        $skin = $request->get('skin');

        // widget form
        $widgetForm = $widgetHandler->setup($widget);

        // skin form
        $skin = $skinHandler->get($skin);

        $skinForm = $skin->renderSetting();

        return apiRender('widget.setup', compact('widget', 'skin', 'widgetForm', 'skinForm'));
    }

    public function setupByCode(Request $request, WidgetParser $widgetParser, WidgetHandler $widgetHandler, SkinHandler $skinHandler)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $code = $request->get('code');

        $inputs = $widgetParser->parseCode($code);

        $widget = array_get($inputs, '@attributes.id');
        // widget form
        $widgetForm = $widgetHandler->setup($widget, $inputs);

        // skin form
        $skin = $skinHandler->get($skin);

        $skinForm = $skin->renderSetting();


        return apiRender('widget.setup-code', compact('widget', 'skin', 'widgetSelector', 'skinSelector', 'widgetForm', 'skinForm'));
    }

    /**
     * render
     *
     * @param WidgetHandler $widgetHandler
     *
     * @return mixed
     */
    public function render(WidgetHandler $widgetHandler)
    {
        $id = Input::get('widget');
        $args = Input::except('widget');

        $render = $widgetHandler->render($id, $args);

        return $render;
    }

}
