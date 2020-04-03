<ul class="@if($__depth == 1) gnb-menu @else sub-menu @endif depth-{{$__depth}}">
    @foreach ($__menuList as $menu)
        <li class="depth-{{$__depth}}" data-menu-type="{{$menu['type']}}">
            <a href="{{ url($menu['url']) }}" class="menu-link @if($__depth == 1) gnb-menu-link @else sub-menu-link @endif @if ($menu['target'] == '_blank') target-blank @endif @if ($menu['url'] === '#') inner-link @endif " @if ($menu['target'] !== '_self') target="{{ $menu['target'] }}" @endif>
                <span class="link-text">{{ $menu['link'] }}@if ($menu['target'] == '_blank') <i class="xi-external-link"></i>@endif</span>
            </a>
        </li>
        @if (isset($menu['children']) && count($menu['children']) && $__depth < $config['limit_depth'])
            @include($_skin::getPath() . '._print_menu', [
            '__menuList' => $menu['children'],
            '__depth' => $__depth + 1,
        ])
        @endif
    @endforeach
</ul>