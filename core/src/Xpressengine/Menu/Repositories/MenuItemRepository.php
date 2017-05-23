<?php
/**
 * MenuItemRepository.php
 *
 * PHP version 5
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Menu\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Events\Dispatcher;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Support\CacheableEloquentRepositoryTrait;

/**
 * Class MenuItemRepository
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class MenuItemRepository
{
    use CacheableEloquentRepositoryTrait {
        delete as traitDelete;
    }

    /**
     * Namespace for cache
     *
     * @var string
     */
    protected $namespace = 'xemenu';

    /**
     * IdentifierGenerator instance
     *
     * @var IdentifierGenerator
     */
    protected $generator;

    /**
     * Event dispatcher instance
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Menu model class provider
     *
     * @var callable
     */
    protected static $provider;

    /**
     * Limit count of retry for ID duplicated
     *
     * @var int
     */
    const DUPLICATE_RETRY_CNT = 3;

    /**
     * MenuItemRepository constructor.
     *
     * @param IdentifierGenerator $generator  IdentifierGenerator instance
     * @param Dispatcher          $dispatcher Event dispatcher instance
     */
    public function __construct(IdentifierGenerator $generator, Dispatcher $dispatcher)
    {
        $this->generator = $generator;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Create menu item
     *
     * @param array $attributes attributes
     * @return MenuItem
     */
    public function create(array $attributes = [])
    {
        $model = $this->createModel();
        $model->fill($attributes);

        $cnt = 0;
        while (true) {
            try {
                $model->{$model->getKeyName()} = $this->generator->generateId();
                $model->save();

                $model->ancestors()->attach($model->getKey(), [$model->getDepthName() => 0]);

                $this->clearCache();

                $this->dispatcher->fire('xe.menu.menuitem.created', $model);

                break;
            } catch (QueryException $e) {
                if (++$cnt >= static::DUPLICATE_RETRY_CNT || $e->getCode() != "23000") {
                    throw $e;
                }
            }
        }

        return $model;
    }

    /**
     * Delete a menu item
     *
     * @param MenuItem $item menu item
     * @return bool|null
     */
    public function delete(MenuItem $item)
    {
        $item->ancestors(false)->detach();

        $result = $this->traitDelete($item);
        $this->dispatcher->fire('xe.menu.menuitem.deleted', $item);

        return $result;
    }

    /**
     * Get menu item list by primary keys
     *
     * @param array        $ids  identifier list
     * @param string|array $with relation name
     * @return mixed
     */
    public function fetchIn(array $ids, $with = [])
    {
        return $this->cacheCall(__FUNCTION__, func_get_args(), function () use ($ids, $with) {
            return $this->query()->with($with)->whereIn('id', $ids)->get();
        });
    }

    /**
     * The name of Menu model class
     *
     * @return string
     */
    public static function getModel()
    {
        $menuModel = static::provideMenuModel();

        return $menuModel::getItemModel();
    }

    /**
     * Set the name of Menu model
     *
     * @param string $model model class
     * @return void
     */
    public static function setModel($model)
    {
        $menuModel = static::provideMenuModel();
        $menuModel::setItemModel($model);

        static::setAggregator($menuModel);
    }

    /**
     * Set aggregator to model
     *
     * @param string $aggregator aggregator class
     * @return void
     */
    protected static function setAggregator($aggregator)
    {
        $model = static::getModel();
        $model::setAggregatorModel($aggregator);
    }

    /**
     * Set menu model class provider
     *
     * @param callable $provider callable
     * @return void
     */
    public static function setMenuModelProvider(callable $provider)
    {
        static::$provider = $provider;
    }

    /**
     * Provide menu model class
     *
     * @return string
     */
    public static function provideMenuModel()
    {
        return call_user_func(static::$provider);
    }
}
