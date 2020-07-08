<?php
/**
 * FormSelect.php
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
 * Class FormSelect
 *
 * @category    UIObjects
 * @package     App\UIObjects\Form
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FormSelect extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@formSelect';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;

        $box = new Element('div', ['class'=>'form-group']);
        $label = new Element('label', ['class' => 'hidden']);
        $select = new Element('select', ['class'=>'form-control']);
        $description = new Element('p', ['class'=>'help-block']);

        $selectedValue = array_get($args, 'selected', null);
        if ($selectedValue === null) {
            $selectedValue = array_get($args, 'value', null);
        }

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'class':
                    $select->addClass($arg);
                    break;
                case 'label':
                    $label->removeClass('hidden')->html($arg);
                    break;
                case 'options':
                    $options = $arg;
                    if (is_callable($options)) {
                        $options = $options();
                    }
                    foreach ($options as $value => $option) {
                        if (is_array($option) === false) {
                            $text = $option;
                            if (is_string($value) === false) {
                                $value = $option;
                            }
                        } else {
                            $value = array_get($option, 'value', $value);
                            $text = array_get($option, 'text', $value);
                        }
                        if ($selectedValue === null) {
                            $selected = array_get($option, 'selected', false) ? 'selected="selected"' : '';
                        } else {
                            $selected = in_array($value, (array) $selectedValue) ? 'selected="selected"' : '';
                        }
                        $optionEl = "<option value=\"$value\" $selected>$text</option>";
                        $select->append($optionEl);
                    }
                    break;
                case 'description':
                    $description->html(array_get($args, $key));
                    break;
                case 'name':
                    $nameSegs = explode('.', $arg);
                    $name = array_shift($nameSegs);
                    foreach ($nameSegs as $seg) {
                        $name .= "[$seg]";
                    }
                    $select->attr($key, $name);
                    break;
                case 'id':
                    $label->attr('for', $arg);
                    // pass to default
                default:
                    if (is_string($arg)) {
                        $select->attr($key, $arg);
                    }
                    break;
            }
        }

        $this->template = $box->append([$label, $select, $description])->render();

        return parent::render();
    }
}
