<div class="panel">
    <div class="panel-body">
        <form id="fSetting" class="form" method="post" action="{{ route('settings.member.setting.join') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label>회원 가입 허용</label>
                <div class="radio mg-reset mg-bottom">
                    <label class="radio-inline">
                        <input type="radio" name="joinable" value="true" @if($config->get('joinable')) checked="checked" @endif>  허용
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="joinable" value="false" @if(!$config->get('joinable')) checked="checked" @endif> 허용 안함
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>이메일 인증 사용</label>
                <div class="radio mg-reset mg-bottom">
                    <label class="radio-inline">
                        <input type="radio" name="useEmailCertify" value="true" @if($config->get('useEmailCertify')) checked="checked" @endif>  사용
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="useEmailCertify" value="false" @if(!$config->get('useEmailCertify')) checked="checked" @endif> 사용 안함
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="">회원 가입 약관</label>
                <textarea id="agreement" class="form-control" name="agreement" rows="10">{{ $config->get('agreement') }}</textarea>
            </div>
            <div class="form-group">
                <label>가입시 CAPTCHA 사용</label>
                <div class="radio">
                    <label class="radio-inline">
                        <input type="radio" name="useCaptcha" value="true" @if($config->get('useCaptcha')) checked="checked" @endif> 사용
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="useCaptcha" value="false" @if(!$config->get('useCaptcha')) checked="checked" @endif>
                        사용 안함
                    </label>
                </div>
            </div>

            {{--<div class="form-group">
                <label>추가 필드</label>
                <div class="panel panel-default">
                    <div class="panel-body">
                        {!! $dynamicFieldSection !!}
                    </div>
                </div>
            </div>--}}
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
{!! uio('uiobject/xpressengine@chakIt', 'Settings:회원설정') !!}
