
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
    <link href="{{ asset('/assets/core/common/css/install.css') }}" rel="stylesheet">

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

            <div class="inner cover" style="padding: 50px; 0">
                <form action="{{ route('webinstall.install.post') }}" method="post">
                    <input type="hidden" name="_token" value="{!! Session::token() !!}" />
                    <h2>Database</h2>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Host</label>
                        <input type="text" class="form-control" name="database_host" placeholder="Database Host(localhost)" value="{{ Input::old('database_host') }}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Port</label>
                        <input type="text" class="form-control" name="database_port" placeholder="Port(3306)" value="{{ Input::old('database_port') }}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Database Name</label>
                        <input type="text" class="form-control" name="database_name" placeholder="Database Name" value="{{ Input::old('database_name') }}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Database User Name</label>
                        <input type="text" class="form-control" name="database_user_name" placeholder="Database User Name" value="{{ Input::old('database_user_name') }}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control" name="database_password" placeholder="Password" value="{{ Input::old('database_password') }}">
                    </div>


                    <h2>Web site Information</h2>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Site Address</label>
                        <input type="text" class="form-control" name="web_url" placeholder="Url(http:://...)" value="{{ Input::old('web_url') }}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Time Zone</label>
                        <input type="text" class="form-control" name="web_timezone" placeholder="셀렉트 박스 구성 이나. 자동완성?" value="{{ Input::old('web_timezone') }}">
                    </div>

                    <h2>Administrator</h2>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" name="admin_email" placeholder="Email" value="{{ Input::old('admin_email') }}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Display Name</label>
                        <input type="text" class="form-control" name="admin_display_name" placeholder="Display Name(admin)" value="{{ Input::old('admin_display_name') }}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control" name="admin_password" placeholder="Password" value="{{ Input::old('admin_password') }}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Password Check</label>
                        <input type="password" class="form-control" name="admin_password_confirmation" placeholder="Password" value="{{ Input::old('admin_password_confirmation') }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Install</button>


                </form>
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

@if($errors = Session::get('errors'))
    <script type="text/javascript">
        @foreach ($errors->all() as $error)
        alert("{{ $error }}");
        @endforeach
    </script>
@endif

</body>
</html>
