<?php

namespace App\Http\Controllers\Plugin;

use App\Http\Controllers\ArtisanBackgroundHelper;
use App\Http\Controllers\Controller;
use Artisan;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XePresenter;
use Xpressengine\Foundation\Operator;
use Xpressengine\Http\Request;
use Xpressengine\Interception\InterceptionHandler;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;
use Xpressengine\Support\Exceptions\XpressengineException;

class PluginManageController extends Controller
{
    use ArtisanBackgroundHelper;

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

    public function getDetailPopup(Request $request, $pluginId, PluginHandler $pluginHandler, PluginProvider $pluginProvider)
    {
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

    public function getActivate(Request $request, PluginHandler $handler)
    {
        $pluginIds = $request->get('pluginId');
        $pluginIds = explode(',', $pluginIds);

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->getList($pluginIds);

        return api_render('manage.activate', compact('plugins'));
    }

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

    public function getDeactivate(Request $request, PluginHandler $handler)
    {
        $pluginIds = $request->get('pluginId');
        $pluginIds = explode(',', $pluginIds);

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->getList($pluginIds);

        return api_render('manage.deactivate', compact('plugins'));
    }

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

    public function getDelete(Request $request, PluginHandler $handler)
    {
        $pluginIds = $request->get('pluginId');
        $pluginIds = explode(',', $pluginIds);

        $collection = $handler->getAllPlugins(true);
        $plugins = $collection->getList($pluginIds);

        return api_render('manage.delete', compact('plugins'));
    }

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

        $logFile = $this->prepareOperation($operator);

        app()->terminating(function () use ($pluginIds, $force, $logFile) {
            Artisan::call('plugin:uninstall', [
                'plugin' => $pluginIds,
                '--force' => !!$force,
                '--no-interaction' => true,
            ], new StreamOutput(fopen(storage_path($logFile), 'a')));
        });

        return redirect()->route('settings.operation.index')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::deletingPlugin')]
        );
    }

    public function download(Request $request, Operator $operator)
    {
        if ($operator->isLocked()) {
            throw new HttpException(422, xe_trans('xe::alreadyProceeding'));
        }

        $plugins = $request->get('plugin');

        foreach ($plugins as $id => $info) {
            if (array_get($info, 'update', false)) {
                $plugins[$id] = $id.':'.array_get($info, 'version');
            }
        }

        if (empty($plugins)) {
            throw new HttpException(422, xe_trans('xe::noPluginsSelected'));
        }

        $logFile = $this->prepareOperation($operator);

        app()->terminating(function () use ($plugins, $logFile) {
            Artisan::call('plugin:update', [
                'plugin' => $plugins,
                '--no-interaction' => true,
            ], new StreamOutput(fopen(storage_path($logFile), 'a')));
        });

        return redirect()->route('settings.operation.index')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::downloadingNewVersionPlugin')]
        );
    }

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

        $logFile = $this->prepareOperation($operator);

        app()->terminating(function () use ($pluginIds, $logFile) {
            Artisan::call('plugin:install', [
                'plugin' => $pluginIds,
                '--no-interaction' => true,
            ], new StreamOutput(fopen(storage_path($logFile), 'a')));
        });

        return redirect()->route('settings.operation.index')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::installingPlugin')]
        );
    }

    protected function prepareOperation(Operator $operator, $private = false)
    {
        $startTime = now()->format('YmdHis');
        $logFile = "logs/plugin-$startTime.log";
        $private ? $operator->setPrivateMode($logFile, false) : $operator->setPluginMode($logFile, false);

        return $logFile;
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

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::pluginActivated')]);
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

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::pluginDeactivated')]);
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

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::appliedUpdatePlugin')]);
    }

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

    public function getUpload(Request $request)
    {
        $typeName = xe_trans('xe::' . $request->get('type'));

        return api_render('common.upload_popup', ['typeName' => $typeName]);
    }

    public function postUpload(Request $request, PluginHandler $pluginHandler)
    {
        $uploadFile = $request->file('plugin');
        if ($uploadFile == null) {
            return redirect()->back();
        }

        try {
            $pluginName =  $pluginHandler->uploadPlugin($uploadFile);
            app()->terminating(function () use ($pluginName) {
                Artisan::call('plugin:private_install', [
                    'name' => $pluginName,
                    '--no-interaction' => true,
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        return redirect()->route('settings.operation.index')->with(
            'alert',
            ['type' => 'success', 'message' => xe_trans('xe::installingPlugin')]
        );
    }
}
