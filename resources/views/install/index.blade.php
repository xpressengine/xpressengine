<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>XE3 - Web installer</title>

    <link rel="stylesheet" href="{{ asset('assets/core/common/css/xe-common.css') }}">
    <script>var xeBaseURL = '{{ url()->to(null) }}';</script>
    <script src="{{ asset('../assets/core/common/js/utils.js') }}" type="text/javascript"></script>
    <script src="{{ asset('../assets/core/common/js/dynamicLoadManager.js') }}" type="text/javascript"></script>
    <script src="{{ asset('../assets/vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('../assets/vendor/vendor.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('../assets/bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('../assets/core/common/js/xe.bundle.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('../assets/core/xe-ui-component/xe-ui-component.css') }}">

    <link rel="stylesheet" href="{{ asset('../assets/core/webinstaller/css/webinstaller.css') }}">
    <link rel="stylesheet" href="{{ asset('../assets/vendor/XEIcon/xeicon.min.css') }}">
</head>

<body>
<header>
    <div class="header-inner">
        <h1>
            <a href="#"><i class="xi-xpressengine"></i><span class="brand-title"><span class="xe-sr-only">XE Web installer</span></span></a>
        </h1>
        <ul id="__xe_tab">
            <!--[D] 해당 depth에서 li.on 추가 -->
            <li class="on"><a href="#"><span class="xe-sr-only">start</span></a></li>
            <li class="step1" data-step="1"><a href="#"><span class="xe-sr-only">step1</span></a></li>
            <li class="step2" data-step="2"><a href="#"><span class="xe-sr-only">step2</span></a></li>
            <li class="step3" data-step="3"><a href="#"><span class="xe-sr-only">step3</span></a></li>
        </ul>
    </div>
</header>
<div class="install-container">
    <div class="content __xe_step" data-step="0">
        <div class="start_content">
            <h2 class="title-installer">
                <span class="text-xe"><span class="xe-sr-only">XE</span></span>
                <!--version number area ex) .num0 ~ .num9 -->
                <span class="num3"><em class="xe-sr-only">3</em></span>
                <span class="dot"><em class="xe-sr-only">.</em></span>
                <span class="num0"><em class="xe-sr-only">0</em></span>
                <span class="dot"><em class="xe-sr-only">.</em></span>
                <span class="num0"><em class="xe-sr-only">0</em></span>
                <!--// version number area-->
                <span class="text-installer"><span class="xe-sr-only">installer</span></span>
            </h2>
            <div class="xe-dropdown">
                <button class="xe-btn" type="button" data-toggle="xe-dropdown">English</button>
                <ul class="xe-dropdown-menu">
                    <li><a href="#" class="__xe_locale_item" data-locale="en"><i class="country-code"></i>English</a></li>
                    <li><a href="#" class="__xe_locale_item" data-locale="ko"><i class="country-code"></i>한국어</a></li>
                </ul>
            </div>

            <p class="text-version-check">Check your server status for XE installation.</p>
            <a href="#" class="btn-start __xe_btn_next"><span class="xe-sr-only">start</span></a>
        </div>
    </div>

    <div class="content __xe_step" data-step="1" style="display: none;">
        <h2>System check</h2>
        <ul class="system-check-list __xe_check_list">
            <!-- 검사 결과에 따라 li.pass, li.false 추가  -->
        </ul>
        <div class="btn-center">
            <!--[D] 모든 항목 pass 시 btn-next로 변경, 버튼태그로 교체 가능  -->
            <a href="#" class="btn-next __xe_btn_next" style="display: none;"><span class="xe-sr-only">next</span></a>
            <a href="#" class="btn-again __xe_btn_check"><span class="xe-sr-only">again</span></a>
        </div>
    </div>

    <div class="content __xe_step" data-step="2" style="display: none;">
        <h2>Condition</h2>
        <textarea class="xe-form-control" rows="12" cols="40">이 문서는 정보 제공의 목적으로만 제공됩니다. `NAVER(주)`는 이 문서에 수록된 정보의 완전성과
정확성을 검증하기 위해 노력하였으나, 발생할 수 있는 내용상의 오류가 있거나 누락되었을 수 있습니다.
이 문서의 사용이나 사용 결과에 따른 책임은 전적으로 사용자에게 있으며, `NAVER(주)`는 이에 대해
명시적 혹은 묵시적으로 어떠한 보증도 하지 않습니다.

