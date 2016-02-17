<?php
namespace Xpressengine\Widgets;

use Xpressengine\Widget\AbstractWidget;
use Config;
use XeStorage;
use View;

/**
 * Class StorageSpace
 *
 * @category    Widgets
 * @package     Xpressengine\Widgets
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class StorageSpace extends AbstractWidget
{
    protected static $id = 'widget/xpressengine@storageSpace';

    protected function init()
    {
        //
    }

    /**
     * render
     *
     * @param array $args
     *
     * @return string
     */
    public function render(array $args)
    {
        $limit = isset($args['limit']) ? $args['limit'] : 5;

        $disks = Config::get('filesystems.disks');
        $list = [];
        $total = [];
        foreach ($disks as $disk => $setting) {
            $scope = function ($query) use ($disk) {
                $query->where('disk', $disk);
            };
            $bytes = XeStorage::bytesByMime($scope);
            $counts = XeStorage::countByMime($scope);
            arsort($bytes);

            $list[$disk] = [
                'bytes' => [],
                'count' => [],
                'total' => [
                    'bytes' => array_sum($bytes),
                    'count' => array_sum($counts),
                ]
            ];

            $bytes = array_slice($bytes, 0, $limit);
            $counts = array_intersect_key($counts, $bytes);

            $list[$disk] = array_merge($list[$disk], [
                'bytes' => $bytes,
                'count' => $counts,
            ]);
        }

        return View::make('widget.widgets.storageSpace.show', [
            'list' => array_filter($list, function ($item) {
                return !empty($item['bytes']);
            }),
            'total' => $total
        ])->render();
    }

    /**
     * getCodeCreationForm
     *
     * @return mixed
     */
    public function getCodeCreationForm()
    {
        //
    }
}
