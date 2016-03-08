<?php namespace Xpressengine\UIObjects\Form;

use XeFrontend;
use Media;
use Storage;
use Xpressengine\UIObject\AbstractUIObject;

class FormFile extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formFile';

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
            $file = Storage::get($args['file']);

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

        $types = (array) array_get($args, 'types');
        if ($types !== null) {
            array_set($fileuploadOptions, 'acceptFileTypes', '(\\.|\\/)('.implode('|', $types).')$');
        }

        array_set($args, 'fileuploadOptions', $fileuploadOptions);

        // render template
        $this->template = \View::make('uiobjects.form.formFile', ['args' => $args, 'seq' => $seq])->render();
        return parent::render();
    }

    public static function boot()
    {
        // TODO: Implement boot() method.
    }

    public static function getSettingsURI()
    {
    }

    /**
     * loadFiles
     *
     * @return void
     */
    protected function loadFiles()
    {

        XeFrontend::js(
            [
                'assets/vendor/JavaScript-Canvas-to-Blob-master/js/canvas-to-blob.min.js',
                'assets/vendor/JavaScript-Load-Image/js/load-image.all.min.js',
                'assets/vendor/jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
                'assets/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js',
                'assets/vendor/jQuery-File-Upload/js/jquery.fileupload.js',
                'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-ui.js',
                'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-process.js',
                'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-image.js',
                'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-audio.js',
                'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-video.js',
                'assets/vendor/jQuery-File-Upload/js/jquery.fileupload-validate.js',
            ]
        )->appendTo('head')->before('/assets/vendor/requirejs/require.js')->load();

        XeFrontend::css(
            [
                'assets/vendor/jQuery-File-Upload/css/jquery.fileupload.css',
                'assets/vendor/jQuery-File-Upload/css/jquery.fileupload-ui.css',
            ]
        )->load();
    }
}