관련 URL 정보를 포함하여 이 문서에서 언급한 특정 소프트웨어 상품이나 제품은 해당 소유자가 속한
현지 및 국내외 관련법을 따르며, 해당 법률을 준수하지 않음으로 인해 발생하는 모든 결과에 대한 책임은
전적으로 사용자 자신에게 있습니다.

`NAVER(주)`는 이 문서의 내용을 예고 없이 변경할 수 있습니다.</textarea>
        <div class="agree-area">
            <label class="xe-label">
                <input type="checkbox" id="__xe_agree">
                <span class="xe-input-helper"></span>
                <span class="xe-label-text">Yes, I read and agree.</span>
            </label>
        </div>
        <div class="btn-center">
            <a href="#" class="btn-next __xe_btn_next"><span class="xe-sr-only">next</span></a>
        </div>
    </div>


    <div class="content __xe_step" data-step="3" style="display: none;">
        <form action="{{ route('install.post') }}" method="post">
            <input type="hidden" name="locale" value="en">
            <h2>Database</h2>
            <table>
                <colgroup>
                    <col width="150">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row">Host</th>
                    <td><input type="text" class="xe-form-control" name="database_host" placeholder="Input database host.(default: localhost)"></td>
                </tr>
                <tr>
                    <th scope="row">Port</th>
                    <td><input type="text" class="xe-form-control" name="database_port" placeholder="Input database port.(default: 3306)"></td>
                </tr>
                <tr>
                    <th scope="row">Database Name</th>
                    <td><input type="text" class="xe-form-control" name="database_name" placeholder="Input database name."></td>
                </tr>
                <tr>
                    <th scope="row">Database User Name</th>
                    <td><input type="text" class="xe-form-control" name="database_user_name" placeholder="Input database user name.(default: root)"></td>
                </tr>
                <tr>
                    <th scope="row">Password</th>
                    <td><input type="password" class="xe-form-control" name="database_password" placeholder="Input database password"></td>
                </tr>
                <tr>
                    <th scope="row">Table Prefix</th>
                    <td><input type="text" class="xe-form-control" name="database_prefix" placeholder="Input database table prefix.(default: xe)"></td>
                </tr>
                </tbody>
            </table>
            <h2>Web site Information</h2>
            <table>
                <colgroup>
                    <col width="150">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row">Site Address</th>
                    <td><input type="text" class="xe-form-control" name="web_url" placeholder="URL(http://...)" value="{{ url()->to(null) }}"></td>
                </tr>
                <tr>
                    <th scope="row">Time Zone</th>
                    <td>
                        <select class="xe-form-control" name="web_timezone">
                            <option value="Asia/Seoul">Asia/Seoul</option>
                            <option value="UTC">UTC</option>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>
            <h2>Administrator</h2>
            <table>
                <colgroup>
                    <col width="150">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row">Email</th>
                    <td><input type="text" class="xe-form-control" name="admin_email" placeholder="Input email address."></td>
                </tr>
                <tr>
                    <th scope="row">Display Name</th>
                    <td><input type="text" class="xe-form-control" name="admin_display_name" placeholder="Input email address.(default: admin)"></td>
                </tr>
                <tr>
                    <th scope="row">Password</th>
                    <td><input type="password" class="xe-form-control" name="admin_password" placeholder="Input password."></td>
                </tr>
                <tr>
                    <th scope="row">Password Check</th>
                    <td><input type="password" class="xe-form-control" name="admin_password_confirmation" placeholder="Input password again."></td>
                </tr>
                </tbody>
            </table>
            <div class="btn-center">
                <a href="#" class="btn-next __xe_btn_submit"><span class="xe-sr-only">next</span></a>
            </div>
        </form>
    </div>


</div>
<div class="footer">
    <p class="text-copy">
        <span class="xe-sr-only">Copyright © NAVER Corp. Supported by D2 Program.</span>
    </p>
</div>


