@extends('emails.common')

@section('content')
    <a href="{{ route('auth.approve_email', ['token' => $token->id, 'code' => $mail->confirmation_code]) }}" class="xe-btn">{{ xe_trans('xe::confirmation') }}</a>
@endsection
