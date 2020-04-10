<?php
/**
 * MenuServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use App\UIObjects\Menu\MenuSelect;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Menu\EventListener;
use Xpressengine\Menu\MenuHandler;
use Xpressengine\Menu\MenuItemPolicy;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Menu\ModuleHandler;
use Xpressengine\Menu\Repositories\IdentifierGenerator;
use Xpressengine\Menu\Repositories\MenuItemRepository;
use Xpressengine\Menu\Repositories\MenuRepository;
use App\UIObjects\Menu\MenuType;
use Xpressengine\Menu\MenuType\DirectLink;
use App\UIObjects\Menu\TypeSelect;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

/**
 * Class MenuServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MenuServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
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
        MenuItemRepository::setMenuModelProvider(function () {
            return MenuRepository::getModel();
        });
        MenuRepository::setModel(Menu::class);
        MenuItemRepository::setModel(MenuItem::class);

        $this->app['events']->subscribe(EventListener::class);

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
            if($image = $item->getRelationValue('basicImage')) {
                $image = $item->isSelected() ? $item->getSelectedImage() : $image;
                $hoverImage = $item->getHoverImage();
                // preload
                app('xe.frontend')->preload()
                    ->href($hoverImage)
                    ->as('image')
                    ->load();
                return new HtmlString(sprintf(
                    '<img src="%s" class="__xe_menu_image" data-hover="%s" alt="%s"/>',
                    $image,
                    $hoverImage,
                    $title
                ));
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
        $this->app->singleton(MenuHandler::class, function ($app) {
            $generator = new IdentifierGenerator($app['xe.keygen']);

            $proxyHandler = $app['xe.interception']->proxy(MenuHandler::class);

            return new $proxyHandler(
                new MenuRepository($generator),
                new MenuItemRepository($generator, $app['events']),
                $app['xe.config'],
                new ModuleHandler($app['xe.pluginRegister']),
                $app['xe.router']
            );
        });
        $this->app->alias(MenuHandler::class, 'xe.menu');
    }
}
