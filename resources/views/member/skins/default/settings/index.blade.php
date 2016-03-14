<div class="xo-container">
    <!--[D]  setting 영역-->
    <div class="setting_wrap">
        <div class="xo-container">
            <div class="cont">
                <div class="side_menu xo-col-sm-3">
                    <div class="menu_open">
                        <button class="xo-menu-toggle" type="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar v2"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <p>계정설정</p>
                    </div>
                    <ul class="sub-list">
                        @foreach($menus as $id => $menu)
                            <li class="@if(array_get($menu, 'selected', false))on @endif">
                                <a href="{{ route('member.settings', ['section'=>$id]) }}">{{ $menu['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="main_con xo-col-sm-9">
                    {!! $tabContent !!}
                </div>
            </div>
        </div>
    </div>
    <!--//setting 영역-->
</div>
