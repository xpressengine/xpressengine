<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Menu;

use Xpressengine\Menu\MenuEntity;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class Module
 *
 * @category    UIObjects
 * @package     App\UIObjects\Menu
 */
class MenuType extends AbstractUIObject
{
    /**
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@menuType';

    /**
     * render
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
