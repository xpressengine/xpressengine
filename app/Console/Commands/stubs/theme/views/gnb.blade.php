<ul class="nav-list">
    @foreach(menu_list($config->get('mainMenu')) as $menu)

    {{-- depth0--}}
    <li class="sub-menu @if($menu['selected']) on @endif ">
        <a href="{{ url($menu['url']) }}">
            {{ $menu['link'] }}
            @if(count($menu['children'])) <em class="ico-arrow"></em> @endif
        </a>

        @if(count($menu['children']))
            <ul  class="sub-menu-list">
                @foreach($menu['children'] as $menu1)
                    {{-- depth1 --}}
                    <li class="sub-menu @if($menu1['selected']) on @endif ">
                        <a href="{{ url($menu1['url']) }}">
                            {{ $menu1['link'] }}
                            @if(count($menu1['children'])) <em class="ico-arrow"></em> @endif
                        </a>

                        @if(count($menu1['children']))
                            <ul class="depth3">
                                @foreach($menu1['children'] as $menu2)
                                    {{-- depth2 --}}
                                    <li class="sub-menu @if($menu2['selected']) on @endif ">
                                        <a href="{{ url($menu2['url']) }}">{{ $menu2['link'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
    @endforeach
</ul>
