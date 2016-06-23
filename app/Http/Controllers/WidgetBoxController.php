<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use XePresenter;

class WidgetBoxController extends Controller {

    public function edit(Request $request, $boxId)
    {

        app('xe.theme')->selectBlankTheme();

        //$widgetbox = WidgetBox::get($boxId);
        $widgetbox = [
            'id' => $boxId,
            'title' => '메인페이지',
            'content' => '',
        ];

        return XePresenter::make('widgetbox.edit', compact('widgetbox'));

    }

}