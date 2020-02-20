
@section('page_title')
    <h2>{{ $theme->getTitle() }} - {{ $config->get('_configTitle', xe_trans('xe::default')) }}</h2>
@stop

@section('page_description')
    <small>{{xe_trans('xe::themeSettingsDescription')}}</small>
@stop

<div class="container-fluid container-fluid--part">
    <div class="row">
        <div class="col-sm-12">
            <form id="setting-form" class="form" role="form" action="{{ route('settings.theme.config', ['theme'=>request()->get('theme')]) }}" method="post" enctype="multipart/form-data">
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

                <div class="panel-group">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label>{{xe_trans('xe::headerHtml')}} <small>{{xe_trans('xe::headerHtmlDescription')}}</small></label>
                                        </div>
                                        {!! uio('langTextArea', ['placeholder'=>'', 'langKey'=>Request::old('_configHeaderHtml', $config->get('_configHeaderHtml')), 'name'=>'_configHeaderHtml']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label>{{xe_trans('xe::footerHtml')}} <small>{{xe_trans('xe::footerHtmlDescription')}}</small></label>
                                        </div>
                                        {!! uio('langTextArea', ['placeholder'=>'', 'langKey'=>Request::old('_configFooterHtml', $config->get('_configFooterHtml')), 'name'=>'_configFooterHtml']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{ csrf_field() }}
                {{ method_field('put') }}

                <div class="pull-right">
                    <button type="button" class="__xe_btn-delete btn btn-danger">{{xe_trans('xe::delete')}}</button>
                    <button type="submit" class="btn btn-primary">{{xe_trans('xe::save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="addConfig" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form action="{{ route('settings.theme.config') }}" method="post">
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
        {{--var $configUrl = '{{ route('settings.theme.config') }}'--}}
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
