<?php
/**
 * WidgetBox.php
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
use Xpressengine\Widget\Presenters\HTMLPresenter;

/**
 * Class WidgetBox
 *
 * @category    UIObjects
 * @package     App\UIObjects\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class WidgetBox extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@widgetbox';

    /**
     * The name of view
     *
     * @var string
     */
    protected $view = 'uiobjects.widgetbox.show';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;

        $widgetbox = null;
        $id = array_get($args, 'id');

        if($id === null) {
            $widgetbox = array_get($args, 'widgetbox');
        }

        $handler = app('xe.widgetbox');

        if($widgetbox === null) {
            $widgetbox = $handler->find($id);
        }

        if($widgetbox) {
            $class = $widgetbox->getPresenter();
            $presenter = new $class($widgetbox->content, $widgetbox->options);
        } else {
            $presenter = new HTMLPresenter('');
        }

        $link = array_get($args, 'link');

        $this->template = view($this->view, compact('widgetbox', 'id', 'presenter', 'link'))->render();
        return parent::render();
    }
}
