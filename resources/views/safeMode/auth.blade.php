<html>
    <head>
        <link href="{{asset('/assets/core/common/css/xe-common.css')}}" type="text/css" rel="stylesheet" media="all">
        <link href="{{asset('/assets/vendor/bootstrap/css/bootstrap.min.css')}}" type="text/css" rel="stylesheet" media="all">
        <link href="{{asset('/assets/vendor/bootstrap/css/bootstrap-theme.min.css')}}" type="text/css" rel="stylesheet" media="all">
        <style>
            .container {padding-top:100px;}
            .description {margin: 30px 0;}
            input, button {margin: 10px 0;}
        </style>
    </head>

    <body>
        <div class="container">
            <div class="description">
                <h1>XE Safe 모드 로그인</h1>
                <p>XE safe 모드로 진입합니다.</p>
                <small>safe 모드는 운영중인 xe에 장애가 발생한 경우 사용할 수 있으며 캐시관리 등을 지원합니다.</small>
            </div>
            <div>
                <form method="post" action="{{route('__safe_mode.login')}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <input type="text" name="email" class="form-control" value="{{old('email')}}" />
                    <input type="password" name="password" class="form-control" value="" />

                    <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </body>
</html>
