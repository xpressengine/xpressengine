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

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $data = [];
        $data['id'] = $request->get('id');
        $data['content'] = $request->get('content', '');

        if($request->has('options')){
            $data['options'] = $request->get('options', []);
        }

        XeDB::beginTransaction();
        try {
            $handler = app('xe.widgetbox');
            $handler->create($data);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return XePresenter::makeApi();
    }

    public function update(Request $request, $boxId)
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
            app('xe.widgetbox')->update($boxId, $data);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();
    }

}
