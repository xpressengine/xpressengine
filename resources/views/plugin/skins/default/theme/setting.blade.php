@section('page_title')
    <h2>{{ xe_trans('xe::settingTheme') }}</h2>
@stop

@section('page_description')
    <small>{!! xe_trans('xe::settingThemeDescription') !!}</small>
@endsection

@if (file_exists(app_storage_path('theme_preview.json')))
    <a href="{{route('settings.theme.stop_preview')}}" class="xe-btn xe-btn-positive">미리보기 종료(임시)</a>
@endif
<div class="container-fluid container-fluid--part">
    <div class="row">
        <div class="col-sm-12">
            <form role="form" action="{{ route('settings.update.theme') }}" method="post" id="__xe_settingForm" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                {!! uio('themeSelect', ['selectedTheme' => $selectedTheme]) !!}

                <div class="panel-group">
                    <div class="panel">
                        <div class="panel-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{xe_trans('xe::save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
