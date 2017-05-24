<!--회원가입하기 기본폼 -->
<div class="member">
    <h1>{{xe_trans('xe::signUp')}}</h1>

    @foreach($guards as $guard)
        {!! $guard() !!}
    @endforeach

    <p class="auth-text">{{xe_trans('xe::alreadyHaveAccount')}} <a href="{{ route('login') }}">{{xe_trans('xe::login')}}</a></p>
</div>
<!--// 회원가입하기 기본폼 -->
