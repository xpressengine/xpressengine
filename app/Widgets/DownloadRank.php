<?php
/**
 * DownloadRank.php
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

use XeStorage;
use Xpressengine\Widget\AbstractWidget;

/**
 * Class DownloadRank
 *
 * @category    Widgets
 * @package     App\Widgets
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DownloadRank extends AbstractWidget
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'widget/xpressengine@downloadRank';

    /**
     * Returns the title of the widget.
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
                    'description' => xe_trans('xe::descDownloadRankLimit')
                ]
            ],
            'value' => $args,
            'type' => 'fieldset'
        ]);
    }
}
