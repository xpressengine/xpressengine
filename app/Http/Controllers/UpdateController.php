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
use Xpressengine\Foundation\ReleaseProvider;
use Xpressengine\Http\Request;
use Xpressengine\Plugin\Composer\ComposerFileWriter;

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
     * @param ComposerFileWriter $writer          ComposerFileWriter
     * @param ReleaseProvider    $releaseProvider ReleaseProvider
     * @return \Xpressengine\Presenter\Presentable
     */
    public function show(ComposerFileWriter $writer, ReleaseProvider $releaseProvider)
    {
        $installedVersion = file_get_contents(base_path('storage/app/installed'));
        $latest = $releaseProvider->getLatestCoreVersion();
        $updatables = $releaseProvider->getUpdatableVersions();

        $operation = $this->getOperation($writer);

        return XePresenter::make('update.show', compact('installedVersion', 'latest', 'updatables', 'operation'));
    }

    /**
     * Update core.
     *
     * @param Request            $request         request
     * @param ComposerFileWriter $writer          ComposerFileWriter instance
     * @param ReleaseProvider    $releaseProvider ReleaseProvider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ComposerFileWriter $writer, ReleaseProvider $releaseProvider)
    {
        $operation = $this->getOperation($writer);
        if($operation['status'] === ComposerFileWriter::STATUS_RUNNING) {
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

        // 명령은 terminate 에서 호출되므로 response 가 상태값이 변경되기전에 반환 됨.
        // 그래서 사전에 running 상태로 만들어 줌
        $writer->set("xpressengine-plugin.operation.status", ComposerFileWriter::STATUS_RUNNING);
        $writer->set("xpressengine-plugin.operation.core_update", $version);

        $startTime = now()->format('YmdHis');
        $logFile = "logs/core-update-$startTime.log";
        $writer->set('xpressengine-plugin.operation.log', $logFile);

        $writer->write();

        app()->terminating(function () use ($version, $skipComposer, $skipDownload, $logFile) {
            ignore_user_abort(true);
            set_time_limit(config('xe.plugin.operation.time_limit'));

            Artisan::call('xe:update', [
                'version' => $version,
                '--skip-download' => $skipDownload,
                '--skip-composer' => $skipComposer,
                '--no-interaction' => true,
            ], new StreamOutput(fopen(storage_path($logFile), 'a')));
        });

        return redirect()->back()->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::startUpdate')]
        );
    }

    /**
     * Returns current status of operation.
     *
     * @param ComposerFileWriter $writer instance
     * @return array|null
     */
    protected function getOperation(ComposerFileWriter $writer)
    {
        $status = $writer->get('xpressengine-plugin.operation.status');
        $updateVersion = $writer->get('xpressengine-plugin.operation.core_update');

        if($updateVersion === null) {
            return null;
        }

        if ($log = $writer->get('xpressengine-plugin.operation.log')) {
            if (file_exists(storage_path($log))) {
                $log = file_get_contents(storage_path($log));
            } else {
                $log = sprintf('"%s" file not founded.', storage_path($log));
            }
        } else {
            $log = 'Running in console.';
        }

        return compact('status', 'updateVersion', 'log');
    }

    /**
     * Show current status of operation.
     *
     * @param ComposerFileWriter $writer ComposerFileWriter instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function showOperation(ComposerFileWriter $writer)
    {
        $operation = $this->getOperation($writer);
        return api_render('update.operation', compact('operation'), compact('operation'));
    }

    /**
     * Delete the log of operation.
     *
     * @param ComposerFileWriter $writer ComposerFileWriter instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function deleteOperation(ComposerFileWriter $writer)
    {
        $writer->reset()->cleanOperation()->write();
        return XePresenter::makeApi(['type' => 'success', 'message' => xe_trans('xe::deleted')]);
    }
}
