<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
            <form id="fSetting" method="post" action="{{ route('settings.user.setting') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::memberDefaultSetting')}}</h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="item-url">{{xe_trans('xe::useLoginCaptcha')}}</label>
                        <div class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="useCaptcha" value="true" @if($config->get('useCaptcha')) checked="checked" @endif> {{xe_trans('xe::use')}}
                                </label>
                                <label>
                                    <input type="radio" name="useCaptcha" value="false" @if(!$config->get('useCaptcha')) checked="checked" @endif> {{xe_trans('xe::disuse')}}
                                </label>
                            </div>
                        </div>
                        @if($captcha->available() !== true)
                            <div class="alert alert-warning" role="alert" style="margin-top:10px;">
                                {!! xe_trans('xe::masAlertCaptchaAtLogin') !!}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="webmasterName">{{xe_trans('xe::webmasterName')}}</label>
                        <input id="webmasterName" type="text" name="webmasterName" class="form-control" placeholder="Webmaster name" value="{{ $config->get('webmasterName') }}">
                    </div>
                    <div class="form-group">
                        <label for="webmasterEmail">{{xe_trans('xe::webmasterEmail')}}</label>
                        <input id="webmasterEmail" type="email" name="webmasterEmail" class="form-control" placeholder="Webmaster email" value="{{ $config->get('webmasterEmail') }}">
                    </div>
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
