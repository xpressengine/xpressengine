<?php
namespace App\Http\Controllers;

use XeToggleMenu;
use Input;
use Presenter;

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

        return Presenter::makeApi($data);
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
