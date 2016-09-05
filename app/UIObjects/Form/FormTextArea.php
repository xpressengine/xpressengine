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

class FormTextArea extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formTextArea';

    protected $template = '<div class="form-group">
        <label for="" class="hidden"></label>
        <textarea class="form-control" rows="3" placeholder=""></textarea>
        <p class="help-block"></p>
    </div>';

    public function render()
    {
        $args = $this->arguments;
        PhpQuery::newDocument();
        $this->markup = PhpQuery::pq($this->template);

        $label    = $this->markup['label'];
        $textarea = $this->markup['textarea'];
        $description = $this->markup['.help-block'];

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'class':
                    $textarea->addClass($arg);
                    break;
                case 'label':
                    $label->removeClass('hidden')->html($arg);
                    break;
                case 'description':
                    $description->html($arg);
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
