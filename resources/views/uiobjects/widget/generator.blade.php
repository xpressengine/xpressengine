<div class="widget-generator" id="{{ $id }}">
    <div class="widget-inputs" data-url="{{route('settings.widget.setup')}}">

        @include('widget.setup')

    </div>

    <hr>
    <button type="button" class="btn btn-default __xe_generate_code">코드생성</button>
    <button type="button" class="btn btn-default __xe_setup_code">코드적용</button>
    <hr>
    <div class="widget-code">
        {{ uio('formTextarea', ['class'=>'__xe_widget_code']) }}
    </div>

</div>

