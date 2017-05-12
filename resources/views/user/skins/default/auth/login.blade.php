<!-- 로그인 폼  -->
<div class="member">
    <h1>{{xe_trans('xe::doLogin')}}</h1>
    <form action="{{ route('login') }}" method="post" {{--data-rule="{{ $loginRuleName }}"--}}>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="redirectUrl" value="{{ $redirectUrl or '' }}">
        <fieldset>
            <legend>{{xe_trans('xe::doLogin')}}</legend>
            <div class="auth-group {{--wrong--}}">
                <label for="name" class="xe-sr-only">{{xe_trans('xe::email')}}</label>
                <input name="email" type="text" id="name" class="xe-form-control" value="{{ old('email') }}" placeholder="{{xe_trans('xe::email')}}">
                {{--<em class="text-message">잘못된 이메일 주소입니다. 이메일 주소를 확인하시고 다시 입력해주세요.</em>--}}
            </div>
            <div class="auth-group">
                <label for="pwd" class="xe-sr-only">{{xe_trans('xe::password')}}</label>
                <input name="password" type="password" id="pwd" class="xe-form-control" placeholder="{{xe_trans('xe::password')}}">
                <p><a href="{{ route('auth.reset') }}" class="xe-pull-right">{{xe_trans('xe::forgotPassword')}}</a></p>
            </div>
            <label class="xe-label xe-input-group">
                <input type="checkbox" class="__xe_keep_login" id="chk" name="remember">
                <span class="xe-input-helper"></span>
                <span class="xe-label-text">{{xe_trans('xe::keepLogin')}}</span>
            </label>
            <!--[D] 체크 시 하단메시지 노출-->
            <p class="auth-noti" id="__xe_infoRemember" style="display: none;">
                {{xe_trans('xe::keepLoginDescription')}}
            </p>



            {{-- recaptcha--}}
            @if($config['useCaptcha'] === true)
                {!! uio('captcha') !!}
            @endif

            <button type="submit" class="xe-btn xe-btn-primary xe-btn-block">{{xe_trans('xe::login')}}</button>
        </fieldset>
    </form>
    <p class="auth-text">{{xe_trans('xe::signUpSite')}} <a href="{{ route('auth.register') }}">{{xe_trans('xe::signUp')}}</a></p>
</div>
<!-- //로그인 폼  -->

{!! app('xe.frontend')->html('user.keep_login')->content("<script>
    $(function($) {
        $('.__xe_keep_login').change(function() {
            if(this.checked) {
                $('#__xe_infoRemember').slideDown();
            } else {
                $('#__xe_infoRemember').slideUp();
            }
        })
    });

</script>")->load()  !!}
