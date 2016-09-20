<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Widget;

use Xpressengine\UIObject\AbstractUIObject;

class WidgetGenerator extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@widgetGenerator';

    protected $view = 'uiobjects.widget.generator';

    public function render()
    {
        $args = $this->arguments;

        $show_code = array_get($args, 'show_code', true);

        $handler = app('xe.widget');

        $widgetList = $handler->getAll();

        $widgets = [];
        $widgets[''] = '위젯을 선택하세요';
        foreach ($widgetList as $id => $class) {
            $widgets[$id] = $class::getTitle();
        }

        //if (!isset($args['selectedWidget'])) {
        //    reset($widgetList);
        //    $selectedWidgetId = key($widgetList);
        //} else {
        //    $selectedWidgetId = array_get($args, 'selectedWidget');
        //}

        // except skin setting
        // $form = $handler->setup($selectedWidgetId);

        $this->loadFiles();

        $id = array_get($args, 'id', 'widget-generator-'.static::seq());

        $this->template = view($this->view, compact('widgets', 'id', 'show_code'))->render();

        return parent::render();
    }

    /**
     * loadFiles
     *
     * @return void
     */
    protected function loadFiles()
    {
        $frontend = \app('xe.frontend');
        $frontend->js(
            [
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/uiobject/widget/generator.js'
            ]
        )->load();
    }
}
