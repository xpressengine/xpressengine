<div class="xe-container">
    <!--[D]  setting 영역-->
    <div class="setting-wrap">
        <div class="xe-container">
            <div class="content">
                <div class="side-menu xe-col-sm-3">
                    <div class="menu-open">
                        <button class="xe-menu-toggle" type="button">
                            <span class="xe-sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar v2"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <p>{{ xe_trans('xe::defaultSettings') }}</p>
                    </div>
                    <ul class="snb-list">
                        @foreach($menus as $id => $menu)
                            <li class="@if(array_get($menu, 'selected', false))on @endif">
                                <a href="{{ route('user.settings', ['section'=>$id]) }}">{{ xe_trans($menu['title']) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="main-content xe-col-sm-9">
                    {!! $tabContent !!}
                </div>
            </div>
        </div>
    </div>
    <!--//setting 영역-->
</div>
