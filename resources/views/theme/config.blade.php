
@section('page_title')
    <h2>{{ $theme->getTitle() }} - {{ $config->get('_configTitle', xe_trans('xe::default')) }}</h2>
@stop

@section('page_description')
    <p>{{xe_trans('xe::themeSettingsDescription')}}<br><br></p>
@stop

@section('content_bread_crumbs')
    <li><a href="{{ route('settings') }}">Home</a></li>

    <li><i class="xi-angle-right"></i>
    @if($theme->getSettingsURI())
    <a href="{{ $theme->getSettingsURI() }}">{{ $theme->getTitle() }}</a>
    @else
    {{ $theme->getTitle() }}
    @endif
    </li>

    <li><i class="xi-angle-right"></i><a href="#">{{ $config->get('_configTitle', xe_trans('xe::default')) }} {{xe_trans('xe::settings')}}</a></li>
@stop
<div class="row">
    <div class="col-sm-12">
        <form id="setting-form" role="form" action="{{ route('settings.theme.setting', ['theme'=>request()->get('theme')]) }}" method="post" enctype="multipart/form-data">
            <div class="panel-group">
                <div class="panel">
                    {{--<div class="panel-heading">--}}
                        {{--<div class="pull-left">--}}
                            {{--<h3 class="panel-title">{{xe_trans('xe::selectThemeInstance')}}</h3>--}}
                            {{--<p>{{xe_trans('xe::selectThemeInstanceDescription', ['count' => count($configList)])}}</p>--}}
                        {{--</div>--}}
                        {{--<div class="pull-right">--}}
                            {{--<button type="button" data-toggle="modal" data-target="#addConfig" class="btn btn-primary">{{xe_trans('xe::add')}}</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="panel-body">
                        {{--{{ uio('formSelect', ['label'=>xe_trans('xe::msgSelectThemeInstance'), 'id'=> '__xe_selectConfig', 'name'=>'_configId', 'options'=> $configList, 'selected'=>request()->get('theme')]) }}--}}
                        <input type="hidden" name="_configId" value="{{ request()->get('theme') }}">
                        {{ uio('formText', ['name'=>'_configTitle', 'value' => $config->get('_configTitle', xe_trans('xe::default')), 'label'=>xe_trans('xe::changeThemeInstanceName')]) }}
                    </div>
                </div>
            </div>

            {!! $theme->renderSetting() !!}

            {{ csrf_field() }}
            {{ method_field('put') }}

            <div class="pull-right">
                <button type="button" class="__xe_btn-delete btn btn-danger">{{xe_trans('xe::delete')}}</button>
                <button type="submit" class="btn btn-primary">{{xe_trans('xe::save')}}</button>
            </div>
        </form>
    </div>
</div>

<div id="addConfig" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form action="{{ route('settings.theme.setting.create') }}" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{xe_trans('xe::addNewThemeInstance')}}</h4>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="theme" value="{{ $theme->getId() }}">
                    {{ csrf_field() }}
                    {{ uio('formText', ['label'=>xe_trans('xe::themeInstanceName'), 'name'=>'title']) }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{xe_trans('xe::cancel')}}</button>
                <button type="submit" class="btn btn-primary">{{xe_trans('xe::add')}}</button>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    jQuery(function($) {
        {{--var $configUrl = '{{ route('settings.theme.setting') }}'--}}
        {{--$('#__xe_selectConfig').change(function(){--}}
            {{--var themeId = this.value;--}}
            {{--location.href = $configUrl + '?theme=' + themeId;--}}
        {{--});--}}

        $('.__xe_btn-delete').click(function(){

            if(confirm('{{ xe_trans('xe::confirmThemeDelete') }}')) {
                $('input[name=_method]').val('delete');
                $('#setting-form').submit();
            }
            return false;
        });
    });

</script>
