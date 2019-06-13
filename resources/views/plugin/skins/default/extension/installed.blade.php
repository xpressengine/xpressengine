@section('page_title')
    <h2>{{ xe_trans('xe::installedExtension') }}</h2>
@stop

@section('page_description')
    <small>{{ xe_trans('xe::installedExtensionDescription') }}</small>
@endsection

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-right">
                        <div class="btn-group">
                            <a href="{{route('settings.extension.install')}}" class="xe-btn">{{xe_trans('xe::installNewExtension')}}</a>
                            <button type="button" class="xe-btn">{{xe_trans('xe::extension')}} {{xe_trans('xe::upload')}}</button>
                        </div>
                    </div>
                </div>

                <div class="panel-heading">
                    <div class="pull-left">
                        <div class="btn-group">
                            <button class="btn btn-default __xe_check_all">{{ xe_trans('xe::selectAll') }}</button>
                        </div>
                        <div class="btn-group __xe_controll_btn">
                            <a href="{{ route('settings.plugins.manage.activate') }}" class="btn btn-default on __xe_activate_plugin"><span>{{ xe_trans('xe::activate') }}</span></a>
                            <a href="{{ route('settings.plugins.manage.deactivate') }}" class="btn btn-default on __xe_deactivate_plugin"><span>{{ xe_trans('xe::deactivate') }}</span></a>
                            <a href="{{ route('settings.plugins.manage.delete') }}" class="btn btn-default on __xe_remove_plugin"><span>{{ xe_trans('xe::delete') }}</span></a>
                        </div>
                    </div>

                    <div class="pull-right">
                        <div class="input-group search-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="selected-type">{{ xe_trans('xe::filter') }}</span>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="#" data-target="allTheme"><span>{{xe_trans('xe::all')}}</span></a>
                                    </li>
                                    <li>
                                        <a href="#" data-target="activated"><span>{{xe_trans('xe::activatedExtension')}}</span></a>
                                    </li>
                                    <li>
                                        <a href="#" data-target="deactivated"><span>{{xe_trans('xe::deactivatedExtension')}}</span></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="search-input-group">
                                <input type="text" class="form-control" placeholder="검색어를 입력하세요" name="q" value="">
                                <button class="btn-link">
                                    <i class="xi-close"></i><span class="sr-only">검색</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="list-group list-plugin">
                    @foreach ($plugins as $plugin)
                        @include($_skin::view('common.item'))
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>



<div class="__xe_plugin_items">
    {{--    @include($_skin::view('install.items'))--}}
</div>

<form action="{{ route('settings.plugins.install') }}" method="POST" id="xe-install-plugin">
    {{ csrf_field() }}
    <input type="hidden" name="pluginId[]">
</form>
<script>
    $(function(){
        $(document).on('click','.plugin-install',function(){
            $("#xe-install-plugin").find('[name="pluginId[]"]').val($(this).data('target'));
            $("#xe-install-plugin").submit();
        })
        $(document).on('click','.search-group li a',function(){
            $(".search-group").find('input[type="text"]').attr('name',$(this).data('target'));
            $(".search-group").find('.selected-type').text($(this).text());
        })
    });
</script>
