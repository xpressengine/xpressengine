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
use Composer\Util\Platform;
use Log;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\Installer\XpressengineInstaller;
use Xpressengine\Interception\InterceptionHandler;
use Xpressengine\Plugin\Composer\Composer;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Support\Migration;

class UpdateController extends Controller
{

    /**
     * PluginController constructor.
     */
    public function __construct()
    {
    }

    public function show(Request $request, ComposerFileWriter $writer)
    {
        $operation = $this->getOperation($writer);

        $installedVersion = file_get_contents(base_path('storage/app/installed'));
        return XePresenter::make('update.show', compact('installedVersion', 'operation'));
    }

    public function update(Request $request, ComposerFileWriter $writer, InterceptionHandler $interceptionHandler)
    {
        $skipComposer = $request->get('skip-composer');
        $installedVersion = file_get_contents(base_path('storage/app/installed'));

        if($skipComposer !== 'Y') {
            $operation = $this->getOperation($writer);
            if($operation['status'] === ComposerFileWriter::STATUS_RUNNING) {
                throw new HttpException(422, "이미 XE 코어 또는 플러그인의 업데이트 작업이 진행중입니다.");
            }

            // 플러그인 업데이트 잠금
            unlink($writer->getPath());
            $writer->load();
            $writer->setFixMode();

            // running 상태로 만들어 줌
            $writer->set("xpressengine-plugin.operation.status", ComposerFileWriter::STATUS_RUNNING);
            $writer->set("xpressengine-plugin.operation.core_update", __XE_VERSION__);
            $writer->write();

            $timeLimit = config('xe.plugin.operation.time_limit');
            $this->reserveCoreUpdate($writer, $timeLimit, function($result) use ($installedVersion, $interceptionHandler) {
                $this->migrateCore($installedVersion);
                $interceptionHandler->clearProxies();
                file_put_contents(base_path('storage/app/installed'), __XE_VERSION__);
            });

            return redirect()->back()->with(
                'alert',
                ['type' => 'success', 'message' => '업데이트를 시작합니다.']
            );

        } else {
            $this->migrateCore($installedVersion);
            $interceptionHandler->clearProxies();
            file_put_contents(base_path('storage/app/installed'), __XE_VERSION__);

            return redirect()->back()->with(
                'alert',
                ['type' => 'success', 'message' => '업데이트하였습니다.']
            );

        }
    }

    protected function getOperation(ComposerFileWriter $writer)
    {
        $status = $writer->get('xpressengine-plugin.operation.status');
        $updateVersion = $writer->get('xpressengine-plugin.operation.core_update');

        if($updateVersion === null) {
            return null;
        }

        $log = $writer->get('xpressengine-plugin.operation.log');
        if (file_exists(storage_path($log))) {
            $log = file_get_contents(storage_path($log));
        } else {
            $log = sprintf('"%s" file not founded.', storage_path($log));
        }

        return compact('status', 'updateVersion', 'log');
    }

    protected function migrateCore($installedVersion)
    {
        $filesystem = app('files');
        $files = $filesystem->files(base_path('migrations'));

        foreach ($files as $file) {
            $class = "\\Xpressengine\\Migrations\\".basename($file, '.php');
            $migration = new $class();

            /** @var Migration $migration */
            if($migration->checkUpdated($installedVersion) === false) {
                $migration->update($installedVersion);
            }
        }

    }
    public function showOperation(ComposerFileWriter $writer)
    {
        $operation = $this->getOperation($writer);
        return api_render('update.operation', compact('operation'), compact('operation'));
    }

    public function deleteOperation(ComposerFileWriter $writer)
    {
        $writer->reset()->cleanOperation()->write();
        return XePresenter::makeApi(['type' => 'success', 'message' => '삭제되었습니다.']);
    }

