<div id="widgetbox-{{ $id }}">
    <div class="widgetbox-content">
        {!! $content !!}
    </div>
    <hr>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('widgetbox.edit', ['id' => $id]) }}" target="_blank">편집</a>
    @endif
</div>
