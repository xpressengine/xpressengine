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
        <label for="" class="hidden"></label>
        <div class="checkbox"></div>
    </div>';

    protected $box;

    public function render()
    {
        $args = $this->arguments;
        PhpQuery::newDocument();
        $this->markup = PhpQuery::pq($this->template);

        $label = $this->markup['label'];
        $this->box = $this->markup['.checkbox'];

        $checkboxes = array_get($args, 'checkboxes');
        $nameGlobal = array_get($args, 'name');

        $labelText = array_get($args, 'label');
        if($labelText !== null) {
            $label->removeClass('hidden')->html($labelText);
        }

        // checkbox가 따로 있을 경우
        if($checkboxes !== null) {
            foreach((array) $checkboxes as $arg){
                $checkboxObj = PhpQuery::pq(
                    "<label class=\"checkbox-inline\"><input type=\"checkbox\"><span></span></label>"
                );
                $arg = array_add($arg, 'name', $nameGlobal.'[]');
                $this->appendCheckbox($checkboxObj, $arg);
            }
        // checkbox가 따로 없을 경우
        } else {
            $checkboxObj = PhpQuery::pq("<input type=\"checkbox\">");
            foreach ($args as $key => $arg) {
                switch ($key) {
                    case 'class':
                        $checkboxObj->addClass($arg);
                        break;
                    case 'id':
                        $label->attr('for', $arg);
                        // pass to default
                    default:
                        $checkboxObj->attr($key, $arg);
                        break;
                }
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

    /**
     * appendCheckbox
     *
     * @param $args
     * @param $dom
     *
     * @return void
     */
    protected function appendCheckbox($dom, $args)
    {
        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'class':
                    $dom['input']->addClass('class', $arg);
                    break;
                case 'label':
                    break;
                case 'text':
                    $dom['span']->text($arg);
                    break;
                default:
                    $dom['input']->attr($key, $arg);
                    break;
            }
        }
        $this->box->append($dom);
}
}
