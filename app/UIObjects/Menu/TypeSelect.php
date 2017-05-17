<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Menu;

use Xpressengine\UIObject\AbstractUIObject;

/**
 * TypeSelect
 *
 * @category    UIObjects
 * @package     App\UIObjects\Menu
 */
class TypeSelect extends AbstractUIObject
{
    /**
     * @var string uiobject id
     */
    protected static $id = 'uiobject/xpressengine@typeSelect';

    /**
     * @var string directLink menu type id
     */
    public static $defaultSelectedId = "xpressengine@directLink";

    /**
     * @var string uiobject view resource name
     */
    protected $view = 'uiobjects.menu.typeSelect';

    /**
     * render
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;

        $types = app('xe.menu')->getModuleHandler()->getAllModuleInfo();

        $selectedTypeId = array_get($args, 'selectedType', static::$defaultSelectedId);

        $this->template = view($this->view, compact('types', 'selectedTypeId'))->render();


        $this->loadFiles();

        return parent::render();
    }

    /**
     * loadFiles
     *
     * @return void
     */
    protected function loadFiles()
    {
        $frontend = app('xe.frontend');
        $frontend->css('assets/core/theme/theme-select.css')->load();
        $frontend->js('assets/core/common/js/form.js')->load();
    }
}
