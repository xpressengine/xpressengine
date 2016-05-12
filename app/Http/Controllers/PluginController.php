<?php namespace App\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use XePlugin;
use XePresenter;
use Redirect;
use Symfony\Component\HttpFoundation\Response;
use Xpressengine\Http\Request;
use Xpressengine\Plugin\PluginHandler;

class PluginController extends Controller
{

    /**
     * PluginController constructor.
     */
    public function __construct()
    {
        XePresenter::setSettingsSkinTargetId('plugins');
    }

    public function index(Request $request)
    {
        // filter input
        $field = [];
        $field['component'] = $request->get('component');
        $field['status'] = $request->get('status');
        $field['keyword'] = $request->get('query');

        if ($field['keyword'] === '') {
            $field['keyword'] = null;
        }

        $collection = XePlugin::getAllPlugins(true);
        $plugins = $collection->fetch($field);

        $componentTypes = $this->getComponentTypes();

        return XePresenter::make(
            'index',
            [
                'plugins' => $plugins,
                'componentTypes' => $componentTypes,
            ]
        );
    }

    public function show($pluginId, PluginHandler $handler)
    {
        $componentTypes = $this->getComponentTypes();

        $plugin = $handler->getPlugin($pluginId);
        return XePresenter::make('show', compact('plugin', 'componentTypes'));
    }

    public function postActivatePlugin($pluginId)
    {
        try {
            XePlugin::activatePlugin($pluginId);
        } catch (XpressengineException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (\Exception $e) {
            throw $e;
        }

        return Redirect::route('settings.plugins')->withAlert(['type' => 'success', 'message' => '플러그인을 켰습니다.']);
    }

    public function postDeactivatePlugin($pluginId)
    {
        try {
            XePlugin::deactivatePlugin($pluginId);
        } catch (XpressengineException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (\Exception $e) {
            throw $e;
        }

        return Redirect::route('settings.plugins')->withAlert(['type' => 'success', 'message' => '플러그인을 껐습니다.']);
    }

    public function postUpdatePlugin($pluginId)
    {
        try {
            XePlugin::updatePlugin($pluginId);
        } catch (XpressengineException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (\Exception $e) {
            throw $e;
        }

        return Redirect::route('settings.plugins')->withAlert(['type' => 'success', 'message' => '플러그인을 업데이트했습니다.']);
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

