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
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
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

    public function index(Request $request, PluginProvider $provider, PluginHandler $handler, ComposerFileWriter $writer)
    {
        $componentTypes = $this->getComponentTypes();

        $filter = 'top';

        $available = ini_get('allow_url_fopen') ? true : false;

        $packages = $provider->search(['collection' => $filter], 1, 10);

        $handler->getAllPlugins(true);

        $items = new Collection($packages->data);

        $plugins = new LengthAwarePaginator($items, $packages->total, $packages->per_page, $packages->current_page);

        $plugins->setPath(route('settings.plugins.install.items'));

        $operation = $handler->getOperation($writer);

        return XePresenter::make(
            'install.index',
            compact('plugins', 'componentTypes', 'handler', 'filter', 'operation', 'available')
        );
    }

    public function items(Request $request, PluginProvider $provider, PluginHandler $handler)
    {
        $page = $request->get('page', 1);
        $q = $query = $request->get('q');
        $filter = $request->get('filter');
        $plugins = null;

        $config = app('xe.config')->get('plugin');
        $site_token = $config->get('site_token');

        if ($query) {
            $query = explode(' ', $query);
            $filter = null;
            $packages = $provider->search(compact('query', 'site_token'), $page, 10);
        } elseif ($filter === 'purchased') {
            if (!$site_token) {
                $link = route('settings.plugins.setting.show');
                throw new HttpException(
                    Response::HTTP_BAD_REQUEST,
                    '자료실에서 구매시 사용한 사이트토큰 정보를 저장해야 구매한 플러그인 목록을 볼 수 있습니다. <a href="'.$link.'">설정하러 가기</a>'
                );
            }
            try {
                $packages = $provider->purchased($site_token);
            } catch (\Exception $e) {
                throw new HttpException(
                    Response::HTTP_BAD_REQUEST,
                    '사이트 토큰 정보가 잘못되었습니다.'
                );
            }
            $plugins = new Collection($packages);
        } else {
            if ($filter === 'top') {
                $collection = $filter;
            } elseif ($filter === 'popular') {
                $order = 'downloadeds';
                $order_type = 'desc';
            }
            $filters = compact('collection', 'order', 'order_type', 'site_token');
            $packages = $provider->search($filters, $page, 10);
        }

        if (!$plugins) {
            $items = new Collection($packages->data);
            $plugins = new LengthAwarePaginator($items, $packages->total, $packages->per_page, $packages->current_page);
            $plugins->setPath(route('settings.plugins.install.items'));
            $plugins->appends('filter', $filter);
            $plugins->appends('q', $q);
        }

        if($query) {
            $filter = 'search';
        }

        $handler->getAllPlugins(true);
        $componentTypes = $this->getComponentTypes();

        return api_render('install.items', compact('plugins', 'componentTypes', 'q', 'handler', 'filter'), compact('filter'));
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

