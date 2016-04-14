<?php
namespace Xpressengine\Themes;

use Xpressengine\User\Rating;
use Xpressengine\Theme\AbstractTheme;

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
        return \View::make('themes.settings', compact('menu', 'selectedMenu', 'user', 'siteTitle'));
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

        $frontendHandler->js('assets/core/settings/js/admin.bundle.js')->appendTo('head')->load();
    }
}
