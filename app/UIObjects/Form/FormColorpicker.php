<?php
/**
 * FormColorpicker.php
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

use XeFrontend;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class FormColorpicker
 *
 * @category    UIObjects
 * @package     App\UIObjects\Form
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FormColorpicker extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@formColorpicker';

    /**
     * The view name
     *
     * @var string
     */
    protected $view = 'uiobjects.form.formColorpicker';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $this->loadAssets();

        $args = $this->arguments;
        $seq  = $this->seq();

        $selector = array_get($args, 'name').$seq;

        // render template
        $this->template = \View::make($this->view, ['args' => $args, 'selector' => $selector])->render();

        return parent::render();
    }

    /**
     * Load assets
     *
     * @return void
     */
    protected function loadAssets()
    {
        XeFrontend::js('assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')->load();
        XeFrontend::css('assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')->load();
    }
}
