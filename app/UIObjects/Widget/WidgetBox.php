<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Widget;

use Xpressengine\UIObject\AbstractUIObject;
use Xpressengine\Widget\Presenters\HTMLPresenter;

class WidgetBox extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@widgetbox';

    protected $view = 'uiobjects.widgetbox.show';

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