    /**
     * reserveCoreUpdate
     *
     * @param ComposerFileWriter $writer
     * @param int                $timeLimit
     * @param string             $logFileName
     * @param null               $callback
     */
    protected function reserveCoreUpdate(ComposerFileWriter $writer, $timeLimit, $callback = null)
    {
        $this->prepareComposer($timeLimit);

        /** @var \Illuminate\Foundation\Application $app */
        app()->terminating(
            function () use ($writer, $callback) {

                $pid = getmypid();
                Log::info("[core update operation] start running composer run [pid=$pid]");

                $input = new ArrayInput(
                    [
                        'command' => 'update',
                        '--working-dir' => base_path(),
                    ]
                );

                Composer::setPackagistToken(config('xe.plugin.packagist.site_token'));
                Composer::setPackagistUrl(config('xe.plugin.packagist.url'));

                $startTime = Carbon::now()->format('YmdHis');
                $logFileName = "logs/core-update-$startTime.log";
                $writer->set('xpressengine-plugin.operation.log', $logFileName);
                $writer->write();

                $output = new StreamOutput(fopen(storage_path($logFileName), 'a', false));
                $application = new Application();
                $application->setAutoExit(false); // prevent `$application->run` method from exitting the script
                $result = $application->run($input, $output);

                if (is_callable($callback)) {
                    $callback($result);
                }

                $writer->load();

                if ($result !== 0) {
                    $writer->set('xpressengine-plugin.operation.status', ComposerFileWriter::STATUS_FAILED);
                    $writer->set('xpressengine-plugin.operation.failed', XpressengineInstaller::$failed);
                } else {
                    $writer->set('xpressengine-plugin.operation.status', ComposerFileWriter::STATUS_SUCCESSED);
                }
                $writer->write();

                Log::info(
                    "[core update operation] core update operation finished. [exit code: $result, memory usage: ".memory_get_usage(
                    )."]"
                );
            }
        );
    }

    protected function prepareComposer($timeLimit)
    {

        $files = [
            storage_path('app/composer.plugins.json'),
            base_path('composer.lock'),
            base_path('plugins/'),
            base_path('vendor/'),
            base_path('vendor/composer/installed.json'),
        ];

        // file permission check

        foreach ($files as $file) {
            $type = is_dir($file) ? '디렉토리' : '파일';

            if (!is_writable($file)) {
                throw new HttpException(500, "[$file] {$type}의 쓰기 권한이 없습니다. 플러그인을 설치하기 위해서는 이 {$type}의 쓰기 권한이 있어야 합니다");
            }
        }

        // composer home check
        $this->checkComposerHome();

        set_time_limit($timeLimit);
        ignore_user_abort(true);
        ini_set('allow_url_fopen', '1');

        $memoryInBytes = function ($value) {
            $unit = strtolower(substr($value, -1, 1));
            $value = (int) $value;
            switch ($unit) {
                case 'g':
                    $value *= 1024;
                // no break (cumulative multiplier)
                case 'm':
                    $value *= 1024;
                // no break (cumulative multiplier)
                case 'k':
                    $value *= 1024;
            }
            return $value;
        };

        $memoryLimit = trim(ini_get('memory_limit'));
        // Increase memory_limit if it is lower than 1GB
        if ($memoryLimit != -1 && $memoryInBytes($memoryLimit) < 1024 * 1024 * 1024) {
            ini_set('memory_limit', '1G');
        }
    }

    /**
     * checkComposerHome
     *
     * @return void
     * @throws \Exception
     */
    protected function checkComposerHome()
    {
        $config = app('xe.config')->get('plugin');
        $home = $config->get('composer_home');

        if ($home) {
            putenv("COMPOSER_HOME=$home");
        } else {
            $home = getenv('COMPOSER_HOME');
        }

        if (Platform::isWindows()) {
            if (!getenv('APPDATA')) {
                throw new HttpException(500,
                    'COMPOSER_HOME 환경변수가 설정되어 있지 않습니다. <a href="'.route('settings.plugins.setting.show').'">플러그인 설정</a>에서 설정할 수 있습니다.'
                );
            }
        }

        if (!$home) {
            $home = getenv('HOME');
            if (!$home) {
                throw new HttpException(500,
                    'COMPOSER_HOME 환경변수가 설정되어 있지 않습니다. <a href="'.route('settings.plugins.setting.show').'">플러그인 설정</a>에서 설정할 수 있습니다.'
                );
            }
        }
    }

}

