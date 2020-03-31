@section('page_title')
    <h2>{{ xe_trans('xe::installedExtension') }}</h2>
@stop

@section('page_description')
    <small>{{ xe_trans('xe::installedExtensionDescription') }}</small>
@endsection

<div class="row">
    <form method="get" action="{{route('settings.extension.installed')}}">
        <input type="hidden" name="status" value="{{\Request::get('status')}}">
        <input type="hidden" name="component" value="{{\Request::get('component')}}">

        <div class="col-sm-12">
            <div class="admin-tab-info">
                <ul class="admin-tab-info-list __status_list">
                    <li @if (Request::get('status', null) === null) class="on" @endif>
                        <a href="#" class="admin-tab-info-list__link" data-type="sale_type">{{xe_trans('xe::all')}} </a>
                    </li>
                    <li @if (Request::get('status') === 'activated') class="on" @endif>
                        <a href="#" class="admin-tab-info-list__link" data-type="sale_type" data-value="activated">{{ xe_trans('xe::active') }} </a>
                    </li>
                    <li @if (Request::get('status') === 'deactivated') class="on" @endif>
                        <a href="#" class="admin-tab-info-list__link" data-type="sale_type" data-value="deactivated">{{xe_trans('xe::deactive')}} </a>
                    </li>
                </ul>
            </div>

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
                                <a href="{{ route('settings.plugins.manage.make.plugin') }}" class="xe-btn xe-btn-primary __xe_make_plugin"><i class="xi-puzzle"></i> {{ xe_trans('xe::plugin') }} {{ xe_trans('xe::create') }}</a>
                                <a href="{{ route('settings.plugins.manage.make.theme') }}" class="xe-btn __xe_make_theme"><i class="xi-layout-snb-o"></i> {{ xe_trans('xe::theme') }} {{ xe_trans('xe::create') }}</a>
                                <a href="{{ route('settings.plugins.manage.make.skin') }}" class="xe-btn __xe_make_skin"><i class="xi-paper-o"></i> {{ xe_trans('xe::skin') }} {{ xe_trans('xe::create') }}</a>
                            </div>

                            <div class="input-group search-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="selected-type">
                                            @if (Request::get('component', null) !== null)
                                                {{$componentTypes[Request::get('component')]}}
                                            @else
                                                {{xe_trans('xe::supportingComponents')}}
                                            @endif
                                        </span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu __component_list" role="menu">
                                        <li><a href="#" data-value="">{{xe_trans('xe::all')}}</a></li>
                                        @foreach ($componentTypes as $key => $component)
                                            <li @if (Request::get('component') == $key) class="active" @endif><a href="#" data-value="{{$key}}">{{$component}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="search-input-group">
                                    <input type="text" class="form-control" placeholder="{{xe_trans('xe::enterKeyword')}}" name="query" value="{{Request::get('query')}}">
                                    <button class="btn-link">
                                        <i class="xi-close"></i><span class="sr-only">{{xe_trans('xe::search')}}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="list-group list-plugin">
                        @foreach ($extensions as $item)
                            @include($_skin::view('common.installed_item'))
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>

<form action="{{ route('settings.plugins.install') }}" method="POST" id="xe-install-plugin">
    {{ csrf_field() }}
    <input type="hidden" name="pluginId[]">
</form>

<script>
    $(function(){
        $(document).on('click', '.plugin-install', function(){
            $("#xe-install-plugin").find('[name="pluginId[]"]').val($(this).data('target'));
            $("#xe-install-plugin").submit();
        })

        $(document).on('click', '.__status_list li a', function() {
            $('input[name=status]').val($(this).data('value'))
            $(this).closest('form').submit()
        })

        $(document).on('click', '.__component_list li a', function() {
            $(this).parents('.input-group-btn').find('.selected-type').text($(this).text())
            $('input[name="component"]').val($(this).data('value'))
            $(this).closest('form').submit()
        })
    });
</script>
