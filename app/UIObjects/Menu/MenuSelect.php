<?php
/**
 * MenuSelect.php
 *
 * PHP version 7
 *
 * @category    UIObjects
 * @package     App\UIObjects\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Menu;

use App\UIObjects\Form\FormSelect;
use XeMenu;
use XeSite;

/**
 * Class MenuSelect
 *
 * @category    UIObjects
 * @package     App\UIObjects\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MenuSelect extends FormSelect
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@menuSelect';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
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
