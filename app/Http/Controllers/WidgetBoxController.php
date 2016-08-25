<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use XeDB;
use XePresenter;
use Xpressengine\WidgetBox\Exceptions\NotFoundWidgetBoxException;
use Xpressengine\WidgetBox\WidgetBoxHandler;

class WidgetBoxController extends Controller {

    public function edit(Request $request, WidgetBoxHandler $handler, $boxId)
    {

        app('xe.theme')->selectBlankTheme();

        $widgetbox = $handler->find($boxId);

        if($widgetbox === null) {
            throw new NotFoundWidgetBoxException();
        }

        return XePresenter::make('widgetbox.edit', compact('widgetbox'));
    }

    public function update(Request $request, WidgetBoxHandler $handler, $boxId)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);

        $data = [];
        $data['content'] = $request->get('content');
        if($request->has('options')){
            $data['options'] = $request->get('options');
        }
        XeDB::beginTransaction();
        try {
            $handler->update($boxId, $data);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return XePresenter::makeApi(['type' => 'success', 'message' => '위젯박스를 저장했습니다.']);

    }



}
