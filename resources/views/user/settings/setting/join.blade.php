<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
        <form id="fSetting" class="form" method="post" action="{{ route('settings.user.setting.join') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::joinSettings')}}</h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="item-url">{{xe_trans('xe::permitSignUp')}}</label>
                        <div class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="joinable" value="true" @if($config->get('joinable')) checked="checked" @endif> {{xe_trans('xe::allow')}}
                                </label>
                                <label>
                                    <input type="radio" name="joinable" value="false" @if(!$config->get('joinable')) checked="checked" @endif> {{xe_trans('xe::deny')}}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="item-url">{{xe_trans('xe::useEmailConfirm')}}</label>
                        <div class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="useEmailCertify" value="true" @if($config->get('useEmailCertify')) checked="checked" @endif>  {{xe_trans('xe::use')}}
                                </label>
                                <label>
                                    <input type="radio" name="useEmailCertify" value="false" @if(!$config->get('useEmailCertify')) checked="checked" @endif> {{xe_trans('xe::disuse')}}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="item-url">{{xe_trans('xe::useSignUpCaptcha')}}</label>
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
                            {!! xe_trans('xe::msgAlertCaptchaAtJoin') !!}
                        </div>
                        @endif
                    </div>
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
