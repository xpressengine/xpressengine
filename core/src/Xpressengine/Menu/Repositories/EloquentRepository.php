<?php
/**
 * EloquentRepository
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
namespace Xpressengine\Menu\Repositories;

use Illuminate\Database\QueryException;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Menu\MenuRepository;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;

/**
 * Class EloquentRepository
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */
class EloquentRepository implements MenuRepository
{
    /**
     * Model class
     *
     * @var string
     */
    protected $model = Menu::class;

    /**
     * Keygen instance
     *
     * @var Keygen
     */
    protected $keygen;

    /**
     * Limit count of retry for ID duplicated
     *
     * @var int
     */
    const DUPLICATE_RETRY_CNT = 2;

    /**
     * EloquentRepository constructor.
     *
     * @param Keygen $keygen Keygen instance
     */
    public function __construct(Keygen $keygen)
    {
        $this->keygen = $keygen;
    }

    /**
     * Find menu
     *
     * @param string $id   menu identifier
     * @param array  $with relation
     * @return Menu
     */
    public function find($id, $with = [])
    {
        $with = !is_array($with) ? [$with] : $with;

        return $this->createModel()->newQuery()->with($with)->find($id);
    }

    /**
     * Get all menu
     *
     * @param string $siteKey site key
     * @param array  $with    relation
     * @return Menu[]
     */
    public function all($siteKey, $with = [])
    {
        $with = !is_array($with) ? [$with] : $with;

        return $this->createModel()->newQuery()->with($with)->where('siteKey', $siteKey)->get()->getDictionary();
    }

    /**
     * Find a menu item
     *
     * @param string $id   menu item identifier
     * @param array  $with relation
     * @return MenuItem
     */
    public function findItem($id, $with = [])
    {
        $with = !is_array($with) ? [$with] : $with;

        return $this->createItemModel()->newQuery()->with($with)->find($id);
    }

    /**
     * Get menu items by identifier list
     *
     * @param array $ids  menu item identifier
     * @param array $with relation
     * @return MenuItem[]
     */
    public function fetchInItem(array $ids, $with = [])
    {
        $with = !is_array($with) ? [$with] : $with;

        $model = $this->createItemModel();
        
        return $model->newQuery()->with($with)->whereIn($model->getKeyName(), $ids)->get();
    }

    /**
     * Insert menu
     *
     * @param Menu $menu menu instance
     * @return Menu
     */
    public function insert(Menu $menu)
    {
        $cnt = 0;
        while ($cnt++ < static::DUPLICATE_RETRY_CNT) {
            try {
                $menu->{$menu->getKeyName()} = $this->generateNewId();
                $menu->save();

                break;
            } catch (QueryException $e) {
                if ($e->getCode() != "23000") {
                    throw $e;
                }
            }
        }

        return $menu;
    }

    /**
     * Update menu
     *
     * @param Menu $menu menu instance
     * @return Menu
     */
    public function update(Menu $menu)
    {
        if ($menu->isDirty()) {
            $menu->save();
        }

        return $menu;
    }

    /**
     * Delete menu
     *
     * @param Menu $menu menu instance
     * @return bool
     */
    public function delete(Menu $menu)
    {
        return $menu->delete();
    }

    /**
     * Insert menu item
     *
     * @param MenuItem $item menu item instance
     * @return MenuItem
     */
    public function insertItem(MenuItem $item)
    {
        $cnt = 0;
        while ($cnt++ < static::DUPLICATE_RETRY_CNT) {
            try {
                $item->{$item->getKeyName()} = $this->generateNewId();
                $item->save();

                $item->menu->increment($item->menu->getCountName());

                break;
            } catch (QueryException $e) {
                if ($e->getCode() != "23000") {
                    throw $e;
                }
            }
        }

        return $item;
    }

    /**
     * Update menu item
     *
     * @param MenuItem $item menu item instance
     * @return MenuItem
     */
    public function updateItem(MenuItem $item)
    {
        if ($item->isDirty()) {
            $item->save();
        }

        return $item;
    }

    /**
     * Delete menu item
     *
     * @param MenuItem $item menu item instance
     * @return bool
     */
    public function deleteItem(MenuItem $item)
    {
        $item->menu->decrement($item->menu->getCountName());

        return $item->delete();
    }

    /**
     * Create new menu model
     *
     * @return Menu
     */
    public function createModel()
    {
        $class = $this->getModel();

        return new $class;
    }

    /**
     * Get menu model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set menu model
     *
     * @param string $model model class
     * @return void
     */
    public function setModel($model)
    {
        $this->model = '\\' . ltrim($model, '\\');
    }

    /**
     * Create new menu item model
     *
     * @param Menu $menu menu instance
     * @return MenuItem
     */
    public function createItemModel(Menu $menu = null)
    {
        $menu = $menu ?: $this->createModel();
        $class = $menu->getItemModel();

        return new $class;
    }

    /**
     * Generate new key
     *
     * @return string
     */
    protected function generateNewId()
    {
        $newId = substr($this->keygen->generate(), 0, 8);

        if (!preg_match('/[^0-9]/', $newId)) {
            $newId = $this->generateNewId();
        }

        return $newId;
    }
}
