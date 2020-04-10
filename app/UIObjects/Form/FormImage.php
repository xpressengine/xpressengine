<?php
/**
 * FormImage.php
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
 * Class FormImage
 *
 * @category    UIObjects
 * @package     App\UIObjects\Form
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FormImage extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@formImage';

    /**
     * The view name
     *
     * @var string
     */
    protected $view = 'uiobjects.form.formImage';

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

        // set width, height
        $args = array_add($args, 'width', 10000);
        $args = array_add($args, 'height', 10000);

        // render template
        $this->template = view($this->view, ['args' => $args, 'seq' => $seq])->render();

        return parent::render();
    }

    /**
     * Load assets
     *
     * @return void
     */
    protected function loadAssets()
    {

        $scripts = [
            'assets/vendor/jQuery-File-Upload/js/canvas-to-blob.min.js',
            'assets/vendor/jQuery-File-Upload/js/load-image.all.min.js',
            'assets/vendor/jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.fileupload.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-ui.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-process.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-image.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-audio.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-video.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-validate.js',
        ];

        $stylesheets = [
            'assets/vendor/jQuery-File-Upload/css/jquery.fileupload.css',
            'assets/vendor/jQuery-File-Upload/css/jquery.fileupload-ui.css',
        ];

        if(request()->ajax()) {
            XeFrontend::js($scripts)->loadAsync();
            XeFrontend::css($stylesheets)->loadAsync();
        } else {
            XeFrontend::js($scripts)->load();
            XeFrontend::css($stylesheets)->load();
        }
    }
}
