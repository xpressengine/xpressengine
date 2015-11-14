<?php
namespace Xpressengine\UIObjects\Form;

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
        
        $label = $this->markup['label'];
        $select = $this->markup['select'];
        $selectedValue = array_get($args, 'selected', null);

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'class':
                    $select->addClass($arg);
                    break;
                case 'label':
                    $label->removeClass('hidden')->html($arg);
                    break;
                case 'options':
                    foreach ($arg as $option) {
                        if (is_string($option) === true) {
                            $value = $text = $option;
                        } else {
                            $value = array_get($option, 'value');
                            $text = array_get($option, 'text', $value);

                            if ($selectedValue === null) {
                                $selected = array_get($option, 'selected', false) ? 'selected="selected"' : '';
                            } else {
                                $selected = $value === $selectedValue ? 'selected="selected"' : '';
                            }
                        }



                        $option = PhpQuery::pq("<option value=\"$value\" $selected\">$text</option>");
                        $select->append($option);
                    }

                case 'id':
                    $label->attr('for', $arg);
                    // pass to default
                default:
                    $select->attr($key, $arg);
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
