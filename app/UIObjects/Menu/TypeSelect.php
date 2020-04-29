<?php
/**
 * TypeSelect.php
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

use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class TypeSelect
 *
 * @category    UIObjects
 * @package     App\UIObjects\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TypeSelect extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@typeSelect';

    /**
     * The menu type id
     *
     * @var string
     */
    public static $defaultSelectedId = "xpressengine@directLink";

    /**
     * The view name
     *
     * @var string
     */
    protected $view = 'uiobjects.menu.typeSelect';

    /**
     * Get the evaluated contents of the object.
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
     * Load assets
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
