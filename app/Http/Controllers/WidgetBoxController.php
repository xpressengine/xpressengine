<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use XeDB;
use XePresenter;
use Xpressengine\Permission\Instance;
use Xpressengine\Permission\PermissionSupport;
use Xpressengine\Presenter\Html\FrontendHandler;
use Xpressengine\Support\Exceptions\AccessDeniedHttpException;
use Xpressengine\Widget\WidgetParser;
use Xpressengine\Widget\Exceptions\IDAlreadyExistsException;
use Xpressengine\Widget\Exceptions\NotFoundWidgetBoxException;
use Xpressengine\Widget\Models\WidgetBox;
use Xpressengine\Widget\WidgetBoxHandler;

class WidgetBoxController extends Controller
{

    use PermissionSupport;

    public function create(Request $request, WidgetBoxHandler $handler, FrontendHandler $frontend)
    {
        $id = $request->get('id');

        if (!$request->user()->isAdmin()) {
            throw new AccessDeniedHttpException();
        }

        $widgetbox = $handler->find($id);
        if($widgetbox) {
            throw new IDAlreadyExistsException();
        }

        $frontend->css('assets/vendor/bootstrap/css/bootstrap.min.css')->loadAsync();

        return api_render('widgetbox.create', compact('id'));
    }

    public function store(Request $request, WidgetBoxHandler $handler, SessionManager $session)
    {

        if (!$request->user()->isAdmin()) {
            throw new AccessDeniedHttpException();
        }

        $this->validate($request, [
            'id' => 'required',
            'title' => 'required'
        ]);

        $inputs = $request->only(['id','title']);

        $widgetbox = $handler->find($inputs['id']);
        if($widgetbox) {
            throw new IDAlreadyExistsException();
        }

        $widgetbox = $handler->create($inputs);

        $session->flash('alert', ['type' => 'success', 'message' => '위젯박스가 생성되었습니다.']);

        return XePresenter::makeApi(['type' => 'success', 'message' => '생성했습니다.']);

    }

    public function edit(Request $request, WidgetBoxHandler $handler, $id)
    {
        /** @var WidgetBox $widgetbox */
        $widgetbox = $handler->find($id);

        if ($widgetbox === null) {
            throw new NotFoundWidgetBoxException();
        }

        if (\Gate::denies('edit', new Instance('widgetbox.'.$id))) {
            throw new AccessDeniedHttpException();
        }

        app('xe.theme')->selectBlankTheme();


        $permission = null;
        if ($request->user()->isAdmin()) {
            $permission = array_merge($this->getPermArguments('widgetbox.'.$id, ['edit'])['edit'], ['mode' => null]);
        }
        return XePresenter::make('widgetbox.edit', compact('widgetbox', 'permission'));
    }

    public function update(Request $request, WidgetBoxHandler $handler, $id)
    {
        if (\Gate::denies('edit', new Instance('widgetbox.'.$id))) {
            throw new AccessDeniedHttpException();
        }

        $this->validate(
            $request,
            [
                'content' => 'required'
            ]
        );

        $data = [];
        $data['content'] = $request->originInput('content');

        if ($request->has('options')) {
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
     * @param string           $id
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function code(Request $request, WidgetBoxHandler $handler, $id)
    {
        if (\Gate::denies('edit', new Instance('widgetbox.'.$id))) {
            throw new AccessDeniedHttpException();
        }

        /** @var WidgetBox $widgetbox */
        $widgetbox = $handler->find($id);

        if ($widgetbox === null) {
            throw new NotFoundWidgetBoxException();
        }

        return XePresenter::makeApi(['code' => $widgetbox->content]);
    }

    /**
     * 주어진 위젯박스 code(content)를 파싱하여 반환한다.
     *
     * @param Request      $request
     * @param WidgetParser $parser
     * @param string       $id
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function preview(Request $request, WidgetParser $parser, $id)
    {
        if (\Gate::denies('edit', new Instance('widgetbox.'.$id))) {
            throw new AccessDeniedHttpException();
        }

        $this->validate(
            $request,
            [
                'code' => 'required'
            ]
        );

        // widgetbox code
        $code = $request->originInput('code');

        $content = $parser->parseXml($code);

        return XePresenter::makeApi(compact('content'));
    }

    public function storePermission(Request $request, WidgetBoxHandler $handler, $id)
    {
        if (\Gate::denies('edit', new Instance('widgetbox.'.$id))) {
            throw new AccessDeniedHttpException();
        }

        $this->permissionRegister($request, 'widgetbox.'.$id, ['edit']);
        return XePresenter::makeApi(['type' => 'success', 'message' => '권한을 저장했습니다.']);
    }
}
