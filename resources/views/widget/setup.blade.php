{{-- select widget --}}
<div class="widget-selector">
    {{ uio('formSelect',
        ['label'=>xe_trans('xe::widget'), 'class'=>'__xe_select_widget', 'name'=>'widget', 'options'=>$widgets, 'selected'=>isset($widget)?$widget:null] )
    }}
</div>

{{-- select skin --}}

<div class="widget-skins" data-url="{{route('settings.widget.skin')}}" @if(isset($code)) data-code="{{ json_enc($code) }}" @endif>
    @if(isset($skins))
    @include('widget.skins', ['setup' => true])
    @endif
</div>

{{-- form fields --}}
<div class="widget-form">
    @if(isset($widgetForm) && $widgetForm !== null)
    @include('widget.form')
    @endif
</div>

<script>
$(function () {
    var _$selectWidget = $('.__xe_select_widget');

    _$selectWidget.ready(function () {
        _hideDirectStore();
    });
    _$selectWidget.on('change', function(e) {
        _hideDirectStore();
    });

    function _hideDirectStore() {
        if(_$selectWidget.val()) {
            $('.xe-panel--direct-store').hide();
        } else {
            $('.xe-panel--direct-store').show();
        }
    }
})
</script>
