<?php
/**
 * FormScriptEditor.php
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
use XeFrontend;
/**
 * Class FormScriptEditor
 *
 * @category    UIObjects
 * @package     App\UIObjects\Form
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FormScriptEditor extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@formScriptEditor';
    protected $view = 'uiobjects.form.formScriptEditor';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;
        $this->loadAssets();
        $this->template = view($this->view, ['args' => $args])->render();
        return parent::render();
    }
    protected function loadAssets()
    {
        $scripts = [
            'https://cdnjs.cloudflare.com/ajax/libs/require.js/2.3.6/require.min.js',
            'assets/vendor/monaco-editor/min/vs/loader.js',
        ];

        $stylesheets = [
            'assets/vendor/monaco-editor/min/vs/editor/editor.main.css',
        ];

        if(request()->ajax()) {
            XeFrontend::js($scripts)->loadAsync();
            XeFrontend::css($stylesheets)->loadAsync();
        } else {
            XeFrontend::js($scripts)->appendTo('head')->load();
            XeFrontend::css($stylesheets)->load();
        }
    }
}
