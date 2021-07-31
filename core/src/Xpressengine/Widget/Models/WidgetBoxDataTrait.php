<?php

namespace Xpressengine\Widget\Models;

trait WidgetBoxDataTrait
{
    /**
     * get widget box's data
     *
     * @return array
     */
    public function getData()
    {
        $widgetNames = [];
        $widgetList = app('xe.widget')->getAll();

        foreach ($widgetList as $id => $class) {
            $widgetNames[$id] = $class::getTitle();
        }

        $content = $this->getAttribute("content");
        $this->getContainerData($content, $widgetNames);

        return $content;
    }

    private function getContainerData(&$content, array $widgetNames)
    {
        foreach ($content as &$container) {
            $this->getGridData($container, $widgetNames);
        }
    }

    private function getGridData(&$content, array $widgetNames)
    {
        foreach ($content as &$row) {
            foreach ($row as &$col) {
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