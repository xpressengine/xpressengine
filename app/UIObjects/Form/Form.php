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
                case 'fields':
                    $this->appendFields($form, $arg, array_get($args, 'value', []));
                default:
                    $form->attr($key, $arg);
                    break;
            }
        }

        return parent::render();
    }

    private function appendFields($form, $inputs, $values)
    {
        foreach ($inputs as $name => $arg) {

            preg_match("/^([^[]+)\\[(.+)\\]$/", $name, $m);
            if(!empty($m)) {
                $seq = (int)$m[2];
                $value = array_get($values, "$m[1].$seq");
                $name = $m[1].'[]';
            } else {
                $value = array_get($values, $name);
            }

            $arg['name'] = $name;

            $type = array_get($arg, '_type');
            unset($arg['_type']);

            $sectionName = array_get($arg, '_section', '기본설정');
            unset($arg['_section']);

            $section = $this->getSection($form, $sectionName);

            array_set($arg, 'value', $value);

            $uio = 'form'.ucfirst($type);
            $input = uio($uio, $arg);

            $this->wrapInput($name, $input)->appendTo($section);
        }
    }

    private function getSection($form, $sectionName)
    {
        $classname = 'form-section-'.str_replace([' ', '.'], '-', $sectionName);
        if(count($form['.'.$classname]) === 0){

            $section = sprintf('<div class="panel %s"><div class="panel-heading"><div class="pull-left"><h3>%s</h3></div></div><div class="panel-body"><div class="row"></div></div></div>', $classname, $sectionName);

            $sectionEl = PhpQuery::pq($section)->appendTo($form);
        }
        return $form['.'.$classname]['.panel-body .row'];
    }

    private function wrapInput($name, $input)
    {
        $classname = 'form-col-'.str_replace([' ', '.'], '-', $name);
        return PhpQuery::pq('<div class="col-md-6 '.$classname.'">'.(string)$input.'</div>');
    }
}
