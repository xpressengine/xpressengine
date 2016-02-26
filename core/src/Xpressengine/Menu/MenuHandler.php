<?php
/**
 * MenuHandler
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Menu;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\QueryException;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Menu\Exceptions\CanNotDeleteMenuEntityHaveChildException;
use Xpressengine\Menu\Exceptions\CanNotDeleteMenuItemHaveChildException;
use Xpressengine\Menu\Exceptions\InvalidArgumentException;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\PermissionHandler;

/**
 * # MenuHandler
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
class MenuHandler
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
     * ConfigManager instance
     *
     * @var ConfigManager
     */
    protected $configs;

    /**
     * PermissionHandler instance
     *
     * @var PermissionHandler
     */
    protected $permissions;

    /**
     * Menu keyword for config
     *
     * @var string
     */
    protected $menuKeyword = 'menu';

    /**
     * Limit count of retry for ID duplicated
     *
     * @var int
     */
    const DUPLICATE_RETRY_CNT = 2;

    /**
     * Access action keyword for permission
     *
     * @var string
     */
    const ACCESS = 'access';

    /**
     * Visible action keyword for permission
     *
     * @var string
     */
    const VISIBLE = 'visible';

    /**
     * MenuHandler constructor.
     *
     * @param Keygen            $keygen      Keygen instance
     * @param ConfigManager     $configs     ConfigManager instance
     * @param PermissionHandler $permissions PermissionHandler instance
     */
    public function __construct(Keygen $keygen, ConfigManager $configs, PermissionHandler $permissions)
    {
        $this->keygen = $keygen;
        $this->configs = $configs;
        $this->permissions = $permissions;
    }

    /**
     * Create new menu
     *
     * @param array $inputs attributes
     * @return Menu
     */
    public function create(array $inputs)
    {
        $class = $this->getModel();
        /** @var Menu $menu */
        $menu = new $class;
        $menu->fill($inputs);

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
     * Upate menu
     *
     * @param Menu $menu menu instance
     * @return Menu
     */
    public function put(Menu $menu)
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
     * @return bool|null
     * @throws CanNotDeleteMenuEntityHaveChildException
     */
    public function remove(Menu $menu)
    {
        if ($menu->items->count() > 0) {
            throw new CanNotDeleteMenuEntityHaveChildException;
        }

        $this->deleteMenuTheme($menu);
        $this->deleteMenuPermission($menu);

        return $menu->delete();
    }

    /**
     * Create new menu item
     *
     * @param Menu  $menu   menu instance
     * @param array $inputs item's attributes
     * @return MenuItem
     */
    public function createItem(Menu $menu, array $inputs)
    {
        $class = $menu->getItemModel();
        /** @var MenuItem $item */
        $item = new $class;
        $item->fill($inputs);
        $item->menuId = $menu->getKey();

        $cnt = 0;
        while ($cnt++ < static::DUPLICATE_RETRY_CNT) {
            try {
                $item->{$item->getKeyName()} = $this->generateNewId();
                $item->save();

                break;
            } catch (QueryException $e) {
                if ($e->getCode() != "23000") {
                    throw $e;
                }
            }
        }

        $item->ancestors()->attach($item->getKey(), [$item->getDepthName() => 0]);
        if ($item->{$item->getParentIdName()}) {
            /** @var MenuItem $parent */
            $parent = $class::find($item->{$item->getParentIdName()});
            $ascIds = array_reverse($parent->getBreadcrumbs());

            foreach ($ascIds as $idx => $ascId) {
                $item->ancestors()->attach($ascId, [$item->getDepthName() => $idx + 1]);
            }
        }

        $this->setOrder($item, $inputs['ordering']);
        $this->registerItemPermission($item, new Grant);

        return $item;
    }

    /**
     * Update menu item
     *
     * @param MenuItem $item item instance
     * @return MenuItem
     */
    public function putItem(MenuItem $item)
    {
        if ($item->isDirty()) {
            $item->save();
        }

        return $item;
    }

    /**
     * Delete menu item
     *
     * @param MenuItem $item item instance
     * @return bool|null
     * @throws \Exception
     */
    public function removeItem(MenuItem $item)
    {
        if ($item->getDescendantCount() > 0) {
            throw new CanNotDeleteMenuItemHaveChildException;
        }

        $this->deleteItemPermission($item);
        $item->ancestors()->detach($item);

        return $item->delete();
    }

    /**
     * Set item order
     *
     * @param MenuItem $item     item instance
     * @param int      $position order position
     * @return void
     */
    public function setOrder(MenuItem $item, $position)
    {
        /** @var MenuItem $parent */
        if (!$parent = $item->getParent()) {
            $children = $item->menu->getProgenitors();
        } else {
            $children = $parent->getChildren();
        }

        /** @var Collection $children */
        $children = $children->filter(function (MenuItem $model) use ($item) {
            return $model->getKey() != $item->getKey();
        });

        $children = $children->slice(0, $position)
            ->merge([$item])
            ->merge($children->slice($position));

        $children->each(function (MenuItem $model, $idx) {
            $model->{$model->getOrderKeyName()} = $idx;
            $model->save();
        });
    }

    /**
     * Move menu item
     *
     * @param Menu          $menu   menu instance
     * @param MenuItem      $item   menu item instance
     * @param MenuItem|null $parent menu item instance
     * @return MenuItem
     * @throws InvalidArgumentException
     */
    public function moveItem(Menu $menu, MenuItem $item, MenuItem $parent = null)
    {
        if ($parent && $menu->getKey() != $parent->menu->getKey()) {
            // todo: exception 수정
            throw new InvalidArgumentException;
        }

        if ($item->{$item->getParentIdName()}) {
            $class = $menu->getItemModel();
            $oldParent = $class::find($item->{$item->getParentIdName()});
            $this->unlinkHierarchy($item, $oldParent);
            $item->{$item->getParentIdName()} = null;
        }

        if ($parent) {
            $this->linkHierarchy($item, $parent);
        }

        $item->menuId = $menu->getKey();
        $item->save();

        // flush relationship
        foreach (array_keys($item->getRelations()) as $relation) {
            unset($item->{$relation});
        }

        $item->setRelation('menu', $menu);

        return $item;
    }

    /**
     * Unlink menu item hierarchy
     *
     * @param MenuItem $item   menu item instance
     * @param MenuItem $parent menu item instance
     * @return int
     */
    protected function unlinkHierarchy(MenuItem $item, MenuItem $parent)
    {
        $conn = $item->getConnection();
        $table = $item->getHierarchyTable();
        $ancestor = $item->getAncestorName();
        $descendant = $item->getDescendantName();

        $rows = $conn->table($table . ' as a')
            ->join($table . ' as rel', "a.{$ancestor}", '=', "rel.{$ancestor}")
            ->join($table . ' as d', "d.{$descendant}", '=', "rel.{$descendant}")
            ->where("a.{$descendant}", $parent->getKey())
            ->where("d.{$ancestor}", $item->getKey())
            ->get(['rel.' . $item->getKeyName()]);

        $ids = array_column($rows, $item->getKeyName());

        return $conn->table($table)->whereIn($item->getKeyName(), $ids)->delete();
    }

    /**
     * Link menu item hierarchy
     *
     * @param MenuItem $item   menu item instance
     * @param MenuItem $parent menu item instance
     * @return bool
     */
    protected function linkHierarchy(MenuItem $item, MenuItem $parent)
    {
        $conn = $item->getConnection();
        $prefix = $conn->getTablePrefix();
        $table = $item->getHierarchyTable();
        $ancestor = $item->getAncestorName();
        $descendant = $item->getDescendantName();
        $depth = $item->getDepthName();

        $select = $conn->table($table . ' as a')
            ->joinWhere($table . ' as d', "d.{$ancestor}", '=', $item->getKey())
            ->where("a.{$descendant}", '=', $parent->getKey())
            ->select([
                "a.{$ancestor}",
                "d.{$descendant}",
                new Expression("`{$prefix}a`.`{$depth}` + `{$prefix}d`.`{$depth}` + 1")
            ]);

        $bindings = $select->getBindings();

        $insertQuery = sprintf("insert into %s (`{$ancestor}`, `{$descendant}`, `{$depth}`) ", $prefix . $table)
            . $select->toSql();

        return $conn->insert($insertQuery, $bindings);
    }

    /**
     * Set menu config consisting of theme identifiers
     *
     * @param Menu   $menu         menu instance
     * @param string $desktopTheme theme id
     * @param string $mobileTheme  theme id
     * @return void
     */
    public function setMenuTheme(Menu $menu, $desktopTheme, $mobileTheme)
    {
        $this->configs->add(
            $this->menuKeyString($menu->getKey()),
            [
                'desktopTheme' => $desktopTheme,
                'mobileTheme' => $mobileTheme
            ]
        );
    }

    /**
     * Get menu config consisting of theme identifiers
     *
     * @param Menu $menu menu instance
     * @return \Xpressengine\Config\ConfigEntity
     */
    public function getMenuTheme(Menu $menu)
    {
        return $this->configs->get($this->menuKeyString($menu->getKey()));
    }

    /**
     * Update menu config consisting of theme identifiers
     *
     * @param Menu   $menu         menu instance
     * @param string $desktopTheme theme id
     * @param string $mobileTheme  theme id
     * @return void
     */
    public function updateMenuTheme(Menu $menu, $desktopTheme, $mobileTheme)
    {
        $keyString = $this->menuKeyString($menu->getKey());
        $config = $this->configs->get($keyString);

        $config->set('desktopTheme', $desktopTheme);
        $config->set('mobileTheme', $mobileTheme);

        $this->configs->modify($config);
    }

    /**
     * Delete menu config consisting of theme identifiers
     *
     * @param Menu $menu menu instance
     * @return void
     */
    public function deleteMenuTheme(Menu $menu)
    {
        $this->configs->removeByName($this->menuKeyString($menu->getKey()));
    }

    /**
     * Set menu config consisting of theme identifiers
     *
     * @param MenuItem $item         menu item instance
     * @param string   $desktopTheme theme id
     * @param string   $mobileTheme  theme id
     * @return void
     */
    public function setMenuItemTheme(MenuItem $item, $desktopTheme, $mobileTheme)
    {
        $this->configs->add(
            $this->menuKeyString($item),
            [
                'desktopTheme' => $desktopTheme,
                'mobileTheme' => $mobileTheme
            ]
        );
    }

    /**
     * Get menu item config consisting of theme identifiers
     *
     * @param MenuItem $item menu item instance
     * @return \Xpressengine\Config\ConfigEntity
     */
    public function getMenuItemTheme(MenuItem $item)
    {
        $configKeyString = $this->menuKeyString($item);
        
        return $this->configs->get($configKeyString);
    }

    /**
     * Update menu item config consisting of theme identifiers
     *
     * @param MenuItem $item         menu item instance
     * @param string   $desktopTheme theme id
     * @param string   $mobileTheme  theme id
     * @return void
     */
    public function updateMenuItemTheme(MenuItem $item, $desktopTheme, $mobileTheme)
    {
        $configKeyString = $this->menuKeyString($item);
        $config = $this->configs->get($configKeyString);

        $config->set('desktopTheme', $desktopTheme);
        $config->set('mobileTheme', $mobileTheme);

        $this->configs->modify($config);
    }

    /**
     * Delete menu item config consisting of theme identifiers
     *
     * @param MenuItem $item menu item instance
     * @return void
     */
    public function deleteMenuItemTheme(MenuItem $item)
    {
        $this->configs->removeByName($this->menuKeyString($item));
    }

    /**
     * Move menu item config consisting of theme identifiers
     *
     * @param MenuItem $beforeItem before item
     * @param MenuItem $movedItem  after item
     * @return void
     */
    public function moveItemConfig(MenuItem $beforeItem, MenuItem $movedItem)
    {
        $configEntity = $this->configs->get($this->menuKeyString($beforeItem));
        $to = $this->menuKeyString($movedItem);
        $this->configs->move($configEntity, substr($to, 0, strrpos($to, '.')));
    }

    /**
     * Make key string for config
     *
     * @param MenuItem|string $value to generate for config key string
     *
     * @return string
     */
    protected function menuKeyString($value)
    {
        if ($value instanceof MenuItem) {
            $string = $value->menu->getKey() . '.' . implode('.', $value->getBreadcrumbs());
        } else {
            $string = $value;
        }

        return $this->menuKeyword . '.' . $string;
    }

    /**
     * Set default permission to menu
     *
     * @param Menu $menu menu instance
     * @return void
     */
    public function registerDefaultPermission(Menu $menu)
    {
        $grant = new Grant();

        $grant->add(static::ACCESS, 'rating', 'guest');
        $grant->add(static::ACCESS, 'group', []);
        $grant->add(static::ACCESS, 'user', []);
        $grant->add(static::ACCESS, 'except', []);

        $grant->add(static::VISIBLE, 'rating', 'guest');
        $grant->add(static::VISIBLE, 'group', []);
        $grant->add(static::VISIBLE, 'user', []);
        $grant->add(static::VISIBLE, 'except', []);

        $this->registerMenuPermission($menu, $grant);
    }

    /**
     * Register menu permission
     *
     * @param Menu  $menu  menu instance
     * @param Grant $grant permission grant instance
     * @return void
     */
    public function registerMenuPermission(Menu $menu, Grant $grant)
    {
        $this->permissions->register($menu->getKey(), $grant, $menu->siteKey);
    }

    /**
     * Get menu permission
     *
     * @param Menu $menu menu instance
     * @return \Xpressengine\Permission\Permission
     */
    public function getPermission(Menu $menu)
    {
        return $this->permissions->find($menu->getKey(), $menu->siteKey);
    }

    /**
     * Delete menu permission
     *
     * @param Menu $menu menu instance
     * @return void
     */
    public function deleteMenuPermission(Menu $menu)
    {
        $this->permissions->destroy($menu->getKey(), $menu->siteKey);
    }

    /**
     * Register menu item permission
     *
     * @param MenuItem $item  menu item instance
     * @param Grant    $grant permission grant instance
     * @return \Xpressengine\Permission\Permission
     */
    public function registerItemPermission(MenuItem $item, Grant $grant)
    {
        return $this->permissions->register($this->permKeyString($item), $grant, $item->menu->siteKey);
    }

    /**
     * Get menu item permission
     *
     * @param MenuItem $item menu item instance
     * @return \Xpressengine\Permission\Permission
     */
    public function getItemPermission(MenuItem $item)
    {
        return $this->permissions->find($this->permKeyString($item), $item->menu->siteKey);
    }

    /**
     * Delete menu item permission
     *
     * @param MenuItem $item menu item instance
     * @return void
     */
    public function deleteItemPermission(MenuItem $item)
    {
        $this->permissions->destroy($this->permKeyString($item), $item->menu->siteKey);
    }

    /**
     * Move menu item permission
     *
     * @param MenuItem $fromItem  before item
     * @param MenuItem $movedItem after item
     * @return void
     */
    public function moveItemPermission(MenuItem $fromItem, MenuItem $movedItem)
    {
        $permission = $this->permissions->find($this->permKeyString($fromItem), $fromItem->menu->siteKey);
        $to = $this->permKeyString($movedItem);
        $this->permissions->move($permission, substr($to, 0, strrpos($to, '.')));
    }

    /**
     * Make key string for permission
     *
     * @param MenuItem $item menu item instance
     * @return string
     */
    protected function permKeyString(MenuItem $item)
    {
        return $item->menu->getKey() . '.' . implode('.', $item->getBreadcrumbs());
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
     * Generate new key
     *
     * @return string
     */
    protected function generateNewId()
    {
        $newId = substr($this->keygen->generate(), 0, 8);

        return $newId;
    }
}
