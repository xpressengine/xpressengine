<?php
/**
 * LangText.php
 *
 * PHP version 7
 *
 * @category    UIObjects
 * @package     App\UIObjects\Lang
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Lang;

use XeFrontend;
use Config;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class LangText
 *
 * @category    UIObjects
 * @package     App\UIObjects\Lang
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class LangText extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@langText';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;

        XeFrontend::js([
            '/assets/vendor/jqueryui/jquery-ui.min.js',
            '/assets/core/lang/langEditorBox.bundle.js'
        ])->load();

        XeFrontend::css([
            '/assets/vendor/jqueryui/jquery-ui.min.css',
            '/assets/core/lang/langEditorBox.css',
            '/assets/core/xe-ui-component/xe-ui-component.css'
        ])->load();

        $locale = app('xe.translator')->getLocale();
        XeFrontend::html('lang.set-url')->content("
            <script>
                var langSearchUrl = '".route('lang.search', ['locale'=>$locale])."';
            </script>
        ")->appendTo('head')->load();


        $langKey = htmlspecialchars(array_get($args, 'langKey', array_get($args, 'value')), ENT_QUOTES, 'UTF-8');
        $url = route('lang.lines.key', ['key'=>$langKey]);
        $autocomplete = Config::get('xe.lang.autocomplete');
        $placeholder = array_get($args, 'placeholder');
        $required = array_get($args, 'required');


        return "<div class=\"lang-editor-box\""
            . " data-name=\"{$args['name']}\""
            . " data-lang-key=\"{$langKey}\""
            . " data-request-url=\"{$url}\""
            . " data-placeholder=\"{$placeholder}\""
            . " data-required=\"{$required}\""
            . " data-autocomplete=\"{$autocomplete}\"></div>";
    }
}
