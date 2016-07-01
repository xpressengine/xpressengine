<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Menu\MenuHandler;
use Xpressengine\Menu\MenuItemPolicy;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Menu\Repositories\CacheDecorator;
use Xpressengine\Menu\Repositories\EloquentRepository;
use Xpressengine\Menu\Repositories\MemoryDecorator;
use Xpressengine\Support\LaravelCache;
use Xpressengine\UIObjects\Menu\MenuList;
use Xpressengine\UIObjects\Menu\MenuType;
use Xpressengine\UIObjects\Menu\MenuThemeList;
use Xpressengine\UIObjects\Menu\MenuSelector;
use Xpressengine\Menu\MenuType\DirectLink;
use Xpressengine\UIObjects\Menu\TypeSelect;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

/**
 * Menu Service Provider
 *
 * @category Menu
 * @package  Xpressengine\Menu
 */
class MenuServiceProvider extends ServiceProvider
{
    protected $policies = [
        MenuItem::class => MenuItemPolicy::class
    ];

    /**
     * Service Provider Boot
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $pluginRegister = $this->app['xe.pluginRegister'];

//        $pluginRegister->add(MenuList::class);
        $pluginRegister->add(MenuType::class);
        $pluginRegister->add(TypeSelect::class);
//        $pluginRegister->add(MenuSelector::class);
//        $pluginRegister->add(MenuThemeList::class);
        $pluginRegister->add(DirectLink::class);

        foreach ($this->policies as $class => $policy) {
            $gate->policy($class, $policy);
        }

        // 메뉴아이템의 링크를 편하게 제공하기 위한 resolver 등록
        MenuItem::setLinkResolver(function(MenuItem $item){
            $title = xe_trans($item->getAttributeValue('title'));
            if($item->getRelationValue('basicImage')) {
                if($item->isSelected()) {
                    $image = $item->getSelectedImage();
                } else {
                    $image = $item->basicImage;
                }
                $hoverImage = $item->getHoverImage();
                return sprintf('<img src="%s" class="__xe_menu_image" data-hover="%s" alt="%s"/>', $image, $hoverImage, $title);
            }
            return $title;
        });

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton([MenuHandler::class => 'xe.menu'], function ($app) {
            $repo = new EloquentRepository($app['xe.keygen']);

            if (env('APP_DEBUG') != true) {
                $repo = new CacheDecorator($repo, new LaravelCache($app['cache.store']));
            }

            return new MenuHandler(
                new MemoryDecorator($repo),
                $app['xe.config'],
                $app['xe.module'],
                $app['xe.router']
            );
        });
    }
}
