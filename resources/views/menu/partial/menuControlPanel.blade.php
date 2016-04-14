<div class="btn-group" role="group">
    <a href="{{route('settings.menu.select.types', $menu->id)}}" class="btn btn-default">{{xe_trans('xe::addItem')}}</a>
    <a href="{{route('settings.menu.edit.menu', $menu->id)}}" class="btn btn-default">{{xe_trans('xe::editInformation')}}</a>
    <a href="{{route('settings.menu.edit.permission.menu', $menu->id)}}" class="btn btn-default">{{xe_trans('xe::editMenuPermission')}}</a>
</div>
<a href="{{route('settings.menu.permit.menu', $menu->id)}}" class="btn btn-danger">{{xe_trans('xe::deleteMenu')}}</a>
