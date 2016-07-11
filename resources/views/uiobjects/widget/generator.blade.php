<div class="widget-generator">

    <form id="widgetForm" action="{{ route('settings.widget.generate') }}" method="post">
        {{ uio('formSelect', ['label'=>'위젯', 'class'=>'__xe_select_widget', 'name'=>'widget', 'options'=>$widgets, 'selected'] ) }}
        <div class="widget-form">
            {{ $form }}
        </div>
    </form>
    <hr>
    <button type="button" class="btn btn-default __xe_generate_code">코드생성</button>
    <hr>
    <div class="widget-code">
        {{ uio('formTextarea', ['class'=>'__xe_widget_code']) }}
    </div>

</div>

