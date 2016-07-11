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
use Xpressengine\Widget\WidgetHandler;

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
        $id = $request->get('widget');
        $inputs = $request->except('widget');

        $code = $widgetHandler->generateCode($id, $inputs);
        return XePresenter::makeApi([
            'code' => $code,
        ]);

    }

    /**
     * setup
     *
     * @param WidgetHandler $widgetHandler
     *
     * @return View
     */
    public function setup(Request $request, WidgetHandler $widgetHandler)
    {
        $this->validate($request, [
            'widget' => 'required'
        ]);

        $id = $request->get('widget');

        $form = $widgetHandler->setup($id);

        return XePresenter::makeApi([
             'result' => (string)$form,
             'data' => [],
             'XE_ASSET_LOAD' => [
                 'css' => \Xpressengine\Presenter\Html\Tags\CSSFile::getFileList(),
                 'js' => \Xpressengine\Presenter\Html\Tags\JSFile::getFileList(),
             ],
         ]);
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
