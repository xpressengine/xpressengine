<?php
/**
 * LangTextArea.php
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
 * Class LangTextArea
 *
 * @category    UIObjects
 * @package     App\UIObjects\Lang
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class LangTextArea extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@langTextArea';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;

        XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.min.js')->appendTo('head')->load();
        XeFrontend::css('/assets/vendor/jqueryui/jquery-ui.min.css')->load();
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
}
