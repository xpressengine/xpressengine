{{ Frontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load() }}
{{ Frontend::css('/assets/vendor/jqueryui/jquery-ui.css')->load() }}
{{ Frontend::js('/assets/vendor/expanding/expanding.js')->appendTo('head')->load() }}
{{ Frontend::js('/assets/core/lang/LangEditorBox.js')->type('text/jsx')->appendTo('head')->load() }}
{{ Frontend::css('/assets/core/lang/LangEditorBox.css')->load() }}
<div class="lang-editor-box"
     data-name="{!! isset($name) ? htmlspecialchars($name, ENT_QUOTES, 'UTF-8') : '' !!}"
     data-lang-key="{!! isset($langKey) ? htmlspecialchars($langKey, ENT_QUOTES, 'UTF-8') : '' !!}"
     data-multiline="{!! isset($multiline) ? htmlspecialchars($multiline, ENT_QUOTES, 'UTF-8') : 'false' !!}"
     data-lines="{!! isset($lines) ? htmlspecialchars(json_enc($lines), ENT_QUOTES, 'UTF-8') : '' !!}"
     >
</div>
