<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Lang;

use XeFrontend;
use Config;
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
//                '/assets/vendor/vendor.bundle.js',
                '/assets/vendor/expanding/expanding.js',
                '/assets/core/lang/langEditorBox.bundle.js'
            ]
        )->load();

        XeFrontend::css(
            [
                '/assets/vendor/jqueryui/jquery-ui.css',
                '/assets/core/lang/langEditorBox.css',
                '/assets/core/xe-ui-component/xe-ui-component.css'
            ]
        )->load();

        $locale = app('xe.translator')->getLocale();
        XeFrontend::html('lang.set-url')->content("
            <script>
                var langSearchUrl = '".route('settings.lang.search', ['locale'=>$locale])."';
            </script>
        ")->appendTo('head')->load();

        $langKey = htmlspecialchars(array_get($args, 'langKey', array_get($args, 'value')), ENT_QUOTES, 'UTF-8');
        $url = route('settings.lang.lines.key', ['key'=>$langKey]);
        $autocomplete = Config::get('xe.lang.autocomplete');

        return "<div class=\"lang-editor-box\""
            . " data-name=\"{$args['name']}\""
            . " data-lang-key=\"{$langKey}\""
            . " data-request-url=\"{$url}\""
            . " data-autocomplete=\"{$autocomplete}\"></div>";
    }

}
