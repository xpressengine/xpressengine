<?php
namespace Xpressengine\Themes;

use Xpressengine\Member\Rating;
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
        $menu = \Settings::getSettingsMenus($isSuper);
        $siteTitle = app('xe.site')->getSiteConfigValue('site_title');
        $siteTitle = $siteTitle !== null ? xe_trans($siteTitle) : 'XpressEngine';
        $selectedMenu = \Settings::getSelectedMenu($isSuper);
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

        $frontendHandler->css('assets/vendor/bootstrap/css/bootstrap.css')->load();

        $frontendHandler->css([
            'assets/core/common/css/form.css',
            'assets/core/common/css/dropdown.css',
            'assets/core/common/css/flag.css',
            'assets/core/common/css/badge.css',
            'assets/core/common/css/modal.css',
            'assets/core/settings/css/admin.css',
        ])->before(['assets/vendor/bootstrap/css/bootstrap.css', 'assets/core/common/css/normalize.css'])->load();

        $frontendHandler->js(
            [
                'assets/vendor/html5shiv/dist/html5shiv.min.js',
                'assets/vendor/respond/dest/respond.min.js',
                'assets/vendor/bootstrap/js/bootstrap.min.js'
            ]
        )->appendTo('head')->target('lt IE 9')->load();

        $frontendHandler->js('assets/core/settings/js/admin.js')
            ->before('assets/vendor/bootstrap/js/bootstrap.min.js')->load();

    }
}
