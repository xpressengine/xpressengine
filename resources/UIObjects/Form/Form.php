<?php
namespace Xpressengine\UIObjects\Form;

use PhpQuery\PhpQuery;
use Xpressengine\UIObject\AbstractUIObject;

class Form extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@form';

    public function render()
    {
        $args = $this->arguments;

        PhpQuery::newDocument();
        if(array_get($args,'action') === null) {
            $this->template = '<div class="panel-group"></div>';
        } else {
            $this->template = '<form method="POST" enctype="multipart/form-data"></form>';
        }

        $this->markup = PhpQuery::pq($this->template);
        $form = $this->markup;

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'class':
                    $form->addClass($arg);
                    break;
                case 'inputs':
                    $this->appendInputs($form, $arg, array_get($args, 'values'));
                default:
                    $form->attr($key, $arg);
                    break;
            }
        }

        return parent::render();
    }

    private function appendInputs($form, $inputs, $values)
    {
        foreach ($inputs as $name => $arg) {
            $arg['name'] = $name;
            $type = array_get($arg, '_type');
            unset($arg['_type']);

            $sectionName = array_get($arg, '_section', '기본설정');
            unset($arg['_section']);

            $section = $this->getSection($form, $sectionName);

            $value = array_get($values, $name);
            array_set($arg, 'value', $value);

            $uio = 'form'.ucfirst($type);
            $input = uio($uio, $arg);

            $this->wrapInput($input)->appendTo($section);
        }
    }

    private function getSection($form, $sectionName)
    {
        $classname = 'section-'.$sectionName;
        if(count($form['.'.$classname]) === 0){

            $section = sprintf('<div class="panel %s"><div class="panel-heading"><div class="pull-left"><h3>%s</h3></div></div><div class="panel-body"><div class="row"></div></div></div>', $classname, $sectionName);

            $sectionEl = PhpQuery::pq($section)->appendTo($form);
        }
        return $form['.'.$classname]['.panel-body .row'];
    }

    private function wrapInput($input)
    {
        return PhpQuery::pq('<div class="col-sm-12">'.(string)$input.'</div>');
    }
}
