<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Form;

use Xpressengine\UIObject\AbstractUIObject;
use Xpressengine\UIObject\Element;

class FormText extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formText';

    public function render()
    {
        $args = $this->arguments;

        $box = new Element('div', ['class'=>'form-group']);
        $label = new Element('label', ['class' => 'hidden']);
        $input = new Element('input', ['type'=>'text', 'class'=>'form-control']);
        $description = new Element('p', ['class'=>'help-block']);

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'class':
                    $input->addClass($arg);
                    break;
                case 'label':
                    $label->removeClass('hidden')->html($arg);
                    break;
                case 'description':
                    $description->html($arg);
                    break;
                case 'name':
                    $nameSegs = explode('.', $arg);
                    $name = array_shift($nameSegs);
                    foreach ($nameSegs as $seg) {
                        $name .= "[$seg]";
                    }
                    $input->attr($key, $name);
                    break;
                case 'id':
                    $label->attr('for', $arg);
                    // pass to default
                default:
                    $input->attr($key, $arg);
                    break;
            }
        }

        $this->template = $box->append([$label, $input, $description])->render();

        return parent::render();
    }
}
