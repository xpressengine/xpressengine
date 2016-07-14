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
use Xpressengine\ToggleMenu\AbstractToggleMenu;

class ToggleMenuController extends Controller
{
    public function get()
    {
        $type = Input::get('type');
        $id = Input::get('id');
        $instanceId = Input::get('instanceId');

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

    public function getPage()
    {
        $type = Input::get('type');
        $id = Input::get('id');
        $instanceId = Input::get('instanceId');

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

    public function postSetting()
    {
        // check is manager

        $type = Input::get('type');
        $instanceId = Input::get('instanceId');
        $activates = Input::get('items', []);

        XeToggleMenu::setActivates($type, $instanceId, $activates);

        if (Input::get('redirect') != null) {
            return redirect(Input::get('redirect'));
        } else {
            return redirect()->route('manage.menu.list.menu');
        }
    }
}
