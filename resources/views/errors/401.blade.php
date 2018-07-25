@extends("{$path}._frame")

@section('content')
<div class="login-header error-{{ $exception->getStatusCode() }}">
    <i class="xi-error-o xi-5x"></i>
    @if(!Auth::check() && $exception instanceof \Xpressengine\Support\Exceptions\AccessDeniedHttpException)
        <h1>{{ xe_trans('xe::tryAfterLogin') }}</h1>
    @else
        <h1>{!! $exception->getMessage() !!}</h1>
    @endif
</div>
<div class="login-body">
    <p>
        @if(!Auth::check())<a href="{{ route('login') }}">{{ xe_trans('xe::login') }}</a>@endif
        @if(Auth::check())<a href="{{ url()->previous() === url()->current() ? url('/') : url()->previous() }}">{{ xe_trans('xe::back') }}</a>@endif
    </p>
</div>
<div class="login-footer">
    @if(Auth::check())
        <a href="{{ route('logout') }}">{{ xe_trans('xe::logout') }}</a>
    @else
    <a href="{{ route('auth.reset') }}">{{xe_trans('xe::findPassword')}}</a>
    <span class="bar">|</span>
    <a href="{{ route('auth.register') }}"><span>{{xe_trans('xe::signUp')}}</span></a>
    @endif
</div>
@stop