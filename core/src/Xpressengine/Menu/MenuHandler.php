<?php
/**
 * MenuHandler
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

namespace Xpressengine\Menu;

use Xpressengine\Config\ConfigManager;
use Xpressengine\Menu\Exceptions\CanNotDeleteMenuEntityHaveChildException;
use Xpressengine\Menu\Exceptions\CanNotDeleteMenuItemHaveChildException;
use Xpressengine\Menu\Exceptions\InvalidArgumentException;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Menu\Repositories\MenuItemRepository;
use Xpressengine\Menu\Repositories\MenuRepository;
use Xpressengine\Permission\Grant;
use Xpressengine\Routing\RouteRepository;
use Xpressengine\Support\Tree\NodePositionTrait;

/**
 * Class MenuHandler
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class MenuHandler
{
    use NodePositionTrait;

    /**
     * MenuRepository instance
     *
     * @var MenuRepository
     */
    protected $menus;

    /**
     * MenuItemRepository instance
     *
     * @var MenuItemRepository
     */
    protected $items;

    /**
     * ConfigManager instance
     *
     * @var ConfigManager
     */
    protected $configs;
    
    /**
     * ModuleHandler instance
     *
     * @var ModuleHandler
     */
    protected $modules;

    /**
     * RouteRepository instance
     *
     * @var RouteRepository
     */
    protected $routes;

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
     * @param MenuRepository     $menus   MenuRepository instance
     * @param MenuItemRepository $items   MenuItemRepository instance
     * @param ConfigManager      $configs ConfigManager instance
     * @param ModuleHandler      $modules ModuleHandler instance
     * @param RouteRepository    $routes  RouteRepository instance
     */
    public function __construct(
        MenuRepository $menus,
        MenuItemRepository $items,
        ConfigManager $configs,
        ModuleHandler $modules,
        RouteRepository $routes
    ) {
        $this->menus = $menus;
        $this->items = $items;
        $this->configs = $configs;
        $this->modules = $modules;
        $this->routes = $routes;
    }

    /**
     * Get menu
     *
     * @param string $id   menu identifier
     * @param array  $with relation
     * @return Menu
     *
     * @deprecated since beta.17. Use MenuRepository::findWith instead.
     */
    public function get($id, $with = [])
    {
        return $this->menus->findWith($id, $with);
    }

    /**
     * Get all menu
     *
     * @param string $siteKey site key
     * @param array  $with    relation
     * @return Menu[]
     *
     * @deprecated since beta.17. Use MenuRepository::fetchBySiteKey instead.
     */
    public function getAll($siteKey, $with = [])
    {
        return $this->menus->fetchBySiteKey($siteKey, $with);
    }

    /**
     * Create new menu
     *
     * @param array $attributes attributes
     * @return Menu
     *
     * @deprecated since beta.17. Use createMenu instead.
     */
    public function create(array $attributes)
    {
        return $this->createMenu($attributes);
    }

    /**
     * Create new menu
     *
     * @param array $attributes attributes
     * @return Menu
     */
    public function createMenu(array $attributes)
    {
        return $this->menus->create($attributes);
    }

    /**
     * Update category
     *
     * @param Menu  $menu       menu instance
     * @param array $attributes attributes
     * @return Menu
     *
     * @deprecated since beta.17. Use updateMenu instead.
     */
    public function put(Menu $menu, array $attributes = [])
    {
        return $this->updateMenu($menu, $attributes);
    }

    /**
     * Update category
     *
     * @param Menu  $menu       menu instance
     * @param array $attributes attributes
     * @return Menu
     */
    public function updateMenu(Menu $menu, array $attributes = [])
    {
        return $this->menus->update($menu, $attributes);
    }

    /**
     * Delete menu
     *
     * @param Menu $menu menu instance
     * @return bool
     * @throws CanNotDeleteMenuEntityHaveChildException
     *
     * @deprecated since beta.17. Use deleteMenu instead.
     */
    public function remove(Menu $menu)
    {
        return $this->deleteMenu($menu);
    }

    /**
     * Delete menu
     *
     * @param Menu $menu menu instance
     * @return bool
     * @throws CanNotDeleteMenuEntityHaveChildException
     */
    public function deleteMenu(Menu $menu)
    {
        if ($menu->items->count() > 0) {
            throw new CanNotDeleteMenuEntityHaveChildException;
        }

        $this->deleteMenuTheme($menu);

        return $this->menus->delete($menu);
    }

    /**
     * Get menu item
     *
     * @param string $id   menu item identifier
     * @param array  $with relation
     * @return MenuItem
     *
     * @deprecated since beta.17. Use MenuItemRepository::find instead.
     */
    public function getItem($id, $with = [])
    {
        return $this->items->find($id);
    }

    /**
     * Get menu item list by identifiers
     *
     * @param array $ids  menu item identifier list
     * @param array $with relation
     * @return MenuItem[]
     *
     * @deprecated since beta.17. Use MenuItemRepository::fetchIn instead.
     */
    public function getItemIn($ids, $with = [])
    {
        return $this->items->fetchIn((array)$ids, $with);
    }

    /**
     * Create new menu item
     *
     * @param Menu  $menu          menu instance
     * @param array $attributes    item's attributes
     * @param array $menuTypeInput input for menu type module
     * @return MenuItem
     */
    public function createItem(Menu $menu, array $attributes, array $menuTypeInput = [])
    {
        $model = $this->items->createModel();
        /** @var MenuItem $item */
        $item = $this->items->create(array_merge($attributes, [$model->getAggregatorKeyName() => $menu->getKey()]));

        $this->setHierarchy($item);
        $this->setOrder($item);

        $this->storeMenuType($item, $menuTypeInput);

        return $item;
    }

    /**
     * Set hierarchy information for new item
     *
     * @param MenuItem $item item object
     * @return void
     */
    protected function setHierarchy(MenuItem $item)
    {
        if ($item->{$item->getParentIdName()}) {
            $parent = $this->items->find($item->{$item->getParentIdName()});

            $this->linkHierarchy($item, $parent);
        }
    }

    /**
     * Store menu type associated with the menu item.
     *
     * @param MenuItem $item          menu item instance
     * @param array    $menuTypeInput input for menu type module
     * @return void
     */
    protected function storeMenuType(MenuItem $item, array $menuTypeInput)
    {
        $menuTypeObj = $this->modules->getModuleObject($item->type);
        $menuTypeObj->storeMenu($item->getKey(), $menuTypeInput, $item->getAttributes());

        // 메뉴 타입이 route 를 사용하는 경우 instance route 를 추가해 줌
        if ($menuTypeObj::isRouteAble()) {
            $this->routes->create([
                'url' => $item->url,
                'module' => $menuTypeObj::getId(),
                'instanceId' => $item->getKey(),
                'menuId' => $item->{$item->getAggregatorKeyName()},
                'siteKey' => $item->menu->siteKey
            ]);
        }
    }

    /**
     * Update menu item
     *
     * @param MenuItem $item          item instance
     * @param array    $menuTypeInput input for menu type module
     * @return MenuItem
     *
     * @deprecated since beta.17. Use updateItem instead.
     */
    public function putItem(MenuItem $item, array $menuTypeInput = [])
    {
        return $this->updateItem($item, [], $menuTypeInput);
    }

    /**
     * Update menu item
     *
     * @param MenuItem $item          item instance
     * @param array    $attributes    attributes
     * @param array    $menuTypeInput input for menu type module
     * @return MenuItem
     */
    public function updateItem(MenuItem $item, array $attributes, array $menuTypeInput = [])
    {
        $parentIdName = $item->getParentIdName();
        // 내용 수정시 부모 키 변경은 허용하지 않음
        // 부모 키가 변경되는 경우는 반드시 moveTo, setOrder 를
        // 통해 처리되야 함
        $item = $this->items->update($item, array_merge(
            $attributes,
            [$parentIdName => $item->getOriginal($parentIdName)]
        ));

        $this->updateMenuType($item, $menuTypeInput);

        return $item;
    }

    /**
     * Update menu type associated with the menu item.
     *
     * @param MenuItem $item          menu item instance
     * @param array    $menuTypeInput input for menu type module
     * @return void
     */
    protected function updateMenuType(MenuItem $item, array $menuTypeInput)
    {
        $menuTypeObj = $this->modules->getModuleObject($item->type);
        $menuTypeObj->updateMenu($item->getKey(), $menuTypeInput, $item->getAttributes());

        if ($menuTypeObj::isRouteAble()) {
            $instanceRoute = $this->routes->findByInstanceId($item->getKey());
            $instanceRoute->url = $item->url;

            $this->routes->put($instanceRoute);
        }
    }

    /**
     * Delete menu item
     *
     * @param MenuItem $item item instance
     * @return bool|null
     * @throws CanNotDeleteMenuItemHaveChildException
     *
     * @deprecated since beta.17. Use deleteItem instead.
     */
    public function removeItem(MenuItem $item)
    {
        return $this->deleteItem($item);
    }

    /**
     * Delete menu item
     *
     * @param MenuItem $item item instance
     * @return bool|null
     * @throws CanNotDeleteMenuItemHaveChildException
     */
    public function deleteItem(MenuItem $item)
    {
        if ($item->getDescendantCount() > 0) {
            throw new CanNotDeleteMenuItemHaveChildException;
        }

        $this->deleteMenuType($item);

        return $this->items->delete($item);
    }

    /**
     * Delete menu type associated with the menu item.
     *
     * @param MenuItem $item menu item instance
     * @return void
     */
    protected function deleteMenuType(MenuItem $item)
    {
        $menuTypeObj = $this->modules->getModuleObject($item->type);
        $menuTypeObj->deleteMenu($item->getKey());

        if ($menuTypeObj::isRouteAble()) {
            $instanceRoute = $this->routes->findByInstanceId($item->getKey());
            $this->routes->delete($instanceRoute);
        }
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
            throw new InvalidArgumentException(['name' => 'parent object']);
        }

        if ($item->{$item->getParentIdName()}) {
            $oldParent = $this->items->find($item->{$item->getParentIdName()});
            $this->unlinkHierarchy($item, $oldParent);
            $item->{$item->getParentIdName()} = null;
        }

        if ($parent) {
            $this->linkHierarchy($item, $parent);
            $item->{$item->getParentIdName()} = $parent->getKey();
        }

        $item = $this->items->update($item, [$item->getAggregatorKeyName() => $menu->getKey()]);
        foreach ($item->descendants as $desc) {
            $this->items->update($desc, [$desc->getAggregatorKeyName() => $menu->getKey()]);
        }

        // 연관 객체 정보들이 변경 되었으므로 객채를 갱신 함
        return $this->items->find($item->getKey());
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
            $breadcrumbs = $value->getBreadcrumbs();
            $string = $value->menu->getKey() . '.' . implode('.', $breadcrumbs->modelKeys());
        } else {
            $string = $value;
        }

        return $this->menuKeyword . '.' . $string;
    }

    /**
     * Get default grant
     *
     * @return Grant
     */
    public function getDefaultGrant()
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
        
        return $grant;
    }

    /**
     * Make key string for permission
     *
     * @param MenuItem $item menu item instance
     * @return string
     */
    public function permKeyString(MenuItem $item)
    {
        $breadcrumbs = $item->getBreadcrumbs();

        return $item->menu->getKey() . '.' . implode('.', $breadcrumbs->modelKeys());
    }

    /**
     * Get setting page url by menu item
     *
     * @param MenuItem $item menu item instance
     * @return string|null
     */
    public function getInstanceSettingURI(MenuItem $item)
    {
        $menuType = $this->modules->getModuleObject($item->type);

        return $menuType::getInstanceSettingURI($item->getKey());
    }

    /**
     * Get setting page url by menu item id
     *
     * @param string $itemId menu item identifier
     * @return string|null
     */
    public function getInstanceSettingURIByItemId($itemId)
    {
        if (!$item = $this->items->find($itemId)) {
            return null;
        }

        return $this->getInstanceSettingURI($item);
    }

    /**
     * Get ModuleHandler instance
     *
     * @return ModuleHandler
     */
    public function getModuleHandler()
    {
        return $this->modules;
    }

    /**
     * Get MenuRepository instance
     *
     * @return MenuRepository
     */
    public function menus()
    {
        return $this->menus;
    }

    /**
     * Get MenuItemRepository instance
     *
     * @return MenuItemRepository
     */
    public function items()
    {
        return $this->items;
    }
}
