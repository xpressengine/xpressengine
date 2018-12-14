<?php
/**
 * PluginSettingsController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
