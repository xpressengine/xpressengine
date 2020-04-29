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
                        <a href="{{ $top->link()?:'#'}}" @if($top->hasVisibleChild()) class="__xe_collapseMenu" @endif><i class="{{data_get($top, 'icon', 'xi-bars')}}"></i>{{xe_trans($top->title)}}</a>

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
        </ul>
    </aside>
    <script>
        $(function () {

            var smartSelectSideMenu = function () {
                var $snb = $('.settings-nav-sidebar .snb-list');
                if ($snb.find('li.on').length == 0) {
                    var url = '{{Request::url()}}',
                        settingsPrefix = '{{app('config')->get('xe.routing.settingsPrefix')}}',
                        parts = url.split('?'),
                        settingsBaseUrl = '';
                    parts = parts[0].split('/');
                    for (var i=0; i<parts.length; i++) {
                        settingsBaseUrl = settingsBaseUrl + parts[i] + '/';
                        if (parts[i] == settingsPrefix) {
                            break;
                        }
                    }

                    var checkurl = '',
                        pop = '',
                        isMatched = false;

                    for (var i=0; i<parts.length; i++) {
                        checkurl = parts.join('/');
                        if (pop == settingsPrefix) {
                            break;
                        }

                        $snb.find('a').each(function () {
                            var $anchor = $(this);
                            if ($anchor.prop('href') == checkurl) {
                                if ($anchor.closest('li').length) {
                                    $anchor.closest('li').addClass('on');
                                }
                                $anchor.parents('.sub-depth').each(function () {
                                    $(this).addClass('open');
                                });
                                isMatched = true;

                                return false; // break each
                            }
                        });

                        if (isMatched == true) {
                            break;
                        }

                        pop = parts.pop();
                    }
                }
            }
            smartSelectSideMenu();
        });
    </script>

    <div id="content" class="transition">
        <div class="ct">
            <div class="title-area container-fluid">
                @section('page_head')
                <div class="row">
                    <div class="col-sm-12">
                        @section('page_title')
                            <h2>{{ xe_trans(data_get($selectedMenu ? $selectedMenu->getParent() : [], 'title', 'xe::enterTitle')) }}</h2>
                        @show
                        @section('page_description')
                            @php
                                $description = xe_trans(data_get($selectedMenu ? $selectedMenu->getParent() : [], 'description', ''));
                            @endphp

                            @if ($description != '')
                                <small>{{ $description }}</small>
                            @endif
                        @show
                    </div>
                </div>
                @show
            </div>

            <div class="container-fluid">
                @if($errors = session('bootfail'))
                    @foreach($errors as $name => $info)
                        <!--[D] notice 데이터 알림 관련해서 구조 새롭게 추가 -->
                        <!--[D] notice 는 기본, 상황에 맞춰 앞에 바 컬러 노출, 배경색 노출, 닫기 버튼 노출 -->
                        <!--[D] is-dissmiss (X 닫기버튼 노출 유무, 공통), 해당 클래스들은 원하는 기능만큼 중복으로 적용해주면 됩니다.
                            빨간색 : notice-danger (왼쪽바), notice-danger-bg (박스 배경색)
                            노란색 : notice-warning (왼쪽바), notice-warning-bg (박스 배경색)
                            녹색 : notice-success (왼쪽바), notice-success-bg (박스 배경색)
                        -->
                        <!-- [D] 메시지 하단 구조는 제목은 h4, 내용은 p 태그로 적용해주면 됩니다. -->
                        <div class="notice notice-danger is-dissmiss">
                            <h4>{{ $info['entity']->getTitle() }} {{ xe_trans('xe::pluginError') }}</h4>
                            <p>
                                {{ xe_trans('xe::errorPluginWasDeactivated', ['name' => $info['entity']->getTitle()]) }}
                            </p>
                            <p>
                                {{ $info['exception']->getMessage() }} ({{ str_replace(base_path(), '', $info['exception']->getFile()) }}:{{ $info['exception']->getLine() }})
                            </p>
                            <button type="button" class="notice__button-close"><i class="xi-close-thin"></i><span class="sr-only">notice 닫기</span></button>
                        </div>
                    @endforeach
                @endif

                <!--어드민 컨텐츠 영역 col-sm-"n" n:1~12에 따라 그리드 사용가능-->
                {!! $content !!}
            </div>
        </div>
    </div>

    <div class="footer">
        <span>Copyright ©2015 <a href="http://xpressengine.io">XpressEngine.</a> All rights reserved.</span>
        <em class="pull-r">Version {{ __XE_VERSION__ }} @if($installedVersion !== __XE_VERSION__)
                (installed Version: {{ $installedVersion }} - <a href="{{ route('settings.coreupdate.show') }}">update XE</a>) @endif </em>
    </div>
</div>
<div class="dim"></div>
