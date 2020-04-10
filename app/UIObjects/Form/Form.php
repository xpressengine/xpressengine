<?php
/**
 * Form.php
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
 * Class Form
 *
 * @category    UIObjects
 * @package     App\UIObjects\Form
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Form extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@form';

    /**
     * List of the section
     *
     * @var array
     */
    protected $sections = [];

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;

        // action, style에 따라 다른 form을 생성
        $form = $this->getForm();

        foreach ($args as $key => $arg) {
            switch ($key) {
                case 'class':
                    $form->addClass($arg);
                    break;
                case 'inputs':
                case 'fields':
                    $this->appendFields($form, $arg, array_get($args, 'value', []));
                    break;
                case 'value':
                    break;
                default:
                    $form->attr($key, $arg);
                    break;
            }
        }

        $this->template = $form->render();

        return parent::render();
    }

    /**
     * Get form element.
     *
     * @return Element
     */
    protected function getForm()
    {
        $args = $this->arguments;

        // style(type) = panel, fieldset
        $style = array_get($args, 'type', 'panel');

        if (array_get($args, 'action') === null) {
            if ($style === 'fieldset') {
                $form = new Element('div');
            } else {
                $form = new Element('div', ['class'=>'panel-group']);
            }
        } else {
            $form = new Element('form', ['method'=>'POST', 'enctype'=>'multipart/form-data']);
        }

        return $form;
    }

    /**
     * Append field to the form.
     *
     * @param Element $form    form element
     * @param array   $inputs  attributes
     * @param array   $values  values
     * @param array   $globals global arguments
     * @throws \Exception
     */
    private function appendFields($form, $inputs, $values, $globals = [])
    {
        // check array type(sequencial or associated)
        if (array_keys($inputs) === range(0, count($inputs) - 1)) {
            foreach ($inputs as $sectionItem) {
                $globals['_section'] = array_get($sectionItem, 'section');
                $fields = array_get($sectionItem, 'fields');
                $this->appendFields($form, $fields, $values, $globals);
            }
            return;
        }

        /** @var string $name field name attr */
        foreach ($inputs as $name => $arg) {
            // name 필드가 배열 형식(name[number])인지 체크
            // 배열 형식일 경우, value는 name => [xx, xx, xx] 형식으로 전달된다고 가정.
            preg_match("/^([^[]+)\\[(.+)\\]$/", $name, $m);
            if (!empty($m)) {
                $seq = (int)$m[2];
                $value = array_get($values, "$m[1].$seq");
                $name = $m[1].'[]';
            } else {
                $value = array_get($values, $name);
            }

            // default value
            if (!isset($value) && isset($arg['value'])) {
                $value = $arg['value'];
            }

            $arg['name'] = $name;

            $type = array_get($arg, '_type');
            unset($arg['_type']);

            array_set($arg, 'value', $value);

            $uio = 'form'.ucfirst($type);
            $input = uio($uio, $arg);

            $field = $this->wrapInput($name, $input);

            $sectionInfo = array_get($arg, '_section', array_get($globals, '_section'));

            unset($arg['_section']);

            $style = array_get($this->arguments, 'type', 'panel');
            $section = $this->getSection($form, $sectionInfo, $style);
            $section->append($field);
        }
    }

    /**
     * Get the section element.
     *
     * @param Element      $form        form element
     * @param array|string $sectionInfo section attributes
     * @param string       $style       style for section
     * @return Element
     */
    private function getSection($form, $sectionInfo, $style = 'panel')
    {
        $sectionName = null;
        $classname = 'default';

        if (is_string($sectionInfo)) {
            $sectionName = $sectionInfo;
            $classname = 'form-section-'.str_replace([' ', '.'], '-', $sectionName);
        } elseif (is_array($sectionInfo)) {
            $sectionName = array_get($sectionInfo, 'title');
            $classname = array_get($sectionInfo, 'class');
        }

        if ($section = array_get($this->sections, $classname)) {
            return $section;
        } else {
            if ($style === 'fieldset') {
                $sectionName = $sectionName ? "<legend>$sectionName</legend>" : '';
                $section = new Element('div', ['class'=>'row']);
                $sectionWrapper = new Element('fieldset', ['class'=>$classname], [$sectionName, $section]);
            } else {
                if ($sectionName) {
                    $section = new Element('div', ['class'=>'row']);
                    $sectionWrapper = new Element('div', ['class' => ['panel', $classname]], [
                        '<div class="panel-heading"><div class="pull-left"><h3>'.$sectionName.'</h3></div></div>',
                        new Element('div', ['class'=>'panel-body'], [$section])
                    ]);
                } else {
                    $section = new Element('div', ['class'=>'row']);
                    $sectionWrapper = new Element('div', ['class' => ['panel', $classname]], [
                        new Element('div', ['class'=>'panel-body'], [$section])
                    ]);
                }
            }
            $this->sections[$classname] = $section;
            $form->append($sectionWrapper);
            return $section;
        }
    }

    /**
     * Wrap the input.
     *
     * @param string                                  $name  name
     * @param \Xpressengine\UIObject\AbstractUIObject $input input element
     * @return string
     */
    private function wrapInput($name, $input)
    {
        $classname = 'form-col-'.str_replace([' ', '.'], '-', $name);
        return '<div class="col-md-12 '.$classname.'">'.(string)$input.'</div>';
    }
}
