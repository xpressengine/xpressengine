<div id="widgetbox-{{ $id }}">
    <div class="widgetbox-content">
        {!! $content !!}
    </div>
    <hr>
    @if(auth()->user()->isAdmin())
    <a href="{{route('widgetbox.edit', ['id' => $id])}}" target="_blank" onclick="window.open(this.href);return false">편집</a>
    @endif
</div>
