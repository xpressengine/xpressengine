<div class="admin-wrap">
    <header>
        <button type="button" class="btn-slide"><i class="xi-dedent"></i><span class="sr-only">{{ xe_trans('xe::hideMenus') }}</span></button>
        <a href="{{ url('/') }}" class="btn-site-home"><i class="xi-home"></i><span class="sr-only">{{ xe_trans('xe::moveToSite') }}</span></a>
        <div class="right-menu">
            <ul>
                <li>
                    <a href="#" data-toggle="dropdown" aria-expanded="true">
                        <div>
                            <img src="{{ $user->getProfileImage() }}" width="40" height="40" alt="{{ xe_trans('xe::profile') }}">
                            <span class="hidden-xs">{{ $user->getDisplayName() }}</span>
                            <i class="xi-angle-down"></i>
                        </div>
                    </a>
                    <!--[D] a 클릭 시 하위메뉴 none/block로 처리-->
                    <div class="transition dropdown-menu">
                        <ul>
                            <li><a href="{{ route('user.profile', ['user' => auth()->id()]) }}">{{ xe_trans('xe::myProfile') }}</a></li>
                            <li><a href="{{ route('user.settings') }}">{{ xe_trans('xe::mySettings') }}</a></li>
                            <li><a href="{{ route('logout') }}">{{ xe_trans('xe::logout') }}</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#" data-toggle="dropdown" aria-expanded="true">
                        <div>
                            <span class="flag-code"><i class="{{XeLang::getLocale()}} xe-flag"></i>{{XeLang::getLocale()}}</span>
                        </div>
                    </a>
                    <div class="transition dropdown-menu">
                        <ul>
                            @foreach ( XeLang::getLocales() as $locale )
                                <li @if(XeLang::getLocale() == $locale) class="on" @endif>
                                    <a href="{{ locale_url($locale) }}"><i class="{{ $locale }} xe-flag" data-locale="{{ $locale }}"></i>{{ XeLang::getLocaleText($locale) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </header>

    <aside class="transition settings-nav-sidebar">
        <div class="logo-area transition">
            <h1><a href="{{ route('settings') }}"><img src="{{ asset('assets/core/settings/img/logo.png') }}" width="28" height="28" alt="admin logo">{{ $siteTitle or 'XpressEngine3' }}</a></h1>
        </div>
        <p class="list-title">MAIN MENU</p>
        <ul class="snb-list">

            {{-- main menu --}}
            @foreach($menu as $topId => $top)
                @if(data_get($top, 'display', true))

                    {{-- depth 1--}}
                    <li class="{{$topId}}
                        @if($top->hasVisibleChild())sub-depth @endif
                        @if($top->isSelected() && $top->hasVisibleChild())open @endif
                        @if($top->isSelected() && !$top->hasVisibleChild())on @endif"
                    >
                        <a href="{{ $top->link()?:'#'}}" @if(!$top->link()) class="__xe_collapseMenu" @endif><i class="{{data_get($top, 'icon', 'xi-bars')}}"></i>{{xe_trans($top->title)}}</a>

                        @if($top->hasVisibleChild())
                        <button type="button" class="btn-link toggle __xe_collapseMenu"><i class="xi-angle-right-thin"></i></button>
                        <ul class="sub-depth-list">

                            {{--loop for middle--}}
                            @foreach($top->getChildren() as $midId => $middle)
                                @if(data_get($middle, 'display', true))

                                    {{-- depth 2 --}}
                                    <li class="@if($middle->hasVisibleChild())sub-depth @endif @if($middle->isSelected() && $middle->hasVisibleChild())open @endif @if($middle->isSelected() && !$middle->hasVisibleChild())on @endif">
                                        <a href="{{ $middle->link()?:'#' }}" @if(!$middle->link()) class="__xe_collapseMenu" @endif>
                                            {{xe_trans($middle->title)}}
                                        </a>
                                        @if($middle->hasVisibleChild())
                                        <button type="button" class="btn-link toggle __xe_collapseMenu"><i class="xi-angle-right-thin"></i></button>
                                        <ul class="sub-depth-list">
                                            {{--loop for bottom--}}
                                            @foreach($middle->getChildren() as $bottomId => $bottom)
                                                @if(data_get($bottom, 'display', true))

                                                    {{-- depth 3 --}}
                                                    <li @if($bottom->isSelected())class="on" @endif>
                                                        <a href="{{ $bottom->link()?:'#' }}">
                                                            {{xe_trans($bottom->title)}}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                @endif
                            @endforeach

                        </ul>
                        @endif
                    </li>
                @endif
            @endforeach
    </aside>

    <div id="content" class="transition">
        <div class="ct">
            <div class="title-area container-fluid">
                @section('page_head')
                <div class="row">
                    <div class="col-sm-12">
                        @yield('page_title', '<h2>'.xe_trans(data_get($selectedMenu ? $selectedMenu->getParent() : [], 'title', 'xe::enterTitle')).'</h2>')
                        @yield('page_description', '<small>'.xe_trans(data_get($selectedMenu ? $selectedMenu->getParent() : [], 'description', '')).'</small>')
                    </div>
                </div>
                <div class="row locate">
                    <div class="col-sm-12">
                        <ul>
                        @if ($selectedMenu)
                            <li><a href="{{ route('settings') }}">Home</a></li>
                            <!-- 게시판 인스턴스 설정 같이 빵조각을 표시하기 어려운 환경 일 수 있음 -->
                            @foreach ($selectedMenu->getBreadCrumbs() as $menu)
                            <li><i class="xi-angle-right"></i><a href="{{$menu->link()}}">{{xe_trans($menu->title)}}</a></li>
                            @endforeach
                        @endif
                            <!-- contents 에서 임의로 빵조각을 추가할 수 있음-->
                            @yield('content_bread_crumbs')
                        </ul>
                    </div>
                </div>
                @show
            </div>
            <div class="container-fluid">
                <!--어드민 컨텐츠 영역 col-sm-"n" n:1~12에 따라 그리드 사용가능-->
                {!! $content !!}
            </div>
        </div>
    </div>

    <div class="footer">
        <span>Copyright ©2015 <a href="http://xpressengine.io">XpressEngine.</a> All rights reserved.</span>
        <em class="pull-r">Version {{ __XE_VERSION__ }}</em>
    </div>
</div>
<div class="dim"></div>
