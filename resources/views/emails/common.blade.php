<table border="0" cellpadding="0" cellspacing="0" align="center" style="width:100%;background:#F1F6FB">
    <tr>
        <td align="center">
            <!-- 아웃룩용 max-width 핵 -->
            <!--[if (gte mso 9)|(IE)]>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="600">
            <![endif]-->
            <div style="max-width:600px;margin:0 auto">
                <table cellpadding="0" cellspacing="0" style="width:100%;margin:0 auto;background-color:#F1F6FB;-webkit-text-size-adjust:100%;text-align:left">
                    <tbody>
                    <tr>
                        <td height="50"></td>
                    </tr>
                    <tr>
                        <td style="text-align:center">
                            @section('header')
                            <a href="{{ url('/') }}" target="_blank" style="text-decoration:none;font-family: NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;line-height:34px;vertical-align:top;color:#6f8dff;font-size:30px;letter-spacing:-1px">{{ xe_trans(app('xe.site')->getSiteConfig()->get('site_title')) }}</a>
                            @show
                        </td>
                    </tr>
                    <tr>
                        <td height="20"></td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" style="width:100%;margin:0 auto;background-color:#fff;-webkit-text-size-adjust:100%;text-align:left;color:#2c2e37">
                                <tbody>
                                <tr>
                                    <td height="35"></td>
                                </tr>
                                <tr>
                                    <td style="width: 40px;line-height: 0;font-size: 0;background-color:#fff;">
                                        &nbsp;
                                    </td>
                                    <td>
                                        @section('content')
                                            {!! $content or '' !!}
                                        @show
                                    </td>
                                    <td style="width: 40px;line-height: 0;font-size: 0;background-color:#fff;">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td height="40"></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="17"></td>
                    </tr>
                    <tr>
                        <td style="font-family:NanumBarunGothic,'나눔고딕',NanumGothic,dotum,'돋움',Helvetica;color:#8e8e93;font-size:13px;text-align:center;line-height:13px;">
                            @section('footer')
                            <p>본 메일은 발신전용 입니다.</p>
                            <p style="font-size: 12px;">CopyLight © <a href="{{ url('/') }}" target="_blank" style="color:#6f8dff;text-decoration:none">{{ xe_trans(app('xe.site')->getSiteConfig()->get('site_title')) }}</a> All Rights Reserved. Supported by <a href="https://xpressengine.io" target="_blank" style="color:#6f8dff;text-decoration:none">XE</a></p>
                            @show
                        </td>
                    </tr>
                    <tr>
                        <td height="50"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--[if mso]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>
