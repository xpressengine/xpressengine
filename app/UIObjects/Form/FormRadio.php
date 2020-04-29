<?php
/**
* FormRadio.php
*
* PHP version 7
*
* @category    UIObjects
* @package     App\UIObjects\Form
* @author      XE Developers <developers@xpressengine.com>
* @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
* @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
* @link        https://xpressengine.io
*/

namespace App\UIObjects\Form;

use Xpressengine\UIObject\AbstractUIObject;
use Xpressengine\UIObject\Element;

/**
* Class FormRadio
*
* @category    UIObjects
* @package     App\UIObjects\Form
* @author      XE Developers <developers@xpressengine.com>
* @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
* @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
* @link        https://xpressengine.io
*/
class FormRadio extends AbstractUIObject
{
    /**
    * The component id
    *
    * @var string
    */
    protected static $id = 'uiobject/xpressengine@formRadio';

    /**
    * Get the evaluated contents of the object.
    *
    * @return string
    */
    public function render()
    {
        $args = $this->arguments;

        $container = new Element('div', ['class' => 'form-group']);
        $containerLavel = new Element('label', ['class' => 'hidden']);
        $radioWrapper = new Element('div', ['class' => 'radioWrap']);
        $description = new Element('p', ['class' => 'help-block']);

        $nameGlobal = array_get($args, 'name');
        $radioboxes = null;

        $values = array_get($args, 'value', null);

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'radioboxes':
                    case 'options':
                        $radioboxes = $arg;
                    break;

                    case 'label':
                        $containerLavel->removeClass('hidden')->html($arg);
                    break;

                    case 'description':
                        $description->html($arg);
                    break;

                    case 'id':
                        $radioWrapper->attr('id', $arg);
                    break;
                    default:
                break;
            }
        }

        // make radioboxes
        foreach ($radioboxes as $itemKey => $itemValue) {
            $box = new Element('div', ['class' => 'radio']);
            $label = new Element('label');
            $radiobox = new Element('input', ['type' => 'radio']);

            $itemValue = value($itemValue);

            // $itemValue == title
            if (!is_array($itemValue)) {
                $text = $itemValue;
                $value = $itemKey;
                $checked = false;
            } else {
                $text = array_get($itemValue, 'text');
                $value = array_get($itemValue, 'value');
                $checked = array_get($itemValue, 'checked', false);
            }

            if ($values != null && $value == $values) {
                $checked = true;
            }

            $radiobox->attr('value', $value);
            $radiobox->attr('name', $nameGlobal);

            if ($checked) {
                $radiobox->attr('checked', 'checked');
            } else {
                $radiobox->removeAttr('checked');
            }

            $label->append([$radiobox, $text]);
            $box->append($label);
            $radioWrapper->append($box);
        }

        $this->template = $container->append([$containerLavel, $radioWrapper, $description])->render();

        return parent::render();
    }
}
