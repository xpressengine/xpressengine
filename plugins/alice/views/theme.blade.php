{{ Frontend::bodyClass(array_get($config, 'mode')) }}
{{ Frontend::bodyClass(array_get($config, 'sub')) }}
{{ Frontend::bodyClass(array_get($config, 'no_spot')) }}
{{ Frontend::bodyClass(array_get($config, 'no_snb')) }}

<header class="site-header trasition {{ array_get($config, 'header_scroll') }} {{ array_get($config, 'bg_none') }}">
    <nav class="main-navigation" role="navigation">
        <div class="container">
            <div class="nav-wrapper">
                <a class="brand-logo" href="{{ url('/') }}">{{ $config['title'] }}</a>

                {{-- menu --}}
                <div class="menu-menu-1-container">
                    <div id="nav-mobile" class="side-nav">
                        <div class="lst auth_lst">
                            <ul>
                                @if(auth()->user()->isAdmin())
                                <li><a href="{{ route('settings') }}"><i class="xi-cog"></i></a></li>
                                @endif
                                <li><a href="#" class="auth_toggle"><i class="xi-user-profile"></i></a></li>
                            </ul>
                            <div class="auth_con" id="" style="display: none;">
                                <ul>
                                    @if(Auth::check())
                                        <li><a href="{{ route('member.profile', ['member' => auth()->id()]) }}">{{ xe_trans('xe::myProfile') }}</a></li>
                                        <li><a href="{{ route('member.settings') }}">{{ xe_trans('xe::mySettings') }}</a></li>
                                        <li><a href="{{ route('logout') }}">{{ xe_trans('xe::logout') }}</a></li>
                                    @else
                                        <li><a href="{{ route('login') }}">{{ xe_trans('xe::login') }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="lst menu_lst">
                            <ul>
                                {{-- loop 1--}}
                                @foreach($mainMenu as $menuItem)
                                @if($menuItem->activated === 1 && $menuItem->checkVisiblePermission(Auth::user()))

                                <!--[D] 메뉴 선택 시 li.on -->
                                <li class="@if($menuItem->isSelected())on @endif @if($menuItem->hasChild()) @endif">

                                    @if($menuItem->hasChild() === false)
                                        <a href="{{ url($menuItem->url) }}"><span>{{ xe_trans($menuItem->title) }}</span></a>
                                    @else
                                        <a href="{{ url($menuItem->url) }}" data-activates="dropdown{{$menuItem->id}}" data-hover="true" class="dropdown-button">
                                            <span>{{ xe_trans($menuItem->title) }}<i class="xi-angle-down-thin"></i></span>
                                        </a>
                                        <div id="dropdown{{$menuItem->id}}" class="dropdown-content" style="display: none;">
                                            <ul>
                                                {{-- loop 2--}}
                                                @foreach($menuItem->getChildren() as $menuItem2Depth)
                                                    @if($menuItem2Depth->activated === 1 && $menuItem2Depth->checkVisiblePermission(Auth::user()))

                                                        <li class="@if($menuItem2Depth->isSelected())on @endif">

                                                            <a href="{{ url($menuItem2Depth->url) }}">{{ xe_trans($menuItem2Depth->title) }}</a>

                                                        </li>
                                                    @endif
                                                @endforeach

                                            </ul>
                                        </div>
                                    @endif
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <button class="button-collapse menu-toggle" data-activates="nav-mobile" type="button">
                    <span class="blind">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar v2"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
        </div>
    </nav>
</header>

@section('spot')
@show

<div class="ct {{ array_get($config, 'ct_class') }}">
    @section('theme_content')
    @show
</div>

<footer class="page-footer grey darken-2">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">
                    <img src="{{ $plugin->asset('assets/img/logo_d2.png') }}" width="100" height="24" alt="naver d2">
                </h5>

                <p class="grey-text text-lighten-4">A modern responsive front-end framework based on Material Design</p>
            </div>

            @foreach($subMenus as $subMenuTitle => $subMenu)
            <div class="col l3 s12">
                <h5 class="white-text">{{ $subMenuTitle }}</h5>
                <ul>
                @foreach($subMenu as $menuItem)
                @if($menuItem->activated === 1 && $menuItem->checkVisiblePermission(Auth::user()))
                    <!--[D] 메뉴 선택 시 li.on -->
                    <li>
                        <a href="{{ url($menuItem->url) }}" class="white-text">{{ xe_trans($menuItem->title) }}</a>
                    </li>
                @endif
                @endforeach
                </ul>
            </div>
            @endforeach

        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            Made by <a href="http://xpressengine.io" class="link_txt">XE</a>
        </div>
    </div>
</footer>

<script>
    $(document).ready(function () {
        var swiper = new Swiper('.swiper', {
            pagination: '.swiper-pagination',
            paginationClickable: true,
            spaceBetween: 0,
            loop: true
        });
        $('.swiper-button-prev').on('click', function (e) {
            e.preventDefault()
            swiper.swipePrev()
        })
        $('.swiper-button-next').on('click', function (e) {
            swiper.swipeNext()
        })


        $(".swiper").hover(function () {
            $('.swiper-button-white').animate({opacity: 1}, 250);
        }, function () {
            $('.swiper-button-white').animate({opacity: 0}, 250);
        });

        $(".auth_toggle").click(function () {
            $(".auth_con").toggle();
        });

        $(window).scroll(function () {
            if ($(window).scrollTop() >= 50) {
                $('header').addClass('fixed');
            }
            else {
                $('header').removeClass('fixed');
            }
        });


    });

</script>
