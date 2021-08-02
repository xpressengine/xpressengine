<?php

namespace Xpressengine\Widget\Models;

use Schema;
use Illuminate\Support\Arr;

class WidgetBoxHistoryObserver
{
    const WRITTEN_FIELDS = [
        WidgetBoxHistory::CONTENT,
        WidgetBoxHistory::OPTIONS
    ];

    public function updating(WidgetBox $widgetBox)
    {
        if (Schema::hasTable(WidgetBoxHistory::TABLE)) {
            if ($this->isUpdated($widgetBox)) {
                WidgetBoxHistory::create($this->getStoredData($widgetBox));
            }
        }
    }

    public function deleted(WidgetBox $widgetBox)
    {
        if (Schema::hasTable(WidgetBoxHistory::TABLE)) {
            WidgetBoxHistory::whereWidgetbox($widgetBox)->delete();
        }
    }

    private function isUpdated(WidgetBox $widgetBox)
    {
        $isUpdated = false;

        foreach (self::WRITTEN_FIELDS as $field) {
            $updatedValue = json_encode($widgetBox->getAttribute($field));

            if ($widgetBox->getOriginal($field) !== $updatedValue) {
                $isUpdated = true;
                break;
            }
        }

        return $isUpdated;
    }

    private function getStoredData(WidgetBox $widgetBox)
    {
        $writtenHistoryData = $widgetBox->getOriginal();

        $writtenHistoryData[WidgetBoxHistory::WIDGETBOX_ID] = Arr::get($writtenHistoryData, 'id');
        $writtenHistoryData[WidgetBoxHistory::CONTENT] = json_decode(Arr::get($writtenHistoryData, 'content'));
        $writtenHistoryData[WidgetBoxHistory::OPTIONS] = json_decode(Arr::get($writtenHistoryData, 'options'));

        if (array_key_exists('id', $writtenHistoryData)) {
            unset($writtenHistoryData["id"]);
        }

        return $writtenHistoryData;
    }
}
