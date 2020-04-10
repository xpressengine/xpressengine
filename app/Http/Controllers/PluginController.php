<?php
/**
 * PluginController.php
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

use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XePresenter;
use Xpressengine\Foundation\Operator;
use Xpressengine\Http\Request;
use Xpressengine\Interception\InterceptionHandler;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;
use Xpressengine\Support\Exceptions\XpressengineException;

/**
 * Class PluginController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 *
 * @deprecated since 3.0.4 instead use Plugin\PluginManageController
 */
class PluginController extends Controller
{
    use ArtisanBackgroundHelper;

    /**
     * PluginController constructor.
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    public function __construct()
    {
        XePresenter::setSettingsSkinTargetId('plugins');

        $this->middleware(function ($request, $next) {
            if (!$request->user()->isAdmin()) {
                throw new AuthorizationException(xe_trans('xe::accessDenied'));
            }
            return $next($request);
        }, ['only' => ['makePlugin', 'makeTheme', 'makeSkin']]);
    }

    /**
     * Show list of plugins.
     *
     * @param Request            $request request
     * @param PluginHandler      $handler PluginHandler instance
     * @return \Xpressengine\Presenter\Presentable
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    public function index(Request $request, PluginHandler $handler)
    {
        //Together 테마 기존 데이터 연동 위해 유지
        return redirect()->route('settings.extension.install');

//        $installType = $request->get('install_type', 'fetched');
//
//        // filter input
//        $field = [];
//        $field['component'] = $request->get('component');
//        $field['status'] = $request->get('status');
//        $field['keyword'] = $request->get('query');
//
//        if ($field['keyword'] === '') {
//            $field['keyword'] = null;
//        }
//
//        $collection = $handler->getAllPlugins(true);
//        $filtered = $collection->fetch($field);
//        $plugins = $collection->fetchByInstallType($installType, $filtered);
//
//        $componentTypes = $this->getComponentTypes();
//
//        $unresolvedComponents = $handler->getUnresolvedComponents();
//
//        if ($installType === 'fetched') {
//            return XePresenter::make('index.fetched', compact('plugins', 'componentTypes', 'installType', 'unresolvedComponents'));
//        } else {
//            return XePresenter::make('index.self-installed', compact('plugins', 'componentTypes', 'installType', 'unresolvedComponents'));
//        }
    }

    /**
     * Show confirm for activate the plugin.
     *
     * @param Request       $request request
     * @param PluginHandler $handler PluginHandler instance
     * @return \Xpressengine\Presenter\Presentable
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    public function getActivate(Request $request, PluginHandler $handler)
    {
        $pluginIds = $request->get('pluginId');
        $pluginIds = explode(',', $pluginIds);

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->getList($pluginIds);

        return api_render('index.activate', compact('plugins'));
    }

    /**
     * Activate plugins.
     *
     * @param Request             $request             request
     * @param PluginHandler       $handler             PluginHandler instance
     * @param InterceptionHandler $interceptionHandler InterceptionHandler instance
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    public function activate(Request $request, PluginHandler $handler, InterceptionHandler $interceptionHandler)
    {
        $handler->getAllPlugins(true);

        $pluginIds = $request->get('pluginId');
        if (empty($pluginIds)) {
            throw new HttpException(422, xe_trans('xe::noPluginsSelected'));
        }

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->getList($pluginIds);

        try {
            foreach ($plugins as $id => $plugin) {
                if ($plugin === null) {
                    throw new HttpException(422, xe_trans('xe::pluginNotFound', ['plugin' => $id]));
                }
                if (!$plugin->isActivated()) {
                    $handler->activatePlugin($plugin->getId());
                }
            }
            $interceptionHandler->clearProxies();
        } catch (XpressengineException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (\Exception $e) {
            throw $e;
        }

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::pluginActivated')]);
    }

    /**
     * Show confirm for deactivate the plugin.
     *
     * @param Request       $request request
     * @param PluginHandler $handler PluginHandler instance
     * @return \Xpressengine\Presenter\Presentable
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    public function getDeactivate(Request $request, PluginHandler $handler)
    {
        $pluginIds = $request->get('pluginId');
        $pluginIds = explode(',', $pluginIds);

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->getList($pluginIds);

        return api_render('index.deactivate', compact('plugins'));
    }

    /**
     * Deactivate plugins.
     *
     * @param Request             $request             request
     * @param PluginHandler       $handler             PluginHandler instance
     * @param InterceptionHandler $interceptionHandler InterceptionHandler instance
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    public function deactivate(Request $request, PluginHandler $handler, InterceptionHandler $interceptionHandler)
    {
        $handler->getAllPlugins(true);

        $pluginIds = $request->get('pluginId');
        if (empty($pluginIds)) {
            throw new HttpException(422, xe_trans('xe::noPluginsSelected'));
        }

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->getList($pluginIds);

        try {
            foreach ($plugins as $id => $plugin) {
                if ($plugin === null) {
                    throw new HttpException(422, xe_trans('xe::pluginNotFound', ['plugin' => $id]));
                }
                if ($plugin->isActivated()) {
                    $handler->deactivatePlugin($plugin->getId());
                }
            }
            $interceptionHandler->clearProxies();
        } catch (XpressengineException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (\Exception $e) {
            throw $e;
        }

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::pluginDeactivated')]);
    }

    /**
     * Update plugins.
     *
     * @param Request       $request  request
     * @param Operator      $operator Operator instance
     * @param PluginHandler $handler PluginHandler instance
     * @return \Illuminate\Http\RedirectResponse
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    public function download(Request $request, Operator $operator, PluginHandler $handler)
    {
        if ($operator->isLocked()) {
            throw new HttpException(422, xe_trans('xe::alreadyProceeding'));
        }

        $plugins = $request->get('plugin');

        foreach ($plugins as $id => $info) {
            if(array_get($info, 'update', false)) {
                if (!$handler->getPlugin($id)) {
                    return back()->with('alert', [
                        'type' => 'danger',
                        'message' => xe_trans('xe::pluginNotFound', ['plugin' => $id])
                    ]);
                }

                $plugins[$id] = $id.':'.array_get($info, 'version');
            }
        }

        if (empty($plugins)) {
            return back()->with('alert', [
                'type' => 'danger',
                'message' => xe_trans('xe::noPluginsSelected')
            ]);
        }

        $operator->setPluginMode(false)->save();

        $this->runArtisan('plugin:update', [
            'plugin' => $plugins,
            '--no-interaction' => true,
        ]);

        return redirect()->route('settings.operation.index')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::downloadingNewVersionPlugin')]
        );
    }

    /**
     * Install new plugin.
     *
     * @param Request        $request  request
     * @param PluginHandler  $handler  PluginHandler instance
     * @param PluginProvider $provider PluginProvider instance
     * @param Operator       $operator Operator instance
     * @return \Illuminate\Http\RedirectResponse
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    public function install(Request $request, PluginHandler $handler, PluginProvider $provider, Operator $operator)
    {
        if ($operator->isLocked()) {
            throw new HttpException(422, xe_trans('xe::alreadyProceeding'));
        }

        $pluginIds = $request->get('pluginId');

        $handler->getAllPlugins(true);

        // 자료실에서 플러그인 정보 조회
        $pluginsData = $provider->findAll($pluginIds);
        if ($pluginsData === null) {
            throw new HttpException(422, xe_trans('xe::notFoundPluginFromMarket'));
        }

        $pluginIds = array_pluck($pluginsData, 'plugin_id');

        $operator->setPluginMode(false)->save();

        $this->runArtisan('plugin:install', [
            'plugin' => $pluginIds,
            '--no-interaction' => true,
        ]);

        return redirect()->route('settings.operation.index')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::installingPlugin')]
        );
    }

    /**
     * Show confirm for delete the plugin.
     *
     * @param Request       $request request
     * @param PluginHandler $handler PluginHandler instance
     * @return \Xpressengine\Presenter\Presentable
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    public function getDelete(Request $request, PluginHandler $handler)
    {
        $pluginIds = $request->get('pluginId');
        $pluginIds = explode(',', $pluginIds);

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->getList($pluginIds);

        return api_render('index.delete', compact('plugins'));
    }

    /**
     * Delete plugins.
     *
     * @param Request       $request  request
     * @param PluginHandler $handler  PluginHandler instance
     * @param Operator      $operator ComposerFileWriter instance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, PluginHandler $handler, Operator $operator)
    {
        if ($operator->isLocked()) {
            throw new HttpException(422, xe_trans('xe::alreadyProceeding'));
        }

        $handler->getAllPlugins(true);

        $pluginIds = $request->get('pluginId', []);
        $force = $request->get('force');

        if (empty($pluginIds)) {
            throw new HttpException(422, xe_trans('xe::noPluginsSelected'));
        }

        $collection = $handler->getAllPlugins(true);

        $plugins = $collection->getList($pluginIds);

        foreach ($plugins as $id => $plugin) {
            if ($plugin === null) {
                throw new HttpException(422, xe_trans('xe::pluginNotFound', ['plugin' => $id]));
            }
        }

        $operator->setPluginMode(false)->save();

        $this->runArtisan('plugin:uninstall', [
            'plugin' => $pluginIds,
            '--force' => !!$force,
            '--no-interaction' => true,
        ]);

        return redirect()->route('settings.operation.index')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::deletingPlugin')]
        );
    }

    /**
     * Show information of the plugin.
     *
     * @param string         $pluginId plugin name
     * @param PluginHandler  $handler  PluginHandler instance
     * @param PluginProvider $provider PluginProvider instance
     * @return \Xpressengine\Presenter\Presentable
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    public function show($pluginId, PluginHandler $handler, PluginProvider $provider)
    {
        // refresh plugin cache
        $handler->getAllPlugins(true);

        $componentTypes = $this->getComponentTypes();

        $plugin = $handler->getPlugin($pluginId);

        $provider->sync($plugin);

        $unresolvedComponents = $handler->getUnresolvedComponents($pluginId);

        return XePresenter::make('show', compact('plugin', 'componentTypes', 'unresolvedComponents'));
    }

    /**
     * Activate plugin.
     *
     * @param string              $pluginId            plugin name
     * @param PluginHandler       $handler             PluginHandler instance
     * @param InterceptionHandler $interceptionHandler InterceptionHandler instance
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
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

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::pluginActivated')]);
    }

    /**
     * Deactivate plugin.
     *
     * @param string              $pluginId            plugin name
     * @param PluginHandler       $handler             PluginHandler instance
     * @param InterceptionHandler $interceptionHandler InterceptionHandler instance
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
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

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::pluginDeactivated')]);
    }

    /**
     * Update plugin.
     *
     * @param string              $pluginId            plugin name
     * @param PluginHandler       $handler             PluginHandler instance
     * @param InterceptionHandler $interceptionHandler InterceptionHandler instance
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
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

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::appliedUpdatePlugin')]);
    }


    /**
     * Returns the list of component type.
     *
     * @return array
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    protected function getComponentTypes()
    {
        $componentTypes = [
            'theme' => xe_trans('xe::theme'),
            'skin' => xe_trans('xe::skin'),
            'settingsSkin' => xe_trans('xe::settingsSkin'),
            'settingsTheme' => xe_trans('xe::settingsTheme'),
            'widget' => xe_trans('xe::widget'),
            'module' => xe_trans('xe::module'),
            'editor' => xe_trans('xe::editor'),
            'editortool' => xe_trans('xe::editorTool'),
            'uiobject' => xe_trans('xe::uiobject'),
            'FieldType' => xe_trans('xe::dynamicField'),
            'FieldSkin' => xe_trans('xe::dynamicFieldSkin'),
        ];
        return $componentTypes;
    }

    /**
     * Renew the plugin
     *
     * @param PluginHandler $handler  plugin handler instance
     * @param Operator      $operator Operator instance
     * @param string        $pluginId plugin name
     * @return \Illuminate\Http\RedirectResponse
     *
     * @deprecated since 3.0.4 instead use Plugin\PluginManageController
     */
    public function renewPlugin(PluginHandler $handler, Operator $operator, $pluginId)
    {
        if ($operator->isLocked()) {
            throw new HttpException(422, xe_trans('xe::alreadyProceeding'));
        }

        if (!$plugin = $handler->getPlugin($pluginId)) {
            return back()->with('alert', [
                'type' => 'danger',
                'message' => xe_trans('xe::pluginNotFound', ['plugin' => $pluginId])
            ]);
        }

        if (!$plugin->isPrivate()) {
            return back()->with('alert', [
                'type' => 'danger',
                'message' => xe_trans('xe::pluginUnableToDependenciesRenew', ['name' => $pluginId])
            ]);
        }

        $operator->setPrivateMode(false)->save();

        $this->runArtisan('private:update', ['name' => $pluginId]);

        return redirect()->route('settings.operation.index')
            ->with('alert', ['type' => 'success', 'message' => xe_trans('xe::startingOperation')]);
    }
}
