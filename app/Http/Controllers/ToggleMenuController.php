<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     LGPL-2.1 http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use XeToggleMenu;
use Input;
use XePresenter;

class ToggleMenuController extends Controller
{
    public function get()
    {
        $type = Input::get('type');
        $id = Input::get('id');

        if (strstr($type, '/')) {
            $pos = strrpos($type, '/');
            $instanceId = substr($type, $pos+1);
            $type = substr($type, 0, $pos);
        } else {
            $instanceId = null;
        }

        $data = [];
        foreach (XeToggleMenu::getItems($type, $instanceId, $id) as $item) {
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
