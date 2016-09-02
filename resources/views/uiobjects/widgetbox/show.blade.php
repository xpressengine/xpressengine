<div id="widgetbox-{{ $id }}">
    <div class="widgetbox-content">
        {!! $content !!}
    </div>
    <hr>
    @if(auth()->user()->isAdmin())
    <a href="{{route('widgetbox.edit', ['id' => $id])}}" target="_blank" onclick="window.open(this.href, 'widgetboxEditor', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no');return false">편집</a>
    @endif
</div>
