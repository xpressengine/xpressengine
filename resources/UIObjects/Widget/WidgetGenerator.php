<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\UIObjects\Widget;

use Xpressengine\UIObject\AbstractUIObject;

class WidgetGenerator extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@widgetGenerator';

    protected $view = 'uiobjects.widget.generator';

    public function render()
    {
        $args = $this->arguments;
        $prefix = array_get($args, 'prefixName', 'theme_');

        $handler = \app('xe.widget');

        $widgetList = $handler->getAll();

        $widgets = [];
        foreach ($widgetList as $id => $class) {
            $widgets[$id] = $class::getTitle();
        }

        if (!isset($args['selectedWidget'])) {
            reset($widgetList);
            $selectedWidgetId = key($widgetList);
        } else {
            $selectedWidgetId = array_get($args, 'selectedWidget');
        }

        // except skin setting
        $form = $handler->setup($selectedWidgetId);

        $this->loadFiles();

        $this->template = view($this->view, compact('widgets', 'selectedWidgetId', 'form'))->render();

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
        $frontend->js('assets/core/xe-ui-component/js/xe-page.js')->load();

        $frontend->html('widget.generator')->content(
            "<script>
                $(function($) {
                    var url = '".route('settings.widget.setup')."';
                    $('.__xe_select_widget').change(function(){
                        var widget = this.value;
                        XE.page(url+'?widget='+widget,'.widget-form');
                    });
                    
                    $('.__xe_generate_code').click(function(){
                        var widget = this.value;
                        var form = $('#widgetForm');
                        $.ajax({
                          type : form.attr('method'),
                          url : form.attr('action'),
                          cache : false,
                          data : form.serialize(),
                          dataType: 'json',
                          success : function (data) {
                            $('.__xe_widget_code').val(data.code);
                          },
                          error : function(data) {
                            XE.toast(data.type, data.message);
                          }
                        })
                    });
                });
            </script>"
        )->load();

    }
}
