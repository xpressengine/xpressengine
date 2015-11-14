<div class="admin_wrap">
    <header class="xo-navbar xo-navbar-static-top">
        <button type="button" class="btn_slide"><i class="xi-dedent"></i><span class="blind">{{ xe_trans('xe::hideMenus') }}</span></button>
        <a href="{{ url('/') }}" class="btn_site_home"><i class="xi-home"></i><span class="blind">사이트로 이동</span></a>
        <div class="right_menu">
            <ul>
                <li>
                    <a href="#" data-toggle="dropdown">
                        <div>
                            <img src="{{ $user->getProfileImage() }}" width="40" height="40" alt="{{ xe_trans('xe::profile') }}" class="img_profile">
                            <span class="hidden-xs">{{ $user->getDisplayName() }}</span>
                            <i class="xi-angle-down"></i>
                        </div>
                    </a>
                    <!--[D] a 클릭 시 하위메뉴 none/block로 처리-->
                    <div class="trasition dropdown-menu">
                        <ul>
                            <li><a href="{{ route('member.profile', ['member' => auth()->id()]) }}">{{ xe_trans('xe::myProfile') }}</a></li>
                            <li><a href="{{ route('member.settings') }}">{{ xe_trans('xe::mySettings') }}</a></li>
                            <li><a href="{{ route('logout') }}">{{ xe_trans('xe::logout') }}</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <aside class="trasition">
        <div class="logo_area trasition">
            <h1><a href="{{ route('settings') }}"><img src="{{ asset('assets/settings/img/logo.png') }}" width="28" height="28" alt="admin logo">{{ $siteTitle or 'XpressEngine3' }}</a></h1>
        </div>
        <p class="lst_tit">MAIN MENU</p>
        <ul class="snb_lst">

            @foreach($menu as $topId => $top)
                @if(data_get($top, 'display', true))
                    <li class="@if($top->hasChild())sub_depth @endif {{$topId}} @if($top->isSelected() && $top->hasChild())open @endif @if($top->isSelected() && !$top->hasChild())on @endif">
                        <a href="{{ $top->link() }}">
                            <i class="{{data_get($top, 'icon', 'xi-stack-paper')}}"></i>
                            {{$top->title}}
                        </a>
                        @if($top->hasChild())
                            <ul class="sub_depth_lst">
                                {{--loop for middle--}}
                                @foreach($top->getChildren() as $midId => $middle)
                                    @if(data_get($middle, 'display', true))
                                        <li class="@if($middle->hasChild())sub_depth @endif @if($middle->isSelected() && $middle->hasChild())open @endif @if($middle->isSelected() && !$middle->hasChild())on @endif">
                                            <a href="{{ $middle->link() }}">
                                                {{$middle->title}}
                                                {{--<div class="xo-badge floating red">55</div>--}}
                                            </a>
                                            @if($middle->hasChild())
                                                <ul class="sub_depth_lst">
                                                    {{--loop for bottom--}}
                                                    @foreach($middle->getChildren() as $bottomId => $bottom)
                                                        @if(data_get($bottom, 'display', true))
                                                            <li @if($bottom->isSelected())class="on" @endif>
                                                                <a href="{{ $bottom->link() }}">
                                                                    {{$bottom->title}}
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
    <div id="content" class="trasition">
        <div class="ct">
            <div class="tit_area">
                <div class="tit_con">
                    @section('page_head')
                    <div class="row">
                        <div class="col-sm-6">
                            @yield('page_title', '<h2>'.data_get($selectedMenu, 'title', '제목을 입력하세요.').'</h2>')
                            @yield('page_description', '<p class="sub_txt">'.data_get($selectedMenu, 'description', '제목을 입력하세요.').'</p>')
                        </div>
                        <div class="col-sm-6">
                            @yield('page_setting_menu')
                            <!-- 버튼 등 서드파티에서 수정할 수 있는 영역 <button type="button" class="btn_setting blue v2 pull-right">메뉴 추가</button> -->
                        </div>
                    </div>
                    @show
                </div>
            </div>
            <div class="container-fluid card_area">
                    <!--어드민 컨텐츠 영역 col-sm-"n" n:1~12에 따라 그리드 사용가능-->
                    {!! $content !!}
            </div>
        </div>
    </div>
    <div class="footer">
        <span>Copyright ©2015 <a href="http://xpressengine.io">XpressEngine.</a> All rights reserved.</span>
        <em class="pull-r">Version 2.0.</em>
    </div>
</div>
<div class="dim"></div>
