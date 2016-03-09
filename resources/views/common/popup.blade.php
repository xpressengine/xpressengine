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

    {{-- set CSRF token for ajax --}}
    <!-- todo: move to js file!! -->

    <!-- Translation -->
    {!! XeFrontend::output('translation') !!}

    <script src="/assets/vendor/requirejs/require.js" type="text/javascript"></script>
    <script type="text/javascript">
        XE.setup({
            loginUserId: '{{ Auth::user()->getId() }}',
            loadedTime: {{ time() }},
            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
        });

        require.config({
            baseUrl: '/assets/vendor/',
            paths: {
                griper: '../core/js/common/modules/griper/griper',
                validator: '../core/common/js/modules/validator'
            }
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
