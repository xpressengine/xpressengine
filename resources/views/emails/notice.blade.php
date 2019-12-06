@extends('emails.common')

@section('content')
<table style="padding:0; margin:0 auto; border:0; width:100%; background:#fff; border-spacing:0; border-collapse:collapse; table-layout:fixed;">
    <tr style="padding:0;margin:0;border:0;">
        <td style="padding:0;margin:0;border:0;width:100%;height:52px;"></td>
    </tr>
    <tr style="padding:0; margin:0; border:0;">
        <td style="padding:0; margin:0; border:0; width:100%;">
            <h2 style="padding:0; margin:0 0 20px 0; border:0; font-size:28px; line-height:36px; font-weight:bold; letter-spacing:-0.01em; word-break:keep-all; color:#333; text-align:center;">{!! $title !!}</h2>
        </td>
    </tr>

    <tr style="padding:0; margin:0; border:0;">
        <td style="padding:0; margin:0; border:0; width:100%;">
            <p style="padding:0; margin:0; border:0; text-align: center;">{!! $contents !!}</p>
        </td>
    </tr>
    <tr style="padding:0;margin:0;border:0;">
        <td style="padding:0;margin:0;border:0;width:100%;height:52px;"></td>
    </tr>
</table>
@endsection
