<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Widget;

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
        $widgets[''] = '위젯을 선택하세요';
        foreach ($widgetList as $id => $class) {
            $widgets[$id] = $class::getTitle();
        }

        //if (!isset($args['selectedWidget'])) {
        //    reset($widgetList);
        //    $selectedWidgetId = key($widgetList);
        //} else {
        //    $selectedWidgetId = array_get($args, 'selectedWidget');
        //}

        // except skin setting
        // $form = $handler->setup($selectedWidgetId);

        $this->loadFiles();

        $this->template = view($this->view, compact('widgets'))->render();

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
                    var url = { 
                        'skin': '".route('settings.widget.skin')."'
                    };
                    $('.__xe_select_widget').change(function(){
                        var widget = this.value;
                        $('.widget-form').empty();
                        if(widget) {
                            XE.page(url.skin+'?widget='+widget, '.widget-skins');
                        } else {
                            $('.widget-skins').empty();
                        }
                    });
                    
                    // skin 선택시
                    $('.widget-skins').on('change', '.__xe_select_widgetskin', function(){
                        var widget = this.value;
                        if(widget) {
                            var url = $(this).find('option:selected').data('url');
                            XE.page(url,'.widget-form');
                        }
                    });
                    
                    // code 생성
                    $('.__xe_generate_code').click(function(){
                        var form = $('#widgetForm');
                        var data = $('#widgetForm').serializeArray();
                        data.push({'name':'skin', 'value': $('#skinForm').serializeArray()});
                        
                        $.ajax({
                          type : form.attr('method'),
                          url : form.attr('action'),
                          cache : false,
                          data : JSON.stringify(data),
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
