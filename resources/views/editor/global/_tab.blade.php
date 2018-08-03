<ul class="nav nav-tabs">
    <li @if($_active == 'detail') class="active" @endif><a href="{{ route('settings.editor.global.detail') }}">{{xe_trans('xe::detailSettings')}}</a></li>
    <li @if($_active == 'perm') class="active" @endif><a href="{{ route('settings.editor.global.perm') }}">{{xe_trans('xe::permission')}}</a></li>
    <li @if($_active == 'tool') class="active" @endif><a href="{{ route('settings.editor.global.tool') }}">{{xe_trans('xe::addTools')}}</a></li>
</ul>