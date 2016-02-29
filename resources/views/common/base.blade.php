<!DOCTYPE html>
<html lang="ko">
<head>

    <!-- CUSTOM TAGS -->
    {!! Frontend::output('html', 'head.prepend') !!}

    <!-- META -->
    <meta charset="utf-8">
    <meta name="Generator" content="XpressEngine">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {!! Frontend::output('meta') !!}

    <!-- TITLE -->
    <title>{!! XeLang::trans(Frontend::output('title')) !!}</title>

    <!-- ICON -->
    {!! Frontend::output('icon') !!}

    <!-- CSS -->
    {!! Frontend::output('css') !!}

    <!-- JS at head.prepend -->
    {!! Frontend::output('js', 'head.prepend') !!}

    <!-- JS at head.append -->
    {!! Frontend::output('js', 'head.append') !!}

    <!-- Translation -->
    {!! Frontend::output('translation') !!}

    <script src="/assets/vendor/requirejs/require.js" type="text/javascript"></script>
    <script type="text/javascript">
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
                griper: 'core/js/modules/griper/griper',
                validator: 'core/js/modules/validator'
            }
        });

    </script>


    <!-- CUSTOM TAGS -->
    {!! Frontend::output('html', 'head.append') !!}

</head>
<body class="{{ Frontend::output('bodyClass') }}">

<!-- JS at body.prepend -->
{!! Frontend::output('js', 'body.prepend') !!}

<!-- CUSTOM TAGS -->
{!! Frontend::output('html', 'body.prepend') !!}

{!! $content !!}

<!-- JS at body.append -->
{!! Frontend::output('js', 'body.append') !!}

<!-- CUSTOM TAGS -->
{!! Frontend::output('html', 'body.append') !!}

<!-- Rule -->
{!! Frontend::output('rule') !!}

@include('common.alert')

</body>
</html>
