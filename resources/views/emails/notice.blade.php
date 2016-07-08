@extends('emails.common')

@section('content')
    <table cellpadding="0" cellspacing="0" style="width:100%;margin:0 auto;background-color:#fff;-webkit-text-size-adjust:100%;text-align:left">
        <tbody>

        <tr>
            <td style="font-family: NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;line-height:34px;vertical-align:top;color:#2c2e37;font-size:30px;letter-spacing:-1px">
                {!! $title !!}
            </td>
        </tr>
        <tr>
            <td height="47"></td>
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
                        <td width="20" style="line-height: 0;font-size: 0;background-color:#fff;">
                            {!! $contents !!}
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
