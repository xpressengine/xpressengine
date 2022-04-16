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

<div class="xe-panel xe-panel--row xe-panel--direct-store">
    <a href="https://store.xehub.io/" target="_blank">
        <div class="xe-panel__thumbnail">
            <i class="xi-xpressengine" style="user-select: auto;"></i>
        </div>
        <div class="xe-panel__info">
            <h1 class="xe-panel__info-title">엑스프레스엔진 스토어</h1>
            <p class="xe-panel__info-description">XpressEngine 온라인 스토어에서 필요한 위젯을 설치하고 웹사이트에 손쉽게 기능을 추가해보세요</p>
        </div>
    </a>
</div>

<script>
    $(function() {
        $('#{{$id}}').widgetGenerator();
    });
</script>
