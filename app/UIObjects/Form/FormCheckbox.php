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

class FormCheckbox extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formCheckbox';

    public function render()
    {
        $args = $this->arguments;

        $container = new Element('div', ['class'=>'form-group']);
        $containerLavel = new Element('label', ['class' => 'hidden']);
        $checkboxWrapper = new Element('div', ['class'=>'checkboxWrap']);
        $description = new Element('p', ['class'=>'help-block']);

        $nameGlobal = array_get($args, 'name');
        $checkboxes = null;

        $values = array_get($args, 'value', null);

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'checkboxes':
                case 'options':
                    $checkboxes = $arg;
                    break;

                case 'label':
                    $containerLavel->removeClass('hidden')->html($arg);
                    break;

                case 'description':
                    $description->html($arg);
                    break;

                case 'id':
                    $checkboxWrapper->attr('id', $arg);
                    break;
                default:
                    break;
            }
        }

        // make checkboxes
        foreach ($checkboxes as $itemKey => $itemValue) {
            $box = new Element('div', ['class'=>'checkbox']);
            $label = new Element('label');
            $checkbox = new Element('input', ['type'=>'checkbox']);

            $itemValue = value($itemValue);

            // $itemValue == title
            if (!is_array($itemValue)) {
                $text = $itemValue;
                $value = $itemKey;
                $checked = false;
            } else {
                $text = array_get($itemValue, 'text');
                $value = array_get($itemValue, 'value');
                $checked = array_get($itemValue, 'checked', false);
            }

            if ($values != null && in_array($value, $values)) {
                $checked = true;
            }

            $checkbox->attr('value', $value);
            $checkbox->attr('name', $nameGlobal.'[]');

            if ($checked) {
                $checkbox->attr('checked', 'checked');
            } else {
                $checkbox->removeAttr('checked');
            }

            $label->append([$checkbox,$text]);
            $box->append($label);
            $checkboxWrapper->append($box);
        }

        $this->template = $container->append([$containerLavel, $checkboxWrapper, $description])->render();

        return parent::render();
    }
}
