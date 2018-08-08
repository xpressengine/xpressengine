<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <form role="form" action="{{ route('settings.setting.theme') }}" method="post" id="__xe_settingForm" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{xe_trans('xe::siteDefaultTheme')}} <small>{{xe_trans('xe::siteDefaultThemeDescription')}}</small></h3>
                        </div>
                        <div class="pull-right">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                        </div>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in">
                        {!! uio('themeSelect', ['selectedTheme' => $selectedTheme]) !!}
                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-lg">{{xe_trans('xe::save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
