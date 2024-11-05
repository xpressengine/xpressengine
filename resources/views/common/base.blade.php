<!DOCTYPE html>
<html lang="{{app('xe.translator')->getLocale()}}">
<head>
    <!-- CUSTOM TAGS -->
    {!! XeFrontend::output('html', 'head.prepend') !!}

    <!-- META -->
    <meta charset="utf-8">
    <meta name="Generator" content="XpressEngine 3">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {!! XeFrontend::output('meta') !!}
    {!! XeFrontend::output('preload') !!}

    <!-- TITLE -->
    <title>{!! XeLang::trans(XeFrontend::output('title')) !!}</title>

    <!-- ICON -->
    {!! XeFrontend::output('icon') !!}

    <!-- CSS -->
    {!! XeFrontend::output('css') !!}

    <!-- JS at head.prepend -->
    <script>
        var xeBaseURL = '{{ url('/') }}'; // @DEPRECATED
    </script>
    {!! XeFrontend::output('js', 'head.prepend') !!}

    <script>
        if (window.XE) {
            XE.setup({
                baseURL: '{{  url('/') }}',
                assetsURL: '{{  request()->root() }}',
                userToken: '{!! csrf_token() !!}',
                loginUserId: '{{ Auth::check() ? Auth::user()->getId() : ''}}', // @DEPRECATED
                user: {
                    id: '{{ Auth::user()->getId() }}',
                    rating: '{{ Auth::user()->getRating() }}'
                },
                useXeSpinner: true, // @DEPRECATED
                locale: '{{ app()->getLocale() }}',
                defaultLocale: '{{ app('xe.translator')->getLocale() }}',
                fixedPrefix: '{{ app('config')['xe.routing.fixedPrefix'] }}',
                @if (in_array(Auth::user()->getRating(), [\Xpressengine\User\Rating::SUPER, \Xpressengine\User\Rating::MANAGER]))
                settingsPrefix: '{{ app('config')['xe.routing.settingsPrefix'] }}',
                @endif
                routes: {!! XeFrontend::output('route') !!},
                ruleSet: {!! XeFrontend::output('rule') !!},
                translation: {!! XeFrontend::output('translation') !!},
                passwordRules: '{!! app('xe.config')->getVal('user.register.password_rules') !!}'
            });
        }
        if (jQuery) {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        }
    </script>

    <!-- JS at head.append -->
    {!! XeFrontend::output('js', 'head.append') !!}

    <!-- CUSTOM TAGS -->
    {!! XeFrontend::output('html', 'head.append') !!}

</head>

<body class="{!! XeFrontend::output('bodyClass') !!}">

<!-- JS at body.prepend -->
{!! XeFrontend::output('js', 'body.prepend') !!}

<!-- CUSTOM TAGS -->
{!! XeFrontend::output('html', 'body.prepend') !!}

{!! $content !!}

<!-- JS at body.append -->
{!! XeFrontend::output('js', 'body.append') !!}

<!-- CUSTOM TAGS -->
{!! XeFrontend::output('html', 'body.append') !!}

@include(app('config')['xe.HtmlWrapper.alert'])

</body>
</html>
