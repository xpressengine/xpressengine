<?php
/**
 * SafeModeController.php
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

use Illuminate\Http\Request;
use File;
use DB;
use Auth;
use Illuminate\Cache\CacheManager;

/**
 * Class SafeModeController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class SafeModeController extends Controller
{
    /**
     * SafeModeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:safe')->except('auth', 'login');
    }

    /**
     * Handle a login request to the application.
     *
     * @return \Illuminate\View\View
     */
    public function auth()
    {
        return view('safeMode.auth');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('safe')->attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'rating' => 'super',
        ])) {
            return redirect()->route('__safe_mode.dashboard');
        }

        return redirect()->back();
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('__safe_mode.auth');
    }

    /**
     * Show the dashboard for safe mode.
     *
     * @return \Illuminate\View\View
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function dashboard()
    {
        // plugin list
        $config = DB::table('config')->where('name', 'plugin')->first();
        $vars = json_dec($config->vars, true);
        $activatedPluginList = [];
        $deactivatedPluginList = [];
        foreach ($vars['list'] as $id => $val) {
            if ($val['status'] == 'activated') {
                $activatedPluginList[] = $id;
            }
            if ($val['status'] == 'deactivated') {
                $deactivatedPluginList[] = $id;
            }
        }
        asort($activatedPluginList);
        asort($deactivatedPluginList);

        // check core version
        $sourceVer = __XE_VERSION__;
        $installedVer =  File::get(storage_path('/app/installed'));

        return view('safeMode.dashboard', [
            'activatedPluginList' => $activatedPluginList,
            'deactivatedPluginList' => $deactivatedPluginList,
            'sourceVer' => $sourceVer,
            'installedVer' => $installedVer,
        ]);
    }

    /**
     * Clear cache.
     *
     * @param CacheManager $cache CacheManager instance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doCacheClear(CacheManager $cache)
    {
        $cache->store('file')->flush();
        $cache->store('plugins')->flush();
        $cache->store('schema')->flush();

        File::cleanDirectory(storage_path('app/interception'));

        $viewPath = app('config')->get('view.compiled');
        File::move($viewPath . '/.gitignore', $viewPath . '/../.gitignore_back');
        File::cleanDirectory($viewPath);
        File::move($viewPath . '/../.gitignore_back', $viewPath . '/.gitignore');

        return redirect()->route('__safe_mode.dashboard')->with('ok', 'complete');
    }

    /**
     * Delete log files.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLogClear()
    {
        $viewPath = storage_path('logs');
        File::move($viewPath . '/.gitignore', $viewPath . '/../.gitignore_back');
        File::cleanDirectory($viewPath);
        File::move($viewPath . '/../.gitignore_back', $viewPath . '/.gitignore');

        return redirect()->route('__safe_mode.dashboard')->with('ok', 'complete');
    }

    /**
     * Turn off the plugins.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doPluginOff(Request $request)
    {
        $pluginId = $request->get('plugin_id');

        $config = DB::table('config')->where('name', 'plugin')->first();
        $vars = json_dec($config->vars, true);

        foreach ($vars['list'] as $id => $val) {
            if ($id == $pluginId) {
                $vars['list'][$id]['status'] = 'deactivated';
                break;
            }
        }

        DB::table('config')->where('name', 'plugin')->update([
            'vars' => json_enc($vars)
        ]);

        return redirect()->route('__safe_mode.dashboard')->with('ok', 'complete');
    }

    /**
     * Turn on the plugins.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doPluginOn(Request $request)
    {
        $pluginId = $request->get('plugin_id');

        $config = DB::table('config')->where('name', 'plugin')->first();
        $vars = json_dec($config->vars, true);

        foreach ($vars['list'] as $id => $val) {
            if ($id == $pluginId) {
                $vars['list'][$id]['status'] = 'activated';
                break;
            }
        }

        DB::table('config')->where('name', 'plugin')->update([
            'vars' => json_enc($vars)
        ]);

        return redirect()->route('__safe_mode.dashboard')->with('ok', 'complete');
    }
}
