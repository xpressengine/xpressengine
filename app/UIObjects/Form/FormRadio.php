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
        $radioOptionElements = $this->radioOptionElements();

        $formGroupElement = new Element('div', ['class' => 'form-group']);
        $formGroupLabelElement = $this->labelElement();
        $radioWrapperElement = $this->radioWrapperElement();
        $descriptionElement = $this->descriptionElement();
        $smallElement = $this->smallElement();

        foreach ($radioOptionElements as $radioOptionElement) {
            $radioWrapperElement->append($radioOptionElement);
        }

        $formGroupElement->append([
            $formGroupLabelElement,
            $smallElement,
            $radioWrapperElement,
            $descriptionElement,
        ]);

        $this->template = $formGroupElement->render();
        return parent::render();
    }

    /**
     * label element
     *
     * @return Element
     */
    private function labelElement()
    {
        $labelValue = array_get($this->arguments, 'label');
        $requiredValue = in_array(array_get($this->arguments, 'required', false), ['required', true], true);

        $labelElement = new Element('label', ['class' => 'hidden']);

        if ($labelValue !== null) {
            $labelElement->html($labelValue);
            $labelElement->removeClass('hidden');
        }

        if ($requiredValue === true) {
            $labelElement->addClass('xe-form__label--requried');
        }

        return $labelElement;
    }

    /**
     * @return Element
     */
    private function radioWrapperElement()
    {
        $id = array_get($this->arguments, 'id');

        $radioWrapperElement = new Element('div', ['class' => 'radioWrap']);

        if ($id !== null) {
            $radioWrapperElement->attr('id', $id);
        }

        return $radioWrapperElement;
    }

    /**
     * description element
     *
     * @return Element
     */
    private function descriptionElement()
    {
        $descriptionValue = array_get($this->arguments, 'description');
        $descriptionElement = new Element('p', ['class' => ['help-block', 'hidden']]);

        if ($descriptionValue !== null) {
            $descriptionElement->html($descriptionValue);
            $descriptionElement->removeClass('hidden');
        }

        return $descriptionElement;
    }

    /**
     * small element
     *
     * @return Element
     */
    private function smallElement()
    {
        $smallValue = array_get($this->arguments, 'small');
        $smallElement = new Element('small', ['class' => 'hidden']);

        if ($smallValue !== null) {
            $smallElement->html($smallValue);
            $smallElement->removeClass('hidden');
        }

        return $smallElement;
    }

    /**
     * Radio Option Elements
     *
     * @return array
     */
    private function radioOptionElements()
    {
        $optionElements = [];

        $radioboxes = array_get($this->arguments, 'radioboxes');
        $options = array_get($this->arguments, 'options');

        if ($options === null) {
            $options = $radioboxes;
        }

        foreach ($options as $itemKey => $itemValue) {
            $optionElements[] = $this->radioOptionElement($itemKey, $itemValue);
        }

        return $optionElements;
    }

    /**
     * @param $itemKey
     * @param $value
     * @return Element
     */
    private function radioOptionElement($itemKey, $value)
    {
        $inputName = array_get($this->arguments, 'name');
        $inputValue = array_get($this->arguments, 'value');
        $inputRequired = in_array(array_get($this->arguments, 'required', false), [true, 'required'], true);

        $radioBox = new Element('div', ['class' => 'radio']);
        $radioLabel = new Element('label');
        $radioInput = new Element('input', ['type' => 'radio']);

        $value = value($value);

        $text = is_array($value) === true ? array_get($value, 'text') : $value;
        $value = is_array($value) === true ? array_get($value, 'value') : $itemKey;
        $checked = is_array($value) === true && in_array(array_get($value, 'checked', false), ['checked', true], true);
        $disabled = is_array($value) === true && in_array(array_get($value, 'disabled', false), ['disabled', true], true);

        if ($inputValue !== null && $inputValue === $value) {
            $checked = true;
        }

        $radioInput->attr('value', $value);
        $radioInput->attr('name', $inputName);


        if ($checked === true) {
            $radioInput->attr('checked', 'checked');
        }

        if ($disabled === true) {
            $radioInput->attr('disabled', 'disabled');
        }

        if ($inputRequired === true) {
            $radioInput->attr('required', 'required');
        }

        $radioLabel->append([$radioInput, $text]);
        $radioBox->append($radioLabel);

        return $radioBox;
    }
}
