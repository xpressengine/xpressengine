<?php
/**
 * PluginInstallController.php
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

use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;
use Xpressengine\Presenter\Presentable;

/**
 * Class PluginInstallController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 *
 * @deprecated since 3.0.4 instead use ExtensionSettingsController or ThemeSettingsController
 */
class PluginInstallController extends Controller
{
    /**
     * PluginInstallController constructor.
     */
    public function __construct()
    {
        XePresenter::setSettingsSkinTargetId('plugins');
    }

    /**
     * Show the list of installable plugins.
     *
     * @param PluginProvider     $provider PluginProvider instance
     * @param PluginHandler      $handler  PluginHandler instance
     * @param ComposerFileWriter $writer   ComposerFileWriter instance
     *
     * @return Presentable
     */
    public function index(PluginProvider $provider, PluginHandler $handler, ComposerFileWriter $writer)
    {
        $componentTypes = $this->getComponentTypes();

        $filter = 'extension';

        $available = ini_get('allow_url_fopen') ? true : false;

        $packages = $provider->search(['collection' => $filter], 1, 6);

        $handler->getAllPlugins(true);

        $items = new Collection($packages->data);

        $plugins = new LengthAwarePaginator($items, $packages->total, $packages->per_page, $packages->current_page);

        $plugins->setPath(route('settings.plugins.install.items'));

        $plugins->appends('filter', $filter);

        return XePresenter::make(
            'install.index',
            compact('plugins', 'componentTypes', 'handler', 'filter', 'available')
        );
    }

    /**
     * Show the list of plugins.
     *
     * @param Request            $request  request
     * @param PluginProvider     $provider PluginProvider instance
     * @param PluginHandler      $handler  PluginHandler instance
     * @param ComposerFileWriter $writer   CopmoserFileWriter instance
     *
     * @return Presentable
     */
    public function items(Request $request, PluginProvider $provider, PluginHandler $handler, ComposerFileWriter $writer)
    {
        $page = $request->get('page', 1);
        $q = $query = $request->get('q');
        $authors = $request->get('author');
        $tags = $request->get('tag');
        $filter = $request->get('filter');
        $plugins = null;
        $config = app('xe.config')->get('plugin');
        $order = null;
        $order_type = null;
        $site_token = $config->get('site_token');

        if ($query) {
            $query = explode(' ', $query);
            $filter = null;
            $packages = $provider->search(compact('query', 'site_token'), $page, 6);
        } elseif ($authors) {
            $authors = explode(' ', $authors);
            $filter = null;
            $packages = $provider->search(compact('authors', 'site_token'), $page, 6);
        } elseif ($tags) {
            $tags = explode(' ', $tags);
            $filter = null;
            $packages = $provider->search(compact('tags', 'site_token'), $page, 6);
        } elseif ($filter === 'purchased') {
            if (!$site_token) {
                $link = route('settings.setting.edit');
                $plugins = new LengthAwarePaginator(collect(), 0, 1, '');
                $site_error =
                    xe_trans('xe::needSiteTokenToViewListOfPurchased', [
                        'link' => sprintf('<a href="%s">%s</a>', $link, xe_trans('xe::moveToSetting'))
                    ]);
                return api_render('install.items', compact('plugins', 'filter', 'site_error'), compact('filter'));
            }
            try {
                $packages = $provider->purchased($site_token);
            } catch (\Exception $e) {
                throw new HttpException(
                    Response::HTTP_BAD_REQUEST,
                    xe_trans('xe::InvalidSiteTokenInformation')
                );
            }
        } else {
            $collection = $filter;
            $filters = compact('collection', 'order', 'order_type', 'site_token');
            $packages = $provider->search($filters, $page, 6);
        }

        if (!$plugins) {
            $items = new Collection($packages->data);
            $plugins = new LengthAwarePaginator($items, $packages->total, $packages->per_page, $packages->current_page);
            $plugins->setPath(route('settings.plugins.install.items'));
            $plugins->appends('filter', $filter);
            $plugins->appends('q', $q);
        }

        if ($query) {
            $filter = 'search';
        }
        $handler->getAllPlugins(true);
        $componentTypes = $this->getComponentTypes();

        return api_render('install.items', compact('plugins', 'componentTypes', 'q', 'handler', 'filter'), compact('filter'));
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
}
