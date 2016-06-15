@foreach($items as $item)
    @if($item['script'] != null){{ XeFrontend::js($item['script'])->loadAsync() }}@endif
    {{--raw, func type 처리 해야 함--}}
    @if($item['type'] == 'link')
        <li><a href="{{$item['action']}}">{{$item['text']}}</a></li>
    @elseif($item['type'] == 'exec')
        <li><a href="#" onclick='{!! $item['action'] !!}'>{{$item['text']}}</a></li>
    @endif
@endforeach
