<?php
/**
 * FormFile.php
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
use XeStorage;
use Xpressengine\Storage\File;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class FormFile
 *
 * @category    UIObjects
 * @package     App\UIObjects\Form
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FormFile extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@formFile';

    /**
     * The view name
     *
     * @var string
     */
    protected $view = 'uiobjects.form.formFile';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $this->loadFiles();

        $args = $this->arguments;
        $seq  = $this->seq();

        // set default file upload options
        $fileuploadOptions = [
            'previewMaxWidth' => 280,
            'previewMaxHeight' => 120,
            'previewCrop' => false,
            'autoUpload' => false,
            'acceptFileTypes' => "(\\.|\\/)(.*)$",
            'maxFileSize' => 5000000,
            'replaceFileInput' => false,
            'disableImageResize' => true,
            'imageCrop' => false,
            'imageMaxWidth' => 480,
            'imageMaxHeight' => 240,
        ];

        // set file
        if (isset($args['file'])) {
            $file = XeStorage::find($args['file']);

            if ($file === null) {
                unset($args['file']);
            } else {
                $filename = $file->clientname;
                $args['file'] = $filename;
            }
        }

        // resolve arguments
        $fileuploadOptions = array_merge($fileuploadOptions, array_get($args, 'fileuploadOptions', []));

        $args = array_add($args, 'width', 420);
        $args = array_add($args, 'height', 240);
        array_set($fileuploadOptions, 'previewMaxWidth', $args['width']);
        array_set($fileuploadOptions, 'previewMaxHeight', $args['height']);

        $types = array_get($args, 'types');
        if ($types !== null) {
            array_set($fileuploadOptions, 'acceptFileTypes', '(\\.|\\/)('.implode('|', (array)$types).')$');
        }

        array_set($args, 'fileuploadOptions', $fileuploadOptions);

        // render template
        $this->template = \View::make($this->view, ['args' => $args, 'seq' => $seq])->render();

        return parent::render();
    }

    /**
     * Load assets
     *
     * @return void
     */
    protected function loadFiles()
    {
        XeFrontend::js([
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
        ])->load();

        XeFrontend::css([
            'assets/vendor/jQuery-File-Upload/css/jquery.fileupload.css',
            'assets/vendor/jQuery-File-Upload/css/jquery.fileupload-ui.css',
        ])->load();
    }
}
