<?php
/**
 * PluginManageController
 *
 * PHP version 7
 *
 * @category  Controllers
 * @package   App\Http\Controllers\Plugin
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace App\Http\Controllers\Plugin;

use App\Http\Controllers\ArtisanBackgroundHelper;
use App\Http\Controllers\Controller;
use Artisan;
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
 * Class PluginManageController
 *
 * @category    Controllers
 * @package     App\Http\Controllers\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginManageController extends Controller
{
    use ArtisanBackgroundHelper;

    /**
     * PluginManageController constructor.
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
     * @param Request        $request        request
     * @param string         $pluginId       plugin id
     * @param PluginHandler  $pluginHandler  plugin handler
     * @param PluginProvider $pluginProvider plugin provider
     *
     * @return mixed
     */
    public function getDetailPopup(
        Request $request,
        $pluginId,
        PluginHandler $pluginHandler,
        PluginProvider $pluginProvider
    ) {
        $storePluginItem = $pluginProvider->find($pluginId);
        $pluginEntity = $pluginHandler->getPlugin($pluginId);

        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-form.js')->load();
        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load();
        app('xe.frontend')->js('assets/core/plugin/js/plugin-index.js')->before(
            [
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/xe-ui-component/js/xe-form.js'
            ]
        )->load();

        return api_render('common.detail_popup', compact('storePluginItem', 'pluginEntity'));
    }

    /**
     * @param string         $pluginId plugin id
     * @param PluginHandler  $handler  plugin handler
     * @param PluginProvider $provider plugin provider
     *
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
     * @param Request       $request request
     * @param PluginHandler $handler plugin handler
     *
     * @return mixed
     */
    public function getActivate(Request $request, PluginHandler $handler)
    {
        $pluginIds = $request->get('pluginId');
        $pluginIds = explode(',', $pluginIds);

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->getList($pluginIds);

        return api_render('manage.activate', compact('plugins'));
    }

    /**
     * @param Request             $request             request
     * @param PluginHandler       $handler             plugin handler
     * @param InterceptionHandler $interceptionHandler intercept handler
     *
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
     * @param Request       $request request
     * @param PluginHandler $handler plugin handler
     *
     * @return mixed
     */
    public function getDeactivate(Request $request, PluginHandler $handler)
    {
        $pluginIds = $request->get('pluginId');
        $pluginIds = explode(',', $pluginIds);

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->getList($pluginIds);

        return api_render('manage.deactivate', compact('plugins'));
    }

    /**
     * @param Request             $request             request
     * @param PluginHandler       $handler             plugin handler
     * @param InterceptionHandler $interceptionHandler intercept handler
     *
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
     * @param Request       $request request
     * @param PluginHandler $handler plugin handler
     *
     * @return mixed
     */
    public function getDelete(Request $request, PluginHandler $handler)
    {
        $pluginIds = $request->get('pluginId');
        $pluginIds = explode(',', $pluginIds);

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->getList($pluginIds);

        return api_render('manage.delete', compact('plugins'));
    }

    /**
     * @param Request       $request  request
     * @param PluginHandler $handler  plugin handler
     * @param Operator      $operator operator
     *
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
     * Update plugins.
     *
     * @param Request       $request  request
     * @param Operator      $operator Operator instance
     * @param PluginHandler $handler  PluginHandler instance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function download(Request $request, Operator $operator, PluginHandler $handler)
    {
        if ($operator->isLocked()) {
            throw new HttpException(422, xe_trans('xe::alreadyProceeding'));
        }

        $data = $request->get('plugin');
        $plugins = [];

        foreach ($data as $id => $info) {
            if (array_get($info, 'update', false)) {
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
     * @param Request        $request  request
     * @param PluginHandler  $handler  plugin handler
     * @param PluginProvider $provider plugin provider
     * @param Operator       $operator operator
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * @param Operator $operator operator
     * @param bool     $private  is private
     *
     * @return string
     */
    protected function prepareOperation(Operator $operator, $private = false)
    {
        $startTime = now()->format('YmdHis');
        $logFile = "logs/plugin-$startTime.log";
        $private ? $operator->setPrivateMode($logFile, false) : $operator->setPluginMode($logFile, false);

        return $logFile;
    }

    /**
     * @param string              $pluginId            plugin id
     * @param PluginHandler       $handler             plugin handler
     * @param InterceptionHandler $interceptionHandler intercept handler
     *
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
     * @param string              $pluginId            plugin id
     * @param PluginHandler       $handler             plugin handler
     * @param InterceptionHandler $interceptionHandler intercept handler
     *
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
     * @param string              $pluginId            plugin id
     * @param PluginHandler       $handler             plugin handler
     * @param InterceptionHandler $interceptionHandler intercept handler
     *
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

        return redirect()->back()->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::appliedUpdatePlugin')]
        );
    }

    /**
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
     * @param PluginHandler $handler  plugin handler
     * @param Operator      $operator operator
     * @param string        $pluginId plugin id
     *
     * @return \Illuminate\Http\RedirectResponse
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

    /**
     * @param Request $request request
     *
     * @return mixed
     */
    public function getUpload(Request $request)
    {
        $typeName = xe_trans('xe::' . $request->get('type'));

        return api_render('common.upload_popup', ['typeName' => $typeName]);
    }

    /**
     * @param Request       $request       request
     * @param PluginHandler $pluginHandler plugin handler
     * @param Operator      $operator      operator
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpload(Request $request, PluginHandler $pluginHandler, Operator $operator)
    {
        $uploadFile = $request->file('plugin');
        if ($uploadFile == null) {
            return redirect()->back();
        }

        try {
            $pluginName = $pluginHandler->uploadPlugin($uploadFile);

            $operator->setPrivateMode(false)->save();

            $this->runArtisan('plugin:private_install', [
                'name' => $pluginName,
                '--no-interaction' => true
            ]);

        } catch (\Exception $e) {
            return back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        return redirect()->route('settings.operation.index')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::installingPlugin')]
        );
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
    public function makePlugin(Request $request, Operator $operator)
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

        $operator->setPrivateMode(false)->save();

        $this->runArtisan('make:plugin', $parameters);

        return redirect()->route('settings.operation.index')
            ->with('alert', ['type' => 'success', 'message' => xe_trans('xe::startingOperation')]);
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
