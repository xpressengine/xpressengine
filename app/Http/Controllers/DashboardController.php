<?php
/**
 * DashboardController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Xpressengine\Permission\Grant;
use Xpressengine\User\Rating;
use Xpressengine\Widget\WidgetBoxHandler;

/**
 * Class DashboardController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     *
     * @param WidgetBoxHandler $handler WidgetBoxHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index(WidgetBoxHandler $handler)
    {
        $widgetboxPrefix = 'dashboard-';
        $userId = auth()->id();

        $id = $widgetboxPrefix.$userId;

        $widgetbox = $handler->find($id);
        if ($widgetbox === null) {
            $dashboard = $handler->find('dashboard');
            $widgetbox = $handler->create([
                'id' => $id,
                'title' => 'Dashboard',
                'content' => $dashboard->content,
                'options' => $dashboard->options,
            ]);
        }

        if (!app('xe.permission')->get('widgetbox.' . $id)) {
            $grant = new Grant();
            $grant->set('edit', [
                Grant::RATING_TYPE => Rating::SUPER,
                Grant::GROUP_TYPE => [],
                Grant::USER_TYPE => [$userId],
                Grant::EXCEPT_TYPE => [],
                Grant::VGROUP_TYPE => []
            ]);
            app('xe.permission')->register('widgetbox.' . $id, $grant);
        }

        return \XePresenter::make('settings.dashboard', compact('widgetbox'));
    }

    /**
     * Redirect to dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        return redirect()->route('settings.dashboard');
    }
}
