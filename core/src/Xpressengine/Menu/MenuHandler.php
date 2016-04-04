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

use Illuminate\Database\QueryException;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Menu\Exceptions\CanNotDeleteMenuEntityHaveChildException;
use Xpressengine\Menu\Exceptions\CanNotDeleteMenuItemHaveChildException;
use Xpressengine\Menu\Exceptions\InvalidArgumentException;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Module\ModuleHandler;
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\Routing\RouteRepository;
use Xpressengine\Support\Tree\NodePositionTrait;

/**
 * # MenuHandler
 *
 * ## app binding
 * * xe.menu 으로 바인딩 되어 있음
 * * XeMenu Facade 로 접근이 가능함
 *
 * ## 사용법
 *
 * ### Menu 등록
 * ```php
 *  $menu = XeMenu::create(
 *      ['title' => 'menu title', 'description' => 'menu description', 'siteKey' => 'default']
 *  );
 * ```
 *
 * ### Menu 수정
 * ```php
 *  $menu->title = 'new title';
 *  $menu->description = 'new description';
 *  XeMenu::put($menu);
 * ```
 *
 * ### Menu 삭제
 * * Menu 에 연결된 MenuItem 이 있는경우 삭제 할 수 없는 제약사항이 있음
 * ```php
 *  XeMenu::remove($menu);
 * ```
 *
 * ### MenuItem 생성
 * * 새로운 MenuItem 을 생성하고자 하는경우 해당 아이템이 소속될 메뉴 객체와 함께
 * 아이템을 구성할 정보를 배열형태로 전달하도록 함
 * * 해당 배열을 다음과 같은 항목으로 구성되어야 함
 * - parentId : 부모에 해당하는 MenuItem ID, 부모가 없는경우 null
 * - title : 사용자에게 표시될 이름
 * - description : MenuItem 에 대한 설명
 * - target : MenuItem 을 클릭했을 때의 링크 옵션 (ex. 새창, 현재창 등)
 * - type : MenuItem 이 어떤 모듈의 인스턴스인지 판별할 수 있는 키
 * - ordering : MenuItem 의 정렬 순번
 * - activated : MenuItem 의 활성화 여부
 *
 * * MenuItem 을 생성하는 경우 대상에 해당하는 모듈이 필요로 하는 정보도 함께 전달되어야 함
 * ```php
 *  $menuInput = [
 *      'title' => 'item title',
 *      'description' => 'item description',
 *      ...
 *  ];
 *  $etcInput = ['foo' => 'bar', 'baz' => 'qux'];
 *  $menuItem = XeMenu::createItem($menu, $menuInput, $etcInput);
 * ```
 *
 * ### MenuItem 수정
 * * 수정시에도 등록시와 마찬가지로 아이템에 해당하는 모듈이 필요로하는 정보를 넘겨주어
 * 함께 갱신되도록 함
 * ```php
 * $menuItem->title = 'new item title';
 * $menuItem->description = 'new item description';
 * $etcInput = ['foo' => 'new bar', 'baz' => 'new qux'];
 * XeMenu::putItem($menuItem, $etcInput);
 * ```
 *
 * ### MenuItem 삭제
 * * MenuItem 을 삭제하고자 할때 자식에 해당하는 다른 MenuItem 이 존재하는 경우
 * 삭제가 불가능 함
 * ```php
 * XeMenu::removeItem($item);
 * ```
 *
 * ### MenuItem 위치 이동
 * * MenuItem 을 이동하여 다른 아이템의 자식, 또는 다른 메뉴의 속하는 아이템으로 지정 할 수 있음.
 * 이때 MenuItem 이 다른 자식에 해당하는 아이템이 있는 경우 함께 이동하여 부모 자식 관계를 유지 시킴
 * ```php
 *  XeMenu::moveItem($menu, $menuItem, $newParentItem);
 * ```
 *
 * ### MenuItem 의 순서 정렬
 * * 형제 관계에 존재하는 MenuItem 은 정렬을 통해 표시되는 순서를 결정하게 되고,
 * 또한 이 순서를 변경할 수 있음
 * ```php
 *  XeMenu::setOrder($menuItem, $position = 1);
 * ```
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
    use NodePositionTrait;
    
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
     * @param Keygen            $keygen      Keygen instance
     * @param ConfigManager     $configs     ConfigManager instance
     * @param PermissionHandler $permissions PermissionHandler instance
     * @param ModuleHandler     $modules     ModuleHandler instance
     * @param RouteRepository   $routes      RouteRepository instance
     */
    public function __construct(
        Keygen $keygen,
        ConfigManager $configs,
        PermissionHandler $permissions,
        ModuleHandler $modules,
        RouteRepository $routes
    ) {
        $this->keygen = $keygen;
        $this->configs = $configs;
        $this->permissions = $permissions;
        $this->modules = $modules;
        $this->routes = $routes;
    }

    /**
     * Create new menu
     *
     * @param array $inputs attributes
     * @return Menu
     */
    public function create(array $inputs)
    {
        $menu = $this->createModel();
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

        $this->registerDefaultPermission($menu);

        return $menu;
    }

    /**
     * Update category
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
     * @param Menu  $menu          menu instance
     * @param array $inputs        item's attributes
     * @param array $menuTypeInput input for menu type module
     * @return MenuItem
     */
    public function createItem(Menu $menu, array $inputs, array $menuTypeInput = [])
    {
        $item = $this->createItemModel($menu);
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
        
        $this->setHierarchy($item);
        $this->setOrder($item);
        $menu->increment($menu->getCountName());
        
        $this->registerItemPermission($item, new Grant);
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
        // 이미 존재하는 경우 hierarchy 정보를 새로 등록하지 않음
        try {
            $item->ancestors()->attach($item->getKey(), [$item->getDepthName() => 0]);
        } catch (\Exception $e) {
            return;
        }

        if ($item->{$item->getParentIdName()}) {
            $model = $this->createItemModel();
            /** @var MenuItem $parent */
            $parent = $model->newQuery()->find($item->{$item->getParentIdName()});

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
                'instanceId' => $item->id,
                'menuId' => $item->menuId,
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
     */
    public function putItem(MenuItem $item, array $menuTypeInput)
    {
        /** @var MenuItem $parent */
        $parent = null;
        if ($item->isDirty($item->getParentIdName())) {
            // todo: parent 가 존재하다가 없어진 경우 처리 필요

            $parent = $item->newQuery()->find($item->getAttribute($item->getParentIdName()));
        }

        $item->save();

        if ($parent) {
            $this->moveItem($parent->menu, $item, $parent);
            $this->setOrder($item, count($parent->getChildren()));
        }

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
     * @throws \Exception
     */
    public function removeItem(MenuItem $item)
    {
        if ($item->getDescendantCount() > 0) {
            throw new CanNotDeleteMenuItemHaveChildException;
        }

        $this->deleteItemPermission($item);
        $item->ancestors()->detach($item);

        $result = $item->delete();

        $this->destroyMenuType($item);

        return $result;
    }

    /**
     * Destroy menu type associated with the menu item.
     *
     * @param MenuItem $item menu item instance
     * @return void
     */
    protected function destroyMenuType(MenuItem $item)
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
            $model = $this->createItemModel($menu);
            $oldParent = $model->newQuery()->find($item->{$item->getParentIdName()});
            $this->unlinkHierarchy($item, $oldParent);
            $item->{$item->getParentIdName()} = null;
        }

        if ($parent) {
            $this->linkHierarchy($item, $parent);
            $item->parentId = $parent->getKey();
        }

        $item->menuId = $menu->getKey();
        $item->save();

        // 연관 객체 정보들이 변경 되었으므로 객채를 갱신 함
        return $item->newQuery()->find($item->getKey());
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
    protected function registerDefaultPermission(Menu $menu)
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
     * @return mixed
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
