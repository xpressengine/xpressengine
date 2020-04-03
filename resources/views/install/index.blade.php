<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>XE3 - Web installer</title>

    <link rel="stylesheet" href="{{ asset('assets/core/common/css/xe-common.css') }}">
    <script>var xeBaseURL = '{{ url()->to(null) }}';</script>

    <script src="{{ asset('assets/vendor.js') }}"></script>
    <script src="{{ asset('assets/common.js') }}"></script>
    <script src="{{ asset('assets/core/common/js/xe.bundle.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/core/xe-ui-component/xe-ui-component.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/core/webinstaller/css/webinstaller.css') }}">
    <link rel="stylesheet" href="{{ asset('https://cdn.jsdelivr.net/npm/xeicon@2.3/xeicon.min.css') }}">
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
                XE {{__XE_VERSION__}} Installer
            </h2>
            <div class="xe-dropdown">
                <button class="xe-btn" type="button" data-toggle="xe-dropdown">{{ trans('xe::install.localeExpression') }}</button>
                <ul class="xe-dropdown-menu">
                    <li><a href="{{ route('install.index', ['_l' => 'en']) }}" class="__xe_locale_item" data-locale="en"><i class="country-code"></i>{{ trans('xe::install.localeExpression', [], 'en') }}</a></li>
                    <li><a href="{{ route('install.index', ['_l' => 'ko']) }}" class="__xe_locale_item" data-locale="ko"><i class="country-code"></i>{{ trans('xe::install.localeExpression', [], 'ko') }}</a></li>
                </ul>
            </div>

            <p class="text-version-check">{{ trans('xe::install.checkForInstall') }}</p>
            <a href="#" class="btn-start __xe_btn_next">START</a>
        </div>
    </div>

    <div class="content __xe_step" data-step="1" style="display: none;">
        <h2>{{ trans('xe::install.systemCheck') }}</h2>
        <ul class="system-check-list __xe_check_list">
            <!-- 검사 결과에 따라 li.pass, li.false 추가  -->
        </ul>
        <div class="btn-center">
            <!--[D] 모든 항목 pass 시 btn-next로 변경, 버튼태그로 교체 가능  -->
            <a href="#" class="btn-next __xe_btn_next" style="display: none;">NEXT</a>
            <a href="#" class="btn-again __xe_btn_check">AGAIN</a>
        </div>
    </div>

    <div class="content __xe_step" data-step="2" style="display: none;">
        <h2>{{ trans('xe::install.terms') }}</h2>
        <textarea class="xe-form-control" rows="12" cols="40">{{ trans('xe::install.termsText') }}</textarea>
        <div class="agree-area">
            <label class="xe-label">
                <input type="checkbox" id="__xe_agree">
                <span class="xe-input-helper"></span>
                <span class="xe-label-text">{{ trans('xe::install.termsReadAndAgree') }}</span>
            </label>
        </div>
        <div class="btn-center">
            <a href="#" class="btn-next __xe_btn_next">NEXT</a>
        </div>
    </div>


    <div class="content __xe_step" data-step="3" style="display: none;">
        <form action="{{ route('install.post') }}" method="post">
            <input type="hidden" name="locale" value="{{ trans()->getLocale() }}">
            <h2>Database</h2>
            <table>
                <colgroup>
                    <col width="150">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row">Driver</th>
                    <td>
                        <select class="xe-form-control" name="database_driver">
                            <option value="mysql">MySQL</option>
                            <option value="cubrid">CUBRID</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Host</th>
                    <td><input type="text" class="xe-form-control" name="database_host" placeholder="{{ trans('xe::install.inputDBHost') }}(default: localhost)"></td>
                </tr>
                <tr>
                    <th scope="row">Port</th>
                    <td><input type="text" class="xe-form-control" name="database_port" placeholder="{{ trans('xe::install.inputDBPort') }}(default: 3306)"></td>
                </tr>
                <tr>
                    <th scope="row">Database Name</th>
                    <td><input type="text" class="xe-form-control" name="database_name" placeholder="{{ trans('xe::install.inputDBName') }}"></td>
                </tr>
                <tr>
                    <th scope="row">Database User Name</th>
                    <td><input type="text" class="xe-form-control" name="database_user_name" placeholder="{{ trans('xe::install.inputDBUser') }}(default: root)"></td>
                </tr>
                <tr>
                    <th scope="row">Password</th>
                    <td><input type="password" class="xe-form-control" name="database_password" placeholder="{{ trans('xe::install.inputDBPassword') }}"></td>
                </tr>
                <tr>
                    <th scope="row">Table Prefix</th>
                    <td><input type="text" class="xe-form-control" name="database_prefix" placeholder="{{ trans('xe::install.inputDBPrefix') }}(default: xe)"></td>
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
                    <td><input type="text" class="xe-form-control" name="admin_email" placeholder="{{ trans('xe::install.inputAdminEmail') }}"></td>
                </tr>
                <tr>
                    <th scope="row">ID</th>
                    <td><input type="text" class="xe-form-control" name="admin_login_id" placeholder="{{ trans('xe::install.inputAdminID') }}(default: admin)"></td>
                </tr>
                <tr>
                    <th scope="row">Nickname</th>
                    <td><input type="text" class="xe-form-control" name="admin_display_name" placeholder="{{ trans('xe::install.inputAdminName') }}(default: admin)"></td>
                </tr>
                <tr>
                    <th scope="row">Password</th>
                    <td><input type="password" class="xe-form-control" name="admin_password" placeholder="{{ trans('xe::install.inputAdminPassword') }}"></td>
                </tr>
                <tr>
                    <th scope="row">Password Check</th>
                    <td><input type="password" class="xe-form-control" name="admin_password_confirmation" placeholder="{{ trans('xe::install.reInputAdminPassword') }}"></td>
                </tr>
                </tbody>
            </table>
            <div class="btn-center">
                <a href="#" class="btn-next __xe_btn_submit">NEXT</a>
            </div>
        </form>
    </div>


