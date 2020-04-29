{{
    app('xe.frontend')->js([
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/codemirror.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/addon/runmode/runmode.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/addon/runmode/colorize.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/mode/xml/xml.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/mode/javascript/javascript.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/mode/css/css.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/mode/htmlmixed/htmlmixed.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/addon/selection/active-line.min.js',
    ])->load()
}}
{{
    app('xe.frontend')->css([
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/codemirror.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.51.0/theme/dracula.min.css',
    ])->load()
}}
@section('page_title')
    <h2>{{ xe_trans('xe::themeEditor') }}</h2>
@stop

@section('page_description')
    <small>{{xe_trans('xe::themeEditorDescription')}}</small>
@stop

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel admin-tab">
                <div class="panel-heading clearfix">
                    <div class="pull-left">
                        <strong class="panel-title">{{ $theme->getTitle() }}</strong>
                    </div>

                    <div class="pull-right">
                        <span class="input-group-label">{{xe_trans('xe::theme')}} {{xe_trans('xe::select')}}</span>
                        <div class="input-group search-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="selected-type">{{$theme->getTitle()}}</span>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    @foreach ($themes as $editableTheme)
                                    <li>
                                        <a href="{{route('settings.theme.edit', ['theme' => $editableTheme->getId()])}}" data-target="query"><span>{{$editableTheme->getTitle()}}</span></a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(count($files) === 0)
    @php
        $message = xe_trans('xe::themeNotSupportEdit');
    @endphp
    @include($_skin::view('empty'))
@else
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked" style="margin-bottom: 10px;">
                @foreach($files as $name => $file)
                <li role="presentation" @if($name === $editFile['fileName'])class="active"@endif>
                    <a href="{{ route('settings.theme.edit', ['theme' => $theme->getId(), 'file' => $name]) }}">{{ $name }} @if($file['hasCache'])<br><em class="xe-text-normal"><i class="xi-library-books"></i>{{ xe_trans('xe::edited') }}</em>@endif</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-10">
            <div class="clearfix" style="margin-bottom: 10px;">
                <h5 class="pull-left">
                    {{ $editFile['fileName'] }}
                    @if($editFile['hasCache'])
                        ({{ xe_trans('xe::edited') }})
                    @endif
                </h5>
                @if($editFile['hasCache'])
                    <button type="button" class="pull-right btn btn-sm btn-primary" data-toggle="modal" data-target="#resetModal">{{ xe_trans('xe::resetToOrigin') }}</button>
                @endif
            </div>
            <form role="form" action="{{ route('settings.theme.edit') }}" method="post" id="_theme">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="theme" value="{{ $theme->getId() }}">
                <input type="hidden" name="file" value="{{ $editFile['fileName'] }}">

                <textarea id="code" class="form-control" rows="30" name="content" @if(request('view_origin') === 'Y') readonly="readonly" @endif>{{ old('content', $editFile['content']) }}</textarea>

                <div class="pull-right" style="margin-top:10px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#widgetModal">{{xe_trans('xe::addWidget')}}</button>
                    <button type="submit" class="btn btn-default">{{ xe_trans('xe::applyModified') }}</button>
                </div>
            </form>
        </div>
    </div>

    {{-- widget modal --}}
    <div class="modal fade" id="widgetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ xe_trans('xe::addWidget') }}</h4>
                </div>
                <div class="modal-body">
                    {{ uio('widget', ['id'=>'widgetGen', 'show_code'=>false]) }}
                </div>
                <div class="xe-modal-footer">
                    <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="modal">{{ xe_trans('xe::cancel') }}</button>
                    <button type="button" class="xe-btn xe-btn-primary __xe_insert_widget" data-dismiss="modal">{{ xe_trans('xe::insert') }}</button>
                </div>
            </div>
        </div>
    </div>

    @if($editFile['hasCache'])
        <div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form role="form" action="{{ route('settings.theme.edit', ['reset'=>'Y']) }}" method="post" id="_theme">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="theme" value="{{ $theme->getId() }}">
                        <input type="hidden" name="file" value="{{ $editFile['fileName'] }}">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ xe_trans('xe::revertContents') }}</h4>
                        </div>
                        <div class="modal-body">
                            {{ xe_trans('xe::confirmRevertContents') }}
                        </div>
                        <div class="xe-modal-footer">
                            <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="modal">{{ xe_trans('xe::cancel') }}</button>
                            <button type="submit" class="xe-btn xe-btn-primary">{{ xe_trans('xe::confirm') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endif

@php
    $codemirrorMode = 'htmlmixed';
    $ext = $files[$editFile['fileName']]['ext'];
    if ($ext === 'css') {
        $codemirrorMode = 'css';
    }
@endphp

{!!
    XeFrontend::html('theme.insert-widget')->content("
    <script>
        jQuery(function($) {
            $('.__xe_insert_widget').click(function(){
                $('#widgetGen').widgetGenerator().generate(function(data){
                    $('#widgetModal').modal('hide');
                    editor.getDoc().replaceSelection(data.code);
                });
            })
            var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
                mode: '{$codemirrorMode}',
                theme: 'dracula',
                viewportMargin: Infinity,
                styleActiveLine: true,
                lineNumbers: true,
                lineWrapping: true,
                tabSize: 2,
            })
        });
    </script>
    ")->load();
!!}

<style>
.CodeMirror {
    height: auto;
}
</style>
