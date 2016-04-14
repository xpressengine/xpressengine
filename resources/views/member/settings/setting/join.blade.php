<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
        <form id="fSetting" class="form" method="post" action="{{ route('settings.member.setting.join') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">회원 가입 설정</h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="item-url">회원 가입 허용</label>
                        <div class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="joinable" value="true" @if($config->get('joinable')) checked="checked" @endif> 허용
                                </label>
                                <label>
                                    <input type="radio" name="joinable" value="false" @if(!$config->get('joinable')) checked="checked" @endif> 허용 안함
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="item-url">이메일 인증 사용</label>
                        <div class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="useEmailCertify" value="true" @if($config->get('useEmailCertify')) checked="checked" @endif>  사용
                                </label>
                                <label>
                                    <input type="radio" name="useEmailCertify" value="false" @if(!$config->get('useEmailCertify')) checked="checked" @endif> 사용 안함
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="item-url">가입 CAPTCHA 사용</label>
                        <div class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="useCaptcha" value="false" @if(!$config->get('useCaptcha')) checked="checked" @endif> 사용
                                </label>
                                <label>
                                    <input type="radio" name="useCaptcha" value="false" @if(!$config->get('useCaptcha')) checked="checked" @endif> 사용 안함
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="xi-download"></i>저장</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
