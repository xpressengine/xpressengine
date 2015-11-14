<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

@foreach ($permissionGroups as $groupName => $permissions)
<div class="panel __xe_section_box">
    <div class="panel-heading">
        <div class="row">
            <p class="txt_tit">{{ $groupName }}</p>

            <div class="right_btn pull-right" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#{{ $groupName }}Section">
                <!-- [D] 메뉴 닫기 시 버튼 클래스에 card_close 추가 및 item_container none/block 처리-->
                <button class="btn_clse ico_gray pull-left"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="blind">{{ xe_trans('xe::closeMenu') }}</span></button>
            </div>
        </div>
    </div>

    <div id="{{ $groupName }}Section" class="panel-collapse collapse in" role="tabpanel">
        @foreach ($permissions as $key => $permission)
        <div class="panel-body">
                <form method="post" action="{{ route('settings.setting.update.permission', $permission['id']) }}">
                    <input type="hidden" name="_token" value="{{{ Session::token() }}}">
                    {!! uio('xpressengine@registeredPermission',['title' => $permission['title'],'type' => 'settings','target' => $permission['id']])->render() !!}

                    <div class="btn_group_all">
                        <button type="submit" class="btn btn_blue">{{ xe_trans('xe::applyModified') }}</button>
                    </div>
                </form>
        </div>
        @endforeach
    </div>
</div>
@endforeach

</div>

{!! uio('uiobject/xpressengine@chakIt', 'Settings:관리페이지권한설정') !!}