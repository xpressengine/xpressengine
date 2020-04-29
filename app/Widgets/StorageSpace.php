<?php
/**
 * StorageSpace.php
 *
 * PHP version 7
 *
 * @category    Widgets
 * @package     App\Widgets
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Widgets;

use Xpressengine\Widget\AbstractWidget;
use Config;
use XeStorage;

/**
 * StorageSpace
 *
 * @category    Widgets
 * @package     App\Widgets
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class StorageSpace extends AbstractWidget
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'widget/xpressengine@storageSpace';

    /**
     * Returns the title of the widget.
     *
     * @return string
     */
    public static function getTitle()
    {
        return '스토리지 위젯';
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->config;

        $limit = (int)array_get($args, 'limit');
        if ($limit < 1) {
            $limit = 5;
        }

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

        return $this->renderSkin(
            [
                'list' => array_filter($list, function ($item) {
                    return !empty($item['bytes']);
                }),
                'total' => $total
            ]
        );
    }

    /**
     * Show the setting form for the widget.
     *
     * @param array $args arguments
     * @return string|\Xpressengine\UIObject\AbstractUIObject
     * @throws \Exception
     */
    public function renderSetting(array $args = [])
    {
        return uio('form', [
            'fields' => [
                'limit' => [
                    '_type' => 'text',
                    'label' => '목록수',
                    'description' => xe_trans('xe::descStorageSpaceLimit')
                ]
            ],
            'value' => $args,
            'type' => 'fieldset'
        ]);
    }
}
