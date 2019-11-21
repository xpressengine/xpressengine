@extends('emails.common')

@section('content')
<table style="padding:0; margin:0 auto; border:0; width:100%; background:#fff; border-spacing:0; border-collapse:collapse; table-layout:fixed;">
    <tr style="padding:0;margin:0;border:0;">
        <td style="padding:0;margin:0;border:0;width:100%;height:52px;"></td>
    </tr>
    <tr style="padding:0; margin:0; border:0;">
        <td style="padding:0; margin:0; border:0; width:100%;">

            <h2 style="padding:0; margin:0 0 20px 0; border:0; font-size:28px; line-height:36px; font-weight:bold; letter-spacing:-0.01em; word-break:keep-all; color:#161616;">회원가입을 축하드립니다</h2>
        </td>
    </tr>

    <tr style="padding:0; margin:0; border:0;">
        <td style="padding:0; margin:0; border:0; width:100%; color:#313131;">
            <p style="padding:0; margin:0; border:0;">안녕하세요. 회원가입을 진심으로 환영합니다 :)</p>
            <p style="padding:0; margin:0; border:0;">회원님의 가입정보는 다음과 같습니다.</p>
        </td>
    </tr>

    <tr style="padding:0; margin:0; border:0;">
        <td style="padding:0; margin:0; border:0; width:100%;">

            <h3 style="margin:0; padding:40px 0 16px 0; font-size:15px; color:#313131;"><i style="display:inline-block; width:5px; height:5px; background-color:#313131; margin:0 16px 0 0; vertical-align:2px;"></i>가입 정보</h3>

            <table style="padding:0; margin:0 auto; border:0; max-width:536px; width:100%; background:#fff; border-spacing:0; border-collapse:collapse; table-layout:fixed;">
                <tbody style="padding:0; margin:0; border:0;">
                    <tr style="padding:0; margin:0; border:0;">
                        <td style="padding:0; margin:0; border: solid 1px #e5e5e5; width:120px; height:35px; background-color:#f4f5f7; text-align:center; font-size:14px;">{{ xe_trans('xe::email') }}</td>
                        <td style="padding:0 0 0 20px; border: solid 1px #e5e5e5; border-left:none;">{{ $mail->address }}</td>
                    </tr>
                    <tr style="padding:0; margin:0; border:0;">
                        <td style="padding:0; margin:0; border: solid 1px #e5e5e5; width:120px; height:35px; background-color:#f4f5f7; text-align:center; font-size:14px;">{{ xe_trans('xe::display_name') }}</td>
                        <td style="padding:0 0 0 20px; border: solid 1px #e5e5e5; border-left:none;">{{ $mail->display_name }}</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:64px 0 0 0; margin:0; border:0; width:100%; text-align:center;">
            <a href="{{ url('/') }}" target="_blank" style="display:inline-block; min-width:176px; padding:14px 52px; margin:0; border:0; border-radius: 3px; font-size:15px; color:#fff; text-decoration:none; text-align:center; background:#345bd9">{{ xe_trans(app('xe.site')->getSiteConfig()->get('site_title')) }}</a>
        </td>
    </tr>
    <tr style="padding:0;margin:0;border:0;">
        <td style="padding:0;margin:0;border:0;width:100%;height:52px;"></td>
    </tr>
</table>
@endsection
