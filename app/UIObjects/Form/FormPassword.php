<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Form;

class FormPassword extends FormText
{
    protected static $id = 'uiobject/xpressengine@formPassword';

    public function render()
    {
        $this->arguments['type'] = 'password';

        return parent::render();
    }
}
