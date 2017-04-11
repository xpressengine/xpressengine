<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\Plugin\PluginProvider;

class PluginInstallController extends Controller
{

    /**
     * PluginInstallController constructor.
     */
    public function __construct()
    {
        XePresenter::setSettingsSkinTargetId('plugins');
    }

    public function index(Request $request, PluginProvider $provider)
    {
        $componentTypes = $this->getComponentTypes();

        $packages = $provider->search();

        $items = new Collection($packages->data);
        $plugins = new LengthAwarePaginator($items, $packages->total, $packages->per_page, $packages->current_page);
        $plugins->setPath(route('settings.plugins.install.items'));

        return XePresenter::make('install.index', compact('plugins', 'componentTypes'));
    }

    public function items(Request $request, PluginProvider $provider)
    {
        $filter = $request->get('filter', '');
        if ($filter === 'purchased') {
            $config = app('xe.config')->get('plugin');
            $site_token = $config->get('site_token');

            if(!$site_token) {
                throw new HttpException(Response::HTTP_BAD_REQUEST, '자료실에서 구매시 사용한 사이트토큰 정보를 저장해야 구매한 플러그인 목록을 볼 수 있습니다.');
            }
            $packages = $provider->purchased($site_token);
            $plugins = new Collection($packages);

        } else {
            $q = $query = $request->get('q');
            if($query) {
                $query = explode(' ', $query);
                $packages = $provider->search($query, $request->get('page', 1));
            }
            $items = new Collection($packages->data);
            $plugins = new LengthAwarePaginator($items, $packages->total, $packages->per_page, $packages->current_page);
            $plugins->setPath(route('settings.plugins.install.items'));
        }

        $componentTypes = $this->getComponentTypes();

        return apiRender('install.items', compact('plugins', 'componentTypes', 'q'));
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

