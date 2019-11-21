@extends('emails.common')

@section('content')
<table style="padding:0; margin:0 auto; border:0; width:100%; background:#fff; border-spacing:0; border-collapse:collapse; table-layout:fixed;">
    <tr style="padding:0;margin:0;border:0;">
        <td style="padding:0;margin:0;border:0;width:100%;height:52px;"></td>
    </tr>
    <tr style="padding:0; margin:0; border:0;">
        <td style="padding:0; margin:0; border:0; width:100%;">
            <h2 style="padding:0; margin:0 0 20px 0; border:0; font-size:28px; line-height:36px; font-weight:bold; letter-spacing:-0.01em; word-break:keep-all; color:#333; text-align:center;">{{ xe_trans('xe::resetPassword') }}</h2>
        </td>
    </tr>
    <tr style="padding:0; margin:0; border:0;">
        <td style="padding:0; margin:0; border:0; width:100%;">
            <p style="padding:0; margin:0; border:0; text-align: center;">{{ xe_trans('xe::msgResetPassword') }}</p>
        </td>
    </tr>
    <tr>
        <td style="padding:40px 0 0 0; margin:0; border:0; width:100%; text-align: center;">
            <a href="{{ route('auth.password', ['token' => $token, 'email' => $user->getEmailForPasswordReset()]) }}" target="_blank" style="display:inline-block; padding:9px 52px; margin:0; border:0; border-radius: 3px; font-size:15px; color:#fff; text-decoration:none; text-align:center; background:#345bd9">{{ xe_trans('xe::resetPassword') }}</a>
        </td>
    </tr>
    <tr style="padding:0;margin:0;border:0;">
        <td style="padding:0;margin:0;border:0;width:100%;height:52px;"></td>
    </tr>
</table>
@endsection
