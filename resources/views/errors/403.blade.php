@extends("{$path}._frame")

@section('content')
<div class="login-header error-{{ $exception->getStatusCode() }}">
    <i class="xi-error-o xi-5x"></i>
    <h1>{!! $exception->getMessage() !!}</h1>
</div>
<div class="login-body">
    @if ( URL::current() != URL::previous() )
        <p><a href="{{ URL::previous() }}">{{ xe_trans('xe::back') }}</a></p>
    @else
        <p><a href="{{ URL::to('/') }}">{{ xe_trans('xe::back') }}</a></p>
    @endif
</div>
@stop
