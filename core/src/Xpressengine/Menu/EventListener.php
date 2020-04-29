<?php
/**
 * Listener.php
 *
 * PHP version 7
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Menu;

use Illuminate\Contracts\Container\Container;
use Illuminate\Events\Dispatcher;
use Xpressengine\Menu\Models\MenuItem;

/**
 * Class Listener
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class EventListener
{
    /**
     * Container instance
     *
     * @var Container
     */
    protected $container;

    /**
     * EventListener constructor.
     *
     * @param Container $container Container instance
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register event listener
     *
     * @param Dispatcher $dispatcher dispatcher instance
     * @return void
     */
    public function subscribe(Dispatcher $dispatcher)
    {
        $dispatcher->listen('xe.menu.menuitem.created', function ($item) {
            $this->menuItemCreated($item);
        });
        $dispatcher->listen('xe.menu.menuitem.deleted', function ($item) {
            $this->menuItemDeleted($item);
        });
    }

    /**
     * Listen to item created
     *
     * @param MenuItem $item menu item
     * @return void
     */
    protected function menuItemCreated(MenuItem $item)
    {
        $handler = $this->container->make('xe.menu');
        $menu = $handler->menus()->find($item->menu_id);
        $handler->menus()->increment($menu, $menu->getCountName());
    }

    /**
     * Listen to item deleted
     *
     * @param MenuItem $item menu item
     * @return void
     */
    protected function menuItemDeleted(MenuItem $item)
    {
        $handler = $this->container->make('xe.menu');
        $menu = $handler->menus()->find($item->menu_id);
        $handler->menus()->decrement($menu, $menu->getCountName());
    }
}
