<?php

namespace Xpressengine\UIObjects\Lang;

use Frontend;
use Xpressengine\UIObject\AbstractUIObject;

class LangTextArea extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@langTextArea';

    public function render()
    {
        $args = $this->arguments;

        Frontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load();
        Frontend::css('/assets/vendor/jqueryui/jquery-ui.css')->load();
        Frontend::js('/assets/vendor/expanding/expanding.js')->appendTo('head')->load();
        Frontend::js('/assets/vendor/lang/LangEditorBox.js')->type('text/jsx')->appendTo('head')->load();
        Frontend::css('/assets/vendor/lang/LangEditorBox.css')->load();

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
