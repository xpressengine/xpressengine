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
use Illuminate\Session\SessionManager;
use Log;
use Redirect;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\Installer\XpressengineInstaller;
use Xpressengine\Interception\InterceptionHandler;
use Xpressengine\Plugin\Composer\Composer;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;
use Xpressengine\Support\Exceptions\XpressengineException;

class PluginController extends Controller
{

    /**
     * PluginController constructor.
     */
    public function __construct()
    {
        XePresenter::setSettingsSkinTargetId('plugins');
    }

    public function index(
        Request $request,
        PluginHandler $handler,
        PluginProvider $provider,
        ComposerFileWriter $writer
    ) {
        // filter input
        $field = [];
        $field['component'] = $request->get('component');
        $field['status'] = $request->get('status');
        $field['keyword'] = $request->get('query');

        if ($field['keyword'] === '') {
            $field['keyword'] = null;
        }

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->fetch($field);

        $provider->sync($plugins);
        $componentTypes = $this->getComponentTypes();

        $operation = $handler->getOperation($writer);

        return XePresenter::make('index', compact('plugins', 'componentTypes', 'operation'));
    }

    public function getOperation(PluginHandler $handler, ComposerFileWriter $writer)
    {
        $operation = $handler->getOperation($writer);
        return apiRender('operation', compact('operation'), compact('operation'));
    }

    public function deleteOperation(ComposerFileWriter $writer)
    {
        $writer->reset()->cleanOperation()->write();
        return XePresenter::makeApi(['type' => 'success', 'message' => '삭제되었습니다.']);
    }

    public function install(
        Request $request,
        PluginHandler $handler,
        PluginProvider $provider,
        ComposerFileWriter $writer,
        SessionManager $session
    ) {
        $id = $request->get('pluginId');

        $handler->getAllPlugins(true);
        if ($handler->getPlugin($id) !== null) {
            throw new HttpException(422, 'Plugin already installed.');
        }

        // 자료실에서 플러그인 정보 조회
        $pluginData = $provider->find($id);

        if ($pluginData === null) {
            throw new HttpException(
                422, "Can not find the plugin(".$id.") that should be installed from the Market-place."
            );
        }

        $title = $pluginData->title;
        $name = $pluginData->name;
        $version = $pluginData->latest_release->version;

        $operation = $handler->getOperation($writer);

        if ($operation['status'] === ComposerFileWriter::STATUS_RUNNING) {
            throw new HttpException(422, "이미 진행중인 요청이 있습니다.");
        }

        $timeLimit = config('xe.plugin.operation.time_limit');
        $writer->reset()->cleanOperation();
        $writer->install($name, $version, Carbon::now()->addSeconds($timeLimit)->toDateTimeString())->write();
        $this->reserveOperation($writer, $timeLimit);

        $session->flash('alert', ['type' => 'success', 'message' => '새로운 플러그인을 설치중입니다.']);
        return XePresenter::makeApi(['type' => 'success', 'message' => '새로운 플러그인을 설치중입니다.']);
    }

    public function delete(
        Request $request,
        PluginHandler $handler,
        PluginProvider $provider,
        ComposerFileWriter $writer,
        $pluginId
    ) {
        $handler->getAllPlugins(true);
        $plugin = $handler->getPlugin($pluginId);
        if ($plugin === null) {
            throw new HttpException(422, 'Plugin not found.');
        }

        if($plugin->isActivated()) {
            throw new HttpException(422, 'Plugin is not deactivated. Please deactivate the plugin.');
        }

        if($plugin->isDevelopMode()) {
            $handler->uninstallPlugin($pluginId);
            return redirect()->route('settings.plugins')->with(
                'alert',
                ['type' => 'success', 'message' => '플러그인을 삭제하였습니다.']
            );
        }

        $operation = $handler->getOperation($writer);
        if ($operation['status'] === ComposerFileWriter::STATUS_RUNNING) {
            throw new HttpException(422, "이미 진행중인 요청이 있습니다.");
        }

        $handler->uninstallPlugin($pluginId);

        $timeLimit = config('xe.plugin.operation.time_limit');
        $writer->reset()->cleanOperation();
        $writer->uninstall($plugin->getName(), Carbon::now()->addSeconds($timeLimit)->toDateTimeString())->write();
        $this->reserveOperation($writer, $timeLimit);

        return redirect()->route('settings.plugins')->with(
            'alert',
            ['type' => 'success', 'message' => '플러그인을 삭제중입니다.']
        );
    }

