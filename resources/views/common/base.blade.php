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
    <script>var xeBaseURL = '{{  url() }}';</script>
    {!! XeFrontend::output('js', 'head.prepend') !!}

    <script type="text/javascript">
        XE.setup({
            'X-CSRF-TOKEN': '{!! csrf_token() !!}',
            loginUserId: '{{ Auth::check() ? Auth::user()->getId() : ''}}',
            useXeSpinner: true
        });

        XE.configure({
            locale: '{{ Request::cookie('locale') ?: app('xe.translator')->getLocale() }}',
            defaultLocale: '{{ app('xe.translator')->getLocale() }}',
            @if (in_array(Auth::user()->getRating(), [\Xpressengine\User\Rating::SUPER, \Xpressengine\User\Rating::MANAGER]))
            managePrefix: '{{ app('config')['xe.routing.settingsPrefix'] }}'
            @endif
        });

        <!-- Translation -->
        {!! XeFrontend::output('translation') !!}
    </script>

    <!-- JS at head.append -->
    {!! XeFrontend::output('js', 'head.append') !!}

    <!-- CUSTOM TAGS -->
    {!! XeFrontend::output('html', 'head.append') !!}


</head>

<body class="{{ XeFrontend::output('bodyClass') }}">

{{--<script src="assets/core/xe-ui-component/js/xe-chart.js"></script>--}}

{{--<div id="chart1"></div>--}}

{{--<script type="text/javascript">--}}
    {{--$(function () {--}}
        {{--var customOptions = {--}}
            {{--axis: {--}}
                {{--x: {--}}
                    {{--type: 'category',--}}
                    {{--categories: ['상품1', '상품2','상품3','상품4','상품5','상품6']--}}
                {{--}--}}
            {{--}--}}
        {{--};--}}
        {{--var data = [--}}
            {{--['data1', 300, 350, 300, 0, 0, 0],--}}
            {{--['data2', 130, 100, 140, 200, 150, 50]--}}
        {{--];--}}

        {{--var chart1 = new XeChart('bar', {--}}
            {{--selector: '#chart1',--}}
            {{--data: data,--}}
            {{--customOptions: customOptions--}}
        {{--});--}}

        {{--console.log(chart1);--}}

        {{--chart1.draw();--}}

{{--//        setTimeout(function () {--}}
{{--//            chart1.destroy();--}}
{{--//        }, 3000);--}}
    {{--})--}}
{{--</script>--}}

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
