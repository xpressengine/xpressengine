<?php
/**
 * DownloadRank.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Widgets;

use XeStorage;
use Xpressengine\Widget\AbstractWidget;

class DownloadRank extends AbstractWidget
{

    protected static $id = 'widget/xpressengine@downloadRank';

    /**
     * 위젯의 이름을 반환한다.
     *
     * @return string
     */
    public static function getTitle()
    {
        return '다운로드 위젯';
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->config;
        $limit = isset($args['limit']) ? $args['limit'] : 5;

        $files = XeStorage::whereNull('origin_id')
            ->orderBy('download_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)->get();

        return $this->renderSkin([
            'files' => $files,
        ]);
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
                    'description' => '다운로드수가 많은 파일 순으로 출력됩니다. 출력할 파일의 목록수를 지정하십시오.'
                ]
            ],
            'value' => $args,
            'type' => 'fieldset'
        ]);
    }
}
