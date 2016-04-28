
<!DOCTYPE html>
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
                    <nav>
                        <ul class="nav masthead-nav">
                            <li class="active"><a href="#">Steps?</a></li>
                            <li><a href="#">Steps1</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="inner cover">
                <h1 class="cover-heading">XE 3.x Installer</h1>
                <p class="lead">XE 설치를 위한 현재 서버의 상태를 체크합니다</p>
                <div class="checking-list">

                </div>
                <p class="lead">
                    <a href="/" class="btn btn-lg btn-danger again-button" style="display:none;">Checking Again</a>
                    <a href="/step1" class="btn btn-lg btn-default next-button">Getting start</a>
                </p>
            </div>

            <div class="mastfoot">
                <div class="inner">
                    <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
                </div>
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
    function checkPHP()
    {
        $('.checking-list').append($('<p>').html('<span class="glyphicon glyphicon-refresh php-icon" aria-hidden="true"></span> PHP 버전을 체크합니다.'));

        $.ajax({
            type: 'get',
            dataType: 'json',
            data: {},
            url: '/checkPHP',
            success: function(data) {
                if (data.result == false) {
                    $('.php-icon').addClass('glyphicon-ban-circle').removeClass('glyphicon-refresh');
                    $('.next-button').hide();
                    $('.again-button').show();

                } else {
                    $('.php-icon').addClass('glyphicon-ok-circle').removeClass('glyphicon-refresh');
                }
            }
        });
    }

    function directoryPermission()
    {
        $('.checking-list').append($('<p>').html('<span class="glyphicon glyphicon-refresh directory-icon" aria-hidden="true"></span> 디렉토리 사용 권한을 체크합니다.'));

        $.ajax({
            type: 'get',
            dataType: 'json',
            data: {},
            url: '/checkDirectoryPermission',
            success: function(data) {
                if (data.result == false) {
                    $('.directory-icon').addClass('glyphicon-ban-circle').removeClass('glyphicon-refresh');
                    $('.next-button').hide();
                    $('.again-button').show();

                } else {
                    $('.directory-icon').addClass('glyphicon-ok-circle').removeClass('glyphicon-refresh');
                }
            }
        });
    }

    $(function() {
        checkPHP();
        directoryPermission();
    });
</script>
</body>
</html>
