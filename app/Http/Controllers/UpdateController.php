<?php
/**
 * UpdateController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UpdateController extends Controller
{
    use ArtisanBackgroundHelper;

    /**
     * Show core status.
     *
     * @param Operator        $operator          Operator
     * @param ReleaseProvider $releaseProvider ReleaseProvider
     * @param PluginHandler   $handler         PluginHandler
     * @param PluginProvider  $provider        PluginProvider
     * @return \Xpressengine\Presenter\Presentable
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(Request $request, Operator $operator, ReleaseProvider $releaseProvider)
    {
        if($operator->isLocked()) {
            throw new HttpException(422, xe_trans('xe::alreadyProceeding'));
        }

        $version = $request->get('version') ?: __XE_VERSION__;

        if (!in_array($version, $releaseProvider->coreVersions())) {
            return back()->with('alert', [
                'type' => 'danger',
                'message' => xe_trans('xe::unknownVersion', ['ver' => $version])
            ]);
        }

        $latestVersion = $releaseProvider->getLatestCoreVersion();
        $skipDownload = version_compare(__XE_VERSION__, $latestVersion) === 0
            || $request->get('skip-download') === 'Y';
        $skipComposer = $request->get('skip-composer') === 'Y';

        if (!$skipDownload) {
            $skipComposer = false;
        }

        $operator->setCoreMode(false)->save();

        $this->runArtisan('xe:update', [
            'version' => $version,
            '--skip-download' => $skipDownload,
            '--skip-composer' => $skipComposer,
            '--no-interaction' => true,
        ]);

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
            return redirect()->route('settings.coreupdate.show');
        }

        return XePresenter::make('update.operation', compact('operator'));
    }

    /**
     * Show the operation progress.
     *
     * @param Operator $operator Operator instance
     * @return \Xpressengine\Presenter\Presentable
     * @throws \Exception
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

        $redirect = null;
        if (!$inProgress) {
            $redirect = route('settings.coreupdate.show');
        }

        return api_render('update.progress', compact('operator'), [
            'in_progress' => $inProgress,
            'succeed' => $operator->isSucceed(),
            'redirect' => $redirect,
            'log' => $log
        ]);
    }
}
