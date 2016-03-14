<!DOCTYPE html>
<html lang="ko">
<head>

    <!-- CUSTOM TAGS -->
    {!! XeFrontend::output('html', 'head.prepend') !!}

    <!-- META -->
    <meta charset="utf-8">
    <meta name="Generator" content="XpressEngine">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {!! XeFrontend::output('meta') !!}

    <!-- TITLE -->
    <title>{!! XeLang::trans(XeFrontend::output('title')) !!}</title>

    <!-- ICON -->
    {!! XeFrontend::output('icon') !!}

    <!-- CSS -->
    {!! XeFrontend::output('css') !!}

    <!-- JS at head.prepend -->
    {!! XeFrontend::output('js', 'head.prepend') !!}

    <!-- JS at head.append -->
    {!! XeFrontend::output('js', 'head.append') !!}

    <!-- Translation -->
    {!! XeFrontend::output('translation') !!}

    <script type="text/javascript">
        {{--
        XE.setup({
            loginUserId: '{{ Auth::user()->getId() }}',
            loadedTime: {{ time() }},
            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
        });
        @if (in_array(Auth::user()->getRating(), [\Xpressengine\User\Rating::SUPER, \Xpressengine\User\Rating::MANAGER]))
        XE.configure({managePrefix: '{{ app('config')['xe.routing.settingsPrefix'] }}'});
        @endif

        require.config({
            baseUrl: '/assets/vendor/',
            paths: {
                griper: '../core/common/js/modules/griper/griper',
                validator: '../core/common/js/modules/validator'
            }
        });
        --}}
    </script>


    <!-- CUSTOM TAGS -->
    {!! XeFrontend::output('html', 'head.append') !!}

</head>
<body class="{{ XeFrontend::output('bodyClass') }}">

<!-- JS at body.prepend -->
{!! XeFrontend::output('js', 'body.prepend') !!}

<!-- CUSTOM TAGS -->
{!! XeFrontend::output('html', 'body.prepend') !!}

{!! $content !!}

<!-- JS at body.append -->
{!! XeFrontend::output('js', 'body.append') !!}

<!-- CUSTOM TAGS -->
{!! XeFrontend::output('html', 'body.append') !!}

<!-- Rule -->
{!! XeFrontend::output('rule') !!}

@include('common.alert')

</body>
</html>
