<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use App\Http\Sections\WidgetSection;
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

    public function generate(WidgetHandler $widgetHandler)
    {
        $id = Input::get('widget');
        $inputs = Input::except('widget');
        return $widgetHandler->generateCode($id, $inputs);

    }

    /**
     * setup
     *
     * @param WidgetHandler $widgetHandler
     *
     * @return View
     */
    public function setup(WidgetHandler $widgetHandler)
    {
        $id = Input::get('widget');

        $settingFormView = $widgetHandler->setup($id);

        return $settingFormView->render();
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
