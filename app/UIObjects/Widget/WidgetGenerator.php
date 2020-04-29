<?php
/**
 * WidgetGenerator.php
 *
 * PHP version 7
 *
 * @category    UIObjects
 * @package     App\UIObjects\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Widget;

use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class WidgetGenerator
 *
 * @category    UIObjects
 * @package     App\UIObjects\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class WidgetGenerator extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@widgetGenerator';

    /**
     * The name of view
     *
     * @var string
     */
    protected $view = 'uiobjects.widget.generator';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;

        $show_code = array_get($args, 'show_code', true);

        $handler = app('xe.widget');

        $widgetList = $handler->getAll();

        $widgets = [];
        $widgets[''] = '위젯을 선택하세요';
        foreach ($widgetList as $id => $class) {
            $widgets[$id] = $class::getTitle();
        }

        $this->loadFiles();

        $id = array_get($args, 'id', 'widget-generator-'.static::seq());

        $this->template = view($this->view, compact('widgets', 'id', 'show_code'))->render();

        return parent::render();
    }

    /**
     * Load assets.
     *
     * @return void
     */
    protected function loadFiles()
    {
        $frontend = app('xe.frontend');
        $frontend->js([
            'assets/core/xe-ui-component/js/xe-page.js',
            'assets/core/uiobject/widget/generator.js'
        ])->load();
    }
}