</div>
<div class="footer">
    <p class="text-copy">
        &copy; 2019 엑스이허브(주)
    </p>
</div>


<script type="text/javascript">
    $(function () {

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
                check('{{ trans('xe::install.checkPHPVersion') }}', 'phpVersion');
                check('{{ trans('xe::install.checkDirPermission') }}', 'directoryPermission');
                check('{{ trans('xe::install.checkPHPExtPDO') }}', 'pdo');
                check('{{ trans('xe::install.checkPHPExtCURL') }}', 'curl');
                check('{{ trans('xe::install.checkPHPExtFILEINFO') }}', 'fileinfo');
                check('{{ trans('xe::install.checkPHPExtGD') }}', 'gd');
                check('{{ trans('xe::install.checkPHPExtMBSTRING') }}', 'mbstring');
                check('{{ trans('xe::install.checkPHPExtOPENSSL') }}', 'openssl');
                check('{{ trans('xe::install.checkPHPExtZIP') }}', 'zip');

                this.checked = true;
            },
            goto: function (step) {
                var self = this;
                step = parseInt(step);

                if (step == 3 && !$('#__xe_agree').is(':checked')) {
                    alert('{{ trans('xe::install.termsMustAgree') }}');
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

            XE.ajax({
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
                alert('{{ trans('xe::install.termsMustAgree') }}');
                stepper.goto(2);
                return false;
            }

            var fields = ['database_name', 'admin_email', 'admin_password', 'admin_password_confirmation'];
            for (var i in fields) {
                var field = fields[i];
                if ($.trim($(f[field]).val()) == '') {
                    $(f[field]).focus();
                    $(f[field]).css('backgroundColor', '#F49EA0');
                    return false;
                }
            }
            
            var password_check = /[^!-\/:-@[-`{-~a-zA-Z0-9]/.test($(f['admin_password']).val())
            if (password_check) {
                $(f['admin_password']).css('backgroundColor', '#F49EA0');
                alert('비밀번호로 사용가능한 문자는 영문과 특수문자만 가능합니다.');
                $(f['admin_password']).focus();
                return false;
            }
            
            if ($(f['admin_password']).val() !== $(f['admin_password_confirmation']).val()) {
                alert('비밀번호가 일치하지 않습니다.');
                $(f['admin_password_confirmation']).focus();
                return false;
            }

            return true;
        }

        {{--var timezones = eval('{{ json_encode(timezone_identifiers_list()) }}');--}}


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
