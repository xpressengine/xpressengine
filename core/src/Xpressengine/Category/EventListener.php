<?php
/**
 * EventListener.php
 *
 * PHP version 5
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
        $category = $handler->cates()->find($item->categoryId);
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
        $category = $handler->cates()->find($item->categoryId);
        $handler->cates()->decrement($category, $category->getCountName());
    }
}
