<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\UIObjects\Form;

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
        $args = array_add($args, 'width', 420);
        $args = array_add($args, 'height', 420);

        // render template
        $this->template = \View::make($this->view, ['args' => $args, 'seq' => $seq])->render();

        return parent::render();
    }

    /**
     * loadFiles
     *
     * @return void
     */
    protected function loadAssets()
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
