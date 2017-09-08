<html>
    <head>
        <link href="{{asset('/assets/core/common/css/xe-common.css')}}" type="text/css" rel="stylesheet" media="all">
        <link href="{{asset('/assets/vendor/bootstrap/css/bootstrap.min.css')}}" type="text/css" rel="stylesheet" media="all">
        <link href="{{asset('/assets/vendor/bootstrap/css/bootstrap-theme.min.css')}}" type="text/css" rel="stylesheet" media="all">
        <style>
            .container {padding-top:10px;}
            input, button {margin: 10px 0;}
            section {border:1px solid #444;}
            label {margin: 5px 30px 5px 10px;}
            small {margin: 5px 20px; display:block;}
        </style>
        <style>

            .description {margin: 30px 0;}

        </style>
    </head>

    <body>
    <div class="container">
        <div class="header">
            <div style="float:right;">
                <a href="{{route('__safe_mode.logout')}}" class="btn btn-primary">logout</a>
            </div>

            <h1>XE3 안전 모드</h1>
            <span>아래 작업을 수행할 수 있습니다.</span>
        </div>

        <section>
            <form method="post" action="{{route('__safe_mode.do.cache-clear')}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <label>캐시 삭제</label>
                <button type="submit" class="btn btn-primary">실행</button>
                <small>
                    웹사이트가 정상동작 하지 않을 때 가장 먼저 해볼 수 있는 조치 입니다.
                    XE 는 설정등 많은 정보를 캐시로 사용하고 있습니다.
                </small>
            </form>
        </section>

        <section>
            <form method="post" action="{{route('__safe_mode.do.log-clear')}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <label>로그 파일 삭제</label>
                <button type="submit" class="btn btn-primary">실행</button>
                <small>
                    에러, 쿼리 로그 파일을 삭제합니다. (storage/logs 디렉토리를 비웁니다)
                </small>
            </form>
        </section>

        <section>
            <form method="post" action="{{route('__safe_mode.do.plugin-off')}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <label>플러그인 끄기</label>
                <select name="plugin_id">
                    <option value="">선택</option>
                    @foreach ($activatedPluginList as $pluginId)
                        <option value="{{$pluginId}}">{{$pluginId}}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-danger">끄기</button>
                <small>
                    플러그인 충돌로 웹사이트에 문제가 발생할 수 있습니다.
                    새로 설치한 플러그인으로 문제가 발생했을 경우 플러그인을 끄는 것으로 문제가 해결될 수 있습니다.
                    이 동작은 단순히 설정 값을 변경하는 동작만 수행합니다.
                </small>
            </form>
        </section>

        <section>
            <form method="post" action="{{route('__safe_mode.do.plugin-on')}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <label>플러그인 켜기</label>
                <select name="plugin_id">
                    <option value="">선택</option>
                    @foreach ($deactivatedPluginList as $pluginId)
                        <option value="{{$pluginId}}">{{$pluginId}}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">켜기</button>
                <small>
                    플러그인이 켜져있지 않아 문제가 있을것으로 생각될 경우엔 켜기 기능으로 복구해보세요.
                    이 동작은 단순히 설정 값을 변경하는 동작만 수행합니다.
                </small>
            </form>
        </section>

        @if (version_compare($installedVer, '3.0.0-beta.23', '<='))
            <section>
                <form method="post" action="{{route('__safe_mode.do.beta24')}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <label>XE3.0.0-beta.24 데이터베이스 테이블 컬럼 이름 변경</label>
                    <button type="submit" class="btn btn-primary">컬럼 이름 변경 실행</button>
                    <small>
                        XE3.0.0-beta.24 버전에서 데이터베이스 테이블 컬럼 이름 작성 방식이 변경되어 database alter table 을 해야합니다.
                        예로 xe_user table 의 displayName 컬럼 이름이 display_name 으로 변경되었습니다.
                    </small>
                </form>
            </section>
        @endif
    </div>

    </body>
</html>