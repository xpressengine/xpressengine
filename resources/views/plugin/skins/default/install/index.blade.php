<div class="row">
    <div class="col-sm-12">
        <div class="panel admin-tab">
            <button class="admin-tab-left" style="display:none"><i class="xi-angle-left"></i><span class="xe-sr-only">처음으로 이동</span></button>

            <ul class="admin-tab-list __xe-tab-list">
                <li class=" @if($filter === 'top')on @endif top"><a href="{{ route('settings.plugins.install.items', ['filter' => 'top']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" data-callback="PluginInstallManager.loaded">추천</a></li>
                <li class=" @if($filter === 'popular')on @endif popular"><a href="{{ route('settings.plugins.install.items', ['filter' => 'popular']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" data-callback="PluginInstallManager.loaded">인기</a></li>
                <li class=" @if($filter === 'purchased')on @endif purchased"><a href="{{ route('settings.plugins.install.items', ['filter' => 'purchased']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" data-callback="PluginInstallManager.loaded">내가 구매한 플러그인</a></li>
                <li class="on search" style="display: none;"><a href="#" onclick="return false;">검색결과</a></li>
            </ul>
            <button class="admin-tab-right"><i class="xi-angle-right"></i><span class="xe-sr-only">끝으로 이동</span></button>
        </div>
    </div>
</div>

@if(!$available)
<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger">
            <code>allow_url_fopen</code> 설정이 꺼져있습니다. 플러그인을 설치하려면 php.ini 파일에서 이 설정을 켜야 합니다.
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-sm-12">
        <form action="{{ route('settings.plugins.install') }}" method="POST" id="__xe_install_form">
            {{ csrf_field() }}

            <div class="panel admin-choice __xe_install_list">
                <p class="admin-choice-count">선택한 플러그인 : <span class="__xe_selected_count">0</span>개</p>

                <ul class="admin-choice-list">
                </ul>
                @if(!$available)
                    <button type="button"
                            onclick="alert('allow_url_fopen 설정이 꺼져있습니다. ' +
                             '플러그인을 설치하려면 php.ini 파일에서 이 설정을 켜야 합니다.');return false;"
                            class="xe-btn xe-btn-primary-outline xe-btn-install">
                        <i class="xi-cog"></i>설치하기
                    </button>
                @else
                <button type="submit" class="xe-btn xe-btn-primary-outline xe-btn-install __xe_install_btn" disabled><i class="xi-cog"></i>설치하기</button>
                @endif

            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group" id="accordion">
            @if($operation)
                <div class="__xe_operation" style="margin-bottom: 10px;">
                    @include($_skin::view('operation'))
                </div>
            @endif
            <div class="__xe_plugin_items" style="margin-top:20px;">
                @include($_skin::view('install.items'))
            </div>
        </div>
    </div>
</div>
