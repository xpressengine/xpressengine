<div class="widget-generator">

    {{-- select widget --}}
    <div class="widget-selector">
        {{ uio('formSelect', ['label'=>'위젯', 'class'=>'__xe_select_widget', 'name'=>'widget', 'options'=>$widgets] ) }}
    </div>
    <div class="widget-skins">
    </div>
    <div class="widget-form">
    </div>
    <hr>
    <button type="button" class="btn btn-default __xe_generate_code">코드생성</button>
    <hr>
    <div class="widget-code">
        {{ uio('formTextarea', ['class'=>'__xe_widget_code']) }}
    </div>

</div>

