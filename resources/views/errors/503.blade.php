@extends("{$path}._frame")

@section('content')
<div class="login-header error-{{ $exception->getStatusCode() }}">
    <i class="xi-error-o xi-5x"></i>
    <h1>공사중!</h1>
</div>

<div class="login-body">
    <p><a href="{{ URL::previous() }}">뒤로가기</a></p>
</div>
@stop
