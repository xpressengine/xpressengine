<script type="text/javascript">
    {!! XeFrontend::output('translation') !!}
</script>
@foreach($items as $item)
    @if($item['script'] != null){{ XeFrontend::js($item['script'])->loadAsync() }}@endif
    {{--raw, func type 처리 해야 함--}}
    @if($item['type'] === Xpressengine\ToggleMenu\AbstractToggleMenu::MENUTYPE_LINK)
        <li><a href="{{$item['action']}}">{{$item['text']}}</a></li>
    @elseif($item['type'] === Xpressengine\ToggleMenu\AbstractToggleMenu::MENUTYPE_EXEC)
        <li><a href="#" onclick='{!! $item['action'] !!}'>{{$item['text']}}</a></li>
    @endif
@endforeach
