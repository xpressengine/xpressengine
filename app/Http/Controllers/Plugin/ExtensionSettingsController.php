<?php

namespace App\Http\Controllers\Plugin;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

class ExtensionSettingsController extends Controller
{
    public function __construct()
    {
        XePresenter::setSettingsSkinTargetId('plugins');

        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-form.js')->load();
        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load();
        app('xe.frontend')->js('assets/core/plugin/js/plugin-index.js')->before(
            [
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/xe-ui-component/js/xe-form.js'
            ]
        )->load();
    }

    public function installed(Request $request, PluginHandler $handler)
    {
        $field = [];
        $field['status'] = $request->get('status');
        $field['keyword'] = $request->get('query', null);
        $field['component'] = $request->get('component');

        $extensions = $handler->getAllExtensions(true);
        $extensions = $extensions->fetch($field);

        $unresolvedComponents = $handler->getUnresolvedComponents();
        $componentTypes = $this->getComponentTypes();

        return XePresenter::make('extension.installed', compact(
            'handler',
            'extensions',
            'unresolvedComponents',
            'componentTypes'
        ));
    }

    public function install(Request $request, PluginHandler $pluginHandler, PluginProvider $pluginProvider)
    {
        $saleType = $request->get('sale_type', 'free');

        $filter = [
            'collection' => 'extension',
            'site_token' => app('xe.config')->get('plugin')->get('site_token'),
            'sale_type' => $saleType
        ];

        $orderTypes = [
            '1' => ['name' => '인기순', 'order' => 'downloadeds', 'order_type' => 'desc'],
            '2' => ['name' => '업데이트', 'order' => 'updated_at', 'order_type' => 'desc'],
            '3' => ['name' => '최신순', 'order' => 'latest', 'order_type' => 'asc'],
            '4' => ['name' => '가격 낮은 순', 'order' => 'price', 'order_type' => 'asc'],
            '5' => ['name' => '가격 높은 순', 'order' => 'price', 'order_type' => 'desc'],
        ];

        if ($orderType = $request->get('order_key')) {
            $order = $orderTypes[$orderType];
            array_forget($order, 'name');
            $filter = array_merge($filter, $order);
        }

        $storeExtensionInformation = $pluginProvider->search(array_merge($filter, $request->except('_token', 'order_key')), $request->get('page', 1));
        $storeExtensions = $storeExtensionInformation->items;
        $storeExtensionCounts = $storeExtensionInformation->counts;
        $extensionCategories = $pluginProvider->getPluginCategories('extension');

        $items = new Collection($storeExtensions->data);

        if ($request->get('sale_type') == 'my_site') {
            $items = $items->filter(function ($item, $value) {
                return $item->is_purchased == true;
            });
        }

        $extensions = new LengthAwarePaginator(
            $items,
            $storeExtensions->total,
            $storeExtensions->per_page,
            $storeExtensions->current_page
        );
        $extensions->setPath(route('settings.extension.install'));
        $extensions->appends('filter', $filter);

        return XePresenter::make(
            'extension.install',
            compact('saleType', 'extensions', 'extensionCategories', 'pluginHandler', 'orderTypes', 'storeExtensionCounts')
        );
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
}
