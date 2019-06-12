<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <form id="fSetting" method="post" action="{{ route('settings.user.setting') }}">
                <div class="panel">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="panel-heading">
                        <h3>{{xe_trans('xe::userDefaultSetting')}}</h3>
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
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-heading">
                        <h3>{{xe_trans('xe::joinSettings')}}</h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label>{{xe_trans('xe::permitSignUp')}}</label>
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
                            <label>{{ xe_trans('xe::emailConfirm') }}</label>
                            <div class="list-group-item">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="guard_forced" value="true" @if($config->get('guard_forced')) checked="checked" @endif> {{xe_trans('xe::use')}}
                                    </label>
                                    <label>
                                        <input type="radio" name="guard_forced" value="false" @if(!$config->get('guard_forced')) checked="checked" @endif> {{xe_trans('xe::disuse')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>회원가입 폼양식</label>
                            <div class="list-group-item">
                                @include('user.settings.setting.forms')
                            </div>
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
