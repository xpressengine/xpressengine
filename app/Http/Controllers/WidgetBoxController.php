<?php
/**
 * WidgetBoxController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Xpressengine\Http\Request;
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

/**
 * Class WidgetBoxController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class WidgetBoxController extends Controller
{
    use PermissionSupport;

    /**
     * Show the create form for the new widget box.
     *
     * @param Request          $request  request
     * @param WidgetBoxHandler $handler  WidgetBoxHandler instance
     * @param FrontendHandler  $frontend FrontendHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
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

    /**
     * Store the new widget box.
     *
     * @param Request          $request  request
     * @param WidgetBoxHandler $handler  WidgetBoxHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function store(Request $request, WidgetBoxHandler $handler)
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

        $handler->create($inputs);

        return XePresenter::makeApi(['type' => 'success', 'message' => xe_trans('xe::wasCreated')]);
    }

    /**
     * Show editable view for the widget box.
     *
     * @param Request          $request  request
     * @param WidgetBoxHandler $handler  WidgetBoxHandler instance
     * @param string           $id       identifier
     * @return \Xpressengine\Presenter\Presentable
     */
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

        return XePresenter::make('widgetbox.edit', [
            'widgetbox' => $widgetbox,
            'permission' => $request->user()->isAdmin() ?
                array_merge($this->getPermArguments('widgetbox.'.$id, ['edit'])['edit'], ['mode' => null]) :
                null,
            'presenters' => $handler->getPresenters(),
        ]);
    }

    /**
     * Update contents of the widget box.
     *
     * @param Request          $request request
     * @param WidgetBoxHandler $handler WidgetBoxHandler instance
     * @param string           $id      identifier
     * @return \Xpressengine\Presenter\Presentable
     * @throws \Exception
     */
    public function update(Request $request, WidgetBoxHandler $handler, $id)
    {
        if (\Gate::denies('edit', new Instance('widgetbox.'.$id))) {
            throw new AccessDeniedHttpException();
        }

        $this->validate($request, ['data' => 'required', 'presenter' => 'required']);
        XeDB::beginTransaction();
        try {
            $handler->update($id, [
                'content' => json_dec($request->originInput('data'), true),
                'options' => array_merge($request->get('options', []), ['presenter' => $request->get('presenter')]),
            ]);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return XePresenter::makeApi(['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * Get the widget box information by given id
     *
     * @param WidgetBoxHandler $handler WidgetBoxHandler instance
     * @param string           $id      identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function code(WidgetBoxHandler $handler, $id)
    {
        if (\Gate::denies('edit', new Instance('widgetbox.'.$id))) {
            throw new AccessDeniedHttpException();
        }

        /** @var WidgetBox $widgetbox */
        $widgetbox = $handler->find($id);

        if ($widgetbox === null) {
            throw new NotFoundWidgetBoxException();
        }

        return XePresenter::makeApi([
            'presenter' => $widgetbox->getPresenter(),
            'data' => $widgetbox->getData(),
            'options' => $widgetbox->getOptions(),
            'supportContainer' => $widgetbox->isSupportContainer(),
        ]);
    }

    /**
     * Preview the widget box by given id
     *
     * @param Request      $request request
     * @param WidgetParser $parser  WidgetParser instance
     * @param string       $id      identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function preview(Request $request, WidgetParser $parser, $id)
    {
        if (\Gate::denies('edit', new Instance('widgetbox.'.$id))) {
            throw new AccessDeniedHttpException();
        }

        $this->validate($request, ['data' => 'required', 'presenter' => 'required']);
        $class = $request->get('presenter');
        $presenter = new $class(json_dec($request->originInput('data'), true), $request->get('options', []));

        $content = $parser->parseXml($presenter->render());

        return XePresenter::makeApi(compact('content'));
    }

    /**
     * Save the permission information for the widget box.
     *
     * @param Request $request request
     * @param string  $id      identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function storePermission(Request $request, $id)
    {
        if (\Gate::denies('edit', new Instance('widgetbox.'.$id))) {
            throw new AccessDeniedHttpException();
        }

        $this->permissionRegister($request, 'widgetbox.'.$id, ['edit']);

        return XePresenter::makeApi(['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }
}
