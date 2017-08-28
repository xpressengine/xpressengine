<!--회원가입하기 기본폼 -->
<div class="member">
    <h1>{{xe_trans('xe::signUp')}}</h1>

    @if($config->get('guard_forced') === false)
        <a href="{{ route('auth.register', ['token'=>'free']) }}">이메일 주소로 회원 가입</a>
    @endif

    @foreach($guards as $guard)
        @if($guard['activated'])
        {!! value($guard['render']) !!}
        @endif
    @endforeach

    <p class="auth-text">{{xe_trans('xe::alreadyHaveAccount')}} <a href="{{ route('login') }}">{{xe_trans('xe::login')}}</a></p>
</div>
<!--// 회원가입하기 기본폼 -->
