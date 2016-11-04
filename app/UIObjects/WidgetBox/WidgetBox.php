<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\WidgetBox;

use Xpressengine\UIObject\AbstractUIObject;

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
        $parser = app('xe.widget.parser');

        if($widgetbox === null) {
            $widgetbox = $handler->find($id);
        }

        $content = null;
        if($widgetbox) {
            $content = $widgetbox->content;
            $this->loadFiles();
        }

        $link = array_get($args, 'link');

        $this->template = view($this->view, compact('widgetbox', 'id', 'content', 'link'))->render();
        return parent::render();
    }

    /**
     * loadFiles
     *
     * @return void
     */
    protected function loadFiles()
    {
        $frontend = \app('xe.frontend');
        /*$frontend->js(
            [
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/uiobject/widget/generator.js'
            ]
        )->load();*/

        $frontend->html('widgetbox.preview')->content("
        <script>
        function previewWidgetBox(id, html) {
            $('#widgetbox-'+id).find('.widgetbox-content').html(html);
        }
        </script>
        ")->load();
    }
}
