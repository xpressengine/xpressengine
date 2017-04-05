<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Form;

use Xpressengine\UIObject\AbstractUIObject;

class FormLangTextArea extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formLangTextArea';

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

        $content = uio('langTextArea', $args);
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
