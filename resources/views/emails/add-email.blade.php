@extends('emails.common')

@section('content')
<table style="padding:0; margin:0 auto; border:0; width:100%; background:#fff; border-spacing:0; border-collapse:collapse; table-layout:fixed;">
    <tr style="padding:0;margin:0;border:0;">
        <td style="padding:0;margin:0;border:0;width:100%;height:52px;"></td>
    </tr>
    <tr style="padding:0; margin:0; border:0;">
        <td style="padding:0; margin:0; border:0; width:100%;">
            <h2 style="padding:0; margin:0 0 20px 0; border:0; font-size:28px; line-height:36px; font-weight:bold; letter-spacing:-0.01em; word-break:keep-all; color:#333; text-align:center;">{{ xe_trans('xe::emailConfirm') }}</h2>
        </td>
    </tr>

    <tr style="padding:0; margin:0; border:0;">
        <td style="padding:0; margin:0; border:0; width:100%;">
            <p style="padding:0; margin:0; border:0;">
                {!! xe_trans('xe::confirmEmailForAddEmailDescription') !!}
            </p>
        </td>
    </tr>

    <tr style="padding:0; margin:0; border:0;">
        <td style="padding:40px 0 0; margin:0; border:0; width:100%;">
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
                    <tr style="padding:0; margin:0; border:0;">
                            <td style="padding:0; margin:0; border: solid 1px #e5e5e5; width:120px; height:35px; background-color:#f4f5f7; text-align:center; font-size:14px;">{{ xe_trans('xe::confirmCode') }}</td>
                            <td style="padding:0 0 0 20px; border: solid 1px #e5e5e5; border-left:none;">{{ $mail->confirmation_code }}</td>
                        </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <tr>
        <td style="padding:40px 0 0 0; margin:0; border:0; width:100%; text-align: center;">
            <a href="" target="_blank" style="display:inline-block; padding:9px 52px; margin:0; border:0; border-radius: 3px; font-size:15px; color:#fff; text-decoration:none; text-align:center; background:#345bd9">{{ xe_trans('xe::confirmation') }}</a>
        </td>
    </tr>
    <tr style="padding:0;margin:0;border:0;">
        <td style="padding:0;margin:0;border:0;width:100%;height:52px;"></td>
    </tr>
</table>
@endsection

{{-- @section('content')
<table cellpadding="0" cellspacing="0" style="width:100%;margin:0 auto;background-color:#fff;-webkit-text-size-adjust:100%;text-align:left">
    <tbody>

        <tr>
            <td style="font-family: NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;line-height:34px;vertical-align:top;color:#2c2e37;font-size:30px;letter-spacing:-1px">
                {{ xe_trans('xe::emailConfirm') }}
            </td>
        </tr>
        <tr>
            <td height="47"></td>
        </tr>
        <tr>
            <td style="font-family:NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;line-height:34px;vertical-align:top;color:#2c2e37;font-size:16px">
                {!! xe_trans('xe::confirmEmailForAddEmailDescription') !!}
            </td>
        </tr>
        <tr>
            <td height="5"></td>
        </tr>
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" style="width:100%;margin:0 auto;-webkit-text-size-adjust:100%;text-align:left;border:1px solid #EDF0F2">
                    <tbody>
                        <tr>
                            <td height="20" colspan="3"></td>
                        </tr>
                        <tr>
                            <td width="20" style="line-height: 0;font-size: 0;background-color:#fff;">
                                &nbsp;
                            </td>
                            <td>
                                <table cellpadding="0" cellspacing="0" style="width:100%;margin:0 auto;-webkit-text-size-adjust:100%;text-align:left">
                                    <tbody>
                                        <tr>
                                            <th width="80" style="height:24px;font-family:NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;font-size:13px;text-align:left;color:#8e8e93;font-weight:normal;vertical-align:top;line-height:21px;">{{ xe_trans('xe::account').' '.xe_trans('xe::email') }}</th>
                                            <td style="height:24px;font-family:NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;color:#2c2e37;font-size:13px;text-align:left;word-break: break-all;vertical-align:top;line-height:21px;">{{ $mail->address }}</td>
                                        </tr>
                                        <tr>
                                            <th width="80" style="height:24px;font-family:NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;font-size:13px;text-align:left;color:#8e8e93;font-weight:normal;vertical-align:top;line-height:21px;">{{ xe_trans('xe::confirmCode') }}</th>
                                            <td style="height:24px;font-family:NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;color:#2c2e37;font-size:13px;text-align:left;word-break: break-all;vertical-align:top;line-height:21px;"><span style="color:#6f8dff;">{{ $mail->confirmation_code }}</span></td>
                                        </tr>
                                        <td height="35">
                                        </td>
                                        <tr>
                                            <td colspan="2" align="center">
                                                <!--[D]  텍스트 사이즈에 따라 width 변경해야 함 or 300px 미만의 넉넉한 사이즈로 지정-->
                                                <div style="display:inline-block;width:100px;max-width:100%;vertical-align:top; margin:0 auto">
                                                    <table style="table-layout:fixed;width:100%;text-align:center" border="0" cellpadding="0" cellspacing="0">
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding:0">
                                                                    <table style="table-layout:fixed;width:100%;background:#6F8DFF" border="0" cellpadding="0" cellspacing="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="42" style="text-align:center">
                                                                                    <a href="{{ route('auth.confirm', ['email' => $mail->address, 'code' => $mail->confirmation_code]) }}" target="_blank" style="display:block;height:42px;font-size:15px;color:#fff;text-decoration:none;line-height:42px;font-family:NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;">{{ xe_trans('xe::confirmation') }}</a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width="20" style="line-height: 0;font-size: 0;background-color:#fff;">
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td height="10" colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
@endsection --}}
