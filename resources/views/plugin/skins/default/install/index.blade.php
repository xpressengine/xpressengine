<div class="row">
    <div class="col-sm-12">
        <div class="panel admin-tab">
            <button class="admin-tab-left" style="display:none"><i class="xi-angle-left"></i><span class="xe-sr-only">처음으로 이동</span></button>

            <ul class="admin-tab-list __xe-tab-list">
                <li class=" @if($filter === 'top')on @endif top"><a href="{{ route('settings.plugins.install.items', ['filter' => 'top']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" data-callback="PluginInstallManager.loaded">{{ xe_trans('xe::recommend') }}</a></li>
                <li class=" @if($filter === 'popular')on @endif popular"><a href="{{ route('settings.plugins.install.items', ['filter' => 'popular']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" data-callback="PluginInstallManager.loaded">{{ xe_trans('xe::popular') }}</a></li>
                <li class=" @if($filter === 'purchased')on @endif purchased"><a href="{{ route('settings.plugins.install.items', ['filter' => 'purchased']) }}" data-toggle="xe-page" data-target=".__xe_plugin_items" data-callback="PluginInstallManager.loaded">{{ xe_trans('xe::purchasedPlugins') }}</a></li>
                <li class="on search" style="display: none;"><a href="#" onclick="return false;">{{ xe_trans('xe::search') }}</a></li>
            </ul>
            <button class="admin-tab-right"><i class="xi-angle-right"></i><span class="xe-sr-only">끝으로 이동</span></button>
        </div>
    </div>
</div>

@if(!$available)
<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger">
            {!! xe_trans('xe::iniOptionOff', ['option' => '<code>allow_url_fopen</code>']) !!} {!! xe_trans('xe::turnOnIniOptionForPluginUpdate', ['option' => '']) !!}
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-sm-12">
        <form action="{{ route('settings.plugins.install') }}" method="POST" id="__xe_install_form">
            {{ csrf_field() }}

            <div class="panel admin-choice __xe_install_list">
                <p class="admin-choice-count">{{ xe_trans('xe::selectedPlugins') }} : <span class="__xe_selected_count">0</span></p>

                <ul class="admin-choice-list">
                </ul>
                @if(!$available)
                    <button type="button"
                            onclick="alert('{{ xe_trans('xe::iniOptionOff', ['option' => 'allow_url_fopen']) }} ' +
                             '{{ xe_trans('xe::turnOnIniOptionForPluginUpdate', ['option' => '']) }}');return false;"
                            class="xe-btn xe-btn-primary-outline xe-btn-install">
                        <i class="xi-cog"></i>{{ xe_trans('xe::install') }}
                    </button>
                @else
                <button type="submit" class="xe-btn xe-btn-primary-outline xe-btn-install __xe_install_btn" disabled><i class="xi-cog"></i>{{ xe_trans('xe::install') }}</button>
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
