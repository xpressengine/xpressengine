<?php

namespace Xpressengine\UIObjects\Lang;

use XeFrontend;
use Xpressengine\UIObject\AbstractUIObject;

class LangText extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@langText';

    public function render()
    {
        $args = $this->arguments;

        XeFrontend::js(
            [
                '/assets/vendor/jqueryui/jquery-ui.js',
                '/assets/vendor/expanding/expanding.js',
                '/assets/core/lang/LangEditorBox.bundle.js'
            ]
        )->load();

        XeFrontend::css(
            [
                '/assets/vendor/jqueryui/jquery-ui.css',
                '/assets/core/lang/LangEditorBox.css',
                '/assets/core/lang/flag.css'
            ]
        )->load();

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
