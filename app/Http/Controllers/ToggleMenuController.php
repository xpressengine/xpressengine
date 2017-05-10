<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use XeToggleMenu;
use Input;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\ToggleMenu\AbstractToggleMenu;

class ToggleMenuController extends Controller
{
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

        return apiRender('toggleMenu.get', ['items' => $items]);
    }

    public function postSetting(Request $request)
    {
        $this->validate($request, ['type' => 'required']);

        $type = $request->get('type');
        $instanceId = $request->get('instanceId');
        $activates = $request->get('items', []);

        XeToggleMenu::setActivates($type, $instanceId, $activates);

        if ($request->get('redirect') != null) {
            return redirect($request->get('redirect'));
        } else {
            return redirect()->route('manage.menu.list.menu');
        }
    }
}
