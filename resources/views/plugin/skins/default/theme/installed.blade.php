@section('page_title')
    <h2>{{ xe_trans('xe::installedTheme') }}</h2>
@stop

@section('page_description')
    <small>{{ xe_trans('xe::installedThemeDescription') }}</small>
@endsection

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
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

                    <div class="pull-right text-align--right">
                        <div class="search-btn-group">
                            <a href="{{route('settings.theme.install')}}" class="xe-btn xe-btn-install"><i class="xi-plus"></i>{{xe_trans('xe::installNewTheme')}}</a>
                            <a href="{{route('settings.plugins.manage.upload', ['type' => 'theme'])}}" class="xe-btn xe-btn-default" data-toggle="xe-page-modal">{{xe_trans('xe::theme')}} {{xe_trans('xe::upload')}}</a>
                        </div>

                        <form method="get" action="{{ route('settings.theme.installed') }}">
                            <div class="input-group search-group">
                                <input type="hidden" name="status" value="{{\Request::get('status')}}">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="selected-type">
                                            @if ($status = \Request::get('status', null))
                                                {{ xe_trans('xe::' . $status) }} {{ xe_trans('xe::theme') }}
                                            @else
                                                {{ xe_trans('xe::filter') }}
                                            @endif
                                        </span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#" data-status=""><span>{{xe_trans('xe::all')}}</span></a>
                                        </li>
                                        <li>
                                            <a href="#" data-status="activated"><span>{{xe_trans('xe::activated')}} {{xe_trans('xe::theme')}}</span></a>
                                        </li>
                                        <li>
                                            <a href="#" data-status="deactivated"><span>{{xe_trans('xe::deactivated')}} {{xe_trans('xe::theme')}}</span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="search-input-group">
                                    <input type="text" class="form-control" placeholder="검색어를 입력하세요" name="query" value="{{ \Request::get('query') }}">
                                    <button class="btn-link">
                                        <span class="sr-only">검색</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <ul class="list-group list-plugin">
                    @foreach ($themes as $item)
                        @include($_skin::view('common.installed_item'))
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
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
            $(".search-group").find('input[name="status"]').attr('value', $(this).data('status'));
            $(this).closest('form').submit();
        })
    });
</script>
