<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
            <form role="form" action="{{ route('settings.setting.update') }}" method="post" id="__xe_settingForm" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::siteDefaultSettings')}}</h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                    </div>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">

                        {{-- 사이트 제목 --}}
                        <div class="form-group">
                            <label>{{ xe_trans('xe::site')}} {{ xe_trans('xe::title') }}</label>
                            {!! uio('langText', ['placeholder'=>xe_trans('xe::inputBrowserTitle'), 'langKey'=>$config->get('site_title', null), 'name'=>'site_title']) !!}
                        </div>

                        {{-- 파비콘 --}}
                        {!! uio('formFile', ['name' => 'favicon', 'label' => xe_trans('xe::favicon'), 'value' => $config->get('favicon'), 'width' => 80, 'height' => 80, 'types' => ['ico','png'], 'fileuploadOptions' => [ 'maxFileSize' => 10000000 ] ]) !!}

                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-lg">{{xe_trans('xe::save')}}</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

