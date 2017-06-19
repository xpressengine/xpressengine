<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
namespace App\UIObjects\Menu;

use App\UIObjects\Form\FormSelect;
use XeMenu;
use XeSite;

class MenuSelect extends FormSelect
{
    protected static $id = 'uiobject/xpressengine@menuSelect';

    public function render()
    {
        $menus = XeMenu::menus()->fetchBySiteKey(XeSite::getCurrentSiteKey());

        $options = [];
        foreach ($menus as $menu) {
            $options[$menu->id] = $menu->title;
        }
        $this->arguments['options'] = $options;

        return parent::render();
    }
}
