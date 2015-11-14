@section('page_head')
    <h2><a href="{{ route('settings.menu.index') }}"><i
                    class="xi-arrow-left"></i></a>@yield('page_title', xe_trans('xe::editMenuPermission'))</h2>
    <div class="tit_btn_area">
        <button type="button" class="btn_lst_toggle visible-xs pull-right"><i class="xi-ellipsis-v"></i></button>
        <ul class="btn_lst">
            <li><a href="{{route('settings.menu.select.types', $menu->id)}}" class="ico_gray"><i
                            class="xi-plus"></i><span
                            class="visible-xs-inline">{{xe_trans('xe::addItem')}}</span></a></li>
            <li><a href="{{route('settings.menu.edit.menu', $menu->id)}}" class="ico_gray"><i class="xi-pen"></i><span
                            class="visible-xs-inline">{{xe_trans('xe::editInformation')}}</span></a></li>
            <li><a href="{{route('settings.menu.edit.permission.menu', $menu->id)}}" class="ico_gray"><i
                            class="xi-lock"></i><span
                            class="visible-xs-inline">{{xe_trans('xe::editMenuPermission')}}</span></a></li>
            <li><a href="{{route('settings.menu.permit.menu', $menu->id)}}" class="ico_gray"><i
                            class="xi-trash"></i><span
                            class="visible-xs-inline">{{xe_trans('xe::deleteMenu')}}</span></a></li>
        </ul>
    </div>
@endsection
