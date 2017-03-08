<ul class="nav navbar-nav">
    @foreach(menu_list($config->get('gnb')) as $menu)
    <li @if($menu['selected']) class="active" @endif><a href="{{ url($menu['url']) }}" target="{{ $menu['target'] }}">{{ $menu['link'] }}</a></li>
    @endforeach
</ul>
