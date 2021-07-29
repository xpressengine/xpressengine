<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use XePresenter;
use Xpressengine\Permission\Instance;
use Xpressengine\Support\Exceptions\AccessDeniedHttpException;
use Xpressengine\Widget\Exceptions\NotFoundWidgetBoxException;
use Xpressengine\Widget\Exceptions\NotFoundWidgetBoxHistoryException;
use Xpressengine\Widget\Models\WidgetBoxHistory;
use Xpressengine\Widget\WidgetBoxHandler;

class WidgetBoxHistoryController extends Controller
{
    public function index(WidgetBoxHandler $widgetBoxHandler, $widgetboxId)
    {
        $widgetbox = $widgetBoxHandler->find($widgetboxId);

        if ($widgetbox === null) {
            throw new NotFoundWidgetBoxException();
        }

        if (\Gate::denies('edit', new Instance('widgetbox.'.$widgetboxId))) {
            throw new AccessDeniedHttpException();
        }

        /** @var Collection $histories */
        $histories = WidgetBoxHistory::whereWidgetbox($widgetbox)->orderBy(WidgetBoxHistory::ID, 'desc')->get();
        $histories->each(function (WidgetBoxHistory $history) {
            $history->addHidden([
                WidgetBoxHistory::WIDGETBOX_ID,
                WidgetBoxHistory::SITE_KEY,
                WidgetBoxHistory::CONTENT,
                WidgetBoxHistory::OPTIONS
            ]);
        });

        return XePresenter::makeApi($histories->toArray());
    }

    public function code($historyId)
    {
        /** @var WidgetBoxHistory $widgetBoxHistory */
        $widgetBoxHistory = WidgetBoxHistory::findOrFail($historyId);

        if ($widgetBoxHistory === null) {
            throw new NotFoundWidgetBoxHistoryException();
        }

        return XePresenter::makeApi([
            'presenter' => $widgetBoxHistory->getPresenter(),
            'data' => $widgetBoxHistory->getData(),
            'options' => $widgetBoxHistory->getOptions(),
        ]);
    }
}