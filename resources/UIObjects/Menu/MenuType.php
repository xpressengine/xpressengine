<?php

namespace Xpressengine\UIObjects\Menu;

use PhpQuery\PhpQuery;
use Xpressengine\Menu\MenuEntity;
use ReflectionClass;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class Module
 *
 * @category    UIObjects
 * @package     Xpressengine\UIObjects\Menu
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
        // TODO: Implement boot() method.
    }

    /**
     * getSettingsURI
     *
     * @return void
     */
    public static function getSettingsURI()
    {
    }
}
