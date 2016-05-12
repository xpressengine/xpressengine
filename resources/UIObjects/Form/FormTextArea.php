<?php
namespace Xpressengine\UIObjects\Form;

use PhpQuery\PhpQuery;
use Xpressengine\UIObject\AbstractUIObject;

class FormTextArea extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formTextArea';

    protected $template = '<div class="form-group">
        <label for="" class="hidden"></label>
        <textarea class="form-control" rows="3" placeholder=""></textarea>
    </div>';

    public function render()
    {
        $args = $this->arguments;
        PhpQuery::newDocument();
        $this->markup = PhpQuery::pq($this->template);

        $label    = $this->markup['label'];
        $textarea = $this->markup['textarea'];

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'class':
                    $textarea->addClass($arg);
                    break;
                case 'label':
                    $label->removeClass('hidden')->html($arg);
                    break;
                case 'value':
                    $textarea->html($arg);
                    break;
                case 'id':
                    $label->attr('for', $arg);
                    // pass to default
                default:
                    $textarea->attr($key, $arg);
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
