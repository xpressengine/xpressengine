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

use Carbon\Carbon;
use Composer\Console\Application;
use Composer\Util\Platform;
use Illuminate\Support\Facades\Artisan;
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
use Xpressengine\Support\Migration;

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
     * @param ComposerFileWriter $writer
     * @return \Xpressengine\Presenter\Presentable
     */
    public function show(ComposerFileWriter $writer)
    {
        $operation = $this->getOperation($writer);
        $installedVersion = file_get_contents(base_path('storage/app/installed'));

        return XePresenter::make('update.show', compact('installedVersion', 'operation'));
    }

    /**
     * Update core.
     *
     * @param Request            $request request
     * @param ComposerFileWriter $writer  ComposerFileWriter instance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ComposerFileWriter $writer)
    {
        $skipComposer = $request->get('skip-composer');

        $operation = $this->getOperation($writer);
        if($operation['status'] === ComposerFileWriter::STATUS_RUNNING) {
            throw new HttpException(422, xe_trans('xe::alreadyProceeding'));
        }

        // 명령은 terminate 에서 호출되므로 response 가 상태값이 변경되기전에 반환 됨.
        // 그래서 사전에 running 상태로 만들어 줌
        $writer->load();
        $writer->set("xpressengine-plugin.operation.status", ComposerFileWriter::STATUS_RUNNING);
        $writer->set("xpressengine-plugin.operation.core_update", __XE_VERSION__);
        $writer->write();

        app()->terminating(function () use ($skipComposer) {
            ignore_user_abort(true);
            set_time_limit(config('xe.plugin.operation.time_limit'));

            Artisan::call('xe:update', [
                '--skip-download' => true,
                '--skip-composer' => $skipComposer === 'Y',
                '--no-interaction' => true,
            ]);
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

        $log = $writer->get('xpressengine-plugin.operation.log');
        if (file_exists(storage_path($log))) {
            $log = file_get_contents(storage_path($log));
        } else {
            $log = sprintf('"%s" file not founded.', storage_path($log));
        }

        return compact('status', 'updateVersion', 'log');
    }

    /**
     * Execute migrations.
     *
     * @param string $installedVersion installed version
     * @return void
     */
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