    /**
     * reserveInstall
     *
     * @param ComposerFileWriter $writer
     * @param int                $timeLimit
     * @param null               $callback
     */
    protected function reserveOperation(ComposerFileWriter $writer, $timeLimit, $callback = null)
    {
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

        /** @var \Illuminate\Foundation\Application $app */
        app()->terminating(
            function () use ($writer, $callback) {

                $pid = getmypid();
                Log::info("[plugin operation] start running composer run [pid=$pid]");

                // call `composer install` command programmatically
                $vendorName = PluginHandler::PLUGIN_VENDOR_NAME;
                $input = new ArrayInput(
                    [
                        'command' => 'update',
                        "--prefer-lowest" => true,
                        "--with-dependencies" => true,
                        '--working-dir' => base_path(),
                        'packages' => ["$vendorName/*"]
                    ]
                );

                Composer::setPackagistToken(config('xe.plugin.packagist.site_token'));
                Composer::setPackagistUrl(config('xe.plugin.packagist.url'));

                $output = new BufferedOutput();
                $application = new Application();
                $application->setAutoExit(false); // prevent `$application->run` method from exitting the script
                if (!defined('__XE_PLUGIN_MODE__')) {
                    define('__XE_PLUGIN_MODE__', true);
                }
                $result = $application->run($input, $output);

                $outputText = $output->fetch();
                file_put_contents(storage_path('logs/plugin.log'), $outputText);

                if(is_callable($callback)) {
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
                    "[plugin operation] plugin operation finished. [exit code: $result, memory usage: ".memory_get_usage(
                    )."]"
                );
            }
        );
    }

    public function show($pluginId, PluginHandler $handler, PluginProvider $provider)
    {
        // refresh plugin cache
        $handler->getAllPlugins(true);

        $componentTypes = $this->getComponentTypes();

        $plugin = $handler->getPlugin($pluginId);

        $provider->sync($plugin);

        return XePresenter::make('show', compact('plugin', 'componentTypes'));
    }

    public function putActivatePlugin($pluginId, PluginHandler $handler, InterceptionHandler $interceptionHandler)
    {
        try {
            $handler->activatePlugin($pluginId);
            $interceptionHandler->clearProxies();
        } catch (XpressengineException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (\Exception $e) {
            throw $e;
        }

        return Redirect::back()->withAlert(['type' => 'success', 'message' => '플러그인을 켰습니다.']);
    }

    public function putDeactivatePlugin($pluginId, PluginHandler $handler, InterceptionHandler $interceptionHandler)
    {
        try {
            $handler->deactivatePlugin($pluginId);
            $interceptionHandler->clearProxies();
        } catch (XpressengineException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (\Exception $e) {
            throw $e;
        }

        return Redirect::back()->withAlert(['type' => 'success', 'message' => '플러그인을 껐습니다.']);
    }

    public function putUpdatePlugin($pluginId, PluginHandler $handler, InterceptionHandler $interceptionHandler)
    {
        try {
            $handler->updatePlugin($pluginId);
            $interceptionHandler->clearProxies();
        } catch (XpressengineException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (\Exception $e) {
            throw $e;
        }

        app('session.store')->flash('alert', ['type' => 'success', 'message' => '플러그인을 업데이트했습니다.']);
        return XePresenter::makeApi(['type' => 'success', 'message' => '플러그인을 업데이트했습니다.']);
    }

    public function putDownloadPlugin(
        $pluginId,
        PluginHandler $handler,
        PluginProvider $provider,
        ComposerFileWriter $writer,
        InterceptionHandler $interceptionHandler,
        SessionManager $session
    ) {
        $handler->getAllPlugins(true);
        $plugin = $handler->getPlugin($pluginId);
        if ($plugin === null) {
            throw new HttpException(422, 'Plugin not found.');
        }

        // 자료실에서 플러그인 정보 조회
        $pluginData = $provider->find($pluginId);

        if ($pluginData === null) {
            throw new HttpException(
                422, "Can not find the plugin(".$pluginId.") that should be installed from the Market-place."
            );
        }

        $title = $pluginData->title;
        $name = $pluginData->name;
        $version = $pluginData->latest_release->version;

        $operation = $handler->getOperation($writer);

        if ($operation['status'] === ComposerFileWriter::STATUS_RUNNING) {
            throw new HttpException(422, "이미 진행중인 요청이 있습니다.");
        }

        $timeLimit = config('xe.plugin.operation.time_limit');
        $writer->reset()->cleanOperation();
        $writer->update($name, $version, Carbon::now()->addSeconds($timeLimit)->toDateTimeString())->write();
        $this->reserveOperation($writer, $timeLimit, function($code) use ($plugin) {
            if($code === 0 && $plugin->checkUpdated()) {
                $plugin->update();
            }
        });

        return redirect()->route('settings.plugins')->with(
            'alert',
            ['type' => 'success', 'message' => '플러그인의 새로운 버전을 다운로드하는 중입니다.']
        );
    }

    /**
     * getComponentTypes
     *
     * @return array
     */
    protected function getComponentTypes()
    {
        $componentTypes = [
            'theme' => '테마',
            'skin' => '스킨',
            'settingsSkin' => '설정스킨',
            'settingsTheme' => '관리페이지테마',
            'widget' => '위젯',
            'module' => '모듈',
            'uiobject' => 'UI오브젝트',
            'FieldType' => '다이나믹필드',
            'FieldSkin' => '다이나믹필드스킨',
        ];
        return $componentTypes;
    }
}

