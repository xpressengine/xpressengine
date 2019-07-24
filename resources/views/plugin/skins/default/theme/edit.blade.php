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
                        <span class="input-group-label">테마선택</span>
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
                @foreach($files as $name => $path)
                <li role="presentation" @if($name === $editFile['fileName'])class="active"@endif>
                    <a href="{{ route('settings.theme.edit', ['theme' => $theme->getId(), 'file' => $name]) }}">{{ $name }}</a>
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

                <textarea class="form-control" rows="30" name="content" @if(request('view_origin') === 'Y') readonly="readonly" @endif>{{ old('content', $editFile['content']) }}</textarea>

                <div class="pull-right" style="margin-top:10px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#widgetModal">위젯 추가</button>
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

{!!
    XeFrontend::html('theme.insert-widget')->content("
    <script>
        jQuery(function($) {
            $('.__xe_insert_widget').click(function(){
                $('#widgetGen').widgetGenerator().generate(function(data){

                    $('#widgetModal').modal('hide');

                    // add code to textarea
                    var txt = $('textarea[name=content]');
                    var caretPos = txt[0].selectionStart;
                    var textAreaTxt = txt.val();
                    txt.val(textAreaTxt.substring(0, caretPos) + data.code + textAreaTxt.substring(caretPos) );

                });
            })
        });
    </script>
    ")->load();
!!}
