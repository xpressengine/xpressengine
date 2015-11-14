<?php namespace Xpressengine\UIObjects\Form;

use Frontend;
use Xpressengine\UIObject\AbstractUIObject;

class FormImage extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formImage';

    protected $view = 'uiobjects.form.formImage';

    public function render()
    {
        $this->loadFiles();

        $args = $this->arguments;
        $seq  = $this->seq();

        // set width, height
        $args = array_add($args, 'width', 420);
        $args = array_add($args, 'height', 420);

        // render template
        $this->template = \View::make($this->view, ['args' => $args, 'seq' => $seq])->render();

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
        Frontend::js(
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
        )->appendTo('head')->load();

        Frontend::css(
            [
                'assets/vendor/jQuery-File-Upload/css/jquery.fileupload.css',
                'assets/vendor/jQuery-File-Upload/css/jquery.fileupload-ui.css',
            ]
        )->load();
    }
}
