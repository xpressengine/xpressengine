<a href="{{ url($item->url) }}" class="btn btn-default">{{xe_trans('xe::moveToPage')}}</a>
<div class="btn-group" role="group">
    <a href="{{ route('settings.menu.select.types', [$menu->id, 'parent' => $item->id]) }}" class="btn btn-default">{{xe_trans('xe::addItem')}}</a>
    <a href="{{route('settings.menu.edit.permission.item', [$menu->id, $item->id])}}" class="btn btn-default">{{xe_trans('xe::permissionSettings')}}</a>
    @if($menuType !== null && !empty($menuType::getInstanceSettingURI($item->id)))
    <a href="{{($menuType::getInstanceSettingURI($item->id))}}" class="btn btn-default">{{xe_trans('xe::detailSettings')}}</a>
    @endif
</div>
<a href="{{route('settings.menu.permit.item', [$menu->id, $item->id])}}" class="btn btn-default btn-danger">{{xe_trans('xe::deleteItem')}}</a>
