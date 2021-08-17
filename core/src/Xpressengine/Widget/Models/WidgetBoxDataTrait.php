<?php

namespace Xpressengine\Widget\Models;

trait WidgetBoxDataTrait
{
    public function getData()
    {
        $widgetNames = [];
        $widgetList = app('xe.widget')->getAll();

        foreach ($widgetList as $id => $class) {
            $widgetNames[$id] = $class::getTitle();
        }

        $content =  $this->getContent();

        if ($this->getPresenter()::SUPPORT_CONTAINER) {
            foreach ($content as &$container) {
                if (array_key_exists('options', $container)) {
                    $container['options']['_time'] = time();
                }

                $this->combineWidgets($container['rows'], $widgetNames);
            }
        } else {
            $this->combineWidgets($content, $widgetNames);
        }

        return $content;
    }

    /**
     * combine widgets
     *
     * @param $content
     * @param array $widgetNames
     */
    private function combineWidgets(&$content, array $widgetNames)
    {
        foreach ($content as &$row) {
            if (array_key_exists('options', $row)) {
                $row['options']['_time'] = time();
            }

            foreach ($row['cols'] as &$col) {
                foreach ($col['widgets'] as &$widgetInfo) {
                    $skinId = $widgetInfo['@attributes']['skin-id'];
                    $class = app('xe.skin')->get($skinId);

                    $widgetInfo['widgetName'] = $widgetNames[$widgetInfo['@attributes']['id']];
                    $widgetInfo['skinName'] = $class->getTitle();

                    if (empty($widgetInfo['@attributes']['activate'])) {
                        $widgetInfo['@attributes']['activate'] = 'activate';
                    }
                }
            }
        }
    }
}
