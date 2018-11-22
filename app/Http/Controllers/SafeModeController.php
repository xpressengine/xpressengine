<?php
/**
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

class SafeModeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:safe')->except('auth', 'login');
    }

    public function auth()
    {
        return view('safeMode.auth');
    }

    public function login(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required',
                'password' => 'required'
            ]
        );

        if (Auth::guard('safe')->attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'rating' => 'super',
        ])) {
            return redirect()->route('__safe_mode.dashboard');
        }

        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('__safe_mode.auth');
    }

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

    public function doLogClear()
    {
        $viewPath = storage_path('logs');
        File::move($viewPath . '/.gitignore', $viewPath . '/../.gitignore_back');
        File::cleanDirectory($viewPath);
        File::move($viewPath . '/../.gitignore_back', $viewPath . '/.gitignore');

        return redirect()->route('__safe_mode.dashboard')->with('ok', 'complete');
    }

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
