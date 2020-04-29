<?php
/**
 * PluginSettingsController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
namespace App\Http\Controllers;

use XePresenter;
use Xpressengine\Http\Request;

/**
 * Class PluginSettingsController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 *
 * @deprecated since 3.0.2 use SettingsController instead
 */
class PluginSettingsController extends Controller
{
    /**
     * PluginController constructor.
     */
    public function __construct()
    {
        XePresenter::setSettingsSkinTargetId('plugins');
    }

    /**
     * Show the setting page for plugin.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function show()
    {
        $config = app('xe.config')->get('plugin');
        return XePresenter::make('settings.show', compact('config'));
    }

    /**
     * Update setting information.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $config = app('xe.config')->get('plugin');

        $siteToken = $request->get('site_token');
        $config->set('site_token', $siteToken);

        if($composerHome = $request->get('composer_home')) {
            $config->set('composer_home', $composerHome);
        }
        app('xe.config')->modify($config);

        return redirect()->back()->with('alert', ['message' => xe_trans('xe::saved'), 'type' => 'success']);
    }
}
