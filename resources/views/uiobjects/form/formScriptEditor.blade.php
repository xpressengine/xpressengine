<div id="monaco"></div>
<textarea id="monaco_value" name="content" type="text" hidden>
{!! html_entity_decode(array_get($args, 'value')) !!}
</textarea>

<style>
    #monaco {
        height: 500px;
    }
</style>

<script>
    var editor;
    require.config({ paths: { 'vs': '/assets/vendor/monaco-editor/min/vs' }});
    require(['vs/editor/editor.main'], function() {
        editor = monaco.editor.create(document.getElementById('monaco'), {
            theme: 'vs-dark',
            fontFamily: 'Nanum Gothic Coding',
            automaticLayout: true,
            language: 'html',
            value: ''
        });
        editor.onDidChangeModelContent(function (e) {
            $('#monaco_value').val(window.editor.getValue());
        });
        window.editor.setValue($('#monaco_value').val());
    });
</script>
