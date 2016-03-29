<!-- 로그인 폼  -->
<div class="member">
    <h1>계정에 로그인</h1>
    <form action="{{ route('login') }}" method="post" {{--data-rule="{{ $loginRuleName }}"--}}>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="redirectUrl" value="{{ $redirectUrl or '' }}">
        <fieldset>
            <legend>로그인</legend>
            <div class="auth_group {{--wrong--}}">
                <label for="name" class="blind">이메일 주소 / 사용자 이름</label>
                <input name="email" type="text" id="name" class="inpt_txt" value="{{ old('email') }}" placeholder="이메일 주소 / 사용자 이름">
                {{--<em class="txt_message">잘못된 이메일 주소입니다. 이메일 주소를 확인하시고 다시 입력해주세요.</em>--}}
            </div>
            <div class="auth_group">
                <label for="pwd" class="blind">비밀번호</label>
                <input name="password" type="password" id="pwd" class="inpt_txt" placeholder="비밀번호">
            </div>
            <div class="inpt_group">
                <!--[D] 로그인 유지가 기본인 경우 inpuit에 "disabled="disabled"추가-->
                <!--[D] 다른 inpt_group과 다르게 label(for=""), input(id="")  같은 값으로 매칭-->
                <input type="checkbox" id="chk" name="remember">
                <label for="chk" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="__xe_infoRemember" data-target="#__xe_infoRemember"><span>로그인 유지하기</span></label>
                <a href="{{ route('auth.reset') }}" class="pull-right">암호를 잊었습니까?</a>
                <!--[D] 체크 시 하단메시지 노출-->
                <div class="auth_noti collapse" id="__xe_infoRemember">
                    <p>브라우저를 닫더라도 로그인이 계속 유지될 수 있습니다. 로그인 유지 기능을 사용할 경우 다음 접속부터는 로그인할 필요가 없습니다. 단, 게임방, 학교 등 공공장소에서 이용 시 개인정보가 유출될 수 있으니 꼭 로그아웃을 해주세요.</p>
                </div>
            </div>

            {{-- recaptcha--}}
            @if($config['useCaptcha'] === true)
                {!! uio('captcha') !!}
            @endif

            <button type="submit" class="btn btn_blue">로그인</button>
        </fieldset>
    </form>
    {{--<div class="hr">
        <p class="txt_hr"><span>or</span></p>
    </div>
    <div class="auth_sns">
        <ul>
            <li class="sns_facebook"><a href="#"><i class="xi-facebook"></i></a></li>
            <li class="sns_twitter"><a href="#"><i class="xi-twitter"></i></a></li>
            <li class="sns_naver"><a href="#"><i class="xi-naver"></i></a></li>
            <li class="sns_google"><a href="#"><i class="xi-google-plus"></i></a></li>
            <li class="sns_github"><a href="#"><i class="xi-github"></i></a></li>
            <li class="sns_line"><a href="#"><i class="xi-line-messenger"></i></a></li>
        </ul>
    </div>--}}
    <p class="auth_txt">아직 회원이 아닙니까? <a href="{{ route('auth.register') }}">회원가입하기</a></p>
</div>
<!-- //로그인 폼  -->
