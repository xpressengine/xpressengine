<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use XePlugin;
use XePresenter;
use Redirect;
use Symfony\Component\HttpFoundation\Response;
use Xpressengine\Http\Request;
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

    public function index(Request $request, PluginHandler $handler, PluginProvider $provider)
    {
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

        return XePresenter::make(
            'index',
            [
                'plugins' => $plugins,
                'componentTypes' => $componentTypes,
            ]
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

    public function putActivatePlugin($pluginId, PluginHandler $handler)
    {
        try {
            $handler->activatePlugin($pluginId);
        } catch (XpressengineException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (\Exception $e) {
            throw $e;
        }

        return Redirect::route('settings.plugins')->withAlert(['type' => 'success', 'message' => '플러그인을 켰습니다.']);
    }

    public function putDeactivatePlugin($pluginId, PluginHandler $handler)
    {
        try {
            $handler->deactivatePlugin($pluginId);
        } catch (XpressengineException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (\Exception $e) {
            throw $e;
        }

        return Redirect::route('settings.plugins')->withAlert(['type' => 'success', 'message' => '플러그인을 껐습니다.']);
    }

    public function putUpdatePlugin($pluginId, PluginHandler $handler)
    {
        try {
            $handler->updatePlugin($pluginId);
        } catch (XpressengineException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (\Exception $e) {
            throw $e;
        }

        app('session.store')->flash('alert', ['type' => 'success', 'message' => '플러그인을 업데이트했습니다.']);
        return XePresenter::makeApi(['type' => 'success', 'message' => '플러그인을 업데이트했습니다.']);
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

