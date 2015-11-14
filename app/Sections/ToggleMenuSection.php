<?php
namespace App\Sections;

use ToggleMenu;
use View;

class ToggleMenuSection
{
    public function setting($type, $instanceId = null)
    {
        $activated = ToggleMenu::getActivated($type, $instanceId);
        $deactivated = ToggleMenu::getDeactivated($type, $instanceId);
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
