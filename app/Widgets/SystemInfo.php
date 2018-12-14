<?php
/**
 * SystemInfo.php
 *
 * PHP version 7
 *
 * @category    Widgets
 * @package     App\Widgets
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Widgets;

use Config;
use View;
use Xpressengine\Widget\AbstractWidget;

/**
 * Class SystemInfo
 *
 * @category    Widgets
 * @package     App\Widgets
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class SystemInfo extends AbstractWidget
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'widget/xpressengine@systemInfo';

    /**
     * Returns the title of the widget.
     *
     * @return string
     */
    public static function getTitle()
    {
        return '시스템 정보 위젯';
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $request = app('request');

        $viewData = [
            'serverSoftware' => $request->server("SERVER_SOFTWARE"),
            'phpVersion' => phpversion(),
            'debugMode' => config('app.debug') ? 'Yes' : 'No',
            'cacheDriver' => config('cache.default'),
            'documentRoot' => $request->server("DOCUMENT_ROOT"),
            'maintenanceMode' => app()->isDownForMaintenance(),
            'timeZone' => Config::get('app.timezone')
        ];

        return $this->renderSkin(
            [
                'viewData' => $viewData,
            ]
        );
    }
}
