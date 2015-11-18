<div class="login-header error-{{ $exception->getStatusCode() }}">
    <i class="xi-error-o xi-5x"></i>
    <h1>{{ $exception->getMessage() }}</h1>
</div>
<div class="login-body">
    <p>
        @if(!Auth::check())<a href="{{ route('login') }}">{{ xe_trans('xe::login') }}</a>@endif
        @if(Auth::check())<a href="{{ URL::previous() }}">{{ xe_trans('xe::back') }}</a>@endif
    </p>
</div>
<div class="login-footer">
    @if(Auth::check())
        <a href="{{ route('logout') }}">{{ xe_trans('xe::logout') }}</a>
    @else
    <a href="{{ route('auth.reset') }}">비밀번호 찾기</a>
    <span class="bar">|</span>
    <a href="{{ route('auth.register') }}"><span>회원가입</span></a>
    @endif
</div>
