@include('editor.global._title')

<div class="container-fluid container-fluid--part">
    @include('editor.global._tab', ['_active' => 'detail'])
</div>

<div class="container-fluid container-fluid--part">
    <div class="panel-group" role="tablist" aria-multiselectable="true">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ xe_trans('xe::detailSettings') }}</h3>
                </div>
            </div>
            <div class="panel-collapse collapse in">
                <form method="post" action="{{ route('settings.editor.global.detail') }}">
                    {{ csrf_field() }}
                    <div class="panel-body">

                        <div class="panel">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h4 class="panel-title">{{ xe_trans('xe::defaultSettings') }}</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="clearfix">
                                                <label>
                                                    {{ xe_trans('xe::editorHeight') }}
                                                    <small> {{ xe_trans('xe::unit') }}: px</small>
                                                </label>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="height" value="{{ $config->get('height') }}">
                                                <span class="input-group-addon">px</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="clearfix">
                                                <label>
                                                    {{ xe_trans('xe::fontSize') }}
                                                    <small>{{ xe_trans('xe::explainFontSize') }}</small>
                                                </label>
                                            </div>
                                            <input type="text" class="form-control" name="fontSize" value="{{ $config->get('fontSize') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="clearfix">
                                                <label>
                                                    {{ xe_trans('xe::fontFamily') }}
                                                    <small>{{ xe_trans('xe::explainFontFamily') }}</small>
                                                </label>
                                            </div>
                                            <input type="text" class="form-control" name="fontFamily" value="{{ $config->get('fontFamily') }}" placeholder="Ex) Tahoma, Geneva, sans-serif">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="clearfix">
                                                <label>
                                                    CSS
                                                    <small>{{ xe_trans('xe::explainStylesheet') }}</small>
                                                </label>
                                            </div>
                                            <input type="text" class="form-control" name="stylesheet" value="{{ $config->get('stylesheet') }}" placeholder="Ex) plugin/myplugin/assets/some.css">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="panel">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h4 class="panel-title">{{ xe_trans('xe::file') }}</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="clearfix">
                                                <label>
                                                    {{ xe_trans('xe::enableUpload') }}
                                                </label>
                                            </div>
                                            <label>
                                                <input type="checkbox" name="uploadActive" value="1" {{ $config->get('uploadActive') ? 'checked' : '' }}>
                                                {{ xe_trans('xe::explainEnableUpload') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="clearfix">
                                                <label>
                                                    {{ xe_trans('xe::availableExtension') }}
                                                    <small>{{ xe_trans('xe::explainAvailableExtension') }}</small>
                                                </label>
                                            </div>
                                            <input type="text" class="form-control" name="extensions" value="{{ $config->get('extensions') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="clearfix">
                                                <label>
                                                    {{ xe_trans('xe::maxFileSize') }}
                                                    <small>{{ xe_trans('xe::descMaxFileSize') }}</small>
                                                </label>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="fileMaxSize" value="{{ $config->get('fileMaxSize') }}">
                                                <span class="input-group-addon">MB</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="clearfix">
                                                <label>
                                                    {{ xe_trans('xe::attachMaxSize') }}
                                                    <small>{{ xe_trans('xe::descAttachMaxSize') }}</small>
                                                </label>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="attachMaxSize" value="{{ $config->get('attachMaxSize') }}">
                                                <span class="input-group-addon">MB</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="clearfix">
                                            <label>{{ xe_trans('xe::phpIniSettings') }}</label>
                                        </div>

                                        <div class="clearfix">
                                            <label>upload_max_filesize</label>
                                            <small>{{ xe_trans('xe::descUploadMaxFilesize', ['fileMaxSize' => xe_trans('xe::maxFileSize'), 'attachMaxSize' => xe_trans('xe::attachMaxSize')]) }}</small>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="{{ $uploadMaxSize }}" disabled>
                                                <span class="input-group-addon">MB</span>
                                            </div>
                                        </div>

                                        <div class="clearfix">
                                            <label>post_max_size</label>
                                            <small>{{ xe_trans('xe::descPostMaxSize') }}</small>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="{{ $postMaxSize }}" disabled>
                                                <span class="input-group-addon">MB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary">{{ xe_trans('xe::save') }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
