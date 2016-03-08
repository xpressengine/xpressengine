<?php
namespace Xpressengine\Widgets;

use Config;
use View;
use Xpressengine\Widget\AbstractWidget;

/**
 * SystemInfo.php
 *
 * PHP version 5
 *
 * @category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class SystemInfo extends AbstractWidget
{

    protected static $id = 'widget/xpressengine@systemInfo';

    /**
     * init
     *
     * @return mixed
     */
    protected function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * getCodeCreationForm
     *
     * @return mixed
     */
    public function getCodeCreationForm()
    {
        // TODO: Implement getCodeCreationForm() method.
    }

    /**
     * render
     *
     * @param array $args to render parameter array
     *
     * @return mixed
     */
    public function render(array $args)
    {

        $request = app('request');

        $viewData = [
            'serverSoftware' => $request->server("SERVER_SOFTWARE"),
            'phpVersion' => phpversion(),
            'debugMode' => $request->server("APP_DEBUG"),
            'cacheDriver' => config('cache.default'),
            'documentRoot' => $request->server("DOCUMENT_ROOT"),
            'maintenanceMode' => app()->isDownForMaintenance(),
            'timeZone' => Config::get('app.timezone')
        ];

        return View::make('widget.widgets.systemInfo.show', [
            'viewData' => $viewData,
        ]);
    }
}
