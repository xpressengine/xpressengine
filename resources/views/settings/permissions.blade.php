@section('page_description')
    <small>{{xe_trans('xe::settingsPermissionSettingsDescription')}}</small>
@endsection

<div class="container-fluid container-fluid--part">
    <div class="row">
        <div class="col-sm-12">
            <!--[D] accordion 효과 제거 시 panel-group에 id="accordion" 추가 -->
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @foreach ($permissionGroups as $groupName => $group)
                    <div class="panel __xe_section_box">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title">{{ $groupName }}</h3>
                            </div>
                            <div class="pull-right">
                                <a data-toggle="collapse" data-parent="#accordion" data-target="#{{ $groupName }}Section" href="#collapseTwo" class="btn-link panel-toggle"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{ xe_trans('xe::closeMenu') }}</span></a>
                            </div>
                        </div>
                        <div id="{{ $groupName }}Section" class="panel-collapse collapse in" role="tabpanel">
                            @foreach ($group as $key => $item)
                                <form method="post" action="{{ route('settings.setting.update.permission', $item['id']) }}">
                                    <div class="panel-body">
                                        <input type="hidden" name="_token" value="{{{ Session::token() }}}">
                                        <p>{{ $item['title'] }}</p>
                                        {!! uio('xpressengine@registeredPermission',['permission'=>$item]) !!}
                                    </div>
                                    <div id="collapseOne" class="panel-collapse">
                                        <div class="panel-heading">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-primary">{{xe_trans('xe::save')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
