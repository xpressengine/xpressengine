<?php
namespace Xpressengine\Themes;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Xpressengine\Member\Rating;
use Xpressengine\Theme\AbstractTheme;

class DefaultSettings extends AbstractTheme
{

    protected static $id = 'settingsTheme/xpressengine@default';

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
        $selectedMenu = \Settings::getSelectedMenu($isSuper);

        return \View::make('settings.theme', compact('menu', 'selectedMenu', 'user'));
    }

    public static function getSettingsURI()
    {
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
//        $frontendHandler->html()->content('<script>
//        require(["core/js/modules/accordion"], function(accordion) {
//            accordion.accordionSection();
//        });
//        </script>')->appendTo('body')->load();


        $frontendHandler->bodyClass('skin-blue')->load();

        $frontendHandler->meta()->name('viewport')->content(
            'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
        )->load();

        $frontendHandler->css(
            [
                '/assets/vendor/bootstrap/css/bootstrap.css',
                '/assets/vendor/font-awesome/css/font-awesome.min.css',
                '/assets/vendor/ionicons/css/ionicons.min.css'
            ]
        )->load();

        $frontendHandler->css(
            [
                '/assets/vendor/adminLTE/dist/css/AdminLTE.min.css',
                '/assets/vendor/adminLTE/dist/css/skins/_all-skins.min.css',
                '/assets/admin-custom.css'
            ]
        )->load();

        $frontendHandler->js(
            [
                'assets/vendor/html5shiv/dist/html5shiv.min.js',
                'assets/vendor/respond/dest/respond.min.js'
            ]
        )->appendTo('head')->target('lt IE 9')->load();

        $frontendHandler->js(
            [
                '/assets/vendor/adminLTE/dist/js/app.js',
            ]
        )->load();
    }
}
