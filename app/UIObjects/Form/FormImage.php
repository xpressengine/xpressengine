<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Form;

use XeFrontend;
use Xpressengine\UIObject\AbstractUIObject;

class FormImage extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@formImage';

    protected $view = 'uiobjects.form.formImage';

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
     * loadFiles
     *
     * @return void
     */
    protected function loadAssets()
    {

        $scripts = [
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
