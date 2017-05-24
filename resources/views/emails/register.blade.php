@extends('emails.common')

@section('content')
    <table cellpadding="0" cellspacing="0" style="width:100%;margin:0 auto;background-color:#fff;-webkit-text-size-adjust:100%;text-align:left">
        <tbody>

        <tr>
            <td style="font-family: NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;line-height:34px;vertical-align:top;color:#2c2e37;font-size:30px;letter-spacing:-1px">
                {{xe_trans('xe::emailConfirm')}}
            </td>
        </tr>
        <tr>
            <td height="47"></td>
        </tr>
        <tr>
            <td style="font-family:NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;line-height:34px;vertical-align:top;color:#2c2e37;font-size:16px">
                {!!  xe_trans('xe::confirmEmailForRegisterDescription') !!}
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
                                    <td style="height:24px;font-family:NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;color:#2c2e37;font-size:13px;text-align:left;word-break: break-all;vertical-align:top;line-height:21px;"><span style="color:#6f8dff;">{{ $mail->confirmationCode }}</span></td>
                                </tr>
                                <td height="35">
                                </td>
                                <tr>
                                    <td colspan="2" align="center">
                                        <!--[D]  텍스트 사이즈에 따라 width 변경해야 함 or 300px 미만의 넉넉한 사이즈로 지정-->
                                        <div style="display:inline-block;width:150px;max-width:100%;vertical-align:top; margin:0 auto">
                                            <table style="table-layout:fixed;width:100%;text-align:center" border="0" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                <tr>
                                                    <td style="padding:0">
                                                        <table style="table-layout:fixed;width:100%;background:#6F8DFF" border="0" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                            <tr>
                                                                <td height="42" style="text-align:center">
                                                                    <a href="{{ route('auth.register', ['token' => $token->id, 'code' => $mail->confirmationCode]) }}" target="_blank" style="display:block;height:42px;font-size:15px;color:#fff;text-decoration:none;line-height:42px;font-family:NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;">{{ xe_trans('xe::continueSigningUp') }}</a>
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
@endsection
