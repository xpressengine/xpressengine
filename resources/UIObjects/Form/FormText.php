<?php
namespace Xpressengine\UIObjects\Form;

use PhpQuery\PhpQuery;
use Xpressengine\UIObject\AbstractUIObject;

class FormText extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formText';

    protected $template = '<div class="form-group">
        <label for="" class="hidden"></label>
        <input type="text" class="form-control" id="" placeholder="">
    </div>';

    public function render()
    {
        $args = $this->arguments;
        PhpQuery::newDocument();
        $this->markup = PhpQuery::pq($this->template);

        $label = $this->markup['label'];
        $input = $this->markup['input'];

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'class':
                    $input->addClass('class', $arg);
                    break;
                case 'label':
                    $label->removeClass('hidden')->html($arg);
                    break;
                case 'id':
                    $label->attr('for', $arg);
                // pass to default
                default:
                    $input->attr($key, $arg);
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
