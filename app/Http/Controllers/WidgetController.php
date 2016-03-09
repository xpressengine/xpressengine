<?php namespace App\Http\Controllers;

use App\Sections\WidgetSection;
use Input;
use View;
use Xpressengine\Module\ModuleHandler;
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
        $widgetSection = new WidgetSection;
        $widgetSectionView = $widgetSection->getSection('__xe_content');

        return XePresenter::make('widget.index', [
            'widgetSectionView' => $widgetSectionView
        ]);
    }

    public function generate(WidgetHandler $widgetHandler)
    {
        $id = Input::get('widget');
        $inputs = Input::except('widget');
        return $widgetHandler->getGeneratedCode($id, $inputs);

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

        $settingFormView = $widgetHandler->setUp($id);

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

        $render = $widgetHandler->create($id, $args);

        return $render;
    }

}
