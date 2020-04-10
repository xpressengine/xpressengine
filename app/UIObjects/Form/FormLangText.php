<?php
/**
 * FormLangText.php
 *
 * PHP version 7
 *
 * @category    UIObjects
 * @package     App\UIObjects\Form
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Form;

use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class FormLangText
 *
 * @category    UIObjects
 * @package     App\UIObjects\Form
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FormLangText extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@formLangText';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;

        $value = array_get($args, 'value');

        if($value !== null) {
            array_set($args, 'langKey', $value);
        }

        $label = array_get($args, 'label', '');
        if($label) {
            $label = '<label>'.$label.'</label>';
        }

        $content = uio('langText', $args);
        $description = array_get($args, 'description');

        return sprintf('
            <div class="form-group">
                %s
                %s
                <p class="help-block">%s</p>
            </div>
        ', $label, $content, $description);
    }
}
