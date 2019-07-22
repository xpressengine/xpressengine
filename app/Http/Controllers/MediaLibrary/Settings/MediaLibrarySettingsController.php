<?php
/**
 * MediaLibrarySettingsController.php
 *
 * PHP version 7
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright (C) XEHub. <https://xehub.io>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers\MediaLibrary\Settings;

use App\Http\Controllers\Controller;
use Xpressengine\Http\Request;
use XeFrontend;

/**
 * Class MediaLibrarySettingsController
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright (C) XEHub. <https://xehub.io>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class MediaLibrarySettingsController extends Controller
{
    /**
     * @param Request $request request
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     */
    public function index(Request $request)
    {
        return \XePresenter::make('mediaLibrary.settings.index');
    }

    /**
     * @param Request $request request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFileSetting(Request $request)
    {
        $fileConfig = $request->except('_token');

        app('xe.media_library.configHandler')->storeConfig(['file' => $fileConfig]);

        return redirect()->route('settings.mediaLibrary.index')->with('alert', ['type' => 'success', 'message' => '저장']);
    }

    /**
     * @param Request $request request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeContainerSetting(Request $request)
    {
        return redirect()->route('settings.mediaLibrary.index')->with('alert', ['type' => 'success', 'message' => '저장']);
    }

    /**
     * @return mixed|\Xpressengine\Presenter\Presentable
     */
    public function contents()
    {
        XeFrontend::js([
            'assets/vendor/jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.fileupload.js',
        ])->before('assets/core/editor/editor.bundle.js')->load();

        return \XePresenter::make('mediaLibrary.contents');
    }
}
