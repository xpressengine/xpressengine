<?php
/**
 * SettingsTheme.php
 *
 * PHP version 7
 *
 * @category    Themes
 * @package     App\Themes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Themes;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Theme\AbstractTheme;
use Xpressengine\User\Rating;

/**
 * Class SettingsTheme
 *
 * @category    Themes
 * @package     App\Themes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SettingsTheme extends AbstractTheme
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'settingsTheme/xpressengine@settings';

    /**
     * @var null|string
     */
    public $content = null;

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $this->loadFrontend();
        $user = \Auth::user();
        $isSuper = $user->getRating() === Rating::SUPER;
        $menu = \XeSettings::getSettingsMenus($isSuper);
        $siteTitle = app('xe.site')->getSiteConfigValue('site_title');
        $siteTitle = $siteTitle !== null ? xe_trans($siteTitle) : 'XpressEngine';
        $selectedMenu = \XeSettings::getSelectedMenu($isSuper);

        $installedVersion = app()->getInstalledVersion();
        if(__XE_VERSION__ !== $installedVersion) {
            app('xe.frontend')->js([
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/xe-ui-component/js/xe-form.js'
            ])->load();
        }

        return view()->make('themes.settings', compact('menu', 'selectedMenu', 'user', 'siteTitle', 'installedVersion'));
    }

    /**
     * Load assets.
     *
     * @return void
     */
    private function loadFrontend()
    {
        /** @var \Xpressengine\Presenter\Html\FrontendHandler $frontendHandler */
        $frontendHandler = app('xe.frontend');

        $frontendHandler->meta()->name('viewport')->content(
            'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
        )->load();

        $frontendHandler->css([
            'assets/vendor/bootstrap/css/bootstrap.min.css',
            'assets/core/xe-ui-component/xe-ui-component.css',
            'assets/core/settings/css/admin.css',
        ])->load();

        $frontendHandler->js([
             'assets/core/settings/js/admin.bundle.js'
         ])->appendTo('head')->load();
    }

    /**
     * Get the view for the component setting.
     *
     * @param ConfigEntity|null $config config
     * @return string
     */
    public function getSettingView(ConfigEntity $config = null)
    {
        return '';
    }

}
