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

class LangTextArea extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@langTextArea';

    public function render()
    {
        $args = $this->arguments;

        XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load();
        XeFrontend::css('/assets/vendor/jqueryui/jquery-ui.css')->load();
        XeFrontend::js('/assets/vendor/expanding/expanding.js')->appendTo('head')->load();
//        XeFrontend::js('/assets/vendor/vendor.bundle.js')->appendTo('head')->load();
        XeFrontend::js('/assets/core/lang/langEditorBox.bundle.js')->appendTo('head')->load();
        XeFrontend::css('/assets/core/lang/langEditorBox.css')->load();

        $langKey = htmlspecialchars(array_get($args, 'langKey', array_get($args, 'value')), ENT_QUOTES, 'UTF-8');
        $autocomplete = Config::get('xe.lang.autocomplete');

        return "<div class=\"lang-editor-box\""
            . " data-name=\"{$args['name']}\""
            . " data-lang-key=\"{$langKey}\""
            . " data-multiline=\"true\""
            . " data-autocomplete=\"{$autocomplete}\"></div>";
    }

    public static function boot()
    {
    }

    public static function getSettingsURI()
    {
    }
}
