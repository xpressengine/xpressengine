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
    <title>{!! XeFrontend::output('title') !!}</title>

    <!-- ICON -->
    {!! XeFrontend::output('icon') !!}

    <!-- CSS -->
    {!! XeFrontend::output('css') !!}

    <!-- JS at head -->
    {!! XeFrontend::output('js', 'head.append') !!}

    <script type="text/javascript">
    System.import('xecore:/common/js/xe').then(function(XE) {
        XE.setup({
            loginUserId: '{{ Auth::user()->getId() }}',
            loadedTime: {{ time() }},
            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
        });

        <!-- Translation -->
        {!! XeFrontend::output('translation') !!}

        @if (in_array(Auth::user()->getRating(), [\Xpressengine\User\Rating::SUPER, \Xpressengine\User\Rating::MANAGER]))
            XE.configure({managePrefix: '{{ app('config')['xe.routing.settingsPrefix'] }}'});
        @endif
    });
    </script>


    <!-- CUSTOM TAGS -->
    {!! XeFrontend::output('html', 'head.append') !!}

</head>
<body class="{{ XeFrontend::output('bodyClass') }}">
<b>팝업임</b>
<!-- CUSTOM TAGS -->
{!! XeFrontend::output('html', 'body.prepend') !!}

{!! $content !!}

<!-- JS at body -->
{!! XeFrontend::output('js', 'body.append') !!}

<!-- CUSTOM TAGS -->
{!! XeFrontend::output('html', 'body.append') !!}

<!-- Rule -->
{!! XeFrontend::output('rule') !!}

@include('common.alert')

</body>
</html>
