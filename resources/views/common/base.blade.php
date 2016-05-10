<!DOCTYPE html>
<html>
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

    <script type="text/javascript">
        XE.initialize(function() {
            XE.setup({
                'X-CSRF-TOKEN': '{!! csrf_token() !!}',
                loginUserId: '{{ Auth::user()->getId() }}'
            });

            XE.configure({
                locale: '{{ session()->get('locale') ?: app('xe.translator')->getLocale() }}',
                defaultLocale: '{{ app('xe.translator')->getLocale() }}',
                @if (in_array(Auth::user()->getRating(), [\Xpressengine\User\Rating::SUPER, \Xpressengine\User\Rating::MANAGER]))
                managePrefix: '{{ app('config')['xe.routing.settingsPrefix'] }}'
                @endif
            });

            <!-- Translation -->
            {!! XeFrontend::output('translation') !!}
        });
    </script>
    {{--<script src="http://cdn.tinymce.com/4/tinymce.min.js"></script>--}}
    {{--<script src="http://cdn.ckeditor.com/4.4.6/standard/ckeditor.js"></script>--}}
    {{--<script src="/assets/core/common/js/xe.editor.js"></script>--}}
    <!-- JS at head.append -->
    {!! XeFrontend::output('js', 'head.append') !!}

    <!-- CUSTOM TAGS -->
    {!! XeFrontend::output('html', 'head.append') !!}
</head>

<body class="{{ XeFrontend::output('bodyClass') }}">

{{--<textarea name="test" id="editor1" cols="30" rows="10"></textarea>--}}
{{--<textarea name="test2" id="editor2" cols="30" rows="10"></textarea>--}}
{{--<textarea name="test3" id="editor3" cols="30" rows="10"></textarea>--}}
{{--<textarea name="test4" id="editor4" cols="30" rows="10"></textarea>--}}

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
