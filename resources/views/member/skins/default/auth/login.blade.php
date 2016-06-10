<!-- 로그인 폼  -->
<div class="member">
    <h1>{{xe_trans('xe::login')}}</h1>
    <form action="{{ route('login') }}" method="post" {{--data-rule="{{ $loginRuleName }}"--}}>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="redirectUrl" value="{{ $redirectUrl or '' }}">
        <fieldset>
            <legend>로그인</legend>
            <div class="auth-group {{--wrong--}}">
                <label for="name" class="sr-only">{{xe_trans('xe::emailOrUserName')}}</label>
                <input name="email" type="text" id="name" class="xe-form-control" value="{{ old('email') }}" placeholder="{{xe_trans('xe::emailOrUserName')}}">
                {{--<em class="text-message">잘못된 이메일 주소입니다. 이메일 주소를 확인하시고 다시 입력해주세요.</em>--}}
            </div>
            <div class="auth-group">
                <label for="pwd" class="sr-only">{{xe_trans('xe::password')}}</label>
                <input name="password" type="password" id="pwd" class="xe-form-control" placeholder="{{xe_trans('xe::password')}}">
            </div>
            <div class="xe-form-group">
                <!--[D] 로그인 유지가 기본인 경우 inpuit에 "disabled="disabled"추가-->
                <!--[D] 다른 xe-form-group과 다르게 label(for=""), input(id="")  같은 값으로 매칭-->
                <input type="checkbox" id="chk" name="remember">
                <label for="chk" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="__xe_infoRemember" data-target="#__xe_infoRemember"><span>{{xe_trans('xe::keepLogin')}}</span></label>
                <a href="{{ route('auth.reset') }}" class="pull-right">{{xe_trans('xe::forgotPassword')}}</a>
                <!--[D] 체크 시 하단메시지 노출-->
                <div class="auth-noti collapse" id="__xe_infoRemember">
                    <p>{{xe_trans('xe::keepLoginDescription')}}</p>
                </div>
            </div>

            {{-- recaptcha--}}
            @if($config['useCaptcha'] === true)
                {!! uio('captcha') !!}
            @endif

            <button type="submit" class="xe-btn xe-btn-primary">{{xe_trans('xe::login')}}</button>
        </fieldset>
    </form>
    {{--<div class="hr">
        <p class="txt_hr"><span>or</span></p>
    </div>
    <div class="auth-sns">
        <ul>
            <li class="sns_facebook"><a href="#"><i class="xi-facebook"></i></a></li>
            <li class="sns-twitter"><a href="#"><i class="xi-twitter"></i></a></li>
            <li class="sns-naver"><a href="#"><i class="xi-naver"></i></a></li>
            <li class="sns-google"><a href="#"><i class="xi-google-plus"></i></a></li>
            <li class="sns-github"><a href="#"><i class="xi-github"></i></a></li>
            <li class="sns-line"><a href="#"><i class="xi-line-messenger"></i></a></li>
        </ul>
    </div>--}}
    <p class="auth-text">{{xe_trans('xe::signUpSite')}} <a href="{{ route('auth.register') }}">{{xe_trans('xe::signUp')}}</a></p>
</div>
<!-- //로그인 폼  -->
