<!DOCTYPE html>
<html>
<head>
    <!-- CUSTOM TAGS -->
    {!! XeFrontend::output('html', 'head.prepend') !!}

    <!-- META -->
    <meta charset="utf-8">
    <meta name="Generator" content="XpressEngine 3">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {!! XeFrontend::output('meta') !!}

    <!-- TITLE -->
    <title>{!! XeLang::trans(XeFrontend::output('title')) !!}</title>

    <!-- ICON -->
    {!! XeFrontend::output('icon') !!}

    <!-- CSS -->
    {!! XeFrontend::output('css') !!}

    <!-- JS at head.prepend -->
    <script>
        var xeBaseURL = '{{  url()->to(null) }}'; // @DEPRECATED
    </script>
    {!! XeFrontend::output('js', 'head.prepend') !!}

    <script>
        XE.setup({
            baseURL: '{{  url()->to(null) }}',
            userToken: '{!! csrf_token() !!}',
            loginUserId: '{{ Auth::check() ? Auth::user()->getId() : ''}}', // @DEPRECATED
            useXeSpinner: true, // @DEPRECATED
            locale: '{{ Request::cookie('locale') ?: app('xe.translator')->getLocale() }}',
            defaultLocale: '{{ app('xe.translator')->getLocale() }}',
            fixedPrefix: '{{ app('config')['xe.routing.fixedPrefix'] }}',
            @if (in_array(Auth::user()->getRating(), [\Xpressengine\User\Rating::SUPER, \Xpressengine\User\Rating::MANAGER]))
                settingsPrefix: '{{ app('config')['xe.routing.settingsPrefix'] }}',
            @endif
            routes: {!! XeFrontend::output('route') !!},
            translation: {!! XeFrontend::output('translation') !!}
        });
    </script>

    <!-- JS at head.append -->
    {!! XeFrontend::output('js', 'head.append') !!}


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

@include(app('config')['xe.HtmlWrapper.alert'])

</body>
</html>
