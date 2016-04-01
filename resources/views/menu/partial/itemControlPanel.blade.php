<a href="{{ url($item->url) }}" class="btn btn-default">페이지로 이동하기</a>
<div class="btn-group" role="group">
    <a href="{{ route('settings.menu.select.types', [$menu->id, 'parent' => $item->id]) }}" class="btn btn-default">아이템 추가</a>
    <a href="{{route('settings.menu.edit.permission.item', [$menu->id, $item->id])}}" class="btn btn-default">권한 설정</a>
    @if($menuType !== null && !empty($menuType::getInstanceSettingURI($item->id)))
    <a href="{{($menuType::getInstanceSettingURI($item->id))}}" class="btn btn-default">상세 설정</a>
    @endif
</div>
<a href="{{route('settings.menu.permit.item', [$menu->id, $item->id])}}" class="btn btn-default btn-danger">아이템 삭제</a>
