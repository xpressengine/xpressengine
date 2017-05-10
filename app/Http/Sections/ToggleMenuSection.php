<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Sections;

use XeToggleMenu;
use View;

class ToggleMenuSection extends Section
{
    protected $type;
    protected $instanceId;

    public function __construct($type, $instanceId = null)
    {
        $this->type = $type;
        $this->instanceId = $instanceId;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $activated = XeToggleMenu::getActivated($this->type, $this->instanceId);
        $deactivated = XeToggleMenu::getDeactivated($this->type, $this->instanceId);
        $items = [];

        foreach ($activated as $key => $item) {
            $items[$key] = ['item' => $item, 'activated' => true];
        }
        foreach ($deactivated as $key => $item) {
            $items[$key] = ['item' => $item, 'activated' => false];
        }

        $typeIdable = str_replace(['/', '@'], '_', $this->type);

        return view('toggleMenu.setting', [
            'items' => $items,
            'type' => $this->type,
            'instanceId' => $this->instanceId,
            'typeIdable' => $typeIdable
        ]);
    }
}
