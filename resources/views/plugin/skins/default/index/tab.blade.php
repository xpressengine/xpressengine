<div class="row">
    <div class="col-sm-12">
        <div class="panel admin-tab">
            <ul class="admin-tab-list">
                <li @if($installType === 'fetched') class="on" @endif><a href="{{ route('settings.plugins', ['install_type' => 'fetched']) }}">{{ xe_trans('xe::fetchedPlugin') }}</a></li>
                <li @if($installType === 'self-installed') class="on" @endif><a href="{{ route('settings.plugins', ['install_type' => 'self-installed']) }}">{{ xe_trans('xe::selfInstalledPlugin') }}</a></li>
            </ul>
        </div>
    </div>
</div>
