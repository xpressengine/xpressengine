<?php
/**
 * EventListener.php
 *
 * PHP version 7
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Category;

use Illuminate\Contracts\Container\Container;
use Illuminate\Events\Dispatcher;
use Xpressengine\Category\Models\CategoryItem;

/**
 * Class EventListener
 *
 * @category    Category
 * @package     Xpressengine\Category
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
        $dispatcher->listen('xe.category.categoryitem.created', function ($item) {
            $this->categoryItemCreated($item);
        });
        $dispatcher->listen('xe.category.categoryitem.deleted', function ($item) {
            $this->categoryItemDeleted($item);
        });
    }

    /**
     * Listen to item created
     *
     * @param CategoryItem $item category item
     * @return void
     */
    protected function categoryItemCreated(CategoryItem $item)
    {
        $handler = $this->container->make('xe.category');
        $category = $handler->cates()->find($item->category_id);
        $handler->cates()->increment($category, $category->getCountName());
    }

    /**
     * Listen to item deleted
     *
     * @param CategoryItem $item category item
     * @return void
     */
    protected function categoryItemDeleted(CategoryItem $item)
    {
        $handler = $this->container->make('xe.category');
        $category = $handler->cates()->find($item->category_id);
        $handler->cates()->decrement($category, $category->getCountName());
    }
}
