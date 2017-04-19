<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Form;

use PhpQuery\PhpQuery;
use Xpressengine\UIObject\AbstractUIObject;

class FormCheckbox extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formCheckbox';

    protected $template = '<div class="form-group">
        <div class="checkboxWrap"></div>
        <p class="help-block"></p>
    </div>';

    protected $box;

    public function render()
    {
        $args = $this->arguments;
        PhpQuery::newDocument();
        $this->markup = PhpQuery::pq($this->template);
        $this->box = $this->markup['.checkboxWrap'];

        $nameGlobal = array_get($args, 'name');
        $checkboxes = null;

        $args = array_set($args, 'name', $nameGlobal.'[]');
        $values = array_get($args, 'value', null);

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'checkboxes':
                case 'options':
                    $checkboxes = $arg;
                    break;

                case 'description':
                    $this->markup['.help-block']->html(array_get($args, $key));
                    break;

                case 'id':
                    $this->box->attr('id', $arg);
                    break;

                default:
                    break;

            }
        }

        foreach ($checkboxes as $itemKey => $itemValue) {
            $checkboxMarkup = PhpQuery::pq("<div class=\"checkbox\"><label class=\"hidden\"><input type=\"checkbox\" value=\"\"></label></div>");
            $checkbox = $checkboxMarkup->find('input');
            $label = $checkboxMarkup->find('label');
            $text = null;
            $value = null;
            $checked = '';

            if (!is_array($itemValue)) {
                $text = $itemValue;
                $value = $itemKey;
                $checked = '';

            } else {
                $value = array_get($itemValue, 'value');
                $text = array_get($itemValue, 'text');
                $checked = array_get($itemValue, 'checked');

            }

            if($values != null && in_array($value, $values)) {
                $checked = true;
            }

            $checkbox->val($value);
            $label->append($text);

            if(is_callable($itemValue)) {
                $itemValue = $itemValue();
            }

            if($checked) {
                $checkbox->attr('checked', 'checked');
            } else {
                $checkbox->removeAttr('checked');
            }

            foreach ($args as $key => $arg) {
                switch($key) {
                    case 'class':
                        $checkbox->addClass($arg);
                        break;

                    case 'label':
                        $label->removeClass('hidden')->append($arg);
                        break;

                    default:
                        $checkbox->attr($key, $arg);
                        break;
                }
            }

            $this->box->append($checkboxMarkup);
        }


        return parent::render();
    }

    public static function boot()
    {
    }

    public static function getSettingsURI()
    {
    }
}
