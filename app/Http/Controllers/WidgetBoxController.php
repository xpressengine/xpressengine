<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
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

    public function update(Request $request, WidgetBoxHandler $handler, $id)
    {
        if (\Gate::denies('edit', new Instance('widgetbox.'.$id))) {
            throw new AccessDeniedHttpException();
        }

        $inputs = $this->validate($request, ['data' => 'required', 'presenter' => 'required']);
        XeDB::beginTransaction();
        try {
            $handler->update($id, [
                'content' => json_dec($inputs['data'], true),
                'options' => array_merge($request->get('options', []), ['presenter' => $inputs['presenter']]),
            ]);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return XePresenter::makeApi(['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * 주어진 id의 widgetbox의 code(content)를 반환한다.
     *
     * @param WidgetBoxHandler $handler
     * @param string           $id
     *
     * @return \Xpressengine\Presenter\RendererInterface
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

        if ($widgetbox->content) {
            $data = array_merge(
                ['presenter' => $widgetbox->getPresenter()],
                ['data' => $widgetbox->content]
            );
        } else {
            $data = array_merge(
                ['presenter' => \Xpressengine\Widget\Presenters\XEUIPresenter::class],
                ['data' => $this->extract($widgetbox->getOriginal('content'))->all()]
            );
        }

        return XePresenter::makeApi(array_merge($data, ['options' => $widgetbox->options]));

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

        $inputs = $this->validate($request, ['data' => 'required', 'presenter' => 'required']);
        $class = $inputs['presenter'];
        $presenter = new $class(json_dec($inputs['data'], true), $request->get('options', []));

        $content = $parser->parseXml($presenter->render());

        return XePresenter::makeApi(compact('content'));
    }

    public function storePermission(Request $request, $id)
    {
        if (\Gate::denies('edit', new Instance('widgetbox.'.$id))) {
            throw new AccessDeniedHttpException();
        }

        $this->permissionRegister($request, 'widgetbox.'.$id, ['edit']);
        return XePresenter::makeApi(['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * @param string $code
     * @return \Illuminate\Support\Collection
     * @deprecated since beta.27
     */
    private function extract($code)
    {
        $doc = new Crawler($code);

        $rows = $doc->children()->first()->children();

        return $this->row2data($rows);
    }

    /**
     * @param Crawler $nodes
     * @return \Illuminate\Support\Collection
     * @deprecated since beta.27
     */
    private function row2data(Crawler $nodes)
    {
        $data = $nodes->each(function (Crawler $node) {
            $classNames = collect(explode(' ', $node->attr('class')));
            if ($classNames->contains('xe-row') && !$classNames->contains('widgetarea-row')) {
                return $this->col2data($node->children());
            }

            return null;
        });

        return collect($data)->filter();
    }

    /**
     * @param Crawler $nodes
     * @return \Illuminate\Support\Collection
     * @deprecated since beta.27
     */
    private function col2data(Crawler $nodes)
    {
        $data = $nodes->each(function (Crawler $node) {
            $classNames = collect(explode(' ', $node->attr('class')));
            if ($classNames->filter([$this, 'isColumn'])->count() < 1) {
                return null;
            }
            $grid = $classNames->reduce(function ($carry, $name) {
                if (!$this->isColumn($name)) {
                    return null;
                }

                list($m, $s) = explode('-', substr($name, strlen('xe-col-')));
                $carry[$m] = (int)$s;

                return $carry;
            }, []);

            $rows = $this->row2data($node->children());
            $widgets = $this->widget2data($node->children());

            return ['grid' => array_filter($grid), 'rows' => $rows, 'widgets' => $widgets];
        });

        return collect($data)->filter();
    }

    /**
     * @param Crawler $nodes
     * @return \Illuminate\Support\Collection
     * @deprecated since beta.27
     */
    private function widget2data(Crawler $nodes)
    {
        $data = $nodes->each(function (Crawler $node) {
            $cssClasses = collect(explode(' ', $node->attr('class')));
            if ($cssClasses->filter([$this, 'isWidget'])->count() < 1) {
                return null;
            }

            $data = $node->filter('xewidget')->each(function (Crawler $widget) {
                $dom = $widget->getNode(0);
                return $this->getWidgetParser()->parseCode($dom->ownerDocument->saveHTML($dom));
            });

            return $data;
        });

        return collect($data)->filter()->flatten(1);
    }

    /**
     * @return WidgetParser
     * @deprecated since beta.27
     */
    private function getWidgetParser()
    {
        return app('xe.widget.parser');
    }

    /**
     * @param string $className
     * @return bool
     * @deprecated since beta.27
     */
    public function isColumn($className)
    {
        return starts_with($className, 'xe-col-');
    }

    /**
     * @param string $className
     * @return bool
     * @deprecated since beta.27
     */
    public function isWidget($className)
    {
        return $className === 'widgetarea-row';
    }
}
