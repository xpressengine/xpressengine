<div class="widget-generator" id="{{$id}}">
    <div class="widget-inputs" data-url="{{route('settings.widget.setup')}}">
        {{-- select widget --}}
        <div class="widget-selector">
            {{ uio('formSelect', ['label'=>'위젯', 'class'=>'__xe_select_widget', 'name'=>'widget', 'options'=>$widgets] ) }}
        </div>

        {{-- select skin --}}
        <div class="widget-skins" data-url="{{ route('settings.widget.skin') }}">
        </div>

        {{-- form fields --}}
        <div class="widget-form">
        </div>
    </div>

    <hr>

    @if($show_code)
    <button type="button" class="btn btn-default __xe_generate_code">코드생성</button>
    <button type="button" class="btn btn-default __xe_setup_code">코드적용</button>
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