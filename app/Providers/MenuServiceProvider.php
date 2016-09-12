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

use App\UIObjects\Menu\MenuSelect;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Menu\MenuHandler;
use Xpressengine\Menu\MenuItemPolicy;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Menu\ModuleHandler;
use Xpressengine\Menu\Repositories\CacheDecorator;
use Xpressengine\Menu\Repositories\EloquentRepository;
use Xpressengine\Menu\Repositories\MemoryDecorator;
use Xpressengine\Support\LaravelCache;
use App\UIObjects\Menu\MenuType;
use Xpressengine\Menu\MenuType\DirectLink;
use App\UIObjects\Menu\TypeSelect;
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

        $pluginRegister->add(MenuType::class);
        $pluginRegister->add(MenuSelect::class);
        $pluginRegister->add(TypeSelect::class);
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
        $this->app->singleton(['xe.module' => ModuleHandler::class], function ($app) {
            $register = $app['xe.pluginRegister'];
            $proxyClass = $app['xe.interception']->proxy(ModuleHandler::class, 'XeModule');
            return new $proxyClass($register);
        });
        
        $this->app->singleton(['xe.menu' => MenuHandler::class], function ($app) {
            $repo = new EloquentRepository($app['xe.keygen']);

            if ($app['config']['app.debug'] !== true) {
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
