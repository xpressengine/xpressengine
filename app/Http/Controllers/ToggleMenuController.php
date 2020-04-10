<?php
/**
 * ToggleMenuController.php
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

use XeToggleMenu;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\ToggleMenu\AbstractToggleMenu;

/**
 * Class ToggleMenuController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ToggleMenuController extends Controller
{
    /**
     * Provide the toggle menu items.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function get(Request $request)
    {
        $type = $request->get('type');
        $id = $request->get('id');
        $instanceId = $request->get('instanceId');

        $data = [];
        /** @var AbstractToggleMenu $item */
        foreach (XeToggleMenu::getItems($type, $instanceId, $id) as $item) {
            if ($item->allows() == false) {
                continue;
            }

            $data[] = [
                'text' => $item->getText(),
                'type' => $item->getType(),
                'action' => $item->getAction(),
                'script' => $item->getScript(),
                'icon' => $item->getIcon(),
            ];
        }

        return XePresenter::makeApi($data);
    }

    /**
     * Show the toggle menu items.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getPage(Request $request)
    {
        $type = $request->get('type');
        $id = $request->get('id');
        $instanceId = $request->get('instanceId');

        $items = [];
        /** @var AbstractToggleMenu $item */
        foreach (XeToggleMenu::getItems($type, $instanceId, $id) as $item) {
            if ($item->allows() == false) {
                continue;
            }

            $items[] = [
                'text' => $item->getText(),
                'type' => $item->getType(),
                'action' => $item->getAction(),
                'script' => $item->getScript(),
                'icon' => $item->getIcon(),
            ];

        }

        return api_render('toggleMenu.get', ['items' => $items]);
    }

    /**
     * Save the setting for toggle menu.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSetting(Request $request)
    {
        $this->validate($request, ['type' => 'required']);

        $type = $request->get('type');
        $instanceId = $request->get('instanceId');
        $activates = $request->get('items', []);

        if ($request->get('inherit')) {
            XeToggleMenu::setInherit($type, $instanceId);
        } else {
            XeToggleMenu::setActivates($type, $instanceId, $activates);
        }

        if ($request->get('redirect') != null) {
            return redirect($request->get('redirect'));
        } else {
            return redirect()->route('manage.menu.list.menu');
        }
    }
}
