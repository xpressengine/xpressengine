<?php
/**
 * MediaLibrarySettingsController.php
 *
 * PHP version 7
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
            'assets/vendor/jqueryui/jquery-ui.min.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.fileupload.js',
        ])->load();

        XeFrontend::css([
            'assets/vendor/jqueryui/jquery-ui.min.css'
        ])->load();

        return \XePresenter::make('mediaLibrary.contents');
    }
}
