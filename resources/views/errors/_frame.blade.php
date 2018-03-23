@if ($xe === true)
    {{ XeFrontend::bodyClass('error-page')->load() }}
    {{ XeFrontend::css('assets/core/error/style.css')->load() }}

    <div class="error-page-contents">
        @yield('content')
    </div>

@else
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="Generator" content="XpressEngine 3">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <link href="{{asset('/assets/core/common/css/xe-common.css')}}" type="text/css" rel="stylesheet" media="all">
        <link href="{{asset('/assets/core/xe-ui-component/xe-ui-component.css')}}" type="text/css" rel="stylesheet" media="all">
        <link href="{{asset('/assets/vendor/bootstrap/css/bootstrap.min.css')}}" type="text/css" rel="stylesheet" media="all">
        <link href="{{asset('/assets/vendor/bootstrap/css/bootstrap-theme.min.css')}}" type="text/css" rel="stylesheet" media="all">
        <link href="{{asset('/assets/core/error/style.css')}}" type="text/css" rel="stylesheet" media="all">
        <link href="{{asset('https://cdn.jsdelivr.net/npm/xeicon@2.3/xeicon.min.css')}}" type="text/css" rel="stylesheet" media="all">

    </head>

    <body class="error-page">
    <div class="container">
        <div class="error-page-contents">
            @yield('content')
        </div>
    </div>
    </body>
    </html>

@endif
