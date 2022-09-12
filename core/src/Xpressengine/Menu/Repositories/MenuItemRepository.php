<?php
/**
 * MenuItemRepository.php
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

namespace Xpressengine\Menu\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Arr;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Support\CacheableEloquentRepositoryTrait;

/**
 * Class MenuItemRepository
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
    public const DUPLICATE_RETRY_CNT = 3;

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

                $this->dispatcher->dispatch('xe.menu.menuitem.created', $model);

                break;
            } catch (QueryException $e) {
                ++$cnt;

                if ($cnt >= static::DUPLICATE_RETRY_CNT || $e->getCode() !== '23000') {
                    throw $e;
                }
            }
        }

        return $model;
    }

    /**
     * Delete a menu item
     *
     * @param  MenuItem  $item  menu item
     * @return bool|null
     * @throws \Exception
     */
    public function delete(MenuItem $item)
    {
        $item->ancestors(false)->detach();

        $result = $this->traitDelete($item);
        $this->dispatcher->dispatch('xe.menu.menuitem.deleted', $item);

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
     * @param string $url
     * @param array $with
     * @return mixed
     */
    public function fetchByUrl(string $url, array $with = [])
    {
        return $this->cacheCall(__FUNCTION__, func_get_args(), function () use ($url, $with) {
            $parsedUrl = parse_url($url);
            $urlPath = str_replace_first('/', '', Arr::get($parsedUrl, 'path', ''));

            parse_str(Arr::get($parsedUrl, 'query', ''), $urlQueries);

            $menuItems = $this->fetchByUrlPath($urlPath, $with)
                ->transform(static function (MenuItem $menuItem) {
                    $parsedMenuItemUrl = parse_url($menuItem->url);
                    $menuItemUrlPath = Arr::get($parsedMenuItemUrl, 'path', '');

                    if ($menuItemUrlPath !== '' && $menuItemUrlPath[0]  === '/') {
                        $menuItemUrlPath = str_replace_first('/', '', $menuItemUrlPath);
                    }

                    parse_str(Arr::get($parsedMenuItemUrl, 'query', ''), $menuItemUrlQueries);

                    $menuItem->setAttribute('url_path', $menuItemUrlPath);
                    $menuItem->setAttribute('url_queries', $menuItemUrlQueries);

                    return $menuItem;
                })
                ->filter(static function (MenuItem $menuItem) use ($urlPath, $urlQueries) {
                    $arrayDiff = array_diff_assoc($menuItem->url_queries, $urlQueries);
                    return $urlPath === $menuItem->url_path && empty($arrayDiff) === true;
                });

            $containedUrlMenuItems = $menuItems->filter(
                static function (MenuItem $menuItem) use ($urlPath, $urlQueries) {
                    $arrayDiff = array_diff_assoc($urlQueries, $menuItem->url_queries);
                    return $urlPath === $menuItem->url_path && empty($arrayDiff) === true;
                }
            );

            return $containedUrlMenuItems->isNotEmpty() === true ? $containedUrlMenuItems : $menuItems;
        });
    }

    /**
     * @param string $urlPath
     * @param array $with
     * @return mixed
     */
    protected function fetchByUrlPath(string $urlPath, array $with = [])
    {
        return $this->cacheCall(__FUNCTION__, func_get_args(), function () use ($urlPath, $with) {
            return $this->query()->with($with)->where('url', 'like', $urlPath . '%')->get();
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
    protected static function setAggregator(string $aggregator)
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
