<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Plugins\Board\Components\Modules\BoardModule;
use Xpressengine\Settings\SettingsHandler;
use Xpressengine\Settings\SettingsMenu;
use Xpressengine\Spotlight\SpotlightItemContainer;
use Xpressengine\User\Rating;

class SpotlightServiceProvider extends ServiceProvider
{
    public function register()
    {
        SpotlightItemContainer::bootSingleton();
    }

    public function boot()
    {
        $this->registerSiteMap();
        $this->registerSettingsMenu();
    }

    protected function registerSiteMap()
    {
        app()->resolving(SpotlightItemContainer::class, function(SpotlightItemContainer $container) {
            $siteKey = app('xe.site')->getCurrentSiteKey();
            $siteMapMenus = app('xe.menu')->menus()->fetchBySiteKey($siteKey, 'items')->getDictionary();

            foreach ($siteMapMenus as $siteMapMenu)
            {
                $container->add($siteMapMenu, 'menu');

                foreach ($siteMapMenu->items as $siteMapMenuItem)
                {
                    $container->add($siteMapMenuItem, 'menuItem');

                    if ($siteMapMenuItem->type === 'board@board')
                    {
                        $container->add($siteMapMenuItem, BoardModule::getId());
                        $boardConfig = app('xe.config')->get(sprintf("%s.%s", BoardModule::getId(), $siteMapMenuItem->id));

                        if ($boardConfig && $boardConfig->get('comment')) {
                            $container->add($siteMapMenuItem, 'board@comment');
                        }
                    }
                }
            }
        });
    }

    protected function registerSettingsMenu()
    {
        app()->resolving(SpotlightItemContainer::class, function() {
            $isSuper = true;

            if (auth()->check()) {
                $isSuper = auth()->user()->getRating() === Rating::SUPER;
            }

            app(SettingsHandler::class)
                ->getSettingsMenus($isSuper)
                ->each($this->eachSettingsMenu());
        });
    }

    private function eachSettingsMenu()
    {
        return function (SettingsMenu $menu) {
            $container = SpotlightItemContainer::make();

            if ($menu->link() !== null) {
                $container->add($menu, 'settingsMenu');
            }

            if ($menu->hasChild()) {
                $menu->getChildren()->each($this->eachSettingsMenu());
            }
        };
    }
}
