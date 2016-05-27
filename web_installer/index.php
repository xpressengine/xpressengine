<?php

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Cover Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="http://getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/assets/core/common/css/install.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="http://getbootstrap.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="http://getbootstrap.com/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="site-wrapper">

    <div class="site-wrapper-inner">

        <div class="cover-container">

            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand">XpressEngine</h3>
                </div>
            </div>

            <div class="inner cover">
                <h1 class="cover-heading">XE 3.x Installer</h1>
                <p class="lead">XE 설치를 위한 현재 서버의 상태를 체크합니다</p>
                <div class="checking-list">

                </div>
                <p class="lead">
                    <a href="/web_installer" class="btn btn-lg btn-danger again-button">Checking Again</a>
                    <a href="/install" class="btn btn-lg btn-default next-button" style="display:none;">Getting start</a>
                </p>
            </div>

        </div>

    </div>

</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="http://getbootstrap.com/assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>

<script>
    var checkSystems = [];

    function check(msg, checkKey)
    {
        checkSystems[checkKey] = false;

        $('.checking-list').append($('<p>').html('<span class="glyphicon glyphicon-refresh '+checkKey+' " aria-hidden="true"></span> ' + msg));

        $.ajax({
            type: 'get',
            dataType: 'json',
            data: {'key' : checkKey},
            url: '/web_installer/index.php',
            success: function(data) {
                if (data.result == false) {
                    $('.'+checkKey).addClass('glyphicon-ban-circle').css('color','red').removeClass('glyphicon-refresh');
                    $('.'+checkKey).closest('p').append($('<span>').css('color','red').text(data.message));
                } else {
                    $('.'+checkKey).addClass('glyphicon-ok-circle').removeClass('glyphicon-refresh');
                }

                checkSystems[checkKey] = data.result

                var result = true;
                for (var key in checkSystems) {
                    if (checkSystems[key] === false) {
                        result = false;
                        break;
                    }
                }

                if (result == true) {
                    $('.again-button').hide();
                    $('.next-button').show();
                }
            }
        });
    }

    $(function() {
        check('PHP 버전을 체크합니다.', 'phpVersion');
        check('디렉토리 사용 권한을 체크합니다.', 'directoryPermission');
        check('환경설청 파일을 체크합니다.', 'envFile');
        check('cURL PHP Extension is required', 'curl');
        check('MCrypt PHP Extension is required', 'mcrypt');
        check('GD PHP Library is required', 'gd');
    });
</script>
</body>
</html>
