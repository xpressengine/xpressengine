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
    {{--<script type="text/javascript">--}}

        {{--//ckeditor--}}
        {{--XEeditor.define({--}}
            {{--name: 'editor.ckeditor',--}}
            {{--initialize: function(selector, options) {--}}
                {{--CKEDITOR.replace(selector, options || {});--}}

                {{--this.addProps({--}}
                    {{--selector: selector--}}
                    {{--, options: options--}}
                {{--});--}}
            {{--},--}}
            {{--getContents: function() {--}}
                {{--return CKEDITOR.instances[this.props.selector].getData();--}}
            {{--},--}}
            {{--setContents: function(text) {--}}
                {{--CKEDITOR.instances[this.props.selector].setData(text);--}}
            {{--},--}}
            {{--addContents: function(text) {--}}
                {{--CKEDITOR.instances[this.props.selector].insertHtml(text);--}}
            {{--}--}}
        {{--});--}}

        {{--//tinyMCE--}}
        {{--XEeditor.define({--}}
            {{--name: 'editor.tinyMCE',--}}
            {{--initialize: function(selector, options) {--}}
                {{--tinymce.init({--}}
                    {{--selector: selector,--}}
                    {{--setup: function (editor) {--}}
                        {{--editor.on('keyup', function (e) {--}}

                        {{--});--}}
                    {{--}--}}
                {{--});--}}

                {{--this.addProps({--}}
                    {{--selector: selector--}}
                    {{--, options: options--}}
                    {{--, id: selector.replace('#', '')--}}
                {{--});--}}
            {{--},--}}
            {{--getContents: function() {--}}
                {{--return tinymce.get(this.props.id).getContent();--}}
            {{--},--}}
            {{--setContents: function(text) {--}}
                {{--tinymce.get(this.props.id).setContent(text);--}}
            {{--},--}}
            {{--addContents: function(text) {--}}
                {{--tinymce.get(this.props.id).execCommand('mceInsertContent', false, text);--}}
            {{--}--}}
        {{--});--}}

        {{--$(function() {--}}
            {{--var ckEditor = XEeditor.getEditor('editor.ckeditor');--}}
            {{--var tinyEditor = XEeditor.getEditor('editor.tinyMCE');--}}

            {{--var editor11 = ckEditor.create('editor1', {});--}}
            {{--eidtor11.addComponent();--}}

            {{--var editor33 = ckEditor.create('editor3', {});--}}
            {{--var editor22 = tinyEditor.create('#editor2', {});--}}
            {{--var editor44 = tinyEditor.create('#editor4', {});--}}

            {{--window.editor11 = editor11;--}}
            {{--window.editor22 = editor22;--}}
            {{--window.editor33 = editor33;--}}
            {{--window.editor44 = editor44;--}}
        {{--});--}}

    {{--</script>--}}
    <!-- JS at head.append -->
    {!! XeFrontend::output('js', 'head.append') !!}

    <!-- CUSTOM TAGS -->
    {!! XeFrontend::output('html', 'head.append') !!}
</head>

<body class="{{ XeFrontend::output('bodyClass') }}">

<textarea name="test" id="editor1" cols="30" rows="10"></textarea>
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
