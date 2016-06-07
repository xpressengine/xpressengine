<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
            <form id="fSetting" method="post" action="{{ route('settings.member.setting') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">회원 기본 설정</h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="item-url">로그인 시 CAPTCHA</label>
                        <div class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="useCaptcha" value="true" @if($config->get('useCaptcha')) checked="checked" @endif> 사용
                                </label>
                                <label>
                                    <input type="radio" name="useCaptcha" value="false" @if(!$config->get('useCaptcha')) checked="checked" @endif> 사용 안함
                                </label>
                            </div>
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
                    <div class="form-group">
                        <label for="agreement">사이트 이용 약관</label>
                        <textarea id="agreement" class="form-control" name="agreement" cols="30" rows="5">{{ $config->get('agreement') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="privacy">사이트 개인정보 보호 정책</label>
                        <textarea class="form-control" id="privacy" name="privacy" cols="30" rows="5">{{ $config->get('privacy') }}</textarea>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary btn-lg">저장</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
