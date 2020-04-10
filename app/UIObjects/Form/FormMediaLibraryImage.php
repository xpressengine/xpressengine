<?php
/**
 * FormMediaLibraryImage.php
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
 * Class FormMediaLibraryImage
 *
 * @category    UIObjects
 * @package     App\UIObjects\Form
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FormMediaLibraryImage extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@formMedialibraryImage';

    /**
     * The view name
     *
     * @var string
     */
    protected $view = 'uiobjects.form.formMedialibraryImage';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;
        $seq  = $this->seq();

        $this->loadAssets();

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
        expose_route('media_library.index');
        expose_route('media_library.drop');
        expose_route('media_library.get_folder');
        expose_route('media_library.store_folder');
        expose_route('media_library.update_folder');
        expose_route('media_library.move_folder');
        expose_route('media_library.get_file');
        expose_route('media_library.update_file');
        expose_route('media_library.modify_file');
        expose_route('media_library.move_file');
        expose_route('media_library.upload');
        expose_route('media_library.download_file');

        $scripts = [
            'assets/vendor/jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.fileupload.js',
            'assets/core/uiobject/form/medialibrary-image.js',
        ];

        $stylesheets = [
            'assets/core/uiobject/form/medialibrary-image.css',
            'assets/vendor/jQuery-File-Upload/css/jquery.fileupload.css',
            'assets/vendor/jQuery-File-Upload/css/jquery.fileupload-ui.css',
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
