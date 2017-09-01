<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <form role="form" action="{{ route('settings.plugins.setting.update') }}" method="post" id="__xe_settingForm" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">플러그인 설정</h3>
                        </div>
                        <div class="pull-right">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">{{xe_trans('xe::fold')}}</span></a>
                        </div>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            {{ uio('formText', ['name'=>'site_token', 'value'=>old('site_token', $config->get('site_token')), 'label'=>'사이트 토큰', 'description'=>'<a href="https://store.xpressengine.io" target="_blank">XE3 공식 자료실</a>에 등록하신 사이트의 토큰을 입력하세요. 자료실에서 구매한 유료 플러그인을 설치할 때 필요합니다.']) }}
                            @if(!getenv('COMPOSER_HOME') && !getenv('HOME'))
                            {{ uio('formText', ['name'=>'composer_home', 'value'=>old('composer_home', $config->get('composer_home')), 'label'=>'컴포저 홈 디렉토리', 'description'=>'플러그인을 설치할 때 컴포저를 사용합니다. 서버에 설치한 컴포저의 홈디렉토리를 지정하셔야 정상적으로 설치됩니다.']) }}
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

