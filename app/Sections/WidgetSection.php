<?php
namespace App\Sections;

use Comment;
use Presenter;
use View;
use Xpressengine\Widget\WidgetHandler;

class WidgetSection
{

    public function getSection($targetId)
    {
        /**
         * @var WidgetHandler @widgetHandler
         */
        $widgetHandler = app('xe.widget');
        $widgets = $widgetHandler->getAll();

        return View::make('widget.list', compact(['widgets', 'targetId']));
    }
}
