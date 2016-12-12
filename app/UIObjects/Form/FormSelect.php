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

class FormSelect extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formSelect';

    protected $template = '<div class="form-group">
        <label for="" class="hidden"></label>
        <select class="form-control" name="" id="">
        </select>
    </div>';

    public function render()
    {
        $args = $this->arguments;
        PhpQuery::newDocument();

        $this->markup = PhpQuery::pq($this->template);

        $labelEl = $this->markup['label'];
        $selectEl = $this->markup['select'];
        $selectedValue = array_get($args, 'selected', null);
        if ($selectedValue === null) {
            $selectedValue = array_get($args, 'value', null);
        }

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'class':
                    $selectEl->addClass($arg);
                    break;
                case 'label':
                    $labelEl->removeClass('hidden')->html($arg);
                    break;
                case 'options':
                    $options = $arg;
                    if(is_callable($options)) {
                        $options = $options();
                    }
                    foreach ($options as $value => $option) {
                        if (is_array($option) === false) {
                            $text = $option;
                            if(is_string($value) === false) {
                                $value = $option;
                            }
                            $selected = '';
                        } else {
                            $value = array_get($option, 'value', $value);
                            $text = array_get($option, 'text', $value);
                        }
                        if ($selectedValue === null) {
                            $selected = array_get($option, 'selected', false) ? 'selected="selected"' : '';
                        } else {
                            $selected = $value === $selectedValue ? 'selected="selected"' : '';
                        }
                        $optionEl = PhpQuery::pq("<option value=\"$value\" $selected \">$text</option>");
                        $selectEl->append($optionEl);
                    }
                    break;

                case 'id':
                    $labelEl->attr('for', $arg);
                    // pass to default
                default:
                    if(is_string($arg)){
                        $selectEl->attr($key, $arg);
                    }
                    break;
            }
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
