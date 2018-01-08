<ul class="nav nav-tabs">
    <li @if($_active == 'detail') class="active" @endif><a href="{{ route('settings.editor.setting.detail', $instanceId) }}">{{xe_trans('xe::detailSettings')}}</a></li>
    <li @if($_active == 'perm') class="active" @endif><a href="{{ route('settings.editor.setting.perm', $instanceId) }}">{{xe_trans('xe::permission')}}</a></li>
    <li @if($_active == 'tool') class="active" @endif><a href="{{ route('settings.editor.setting.tool', $instanceId) }}">{{xe_trans('xe::addTools')}}</a></li>
</ul>