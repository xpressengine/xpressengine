@extends("{$path}._frame")

@section('content')
<div class="login-header error-{{ $exception->getStatusCode() }}">
    <i class="xi-error-o xi-5x"></i>
    <h1>{!! $exception->getMessage() !!}</h1>
</div>
<div class="login-body">
    <p><a href="{{ URL::previous() }}">{{ xe_trans('xe::back') }}</a></p>
</div>
@stop