<script type="text/javascript">
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    var stepper = {
        current: 0,
        checked: false,
        next: function () {
            this.goto(this.current + 1);
        },
        tabOn: function (index) {
            $('#__xe_tab').children().removeClass('on');
            $('#__xe_tab').children().eq(index).addClass('on');
        },
        check: function () {
            $('.__xe_check_list').empty();
            check('Check PHP version.', 'phpVersion');
            /*check('<?=trans('checkPHPVersion')?>', 'phpVersion');
            check('<?=trans('checkDirPermission')?>', 'directoryPermission');
            check('<?=trans('checkPHPExtPDO')?>', 'pdo');
            check('<?=trans('checkPHPExtCURL')?>', 'curl');
            check('<?=trans('checkPHPExtFILEINFO')?>', 'fileinfo');
            check('<?=trans('checkPHPExtGD')?>', 'gd');
            check('<?=trans('checkPHPExtMBSTRING')?>', 'mbstring');
            check('<?=trans('checkPHPExtOPENSSL')?>', 'openssl');
            check('<?=trans('checkPHPExtZIP')?>', 'zip');*/

            this.checked = true;
        },
        goto: function (step) {
            var self = this;
            step = parseInt(step);

            if (step == 3 && !$('#__xe_agree').is(':checked')) {
                //alert('<?=trans('termsMustAgree')?>');
                alert('You must be agree condition');
                step = 2;
            }

            $('.__xe_step').each(function (i) {
                if (parseInt($(this).data('step')) == step) {
                    self.current = step;
                    $('.__xe_step').hide();
                    $(this).show();

                    self.tabOn(i);

                    if (step == 1 && !self.checked) {
                        self.check();
                    }

                    location.hash = '#step' + step;

                    return false;
                }
            });
        }
    };

    var checkSystems = [];

    function check(msg, checkKey)
    {
        checkSystems[checkKey] = false;

        $('.__xe_check_list').append(
            $('<li>').addClass('__xe_check ' + checkKey).append(
                $('<div>').append(
                    $('<span>').addClass('install-check').append(
                        $('<strong>').addClass('xe-sr-only').text('ready')
                    )
                ).append(
                    $('<p>').text(msg)
                )
            )
        );

        $.ajax({
            url: '{{ route('install.check') }}',
            type: 'get',
            dataType: 'json',
            data: {'key' : checkKey},
            success: function(data) {
                if (data.result == false) {
                    $('.__xe_check.'+checkKey).addClass('false').find('> div').append(
                        $('<strong>').text(data.message)
                    );
                } else {
                    $('.__xe_check.'+checkKey).addClass('pass')
                }

                checkSystems[checkKey] = data.result;

                var result = true;
                for (var key in checkSystems) {
                    if (checkSystems[key] === false) {
                        result = false;
                        break;
                    }
                }

                if (result == true) {
                    $('.__xe_btn_check').hide().siblings('.__xe_btn_next').show();
                }
            }
        });
    }

    function validation(f)
    {
        if (!$('#__xe_agree').is(':checked')) {
            alert('<?=trans('termsMustAgree')?>');
            stepper.goto(2);
            return false;
        }

        var fields = ['database_name', 'database_password', 'admin_email', 'admin_password', 'admin_password_confirmation'];
        for (var i in fields) {
            var field = fields[i];
            if ($.trim($(f[field]).val()) == '') {
                $(f[field]).focus();
                $(f[field]).css('backgroundColor', '#F49EA0');
                return false;
            }
        }

        if ($(f['admin_password']).val() !== $(f['admin_password_confirmation']).val()) {
            alert('비밀번호가 일치하지 않습니다.');
            $(f['admin_password_confirmation']).focus();
            return false;
        }

        return true;
    }

    var timezones = <?=json_encode(timezone_identifiers_list())?>;

    $(function () {
        $('.__xe_locale_item').click(function (e) {
            e.preventDefault();
            setCookie('install_locale', $(this).data('locale'), 24);
            location.reload();
        });

        $('.__xe_btn_next').click(function (e) {
            e.preventDefault();
            stepper.next();
        });
        $('.__xe_btn_check').click(function (e) {
            e.preventDefault();
            stepper.check();
        });
        $('.__xe_btn_submit').click(function (e) {
            e.preventDefault();
            $(this).hide();
            var $f = $(this).closest('form');
            if (validation($f[0]) === true) {
                $f.submit();
            } else {
                $(this).show();
            }
        });

        $('.header-inner a').click(function (e) {
            e.preventDefault();
            if ($(this).parent().data('step')) {
                stepper.goto($(this).parent().data('step'));
            }
        });

        var step = location.hash.replace(/^\#(step)/, '');
        stepper.goto(step);
    });
</script>

</body>
</html>