<?php

namespace Xpressengine\UIObjects\Lang;

use XeFrontend;
use Xpressengine\UIObject\AbstractUIObject;

class LangTextArea extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@langTextArea';

    public function render()
    {
        $args = $this->arguments;

        XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load();
        XeFrontend::css('/assets/vendor/jqueryui/jquery-ui.css')->load();
        XeFrontend::js('/assets/vendor/expanding/expanding.js')->appendTo('head')->load();
        XeFrontend::js('/assets/core/lang/LangEditorBox.js')->type('text/jsx')->appendTo('head')->load();
        XeFrontend::css('/assets/core/lang/LangEditorBox.css')->load();

        $langKey = htmlspecialchars($args['langKey'], ENT_QUOTES, 'UTF-8');

        return <<<OUPUT
    <div class="lang-editor-box" data-name="{$args['name']}" data-lang-key="{$langKey}" data-multiline="true"></div>
OUPUT;
    }

    public static function boot()
    {
    }

    public static function getSettingsURI()
    {
    }
}
