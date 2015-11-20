@section('page_head')
    <h2><a href="{{route('settings.menu.index')}}"><i class="xi-arrow-left"></i></a>@yield('page_title', 'Edit Item')
    </h2>
    <div class="tit_btn_area">
        <button type="button" class="btn_lst_toggle visible-xs pull-right"><i class="xi-ellipsis-v"></i></button>
        <ul class="btn_lst">
            @if( $menuType !== null && $menuType::isRouteAble())
            <li><a href="/{{$item->url}}" class="ico_gray">
            @else
            <li><a href="{{$item->url}}" class="ico_gray">
            @endif
                   <i class="xi-external-link"></i><span
                            class="visible-xs-inline">페이지로 이동하</span></a></li>
            <li><a href="{{route('settings.menu.select.types', [$menu->id, 'parent' => $item->id])}}"
                   class="ico_gray"><i
                            class="xi-plus"></i><span
                            class="visible-xs-inline">아이템 추가하기</span></a></li>
            <li><a href="{{route('settings.menu.edit.item', [$menu->id, $item->id])}}" class="ico_gray"><i
                            class="xi-pen"></i><span
                            class="visible-xs-inline">정보 수정하기</span></a></li>
            <li><a href="{{route('settings.menu.edit.permission.item', [$menu->id, $item->id])}}" class="ico_gray">
                    <i class="xi-lock"></i><span class="visible-xs-inline">권한 설정하기</span></a></li>
            @if($menuType !== null && !empty($menuType::getInstanceSettingURI($item->id)))
                <li><a href="{{($menuType::getInstanceSettingURI($item->id))}}" class="ico_gray"><i
                                class="xi-cog"></i><span
                                class="visible-xs-inline">상세 설정하기</span></a></li>
            @endif
            <li><a href="{{route('settings.menu.permit.item', [$menu->id, $item->id])}}" class="ico_gray"><i
                            class="xi-trash"></i><span class="visible-xs-inline">삭제하기</span></a></li>
        </ul>
    </div>
    <div class="tit_bottom">
        <ul class="locate">
            <li><a href="{{ route('settings.menu.edit.menu', $menu->id) }}">{{$menu->title}}</a></li>
            @if($item->getParent() !== null)
                @include('menu.partial.itemBreadCrumbs', ['parent' => $item->getParent()])
            @endif
        </ul>
    </div>
@endsection
