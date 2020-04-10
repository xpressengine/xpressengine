<?php
/**
 * HtmlMenuPrintWidget.php
 *
 * PHP version 7
 *
 * @category    Widgets
 * @package     App\Widgets
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Widgets;

use Config;
use View;
use Xpressengine\Widget\AbstractWidget;

/**
 * Class MenuPrint
 *
 * @category    Widgets
 * @package     App\Widgets
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MenuPrint extends AbstractWidget
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'widget/xpressengine@menuPrint';

    /**
     * Returns the title of the widget.
     *
     * @return string
     */
    public static function getTitle()
    {
        return 'Menu print';
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $menuId = $this->config['menu_id'];
        $config = $this->config;

        $menuTree = menu_list($menuId);

        return $this->renderSkin(compact('menuTree', 'config'));
    }

    /**
     * Show the setting form for the widget.
     *
     * @param array $args arguments
     * @return string|\Xpressengine\UIObject\AbstractUIObject
     * @throws \Exception
     */
    public function renderSetting(array $args = [])
    {
        $menuList = [];
        $menus = app('xe.menu')->menus()->get();
        $baseMenuId = '';
        foreach ($menus as $menu) {
            $menuList[] = [
                'value' => $menu->id,
                'text' => $menu->title,
            ];

            if ($menu->title == 'Main Menu') {
                $baseMenuId = $menu->id;
            }
        }

        // default
        if (isset($args['menu_id']) == false && $baseMenuId != '') {
            $args['menu_id'] = $baseMenuId;
        }
        if (isset($args['limit_depth']) == false) {
            $args['limit_depth'] = 2;
        }

        return uio('form', [
            'fields' => [
                'menu_id' => [
                    '_type' => 'select',
                    'label' => 'Menu',
                    'description' => 'Select a menu to print.',
                    'options' => $menuList,
                ],
                'limit_depth' => [
                    '_type' => 'text',
                    'label' => 'Menu depth',
                    'description' => 'If you input 0 then will print all menu without limits.'
                ],
            ],
            'value' => $args,
            'type' => 'fieldset'
        ]);
    }
}
