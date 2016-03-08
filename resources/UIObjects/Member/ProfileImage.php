<?php namespace Xpressengine\UIObjects\Member;

use XeFrontend;
use Xpressengine\UIObjects\Form\FormImage;

class ProfileImage extends FormImage
{
    protected static $id = 'uiobject/xpressengine@profileImage';

    protected $view = 'uiobjects.member.profileImage';

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
        )->appendTo('head')->load();

        XeFrontend::css(
            [
                'assets/vendor/jQuery-File-Upload/css/jquery.fileupload.css',
                'assets/vendor/jQuery-File-Upload/css/jquery.fileupload-ui.css',
            ]
        )->load();
    }
}
