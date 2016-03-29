<div class="panel">
    <div class="panel-body">
        <form id="fSetting" method="post" action="{{ route('settings.member.setting') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label>로그인시 CAPTCHA 사용</label>
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

            <div class="form-group">
                <label for="webmasterName">웹마스터 이름</label>
                <input id="webmasterName" type="text" name="webmasterName" class="form-control" placeholder="Webmaster name" value="{{ $config->get('webmasterName') }}">
            </div>

            <div class="form-group">
                <label for="webmasterEmail">웹마스터 이메일</label>
                <input id="webmasterEmail" type="email" name="webmasterEmail" class="form-control" placeholder="Webmaster email" value="{{ $config->get('webmasterEmail') }}">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

