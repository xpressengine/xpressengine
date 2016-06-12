<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Sections;

use Comment;
use Presenter;
use View;
use Xpressengine\Widget\WidgetHandler;

class WidgetSection extends Section
{
    protected $targetId;

    public function __construct($targetId)
    {
        $this->targetId = $targetId;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        /**
         * @var WidgetHandler @widgetHandler
         */
        $widgetHandler = app('xe.widget');
        $widgets = $widgetHandler->getAll();

        return View::make('widget.list', [
            'widgets' => $widgets,
            'targetId' => $this->targetId
        ]);
    }
}
