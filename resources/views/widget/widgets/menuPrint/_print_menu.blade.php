<ul class="xe-widget xe-widget-type--menuprint __xe-widget xe-menu @if($__depth == 1) xe-menu--top @else xe-menu--sub @endif xe-menu--depth-{{$__depth}}" @if($__depth == 1)data-widget-id="{{$config['menu_id']}}" data-widget="menuPrint" @endif>
    @foreach ($__menuList as $menu)
        <li class="xe-menu__item @if($menu['selected']) xe-menu__item--active @endif xe-menu--depth-{{$__depth}}" data-menu-type="{{ $menu['type'] }}">
            <a href="{{ url($menu['url']) }}"
                class="xe-menu__link @if($__depth == 1) xe-menu__link--top @else xe-menu__link--sub @endif @if($menu['target'] == '_blank') xe-menu__link--target-new @endif @if($menu['url'] === '#') xe-menu__link--target-bookmark @endif"
                @if($menu['target'] !== '_self') target="{{ $menu['target'] }}" @endif
                @if($menu['target'] === '_blank') rel="noreferrer noopener" @endif
            >
                <span class="xe-menu__text">{{ $menu['link'] }}</span>
            </a>

            @if(isset($menu['children']) && count($menu['children']) && $__depth < $config['limit_depth'])
                @include($_skin::getPath() . '._print_menu', [
                    '__menuList' => $menu['children'],
                    '__depth' => $__depth + 1,
                ])
            @endif
        </li>
    @endforeach
</ul>
