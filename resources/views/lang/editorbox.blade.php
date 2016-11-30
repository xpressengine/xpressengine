{{ XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load() }}
{{ XeFrontend::css('/assets/vendor/jqueryui/jquery-ui.css')->load() }}
{{ XeFrontend::js('/assets/vendor/expanding/expanding.js')->appendTo('head')->load() }}
{{--{{ XeFrontend::js('/assets/vendor/vendor.bundle.js')->appendTo('head')->load() }}--}}
{{ XeFrontend::js('/assets/core/lang/langEditorBox.bundle.js')->appendTo('head')->load() }}
{{ XeFrontend::css('/assets/core/lang/langEditorBox.css')->load() }}
<div class="lang-editor-box"
     data-name="{!! isset($name) ? htmlspecialchars($name, ENT_QUOTES, 'UTF-8') : '' !!}"
     data-lang-key="{!! isset($langKey) ? htmlspecialchars($langKey, ENT_QUOTES, 'UTF-8') : '' !!}"
     data-multiline="{!! isset($multiline) ? htmlspecialchars($multiline, ENT_QUOTES, 'UTF-8') : 'false' !!}"
     data-lines="{!! isset($lines) ? htmlspecialchars(json_enc($lines), ENT_QUOTES, 'UTF-8') : '' !!}"
     >
</div>
