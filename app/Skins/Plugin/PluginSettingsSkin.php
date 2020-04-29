<?php
/**
 * PluginSettingsSkin.php
 *
 * PHP version 7
 *
 * @category    Skins
 * @package     App\Skins\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Skins\Plugin;

use Xpressengine\Skin\GenericSkin;

/**
 * Class PluginSettingsSkin
 *
 * @category    Skins
 * @package     App\Skins\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class PluginSettingsSkin extends GenericSkin
{

    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'plugins/settingsSkin/xpressengine@default';

    /**
     * The information for the component
     *
     * @var array
     */
    protected static $componentInfo = [
        'name' => '기본 플러그인 설정스킨',
        'description' => 'Xpressengine의 기본 플러그인 설정페이지 스킨입니다'
    ];

    /**
     * @var array
     */
    protected static $info = [];

    /**
     * @var string
     */
    protected static $path = 'plugin.skins.default';

    /**
     * @var string
     */
    protected static $viewDir = '';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $this->loadDefault();
        return parent::render();
    }

    /**
     * Call the view for fetched index.
     *
     * @return \Illuminate\View\View
     */
    protected function indexFetched()
    {
        return $this->index();
    }

    /**
     * Call the view for self installed index.
     *
     * @return \Illuminate\View\View
     */
    protected function indexSelfInstalled()
    {
        return $this->index();
    }

    /**
     * Show the list.
     *
     * @return \Illuminate\View\View
     */
    protected function index()
    {
        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-form.js')->load();
        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load();
        app('xe.frontend')->js('assets/core/plugin/js/plugin-index.js')->before(
            [
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/xe-ui-component/js/xe-form.js'
            ]
        )->load();

        return $this->renderBlade();
    }

    /**
     * Show the setting view for plugin.
     *
     * @return \Illuminate\View\View
     */
    protected function show()
    {
        app('xe.frontend')->js([
           'assets/core/plugin/swiper2/idangerous.swiper.min.js',
           'assets/core/plugin/js/plugin.js'
        ])->appendTo('head')->load();
        app('xe.frontend')->css('assets/core/plugin/swiper2/idangerous.swiper.css')
            ->before('assets/core/settings/css/admin.css')->load();

        return $this->renderBlade();
    }

    /**
     * Show the view for install.
     *
     * @return \Illuminate\View\View|null
     */
    protected function installIndex()
    {
        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-form.js')->load();
        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load();
        app('xe.frontend')->js('assets/core/plugin/js/plugin-install.js')->before(
            [
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/xe-ui-component/js/xe-form.js'
            ]
        )->load();
        return $this->renderBlade();
    }

    /**
     * Load default for plugin setting.
     *
     * @return void
     */
    protected function loadDefault()
    {
        app('xe.frontend')->html('plugins.loadTooltip')->content("<script>
            jQuery(function ($) {
              $('[data-toggle=tooltip]').tooltip()
            })
        </script>")->load();

        array_set($this->data, 'color', [
            'theme' => 'success',
            'skin' => 'info',
            'settingsSkin' => 'warning',
            'settingsTheme' => 'warning',
            'widget' => 'danger',
            'module' => 'danger',
            'uiobject' => 'primary',
            'editor' => 'primary',
            'editortool' => 'primary',
            'FieldType' => 'default',
            'FieldSkin' => 'default',
            'toggleMenu' => 'default',
        ]);
    }

}
