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
use Xpressengine\Widget\WidgetParser;
use Xpressengine\WidgetBox\Exceptions\NotFoundWidgetBoxException;
use Xpressengine\WidgetBox\Models\WidgetBox;
use Xpressengine\WidgetBox\WidgetBoxHandler;

class WidgetBoxController extends Controller {

    public function edit(Request $request, WidgetBoxHandler $handler, $id)
    {
        app('xe.theme')->selectBlankTheme();

        /** @var WidgetBox $widgetbox */
        $widgetbox = $handler->find($id);

        if($widgetbox === null) {
            throw new NotFoundWidgetBoxException();
        }

        return XePresenter::make('widgetbox.edit', compact('widgetbox'));
    }

    public function update(Request $request, WidgetBoxHandler $handler, $id)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);

        $data = [];
        $data['content'] = $request->originInput('content');

        if($request->has('options')){
            $data['options'] = $request->get('options');
        }
        XeDB::beginTransaction();
        try {
            $handler->update($id, $data);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return XePresenter::makeApi(['type' => 'success', 'message' => '위젯박스를 저장했습니다.']);
    }

    /**
     * 주어진 id의 widgetbox의 code(content)를 반환한다.
     *
     * @param Request          $request
     * @param WidgetBoxHandler $handler
     * @param                  $id
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function code(Request $request, WidgetBoxHandler $handler, $id)
    {
        /** @var WidgetBox $widgetbox */
        $widgetbox = $handler->find($id);

        if($widgetbox === null) {
            throw new NotFoundWidgetBoxException();
        }

        return XePresenter::makeApi(['code' => $widgetbox->content]);
    }

    /**
     * 주어진 위젯박스 code(content)를 파싱하여 반환한다.
     *
     * @param Request      $request
     * @param WidgetParser $parser
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function preview(Request $request, WidgetParser $parser)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        // widgetbox code
        $code = $request->originInput('code');

        $content = $parser->parseXml($code);

        return XePresenter::makeApi(compact('content'));
    }

}
