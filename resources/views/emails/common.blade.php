<!-- 공통 환경 구성 -->
<table style="padding:0; margin:0; border:0; width:100%; border-spacing: 0; border-collapse:collapse; table-layout:fixed; color:#333; font-family:-apple system, BlinkMacSystemFont, 'San Francisco', 'Roboto', 'Segoe UI',  'Avenir LT Std', 'Noto Sans KR', 'Malgun Gothic', '맑은 고딕', 'Nanum Gothic', Dotum, 돋움, 'Helvetica Neue', sans-serif; font-size:15px; line-height:1.6em; letter-spacing:-.01em; word-break:break-all;">
    <tbody style="padding:0; margin:0; border:0;">
        <tr style="padding:0; margin:0; border:0;">
            <td style="padding:0 10px; margin:0; border:0;">
                <table style="padding:0; margin:0 auto; border:0; min-width:280px; max-width:536px; background:#fff; border-spacing:0; border-collapse:collapse; table-layout:fixed;">
                    <tbody>
                        <tr>
                            <td>
                                <!-- 이메일 레이아웃 -->
                                <table style="padding:0; margin:0 auto; border:0; max-width:536px; width:100%; background:#fff; border-spacing:0; border-collapse:collapse; table-layout:fixed;">
                                    <tbody style="padding:0; margin:0; border:0;">
                                        <tr style="padding:0; margin:0; border:0;">
                                            <td style="padding:0; margin:0; border:0; width:100%; height:35px;"></td>
                                        </tr>
                                        <tr style="padding:0; margin:0; border:0;">
                                            <td style="padding:0; margin:0; border:0; width:100%; height:25px; text-align: center;">

                                                @section('header')
                                                <a href="{{ url('/') }}" target="_blank" style="padding:0; margin:0; border:0; font-size:24px; font-weight:600; color:#161616; text-decoration:none;">
                                                    {{ xe_trans(app('xe.site')->getSiteConfig()->get('site_title')) }}
                                                </a>
                                                @show

                                            </td>
                                        </tr>
                                        <tr style="padding:0;margin:0;border:0;">
                                            <td style="padding:10px 0 20px 0;margin:0;border:0;width:100%;">
                                                <hr style="margin:0;border:0;background:#DADCE0;height:1px;">
                                            </td>
                                        </tr>
                                        <tr style="padding:0;margin:0;border:0;">
                                            <td style="padding:0;margin:0;border:0;width:100%;">
                                            @section('content')
                                            {!! $content or '' !!}
                                            @show
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<!-- 푸터 -->
<table style="padding:0; border:0; width:100%; border-spacing: 0; border-collapse:collapse; table-layout:fixed; color:#4a4a4a; font-family:'Malgun Gothic', sans-serif;">
    <tbody style="padding:0; margin:0; border:0;">
        <tr style="padding:0; margin:0; border:0;">
            <td style="padding:0; margin:0; border:0;">
                <table style="padding:0; margin:0; border:0; max-width:536px; width:100%; margin:0 auto; border-spacing:0; border-collapse:collapse; table-layout:fixed;">
                    <tbody style="padding:0; margin:0; border:0;">
                        <tr style="padding:0;margin:0;border:0;">
                            <td style="padding:20px 0 10px 0;margin:0;border:0;width:100%;height:1px;">
                                <hr style="margin:0;border:0;background:#DADCE0;height:1px;">
                            </td>
                        </tr>
                        {{-- <tr style="padding:0; margin:0; border:0;">
                            <td style="padding:0; margin:0; border:0; width:100%; text-align:center;">
                                <a href="#"><img src="image/ico-xe.png" style="padding:0; margin:0 5px; border:0; width:36px; height:36px;" /></a>
                                <a href="#"><img src="image/ico-facebook.png" style="padding:0; margin:0 5px; border:0; width:36px; height:36px;" /></a>
                                <a href="#"><img src="image/ico-medium.png" style="padding:0; margin:0 5px; border:0; width:36px; height:36px;" /></a>
                            </td>
                        </tr> --}}
                        <tr style="padding:0; margin:0; border:0;">
                            <td style="padding:0; margin:0; border:0; width:100%; height:20px;"></td>
                        </tr>
                        <tr style="padding:0; margin:0; border:0;">
                            <td style="padding:0; margin:0; border:0; width:100%; text-align:center;">
                                <p style="padding:0; margin:0; border:0; font-size:13px; line-height:1.5em; color:#777;">본 메일은 발신 전용 메일입니다.</p>
                            </td>
                        </tr>
                        <tr style="padding:0; margin:0; border:0;">
                            <td style="padding:0; margin:0; border:0; width:100%; height:10px;"></td>
                        </tr>
                        <tr style="padding:0; margin:0; border:0;">
                            <td style="padding:0; margin:0; border:0; width:100%; text-align:center;">
                                <p style="padding:0; margin:0; border:0; font-size:13px; line-height:1.5em; color:#777;">Copyright &copy; {{ xe_trans(app('xe.site')->getSiteConfig()->get('site_title')) }}. All Rights Reserved.</p>
                            </td>
                        </tr>
                        <tr style="padding:0; margin:0; border:0;">
                            <td style="padding:0; margin:0; border:0; width:100%; height:55px;"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
