<?php
/**
 * Created by PhpStorm.
 * User: seungman
 * Date: 2017. 4. 20.
 * Time: PM 4:42
 */

namespace App\UIObjects\Form;

use XeFrontend;
use Xpressengine\UIObject\AbstractUIObject;

class FormColorpicker extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formColorpicker';

    protected $view = 'uiobjects.form.formColorpicker';

    public function render()
    {
        $this->loadAssets();

        $args = $this->arguments;
        $seq  = $this->seq();

        $selector = array_get($args, 'name').$seq;

//        dd($args);

        // render template
        $this->template = \View::make($this->view, ['args' => $args, 'selector' => $selector])->render();

        return parent::render();
    }

    protected function loadAssets()
    {

        XeFrontend::js(
            [
                'assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js',
            ]
        )->load();

        XeFrontend::css(
            [
                'assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css',
            ]
        )->load();
    }
}