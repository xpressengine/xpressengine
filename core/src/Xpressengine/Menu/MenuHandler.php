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
use Xpressengine\Menu\ModuleHandler;
use Xpressengine\Permission\Grant;
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
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
     * MenuRepository instance
     *
     * @var MenuRepository
     */
    protected $repo;

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
     * @param MenuRepository  $repo    MenuRepository instance
     * @param ConfigManager   $configs ConfigManager instance
     * @param ModuleHandler   $modules ModuleHandler instance
     * @param RouteRepository $routes  RouteRepository instance
     */
    public function __construct(
        MenuRepository $repo,
        ConfigManager $configs,
        ModuleHandler $modules,
        RouteRepository $routes
    ) {
        $this->repo = $repo;
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
     */
    public function get($id, $with = [])
    {
        return $this->repo->find($id, $with);
    }

    /**
     * Get all menu
     *
     * @param string $siteKey site key
     * @param array  $with    relation
     * @return Menu[]
     */
    public function getAll($siteKey, $with = [])
    {
        return $this->repo->all($siteKey, $with);
    }

    /**
     * Create new menu
     *
     * @param array $inputs attributes
     * @return Menu
     */
    public function create(array $inputs)
    {
        $menu = $this->repo->createModel();
        $menu->fill($inputs);

        return $this->repo->insert($menu);
    }

    /**
     * Update category
     *
     * @param Menu $menu menu instance
     * @return Menu
     */
    public function put(Menu $menu)
    {
        return $this->repo->update($menu);
    }

    /**
     * Delete menu
     *
     * @param Menu $menu menu instance
     * @return bool
     * @throws CanNotDeleteMenuEntityHaveChildException
     */
    public function remove(Menu $menu)
    {
        if ($menu->items->count() > 0) {
            throw new CanNotDeleteMenuEntityHaveChildException;
        }

        $this->deleteMenuTheme($menu);

        return $this->repo->delete($menu);
    }

    /**
     * Get menu item
     *
     * @param string $id   menu item identifier
     * @param array  $with relation
     * @return MenuItem
     */
    public function getItem($id, $with = [])
    {
        return $this->repo->findItem($id, $with);
    }

    /**
     * Get menu item list by identifiers
     *
     * @param array $ids  menu item identifier list
     * @param array $with relation
     * @return MenuItem[]
     */
    public function getItemIn($ids, $with = [])
    {
        return $this->repo->fetchInItem((array)$ids, $with);
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
        /** @var MenuItem $item */
        $item = $this->repo->createItemModel($menu);
        $item->fill($inputs);
        $item->{$item->getAggregatorKeyName()} = $menu->getKey();

        $item = $this->repo->insertItem($item);

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
        // 이미 존재하는 경우 hierarchy 정보를 새로 등록하지 않음
        try {
            $item->ancestors()->attach($item->getKey(), [$item->getDepthName() => 0]);
        } catch (\Exception $e) {
            return;
        }

        if ($item->{$item->getParentIdName()}) {
            $parent = $this->repo->findItem($item->{$item->getParentIdName()});

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
     */
    public function putItem(MenuItem $item, array $menuTypeInput)
    {
        if ($item->isDirty($parentIdName = $item->getParentIdName())) {
            // 내용 수정시 부모 키 변경은 허용하지 않음
            // 부모 키가 변경되는 경우는 반드시 moveItem, setOrder 를
            // 통해 처리되야 함
            $item->{$parentIdName} = $item->getOriginal($parentIdName);
        }

        $item = $this->repo->updateItem($item);

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
     */
    public function removeItem(MenuItem $item)
    {
        if ($item->getDescendantCount() > 0) {
            throw new CanNotDeleteMenuItemHaveChildException;
        }

        $item->ancestors(false)->detach();
        $this->destroyMenuType($item);

        return $this->repo->deleteItem($item);
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
            $oldParent = $this->repo->findItem($item->{$item->getParentIdName()});
            $this->unlinkHierarchy($item, $oldParent);
            $item->{$item->getParentIdName()} = null;
        }

        if ($parent) {
            $this->linkHierarchy($item, $parent);
            $item->parentId = $parent->getKey();
        }

        // 캐시를 사용하는 경우 기존 메뉴를 대상으로 하는 캐시의 갱신이 필요하여
        // 변경전 업데이트를 수행함
        $this->repo->update($item->menu);
        $item->{$item->getAggregatorKeyName()} = $menu->getKey();
        $item->setRelation('menu', $menu);
        $item = $this->repo->updateItem($item);

        // 연관 객체 정보들이 변경 되었으므로 객채를 갱신 함
        return $this->repo->findItem($item->getKey());
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
        if (!$item = $this->repo->findItem($itemId)) {
            return null;
        }

        return $this->getInstanceSettingURI($item);
    }
}
