@include('editor._title')

@include('editor._tab', ['_active' => 'detail', 'instanceId' => $instanceId])

<div class="panel-group" role="tablist" aria-multiselectable="true">
    <div class="panel">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">{{ xe_trans('xe::detailSettings') }}</h3>
                <small><a href="{{ route('settings.editor.global.detail') }}" target="_blank">{{xe_trans('xe::moveToParentSettingPage')}}</a></small>
            </div>
        </div>
        <div class="panel-collapse collapse in">
            <form method="post" id="f-editor-setting" action="{{ route('settings.editor.setting.detail', $instanceId) }}">
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
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="__xe_inherit" {{ !$config->getPure('height')? 'checked' : '' }}>
                                                    {{ xe_trans('xe::inheritMode') }}
                                                </label>
                                            </div>
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
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="__xe_inherit" {{ !$config->getPure('fontSize')? 'checked' : '' }}>
                                                    {{ xe_trans('xe::inheritMode') }}
                                                </label>
                                            </div>
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
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="__xe_inherit" {{ !$config->getPure('fontFamily')? 'checked' : '' }}>
                                                    {{ xe_trans('xe::inheritMode') }}
                                                </label>
                                            </div>
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
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="__xe_inherit" {{ !$config->getPure('stylesheet')? 'checked' : '' }}>
                                                    {{ xe_trans('xe::inheritMode') }}
                                                </label>
                                            </div>
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
                                                <small>{{ xe_trans('xe::explainEnableUpload') }}</small>
                                            </label>
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="__xe_inherit" {{ $config->getPure('uploadActive') === null ? 'checked' : '' }}>
                                                    {{ xe_trans('xe::inheritMode') }}
                                                </label>
                                            </div>
                                        </div>
                                        <select name="uploadActive" class="form-control">
                                            <option value="1" {{ $config->get('uploadActive') ? 'selected' : '' }}>{{ xe_trans('xe::use') }}</option>
                                            <option value="0" {{ $config->get('uploadActive') ? '' : 'selected' }}>{{ xe_trans('xe::disuse') }}</option>
                                        </select>
                                        {{--<label>--}}
                                            {{--<input type="checkbox" name="uploadActive" value="1" {{ $config->get('uploadActive') ? 'checked' : '' }}>--}}
                                            {{--{{ xe_trans('xe::explainEnableUpload') }}--}}
                                        {{--</label>--}}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label>
                                                {{ xe_trans('xe::availableExtension') }}
                                                <small>{{ xe_trans('xe::explainAvailableExtension') }}</small>
                                            </label>
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="__xe_inherit" {{ !$config->getPure('extensions')? 'checked' : '' }}>
                                                    {{ xe_trans('xe::inheritMode') }}
                                                </label>
                                            </div>
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
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="__xe_inherit" {{ !$config->getPure('fileMaxSize')? 'checked' : '' }}>
                                                    {{ xe_trans('xe::inheritMode') }}
                                                </label>
                                            </div>
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
                                            <div class="checkbox pull-right">
                                                <label>
                                                    <input type="checkbox" class="__xe_inherit" {{ $config->getPure('attachMaxSize') === null ? 'checked' : '' }}>
                                                    {{ xe_trans('xe::inheritMode') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="attachMaxSize" value="{{ $config->get('attachMaxSize') }}">
                                            <span class="input-group-addon">MB</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="clearfix">
                                        <label>php.ini 설정 값</label>
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

<script>
  window.jQuery(function ($) {
    $('.__xe_inherit', '#f-editor-setting').click(function (e) {
      var $group = $(this).closest('.form-group');
      $('input,select,textarea', $group).not(this).prop('disabled', $(this).is(':checked'));
    }).each(function () {
      $(this).triggerHandler('click');
    });
  });
</script>
