<div class="widget-generator" id="{{$id}}">
    <div class="widget-inputs" data-url="{{route('settings.widget.setup')}}">
        @include('widget.setup')
    </div>

    @if($show_code)
        <hr>
        <button type="button" class="btn btn-default __xe_generate_code">코드생성</button>
        <hr>
        <div class="widget-code">
            {{ uio('formTextarea', ['class'=>'__xe_widget_code']) }}
        </div>
    @else
        <input type="hidden" class="__xe_widget_code">
    @endif
</div>

<script>
    $(function() {
        $('#{{$id}}').widgetGenerator();
    });
</script>
