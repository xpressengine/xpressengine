<?php
/**
 * FormTextArea.php
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
 * Class FormTextArea
 *
 * @category    UIObjects
 * @package     App\UIObjects\Form
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FormTextArea extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@formTextArea';

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
        $textarea = new Element('textarea', ['rows'=>'3', 'type'=>'text', 'class'=>'form-control']);
        $description = new Element('p', ['class'=>'help-block']);

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
                case 'name':
                    $nameSegs = explode('.', $arg);
                    $name = array_shift($nameSegs);
                    foreach ($nameSegs as $seg) {
                        $name .= "[$seg]";
                    }
                    $textarea->attr($key, $name);
                    break;
                case 'id':
                    $label->attr('for', $arg);
                    // pass to default
                default:
                    $textarea->attr($key, $arg);
                    break;
            }
        }

        $this->template = $box->append([$label, $textarea, $description])->render();

        return parent::render();
    }
}
