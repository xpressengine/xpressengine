<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <form role="form" action="{{ route('settings.plugins.setting.update') }}" method="post" id="__xe_settingForm" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{ xe_trans('xe::pluginSettings') }}</h3>
                        </div>
                        <div class="pull-right">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                        </div>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            {{ uio('formText', ['name'=>'site_token', 'value'=>old('site_token', $config->get('site_token')), 'label' => xe_trans('xe::siteToken'), 'description' => xe_trans('xe::descSiteXehubToken')]) }}
                            @if(!getenv('COMPOSER_HOME') && !getenv('HOME'))
                            {{ uio('formText', ['name'=>'composer_home', 'value'=>old('composer_home', $config->get('composer_home')), 'label' => xe_trans('xe::composerHomeDir'), 'description'=> xe_trans('xe::descComposerHomeDir')]) }}
                            @endif
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

