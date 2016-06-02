<?php

//    require '../vendor/autoload.php';
//    $app = include('../bootstrap/app.php');
//    $kernel = $app->make('Illuminate\Contracts\Http\Kernel');
//    $kernel->bootstrap();

    if (empty($_GET['key']) === false) {
        $key = $_GET['key'];

        $result = true;
        $message = '';

        switch ($key) {
            case "directoryPermission" :
                $checkFile = '/checkFile';

                $paths = [
                    realpath( __DIR__ . '/../bootstrap/cache'),
                    realpath( __DIR__ . '/../config/cms'),
                    realpath( __DIR__ . '/../storage/'),
                ];

                foreach ($paths as $path) {
                    $fp = @fopen($path . $checkFile, 'a');
                    if ($fp === false) {
                        $result = false;
                        $message = 'Write permission required to "'.$path.'" directory ';
                        break;
                    } else {
                        fclose($fp);
                        unlink($path.$checkFile);
                    }
                }

                break;

            case "envFile" :
                $path = realpath(__DIR__ . '/../').'/.env';
                if (file_exists($path) === false) {
                    $result = false;
                    $message = 'Make ".env"('.$path.') file ';
                } else if (is_writable($path) === false) {
                    $result = false;
                    $message = 'Write permission required to ".env"('.$path.') file';
                }

                break;

            case "phpVersion" :
                $phpVersion = 50509;
                $result = PHP_VERSION_ID < $phpVersion ? false : true;
                break;

            case "mcrypt" :
                $result = extension_loaded('mcrypt');
                break;

            case "curl" :
                $result = extension_loaded('curl');
                break;

            case "gd" :
                $result = extension_loaded('gd');
                break;
        }

        echo json_encode([
            'result' => $result,
            'message' => $message,
        ]);

        exit;
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>XE3 - Web installer</title>

    <link rel="stylesheet" href="../assets/core/common/css/xe-common.css">
    <script src="../assets/jspm_packages/system.js"></script>
    <script src="../assets/systemjs.config.js"></script>

    <link rel="stylesheet" href="../assets/core/xe-ui-component/xe-ui-component.css">
    <script>
        System.import('xecore:/xe-ui-component/js/xe-ui-component.bundle');
    </script>

    <link rel="stylesheet" href="../assets/core/common/css/install.css">
    <link rel="stylesheet" href="http://cdn.jsdelivr.net/xeicon/2.0.0/xeicon.min.css">
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
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
                <span class="num1"><em class="xe-sr-only">0</em></span>
                <!--// version number area-->
                <span class="text-installer"><span class="xe-sr-only">installer</span></span>
            </h2>
            <div class="xe-dropdown">
                <button class="xe-btn" type="button" data-toggle="xe-dropdown">Language</button>
                <ul class="xe-dropdown-menu">
                    <li><a href="#"><i class="south korea xe-flag"></i>korea</a></li>
                    <li><a href="#"><i class="united states xe-flag"></i>United States</a></li>
                </ul>
            </div>

            <p class="text-version-check">XE 설치를 위해 현재 서버의 상태를 체크합니다.</p>
            <a href="#" class="btn-start __xe_btn_next"><span class="xe-sr-only">start</span></a>
        </div>
    </div>

    <div class="content __xe_step" data-step="1" style="display: none;">
        <h2>시스템 검사</h2>
        <ul class="system-check-list __xe_check_list">
            <!-- 검사 결과에 따라 li.pass, li.false 추가  -->
            <li class="pass">
                <div>
						<span class="install-check">
							<strong class="xe-sr-only">pass</strong>
						</span>
                    <p>PHP version 5.4 or greater required</p>
                </div>
            </li>
            <li class="false">
                <div>
						<span class="install-check">
							<strong class="xe-sr-only">false</strong>
						</span>
                    <p>Test connection to the installation server</p>
                    <strong>“.env”(home/vagrant/Code/xpressengine/installer/../env) fime</strong>
                </div>
            </li>
            <li class="pass">
                <div>
						<span class="install-check">
							<strong class="xe-sr-only">ready</strong>
						</span>
                    <p>Permission to write to directories and files</p>
                </div>
            </li>
            <li>
                <div>
						<span class="install-check">
							<strong class="xe-sr-only">ready</strong>
						</span>
                    <p>PDO PHP Extension is required</p>
                </div>
            </li>
            <li>
                <div>
						<span class="install-check">
							<strong class="xe-sr-only">ready</strong>
						</span>
                    <p>MCrypt PHP Extension is required</p>
                </div>
            </li>
            <li>
                <div>
						<span class="install-check">
							<strong class="xe-sr-only">ready</strong>
						</span>
                    <p>Mbstring PHP Extension is required</p>
                </div>
            </li>
        </ul>
        <div class="btn-center">
            <!--[D] 모든 항목 pass 시 btn-next로 변경, 버튼태그로 교체 가능  -->
             <a href="#" class="btn-next __xe_btn_next" style="display: none;"><span class="xe-sr-only">next</span></a>
            <a href="#" class="btn-again __xe_btn_check"><span class="xe-sr-only">again</span></a>
        </div>
    </div>

    <div class="content __xe_step" data-step="2" style="display: none;">
        <h2>약관 동의</h2>
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
                <span class="xe-label-text">이용 약관을 모두 읽었으며, 이에 동의합니다.</span>
            </label>
        </div>
        <div class="btn-center">
            <a href="#" class="btn-next __xe_btn_next"><span class="xe-sr-only">next</span></a>
        </div>
    </div>

    
    <div class="content __xe_step" data-step="3" style="display: none;">
        <form action="../install/post" method="post">
            <h2>Database</h2>
            <table>
                <colgroup>
                    <col width="150">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row">Host</th>
                    <td><input type="text" class="xe-form-control" name="database_host" placeholder="Database Host를 입력하세요.(default: localhost)"></td>
                </tr>
                <tr>
                    <th scope="row">Port</th>
                    <td><input type="text" class="xe-form-control" name="database_port" placeholder="Port를 입력하세요.(default: 3306)"></td>
                </tr>
                <tr>
                    <th scope="row">Database Name</th>
                    <td><input type="text" class="xe-form-control" name="database_name" placeholder="Database Name을 입력하세요."></td>
                </tr>
                <tr>
                    <th scope="row">Database User Name</th>
                    <td><input type="text" class="xe-form-control" name="database_user_name" placeholder="Database User Name을 입력하세요.(default: root)"></td>
                </tr>
                <tr>
                    <th scope="row">Password</th>
                    <td><input type="password" class="xe-form-control" name="database_password" placeholder="Password를 입력하세요."></td>
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
                    <td><input type="text" class="xe-form-control" name="web_url" placeholder="URL(http://...)"></td>
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
                    <td><input type="text" class="xe-form-control" name="admin_email" placeholder="Email을 입력하세요."></td>
                </tr>
                <tr>
                    <th scope="row">Display Name</th>
                    <td><input type="text" class="xe-form-control" name="admin_display_name" placeholder="화면에 표시될 이름을 입력하세요.(default: admin)"></td>
                </tr>
                <tr>
                    <th scope="row">Password</th>
                    <td><input type="password" class="xe-form-control" name="admin_password" placeholder="Password를 입력하세요."></td>
                </tr>
                <tr>
                    <th scope="row">Password Check</th>
                    <td><input type="password" class="xe-form-control" name="admin_password_confirmation" placeholder="Password를 재입력하세요."></td>
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
            check('PHP 버전을 체크합니다.', 'phpVersion');
            check('디렉토리 사용 권한을 체크합니다.', 'directoryPermission');
            check('환경설청 파일을 체크합니다.', 'envFile');
            check('cURL PHP Extension is required', 'curl');
            check('MCrypt PHP Extension is required', 'mcrypt');
            check('GD PHP Library is required', 'gd');
            this.checked = true;
        },
        goto: function (step) {
            var self = this;
            step = parseInt(step);

            if (step == 3 && !$('#__xe_agree').is(':checked')) {
                alert('약관에 동의 하셔야 합니다.');
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
            type: 'get',
            dataType: 'json',
            data: {'key' : checkKey},
            url: 'index.php',
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
            alert('약관에 동의 하셔야 합니다.');
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

    var timezones = [
        'Africa/Abidjan', 'Africa/Accra', 'Africa/Addis_Ababa', 'Africa/Algiers', 'Africa/Asmara', 'Africa/Bamako',
        'Africa/Bangui', 'Africa/Banjul', 'Africa/Bissau', 'Africa/Blantyre', 'Africa/Brazzaville', 'Africa/Bujumbura',
        'Africa/Cairo', 'Africa/Casablanca', 'Africa/Ceuta', 'Africa/Conakry', 'Africa/Dakar', 'Africa/Dar_es_Salaam',
        'Africa/Djibouti', 'Africa/Douala', 'Africa/El_Aaiun', 'Africa/Freetown', 'Africa/Gaborone', 'Africa/Harare',
        'Africa/Johannesburg', 'Africa/Juba', 'Africa/Kampala', 'Africa/Khartoum', 'Africa/Kigali', 'Africa/Kinshasa',
        'Africa/Lagos', 'Africa/Libreville', 'Africa/Lome', 'Africa/Luanda', 'Africa/Lubumbashi', 'Africa/Lusaka',
        'Africa/Malabo', 'Africa/Maputo', 'Africa/Maseru', 'Africa/Mbabane', 'Africa/Mogadishu', 'Africa/Monrovia',
        'Africa/Nairobi', 'Africa/Ndjamena', 'Africa/Niamey', 'Africa/Nouakchott', 'Africa/Ouagadougou', 'Africa/Porto-Novo',
        'Africa/Sao_Tome', 'Africa/Tripoli', 'Africa/Tunis', 'Africa/Windhoek', 'America/Adak', 'America/Anchorage',
        'America/Anguilla', 'America/Antigua', 'America/Araguaina', 'America/Argentina/Buenos_Aires', 'America/Argentina/Catamarca',
        'America/Argentina/Cordoba', 'America/Argentina/Jujuy', 'America/Argentina/La_Rioja', 'America/Argentina/Mendoza',
        'America/Argentina/Rio_Gallegos', 'America/Argentina/Salta', 'America/Argentina/San_Juan', 'America/Argentina/San_Luis',
        'America/Argentina/Tucuman', 'America/Argentina/Ushuaia', 'America/Aruba', 'America/Asuncion', 'America/Atikokan',
        'America/Bahia', 'America/Bahia_Banderas', 'America/Barbados', 'America/Belem', 'America/Belize', 'America/Blanc-Sablon',
        'America/Boa_Vista', 'America/Bogota', 'America/Boise', 'America/Cambridge_Bay', 'America/Campo_Grande', 'America/Cancun',
        'America/Caracas', 'America/Cayenne', 'America/Cayman', 'America/Chicago', 'America/Chihuahua', 'America/Costa_Rica',
        'America/Creston', 'America/Cuiaba', 'America/Curacao', 'America/Danmarkshavn', 'America/Dawson', 'America/Dawson_Creek',
        'America/Denver', 'America/Detroit', 'America/Dominica', 'America/Edmonton', 'America/Eirunepe', 'America/El_Salvador',
        'America/Fort_Nelson', 'America/Fortaleza', 'America/Glace_Bay', 'America/Godthab', 'America/Goose_Bay', 'America/Grand_Turk',
        'America/Grenada', 'America/Guadeloupe', 'America/Guatemala', 'America/Guayaquil', 'America/Guyana', 'America/Halifax',
        'America/Havana', 'America/Hermosillo', 'America/Indiana/Indianapolis', 'America/Indiana/Knox', 'America/Indiana/Marengo',
        'America/Indiana/Petersburg', 'America/Indiana/Tell_City', 'America/Indiana/Vevay', 'America/Indiana/Vincennes',
        'America/Indiana/Winamac', 'America/Inuvik', 'America/Iqaluit', 'America/Jamaica', 'America/Juneau', 'America/Kentucky/Louisville',
        'America/Kentucky/Monticello', 'America/Kralendijk', 'America/La_Paz', 'America/Lima', 'America/Los_Angeles', 'America/Lower_Princes',
        'America/Maceio', 'America/Managua', 'America/Manaus', 'America/Marigot', 'America/Martinique', 'America/Matamoros',
        'America/Mazatlan','America/Menominee', 'America/Merida', 'America/Metlakatla', 'America/Mexico_City', 'America/Miquelon',
        'America/Moncton', 'America/Monterrey', 'America/Montevideo', 'America/Montserrat', 'America/Nassau', 'America/New_York',
        'America/Nipigon', 'America/Nome', 'America/Noronha', 'America/North_Dakota/Beulah', 'America/North_Dakota/Center',
        'America/North_Dakota/New_Salem', 'America/Ojinaga', 'America/Panama', 'America/Pangnirtung', 'America/Paramaribo',
        'America/Phoenix', 'America/Port-au-Prince', 'America/Port_of_Spain', 'America/Porto_Velho', 'America/Puerto_Rico',
        'America/Rainy_River', 'America/Rankin_Inlet', 'America/Recife', 'America/Regina', 'America/Resolute', 'America/Rio_Branco',
        'America/Santarem', 'America/Santiago', 'America/Santo_Domingo', 'America/Sao_Paulo', 'America/Scoresbysund',
        'America/Sitka', 'America/St_Barthelemy', 'America/St_Johns', 'America/St_Kitts', 'America/St_Lucia', 'America/St_Thomas',
        'America/St_Vincent', 'America/Swift_Current', 'America/Tegucigalpa', 'America/Thule', 'America/Thunder_Bay',
        'America/Tijuana', 'America/Toronto', 'America/Tortola', 'America/Vancouver', 'America/Whitehorse', 'America/Winnipeg',
        'America/Yakutat', 'America/Yellowknife', 'Antarctica/Casey', 'Antarctica/Davis', 'Antarctica/DumontDUrville',
        'Antarctica/Macquarie', 'Antarctica/Mawson', 'Antarctica/McMurdo', 'Antarctica/Palmer', 'Antarctica/Rothera',
        'Antarctica/Syowa', 'Antarctica/Troll', 'Antarctica/Vostok', 'Arctic/Longyearbyen', 'Asia/Aden', 'Asia/Almaty',
        'Asia/Amman', 'Asia/Anadyr', 'Asia/Aqtau', 'Asia/Aqtobe', 'Asia/Ashgabat', 'Asia/Baghdad', 'Asia/Bahrain',
        'Asia/Baku', 'Asia/Bangkok', 'Asia/Barnaul', 'Asia/Beirut', 'Asia/Bishkek', 'Asia/Brunei', 'Asia/Chita',
        'Asia/Choibalsan', 'Asia/Colombo', 'Asia/Damascus', 'Asia/Dhaka', 'Asia/Dili', 'Asia/Dubai', 'Asia/Dushanbe',
        'Asia/Gaza', 'Asia/Hebron', 'Asia/Ho_Chi_Minh', 'Asia/Hong_Kong', 'Asia/Hovd', 'Asia/Irkutsk', 'Asia/Jakarta',
        'Asia/Jayapura', 'Asia/Jerusalem', 'Asia/Kabul', 'Asia/Kamchatka', 'Asia/Karachi', 'Asia/Kathmandu', 'Asia/Khandyga',
        'Asia/Kolkata', 'Asia/Krasnoyarsk', 'Asia/Kuala_Lumpur', 'Asia/Kuching', 'Asia/Kuwait', 'Asia/Macau', 'Asia/Magadan',
        'Asia/Makassar', 'Asia/Manila', 'Asia/Muscat', 'Asia/Nicosia', 'Asia/Novokuznetsk', 'Asia/Novosibirsk', 'Asia/Omsk',
        'Asia/Oral', 'Asia/Phnom_Penh', 'Asia/Pontianak', 'Asia/Pyongyang', 'Asia/Qatar', 'Asia/Qyzylorda', 'Asia/Rangoon',
        'Asia/Riyadh', 'Asia/Sakhalin', 'Asia/Samarkand', 'Asia/Seoul', 'Asia/Shanghai', 'Asia/Singapore', 'Asia/Srednekolymsk',
        'Asia/Taipei', 'Asia/Tashkent', 'Asia/Tbilisi', 'Asia/Tehran', 'Asia/Thimphu', 'Asia/Tokyo', 'Asia/Tomsk', 'Asia/Ulaanbaatar',
        'Asia/Urumqi', 'Asia/Ust-Nera', 'Asia/Vientiane', 'Asia/Vladivostok', 'Asia/Yakutsk', 'Asia/Yekaterinburg', 'Asia/Yerevan',
        'Atlantic/Azores', 'Atlantic/Bermuda', 'Atlantic/Canary', 'Atlantic/Cape_Verde', 'Atlantic/Faroe', 'Atlantic/Madeira',
        'Atlantic/Reykjavik', 'Atlantic/South_Georgia', 'Atlantic/St_Helena', 'Atlantic/Stanley', 'Australia/Adelaide', 
        'Australia/Brisbane', 'Australia/Broken_Hill', 'Australia/Currie', 'Australia/Darwin', 'Australia/Eucla', 
        'Australia/Hobart', 'Australia/Lindeman', 'Australia/Lord_Howe', 'Australia/Melbourne', 'Australia/Perth', 
        'Australia/Sydney', 'Europe/Amsterdam', 'Europe/Andorra', 'Europe/Astrakhan', 'Europe/Athens', 'Europe/Belgrade', 
        'Europe/Berlin', 'Europe/Bratislava', 'Europe/Brussels', 'Europe/Bucharest', 'Europe/Budapest', 'Europe/Busingen', 
        'Europe/Chisinau', 'Europe/Copenhagen', 'Europe/Dublin', 'Europe/Gibraltar', 'Europe/Guernsey', 'Europe/Helsinki', 
        'Europe/Isle_of_Man', 'Europe/Istanbul', 'Europe/Jersey', 'Europe/Kaliningrad', 'Europe/Kiev', 'Europe/Kirov', 
        'Europe/Lisbon', 'Europe/Ljubljana', 'Europe/London', 'Europe/Luxembourg', 'Europe/Madrid', 'Europe/Malta', 
        'Europe/Mariehamn', 'Europe/Minsk', 'Europe/Monaco', 'Europe/Moscow', 'Europe/Oslo', 'Europe/Paris', 'Europe/Podgorica', 
        'Europe/Prague', 'Europe/Riga', 'Europe/Rome', 'Europe/Samara', 'Europe/San_Marino', 'Europe/Sarajevo', 'Europe/Simferopol', 
        'Europe/Skopje', 'Europe/Sofia', 'Europe/Stockholm', 'Europe/Tallinn', 'Europe/Tirane', 'Europe/Ulyanovsk', 
        'Europe/Uzhgorod', 'Europe/Vaduz', 'Europe/Vatican', 'Europe/Vienna', 'Europe/Vilnius', 'Europe/Volgograd', 
        'Europe/Warsaw', 'Europe/Zagreb', 'Europe/Zaporozhye', 'Europe/Zurich', 'Indian/Antananarivo', 'Indian/Chagos', 
        'Indian/Christmas', 'Indian/Cocos', 'Indian/Comoro', 'Indian/Kerguelen', 'Indian/Mahe', 'Indian/Maldives', 
        'Indian/Mauritius', 'Indian/Mayotte', 'Indian/Reunion', 'Pacific/Apia', 'Pacific/Auckland', 'Pacific/Bougainville', 
        'Pacific/Chatham', 'Pacific/Chuuk', 'Pacific/Easter', 'Pacific/Efate', 'Pacific/Enderbury', 'Pacific/Fakaofo', 
        'Pacific/Fiji', 'Pacific/Funafuti', 'Pacific/Galapagos', 'Pacific/Gambier', 'Pacific/Guadalcanal', 'Pacific/Guam', 
        'Pacific/Honolulu', 'Pacific/Johnston', 'Pacific/Kiritimati', 'Pacific/Kosrae', 'Pacific/Kwajalein', 'Pacific/Majuro', 
        'Pacific/Marquesas', 'Pacific/Midway', 'Pacific/Nauru', 'Pacific/Niue', 'Pacific/Norfolk', 'Pacific/Noumea', 
        'Pacific/Pago_Pago', 'Pacific/Palau', 'Pacific/Pitcairn', 'Pacific/Pohnpei', 'Pacific/Port_Moresby', 'Pacific/Rarotonga', 
        'Pacific/Saipan', 'Pacific/Tahiti', 'Pacific/Tarawa', 'Pacific/Tongatapu', 'Pacific/Wake', 'Pacific/Wallis', 'UTC'
    ];

    $(function () {
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
            var $f = $(this).closest('form');
            if (validation($f[0]) === true) {
                $f.submit();
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
