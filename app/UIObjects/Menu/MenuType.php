<?php
/**
 * MenuType.php
 *
 * PHP version 7
 *
 * @category    UIObjects
 * @package     App\UIObjects\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Menu;

use Xpressengine\Menu\MenuEntity;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class MenuType
 *
 * @category    UIObjects
 * @package     App\UIObjects\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class MenuType extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@menuType';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;

        $menuType = $args['menuType'];
        $action = $args['action'];
        $param = $args['param'];

        $content = $menuType->{$action}($param);

        $this->template = view('uiobjects/menu/menuType', compact('content'))->render();
        $this->template = $content;
        return parent::render();
    }
}
