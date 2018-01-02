<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Xpressengine\Widget\WidgetBoxHandler;

class DashboardController extends Controller
{

    public function index(WidgetBoxHandler $handler)
    {
        $widgetboxPrefix = 'dashboard-';
        $userId = auth()->id();

        $id = $widgetboxPrefix.$userId;

        $widgetbox = $handler->find($id);
        if($widgetbox === null) {
            $dashboard = $handler->find('dashboard');
            $widgetbox = $handler->create(['id'=>$id, 'title'=>'Dashboard', 'content'=> $dashboard->content]);
        }

        \XeFrontend::title('XpressEngine3 Settings');

        return \XePresenter::make('settings.dashboard', compact('widgetbox'));
    }
}
