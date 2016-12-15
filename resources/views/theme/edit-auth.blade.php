    @section('page_title')
        <h2>{{ xe_trans('xe::editTheme') }}</h2>
    @stop

    @section('page_description')
        {{xe_trans('xe::editThemeDescription')}}
    @stop

    <div class="row">
        <div class="col-sm-12">
            <form role="form" action="{{ route('settings.theme.edit.auth', ['theme'=>request()->get('theme')]) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="panel-group">
                    <div class="panel">
                        <div class="panel-body">
                            <p>{{ xe_trans('xe::enterPasswordForEditingTheme') }}</p>
                            <div class="form-group">
                                <label for="#password"></label>
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">{{xe_trans('xe::save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
