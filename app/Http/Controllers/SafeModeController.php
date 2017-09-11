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

    public function doBeta24()
    {
        /** @var \Illuminate\Database\Connection $connection */
        $connection = DB::connection();
        $tablePrefix = $connection->getTablePrefix();
        $tables = DB::select("SHOW TABLES LIKE '{$tablePrefix}%'");
        $names = [];
        foreach ($tables as $table) {
            $names[] = head($table);
        }

        // for timestamp DEFAULT '0000-00-00 00:00:00'
        $connection->select("SET SESSION sql_mode = ''");

        // 이 처리는 시간이 오래 걸립니다
        $alterQueries = [];
        foreach ($names as $name) {
            $query = $connection->select("SHOW CREATE TABLE {$name}");
            $tableQuery = ($query[0]->{'Create Table'});

            $queries = explode("\n", $tableQuery);

            $columns = $connection->getSchemaBuilder()
                ->getColumnListing(str_replace($tablePrefix, '', $name));

            $changes = [];
            foreach ($columns as $form) {
                $to = snake_case($form);
                if ($form != $to) {
                    $pos = false;
                    foreach ($queries as $query) {
                        $query = trim($query);

                        $pos = strpos($query, "`{$form}`");
                        if ($pos !== false) {
                            break;
                        }
                    }
                    $column_definition = trim(substr($query, strlen("`{$form}`"), -1));

                    $changes[] = sprintf('CHANGE COLUMN %s %s %s', $form, $to, $column_definition);
                }
            }

            if (count($changes) > 0) {
                $alterQueries[] = sprintf(
                    "ALTER TABLE %s  %s", $name, join(', ', $changes)
                );
            }
        }

        foreach ($alterQueries as $alterQuery) {
            $ret = $connection->select($alterQuery);
        }

        return redirect()->route('__safe_mode.dashboard')->with('ok', 'complete');
    }
}
