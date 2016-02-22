<?php

namespace Xpressengine\UIObjects\Lang;

use Frontend;
use Xpressengine\UIObject\AbstractUIObject;

class LangText extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@langText';

    public function render()
    {
        $args = $this->arguments;

        Frontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load();
        Frontend::css('/assets/vendor/jqueryui/jquery-ui.css')->load();
        Frontend::js('/assets/vendor/expanding/expanding.js')->appendTo('head')->load();
        Frontend::js('/assets/core/lang/LangEditorBox.js')->type('text/jsx')->appendTo('head')->load();
        Frontend::css('/assets/core/lang/LangEditorBox.css')->load();
        Frontend::css('/assets/core/lang/flag.css')->load();

        $langKey = htmlspecialchars($args['langKey'], ENT_QUOTES, 'UTF-8');

        return "<div class=\"lang-editor-box\" data-name=\"{$args['name']}\" data-lang-key=\"{$langKey}\"></div>";
    }

    public static function boot()
    {
    }

    public static function getSettingsURI()
    {
    }
}
