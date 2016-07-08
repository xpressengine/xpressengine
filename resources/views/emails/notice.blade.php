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
            <td style="font-family:NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;color:#8e8e93;font-size:13px;text-align:left;line-height:21px;">{!! $contents !!}</td>
        </tr>
        </tbody>
    </table>
@endsection
