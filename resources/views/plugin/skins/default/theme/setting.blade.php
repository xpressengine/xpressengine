@section('page_title')
    <h2>{{ xe_trans('xe::settingTheme') }}</h2>
@stop

@section('page_description')
    <small>{!! xe_trans('xe::settingThemeDescription') !!}</small>
@endsection

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
