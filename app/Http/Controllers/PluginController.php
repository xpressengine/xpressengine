<?php
/**
 * PluginController.php
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

use Artisan;
use Illuminate\Auth\Access\AuthorizationException;
use Redirect;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\Interception\InterceptionHandler;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;
use Xpressengine\Support\Exceptions\XpressengineException;

/**
 * Class PluginController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class PluginController extends Controller
{

    /**
     * PluginController constructor.
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
     * @param ComposerFileWriter $writer  ComposerFileWriter instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index(Request $request, PluginHandler $handler, ComposerFileWriter $writer)
    {
        $installType = $request->get('install_type', 'fetched');

        // filter input
        $field = [];
        $field['component'] = $request->get('component');
        $field['status'] = $request->get('status');
        $field['keyword'] = $request->get('query');

        if ($field['keyword'] === '') {
            $field['keyword'] = null;
        }

        $collection = $handler->getAllPlugins(true);
        $filtered = $collection->fetch($field);
        $plugins = $collection->fetchByInstallType($installType, $filtered);

        $componentTypes = $this->getComponentTypes();

        $unresolvedComponents = $handler->getUnresolvedComponents();

        if ($installType === 'fetched') {
            $operation = $handler->getOperation($writer);
            return XePresenter::make('index.fetched', compact('plugins', 'componentTypes', 'operation', 'installType', 'unresolvedComponents'));
        } else {
            return XePresenter::make('index.self-installed', compact('plugins', 'componentTypes', 'installType', 'unresolvedComponents'));
        }
    }

    /**
     * Show current operation status.
     *
     * @param PluginHandler      $handler PluginHandler instance
     * @param ComposerFileWriter $writer  ComposerFileWriter instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getOperation(PluginHandler $handler, ComposerFileWriter $writer)
    {
        $term = 15;
        $sleep = 2;
        $begin = time();
        while (true) {
            $current = time();
            $operation = $handler->getOperation($writer);
            if ($operation['status'] !== ComposerFileWriter::STATUS_RUNNING || $current - $begin > $term) {
                break;
            }

            sleep($sleep);
        }

        return api_render('operation', compact('operation'), compact('operation'));
    }

    /**
     * Delete operation log.
     *
     * @param ComposerFileWriter $writer ComposerFileWriter instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function deleteOperation(ComposerFileWriter $writer)
    {
        $writer->reset()->cleanOperation()->write();
        return XePresenter::makeApi(['type' => 'success', 'message' => xe_trans('xe::deleted')]);
    }

    /**
     * Show confirm for delete the plugin.
     *
     * @param Request       $request request
     * @param PluginHandler $handler PluginHandler instance
     * @return \Xpressengine\Presenter\Presentable
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
     * @param Request            $request request
     * @param PluginHandler      $handler PluginHandler instance
     * @param ComposerFileWriter $writer  ComposerFileWriter instance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, PluginHandler $handler, ComposerFileWriter $writer)
    {
        $operation = $handler->getOperation($writer);
        if ($operation['status'] === ComposerFileWriter::STATUS_RUNNING) {
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

        /** @var \Illuminate\Foundation\Application $app */
        app()->terminating(function () use ($pluginIds, $force) {
            Artisan::call('plugin:uninstall', [
                'plugin' => $pluginIds,
                '--force' => !!$force,
                '--no-interaction' => true,
            ]);
        });

        return redirect()->route('settings.plugins')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::deletingPlugin')]
        )->with('operation', 'running');
    }

    /**
     * Show confirm for activate the plugin.
     *
     * @param Request       $request request
     * @param PluginHandler $handler PluginHandler instance
     * @return \Xpressengine\Presenter\Presentable
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
     * Show confirm for update the plugin.
     *
     * @param PluginHandler  $handler  PluginHandler instance
     * @param PluginProvider $provider PluginProvider instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getDownload(PluginHandler $handler, PluginProvider $provider)
    {
        $collection = $handler->getAllPlugins(true);
        $fetched = $collection->fetchByInstallType('fetched');

        $provider->sync($fetched);

        $plugins = array_where(
            $fetched,
            function ($plugin) {
                return $plugin->hasUpdate();
            }
        );

        $available = ini_get('allow_url_fopen') ? true : false;


        return api_render('index.update', compact('plugins', 'available'));
    }

    /**
     * Update plugins.
     *
     * @param Request            $request request
     * @param PluginHandler      $handler PluginHandler instance
     * @param ComposerFileWriter $writer  ComposerFileWriter instance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function download(Request $request, PluginHandler $handler, ComposerFileWriter $writer)
    {
        $operation = $handler->getOperation($writer);
        if ($operation['status'] === ComposerFileWriter::STATUS_RUNNING) {
            throw new HttpException(422, xe_trans('xe::alreadyProceeding'));
        }

        $plugins = $request->get('plugin');

        foreach ($plugins as $id => $info) {
            if(array_get($info, 'update', false)) {
                $plugins[$id] = $id.':'.array_get($info, 'version');
            }
        }

        if (empty($plugins)) {
            throw new HttpException(422, xe_trans('xe::noPluginsSelected'));
        }

        /** @var \Illuminate\Foundation\Application $app */
        app()->terminating(function () use ($plugins) {
            Artisan::call('plugin:update', [
                'plugin' => $plugins,
                '--no-interaction' => true,
            ]);
        });

        return redirect()->route('settings.plugins')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::downloadingNewVersionPlugin')]
        )->with('operation', 'running');
    }

    /**
     * Install new plugin.
     *
     * @param Request            $request  request
     * @param PluginHandler      $handler  PluginHandler instance
     * @param PluginProvider     $provider PluginProvider instance
     * @param ComposerFileWriter $writer   ComposerFileWriter instance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function install(
        Request $request,
        PluginHandler $handler,
        PluginProvider $provider,
        ComposerFileWriter $writer
    ) {
        $operation = $handler->getOperation($writer);

        if ($operation['status'] === ComposerFileWriter::STATUS_RUNNING) {
            throw new HttpException(422, xe_trans('xe::alreadyProceeding'));
        }

        $pluginIds = $request->get('pluginId');

        $handler->getAllPlugins(true);

        // 자료실에서 플러그인 정보 조회
        $pluginsData = $provider->findAll($pluginIds);
        if ($pluginsData === null) {
            throw new HttpException(422, xe_trans('xe::notFoundPluginFromMarket'));
        }

        /** @var \Illuminate\Foundation\Application $app */
        app()->terminating(function () use ($pluginIds) {
            Artisan::call('plugin:install', [
                'plugin' => $pluginIds,
                '--no-interaction' => true,
            ]);
        });

        return redirect()->back()->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::installingPlugin')]
        )->with('operation', 'running');
    }

    /**
     * Show information of the plugin.
     *
     * @param string         $pluginId plugin name
     * @param PluginHandler  $handler  PluginHandler instance
     * @param PluginProvider $provider PluginProvider instance
     * @return \Xpressengine\Presenter\Presentable
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
     * Show the create form for the new plugin.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getMakePlugin()
    {
        return api_render('index.make-plugin', []);
    }

    /**
     * Make new plugin.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makePlugin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|alpha_dash',
            'vendor' => 'required|alpha_dash',
        ]);

        $parameters = [
            'name' => $request->get('name'),
            'vendor' => $request->get('vendor'),
            '--no-interaction' => true,
        ];
        if ($ns = $request->get('namespace')) {
            $parameters['--namespace'] = $ns;
        }
        if ($title = $request->get('title')) {
            $parameters['--title'] = $title;
        }

        Artisan::call('make:plugin', $parameters);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::wasCreated')]);
    }

    /**
     * Show the create form for the new theme.
     *
     * @param PluginHandler $handler PluginHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getMakeTheme(PluginHandler $handler)
    {
        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->fetchByInstallType('self-installed');

        return api_render('index.make-theme', ['plugins' => $plugins]);
    }

    /**
     * Make new theme.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeTheme(Request $request)
    {
        $this->validate($request, [
            'plugin' => 'required',
            'name' => 'required|alpha_dash',
        ]);

        $parameters = [
            'plugin' => $request->get('plugin'),
            'name' => $request->get('name'),
            '--no-interaction' => true,
        ];
        if ($id = $request->get('id')) {
            $parameters['--id'] = $id;
        }
        if ($path = $request->get('path')) {
            $parameters['--path'] = $path;
        }
        if ($class = $request->get('class')) {
            $parameters['--class'] = $class;
        }
        if ($title = $request->get('title')) {
            $parameters['--title'] = $title;
        }
        if ($description = $request->get('description')) {
            $parameters['--description'] = $description;
        }

        Artisan::call('make:theme', $parameters);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::wasCreated')]);
    }

    /**
     * Show the create form for the new skin.
     *
     * @param PluginHandler $handler PluginHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getMakeSkin(PluginHandler $handler)
    {
        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->fetchByInstallType('self-installed');

        $targets = [];
        foreach (['widget', 'module'] as $type) {
            $targets = $targets + app('xe.register')->get($type);
        }

        return api_render('index.make-skin', ['plugins' => $plugins, 'targets' => $targets]);
    }

    /**
     * Make new skin.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeSkin(Request $request)
    {
        if ($request->get('target') === '__direct') {
            $request->merge(['target' => $request->get('target_direct')]);
        }

        $this->validate($request, [
            'plugin' => 'required',
            'name' => 'required|alpha_dash',
            'target' => 'required',
        ]);

        $parameters = [
            'plugin' => $request->get('plugin'),
            'name' => $request->get('name'),
            'target' => $request->get('target'),
            '--no-interaction' => true,
        ];
        if ($id = $request->get('id')) {
            $parameters['--id'] = $id;
        }
        if ($path = $request->get('path')) {
            $parameters['--path'] = $path;
        }
        if ($class = $request->get('class')) {
            $parameters['--class'] = $class;
        }
        if ($title = $request->get('title')) {
            $parameters['--title'] = $title;
        }
        if ($description = $request->get('description')) {
            $parameters['--description'] = $description;
        }

        Artisan::call('make:skin', $parameters);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::wasCreated')]);
    }
}
