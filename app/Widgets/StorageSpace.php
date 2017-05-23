<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Widgets;

use Xpressengine\Widget\AbstractWidget;
use Config;
use XeStorage;
use View;

/**
 * Class StorageSpace
 *
 * @category    Widgets
 * @package     Xpressengine\Widgets
 */
class StorageSpace extends AbstractWidget
{
    protected static $id = 'widget/xpressengine@storageSpace';

    /**
     * 위젯의 이름을 반환한다.
     *
     * @return string
     */
    public static function getTitle()
    {
        return '스토리지 위젯';
    }

    /**
     * render
     *
     * @return string
     * @internal param array $args
     *
     */
    public function render()
    {
        $args = $this->config;
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
     * getCodeCreationForm
     *
     * @param array $args
     *
     * @return mixed
     */
    public function renderSetting(array $args = [])
    {
        return uio('form', [
            'fields' => [
                'limit' => [
                    '_type' => 'text',
                    'label' => '목록수',
                    'description' => '파일수가 많은 파일형식(확장자) 순으로 출력됩니다. 출력할 파일형식의 목록수를 지정하십시오.'
                ]
            ],
            'value' => $args,
            'type' => 'fieldset'
        ]);
    }

}
