<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use Composer\Console\Application;
use Illuminate\Http\Request;
use File;
use DB;
use Auth;
use Illuminate\Cache\CacheManager;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use Xpressengine\Installer\XpressengineInstaller;
use Xpressengine\Plugin\Composer\ComposerFileWriter;

class SafeModeController extends Controller
{
    /**
     * @var array
     *
     * @deprecated since beta.24
     */
    private $requires = [
        'xpressengine-plugin/board' => '0.9.22',
        'xpressengine-plugin/claim' => '0.9.5',
        'xpressengine-plugin/comment' => '0.9.16',
        'xpressengine-plugin/page' => '0.9.6',
    ];

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

        /**
         * @deprecated since beta.24
         */
        $needUpdatePlugins = $this->needUpdatePlugins();
        $pluginUpdateStatus = $this->getPluginUpdateStatus();
        $timeLimit = config('xe.plugin.operation.time_limit');

        return view('safeMode.dashboard', [
            'activatedPluginList' => $activatedPluginList,
            'deactivatedPluginList' => $deactivatedPluginList,
            'sourceVer' => $sourceVer,
            'installedVer' => $installedVer,
            'needUpdatePlugins' => $needUpdatePlugins,
            'pluginUpdateStatus' => $pluginUpdateStatus,
            'timeLimit' => $timeLimit,
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

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @deprecated since beta.24
     */
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
                        $query = trim($query, " \t\n\r\0\x0B,");

                        $pos = strpos($query, "`{$form}`");
                        if ($pos !== false) {
                            break;
                        }
                    }
                    $column_definition = trim(substr($query, strlen("`{$form}`")));

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

    /**
     * @return array
     *
     * @deprecated since beta.24
     */
    private function needUpdatePlugins()
    {
        $directories = glob(base_path('plugins').DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR);

        if (count($directories) === 0) {
            return [];
        }

        $plugins = [];

        foreach ($directories as $directory) {
            $id = basename($directory);

            if (strpos($id, '_') === 0) {
                continue;
            }

            if (is_dir($directory.DIRECTORY_SEPARATOR.'vendor')) {
                continue;
            }

            $info = json_decode(file_get_contents($directory.DIRECTORY_SEPARATOR.'composer.json'), true);
            if (!array_key_exists($info['name'], $this->requires)) {
                continue;
            }

            if(!version_compare($info['version'], $this->requires[$info['name']], '<')) {
                continue;
            }

            $plugins[] = $info['name'];
        }

        return $plugins;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @deprecated since beta.24
     */
    public function doPluginUpdate()
    {
        $plugins = $this->needUpdatePlugins();

        if (count($plugins) < 1) {
            return redirect()->back();
        }

        $timeLimit = config('xe.plugin.operation.time_limit');
        $data = $this->getPluginComposerData();

        foreach ($plugins as $plugin) {
            array_set($data, "xpressengine-plugin.operation.update.$plugin", $this->requires[$plugin]);
        }
        array_set($data, 'xpressengine-plugin.operation.expiration_time', Carbon::now()->addSeconds($timeLimit)->toDateTimeString());
        array_set($data, "xpressengine-plugin.operation.status", ComposerFileWriter::STATUS_RUNNING);

        $this->writePluginComposer($data);

        app()->terminating(function () use ($plugins, $data, $timeLimit) {
            if (!defined('__XE_PLUGIN_MODE__')) {
                define('__XE_PLUGIN_MODE__', true);
            }

            set_time_limit($timeLimit);
            ignore_user_abort(true);
            ini_set('allow_url_fopen', '1');
            ini_set('memory_limit', '1G');


            $input = new ArrayInput([
                'command' => 'update',
                "--with-dependencies" => true,
                '--working-dir' => base_path(),
                '--verbose' => 3,
                'packages' => $plugins
            ]);
            $output = new StreamOutput(fopen(storage_path('logs/plugin-safe.log'), 'a', false));

            $composer = new Application();
            $composer->setAutoExit(false);

            $result = $composer->run($input, $output);

            if ($result !== 0) {
                array_set($data, 'xpressengine-plugin.operation.status', ComposerFileWriter::STATUS_FAILED);
                array_set($data, 'xpressengine-plugin.operation.failed', XpressengineInstaller::$failed);
            } else {
                array_set($data, 'xpressengine-plugin.operation.status', ComposerFileWriter::STATUS_SUCCESSED);
            }

            $this->writePluginComposer($data);
        });

        return redirect()->route('__safe_mode.dashboard')->with('ok', 'complete');
    }

    /**
     * @return mixed
     *
     * @deprecated since beta.24
     */
    private function getPluginComposerData()
    {
        return json_decode(File::get(storage_path('app/composer.plugins.json')), true);
    }

    /**
     * @param $data
     *
     * @deprecated since beta.24
     */
    private function writePluginComposer($data)
    {
        $json = \Composer\Json\JsonFormatter::format(json_encode($data), true, true);
        File::put(storage_path('app/composer.plugins.json'), $json);
    }

    /**
     * @return mixed|string
     *
     * @deprecated since beta.24
     */
    private function getPluginUpdateStatus()
    {
        $data = $this->getPluginComposerData();
        $time = array_get($data, 'xpressengine-plugin.operation.expiration_time');
        if ($time) {
            if (Carbon::parse($time)->isPast()) {
                return ComposerFileWriter::STATUS_EXPIRED;
            }
        }

        return array_get($data, 'xpressengine-plugin.operation.status');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @deprecated since beta.24
     */
    public function doPluginCheck()
    {
        return response()->json(['status' => $this->getPluginUpdateStatus()]);
    }
}
