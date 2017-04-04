<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Themes;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Theme\AbstractTheme;
use Xpressengine\User\Rating;

class SettingsTheme extends AbstractTheme
{

    protected static $id = 'settingsTheme/xpressengine@settings';

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

        $installedVersion = file_get_contents(base_path('storage/app/installed'));
        if(__XE_VERSION__ !== $installedVersion) {
            app('xe.frontend')->js([
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/xe-ui-component/js/xe-form.js'
            ])->load();
        }

        return view()->make('themes.settings', compact('menu', 'selectedMenu', 'user', 'siteTitle', 'installedVersion'));
    }

    /**
     * loadFrontend
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
            'assets/vendor/bootstrap/css/bootstrap.css',
            'assets/core/xe-ui-component/xe-ui-component.css',
            'assets/core/settings/css/admin.css',
        ])->load();

        $frontendHandler->js([
             'assets/core/settings/js/admin.bundle.js'
         ])->appendTo('head')->load();
    }

    /**
     * 테마 설정 페이지에 출력할 html 텍스트를 출력한다.
     * 설정폼은 자동으로 생성되며 설정폼 내부에 출력할 html만 반환하면 된다.
     *
     * @param ConfigEntity|null $config 기존에 설정된 설정값
     *
     * @return string
     */
    public function getSettingView(ConfigEntity $config = null)
    {
        return '';
    }

}
