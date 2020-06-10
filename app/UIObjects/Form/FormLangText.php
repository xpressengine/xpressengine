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

use Illuminate\Support\Arr;
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

        $value = Arr::get($args, 'value');

        if($value !== null) {
            Arr::set($args, 'langKey', $value);
        }

        $label = Arr::get($args, 'label', '');
        if($label) {
            $label = '<label>'.$label.'</label>';
        }

        $content = uio('langText', $args);
        $description = Arr::get($args, 'description');

        return sprintf('
            <div class="form-group">
                %s
                %s
                <p class="help-block">%s</p>
            </div>
        ', $label, $content, $description);
    }
}
