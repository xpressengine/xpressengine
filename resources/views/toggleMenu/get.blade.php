@foreach($items as $item)
    @if($item['script'] != null){{ XeFrontend::js($item['script'])->loadAsync() }}@endif
    @if($item['type'] === Xpressengine\ToggleMenu\AbstractToggleMenu::MENUTYPE_LINK)
        <li><a href="{{$item['action']}}">{{$item['text']}}</a></li>
    @elseif($item['type'] === Xpressengine\ToggleMenu\AbstractToggleMenu::MENUTYPE_EXEC)
        <li><a href="#" onclick='{!! $item['action'] !!}'>{{$item['text']}}</a></li>
    @elseif($item['type'] === Xpressengine\ToggleMenu\AbstractToggleMenu::MENUTYPE_RAW)
        <li>{!! $item['action'] !!}</li>
    @endif
@endforeach
