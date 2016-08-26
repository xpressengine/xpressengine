<div id="widgetbox-{{ $id }}">
    <div class="widgetbox-content">
        {!! $content !!}
    </div>
    <hr>
    @if(auth()->user()->isAdmin())
    <a href="#{{$id}}" target="_blank" onclick="window.open('{{route('widgetbox.edit', ['id' => $id])}}') ">편집</a>
    @endif
</div>
