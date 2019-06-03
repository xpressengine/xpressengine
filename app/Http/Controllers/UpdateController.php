<?php
/**
 * UpdateController.php
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

use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XePresenter;
use Xpressengine\Foundation\Operator;
use Xpressengine\Foundation\ReleaseProvider;
use Xpressengine\Http\Request;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

/**
 * Class UpdateController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class UpdateController extends Controller
{
    /**
     * Show core status.
     *
     * @param Operator        $operator          Operator
     * @param ReleaseProvider $releaseProvider ReleaseProvider
     * @param PluginHandler   $handler         PluginHandler
     * @param PluginProvider  $provider        PluginProvider
     * @return \Xpressengine\Presenter\Presentable
     */
    public function show(Operator $operator, ReleaseProvider $releaseProvider, PluginHandler $handler, PluginProvider $provider)
    {
        if ($operator->isInProgress()) {
            return redirect()->route('settings.operation.index');
        }

        $installedVersion = app()->getInstalledVersion();
        $latest = $releaseProvider->getLatestCoreVersion();
        $updatables = $releaseProvider->getUpdatableVersions();


        $collection = $handler->getAllPlugins(true);
        $fetched = $collection->fetchByInstallType('fetched');

        $provider->sync($fetched);

        $plugins = array_where($fetched, function ($plugin) {
            return $plugin->hasUpdate();
        });
        $available = ini_get('allow_url_fopen') ? true : false;

        $operation = $operator->getOperation(Operator::TYPE_CORE);

        return XePresenter::make(
            'update.show',
            compact('installedVersion', 'latest', 'updatables', 'plugins', 'available', 'operation')
        );
    }

    /**
     * Update core.
     *
     * @param Request         $request         request
     * @param Operator        $operator        Operator instance
     * @param ReleaseProvider $releaseProvider ReleaseProvider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Operator $operator, ReleaseProvider $releaseProvider)
    {
        if($operator->isLocked()) {
            throw new HttpException(422, xe_trans('xe::alreadyProceeding'));
        }

        $version = $request->get('version') ?: __XE_VERSION__;
        $latestVersion = $releaseProvider->getLatestCoreVersion();
        $skipDownload = version_compare(__XE_VERSION__, $latestVersion) === 0
            || $request->get('skip-download') === 'Y';
        $skipComposer = $request->get('skip-composer') === 'Y';

        if (!$skipDownload) {
            $skipComposer = false;
        }

        $startTime = now()->format('YmdHis');
        $logFile = "logs/core-update-$startTime.log";

        $operator->setCoreMode($version, $logFile, false);

        app()->terminating(function () use ($version, $skipComposer, $skipDownload, $logFile) {
            Artisan::call('xe:update', [
                'version' => $version,
                '--skip-download' => $skipDownload,
                '--skip-composer' => $skipComposer,
                '--no-interaction' => true,
            ], new StreamOutput(fopen(storage_path($logFile), 'a')));
        });

        return redirect()->route('settings.operation.index')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::startUpdate')]
        );
    }

    /**
     * Show current status of operation.
     *
     * @param $operator $operator Operator instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function showOperation(Operator $operator)
    {
        if (!$operator->isInProgress()) {
            if ($operator->isPrivate()) {
                return redirect()->route('settings.plugins', ['install_type' => 'self-installed']);
            }

            return redirect()->route('settings.coreupdate.show');
        }

        return XePresenter::make('update.operation', compact('operator'));
    }

    /**
     * Show the operation progress.
     *
     * @param Operator $operator Operator instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function progress(Operator $operator)
    {
        $inProgress = $operator->isInProgress();

        if ($inProgress && $operator->timeover()) {
            $operator->expired();
            $operator->unlock();

            $inProgress = false;
        }

        $log = null;
        if ($operator->getLogFile() && file_exists($path = storage_path($operator->getLogFile()))) {
            $log = nl2br(file_get_contents($path));
        }
        return api_render('update.progress', compact('operator'), [
            'in_progress' => $inProgress,
            'log' => $log
        ]);
    }
}
