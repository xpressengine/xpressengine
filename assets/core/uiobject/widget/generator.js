$(function($) {
    $('.__xe_select_widget').change(function(){
        var widget = this.value;
        $('.widget-form').empty();
        var url = $('.widget-skins').data('url');
        if(widget) {
            XE.page(url+'?widget='+widget, '.widget-skins');
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

    // code 적용
    $('.__xe_setup_code').click(function(){

        var code = $('.__xe_widget_code').val();
        var url = $('.widget-inputs').data('url');

        XE.page(url, '.widget-inputs', {data : {code: code}});
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
