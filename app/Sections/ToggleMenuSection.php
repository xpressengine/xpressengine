<?php
namespace App\Sections;

use XeToggleMenu;
use View;

class ToggleMenuSection
{
    public function setting($type, $instanceId = null)
    {
        $activated = XeToggleMenu::getActivated($type, $instanceId);
        $deactivated = XeToggleMenu::getDeactivated($type, $instanceId);
        $items = [];
        foreach ($activated as $key => $item) {
            $items[$key] = ['item' => $item, 'activated' => true];
        }
        foreach ($deactivated as $key => $item) {
            $items[$key] = ['item' => $item, 'activated' => false];
        }

        $typeIdable = str_replace(['/', '@'], '_', $type);

        return View::make('toggleMenu.setting', compact('items', 'type', 'instanceId', 'typeIdable'));
    }
}
