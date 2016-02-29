<?php
/**
 * Class MenuController
 *
 * PHP version 5
 *
 * @category  App\Http\Controllers
 * @package   App\Http\Controllers
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace App\Http\Controllers;

use App\Facades\Frontend;
use Exception;
use Illuminate\Contracts\Config\Repository as IlluminateConfig;
use Illuminate\Http\RedirectResponse;
use Presenter;
use Redirect;
use Request;
use Validator;
use XeDB;
use Xpressengine\Menu\MenuHandler;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Module\Exceptions\NotFoundModuleException;
use Xpressengine\Module\ModuleHandler;
use Xpressengine\Permission\Grant;
use Xpressengine\Presenter\RendererInterface;
use Xpressengine\Routing\RouteRepository;
use Xpressengine\Site\SiteHandler;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;
use Xpressengine\User\Models\User;
use Xpressengine\User\Models\UserGroup;

/**
 * Class MenuController
 *
 * @category    App
 * @package     App\Http\Controllers
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class MenuController extends Controller
{

    /**
     * index
     *
     * @param IlluminateConfig    $config       laravel config
     * @param SiteHandler         $siteHandler  site handler
     *
     * @return RendererInterface
     */
    public function index(IlluminateConfig $config, SiteHandler $siteHandler)
    {
        $siteKey = $siteHandler->getCurrentSiteKey();
        $menus = Menu::where('siteKey', $siteKey)->get()->getDictionary();
        $homeMenuId = $siteHandler->getHomeInstanceId();
        $menuMaxDepth = $config->get('xe.menu.maxDepth');

        $transKey = [];
        foreach ($menus as $menu) {
            foreach ($menu->items as $item) {
                $transKey[] = $item->title;
            }
        }

        // 메뉴 어드민 트리 뷰에서 필요한 고유 다국어
        FrontEnd::translation(['xe::addItem', 'xe::goLink', 'xe::setHome']);
        // 메뉴 타이틀 user 다국어
        Frontend::translation($transKey);
        return Presenter::make('menu.index',
            ['siteKey' => $siteKey, 'menus' => $menus, 'home' => $homeMenuId, 'maxDepth' => $menuMaxDepth]
        );
    }

    /**
     * create
     * 새로운 메뉴를 생성하는 페이지
     *
     * @param SiteHandler $siteHandler site handler
     *
     * @return RendererInterface
     */
    public function create(SiteHandler $siteHandler)
    {
        $siteKey = $siteHandler->getCurrentSiteKey();

        return Presenter::make(
            'menu.create',
            ['siteKey' => $siteKey]
        );
    }

    /**
     * store
     * 새로운 메뉴 생성을 처리하는 메소드
     *
     * @param MenuHandler $handler menu handler
     *
     * @return mixed
     * @throws Exception
     */
    public function store(MenuHandler $handler)
    {
        $desktopTheme = Request::get('theme_desktop');
        $mobileTheme = Request::get('theme_mobile');

        $rules = [
            'menuTitle'=> 'required',
            'theme_desktop' => 'required',
            'theme_mobile' => 'required',
        ];
        $validator = Validator::make(Request::all(), $rules);

        if ($validator->fails()) {
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $validator->messages()]);
        }

        XeDB::beginTransaction();
        try {
            $menu = $handler->create([
                'title' => Request::get('menuTitle'),
                'description' => Request::get('menuDescription'),
                'siteKey' => Request::get('siteKey')
            ]);

            $handler->setMenuTheme($menu, $desktopTheme, $mobileTheme);
            $handler->registerDefaultPermission($menu);

        } catch (Exception $e) {
            XeDB::rollback();
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::route('settings.menu.index');
    }

    /**
     * edit
     *
     * @param MenuHandler $handler menu handler
     * @param string      $menuId  string menu id
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function edit(MenuHandler $handler, $menuId)
    {
        $menu = Menu::find($menuId);
        $menuConfig = $handler->getMenuTheme($menu);

        return Presenter::make('menu.edit', ['menu' => $menu, 'config' => $menuConfig]);
    }

    /**
     * update
     *
     * @param MenuHandler $handler menu handler
     * @param string      $menuId to update menu entity object id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(MenuHandler $handler, $menuId)
    {
        $menu = Menu::find($menuId);

        $desktopTheme = Request::get('theme_desktop');
        $mobileTheme = Request::get('theme_desktop');

        $rules = [
            'menuTitle'=> 'required',
            'theme_desktop' => 'required',
            'theme_mobile' => 'required',
        ];
        $validator = Validator::make(Request::all(), $rules);

        if ($validator->fails()) {
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $validator->messages()]);
        }

        XeDB::beginTransaction();

        try {
            $menu->title = Request::get('menuTitle');
            $menu->description = Request::get('menuDescription');

            $handler->put($menu);
            $handler->updateMenuTheme($menu, $desktopTheme, $mobileTheme);

        } catch (Exception $e) {
            XeDB::rollback();
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::route('settings.menu.index');
    }

    /**
     * permit
     *
     * @param string $menuId menu id
     *
     * @return RendererInterface
     */
    public function permit($menuId)
    {
        $menu = Menu::with('items')->find($menuId);

        return Presenter::make(
            'menu.delete',
            ['menu' => $menu]
        );
    }


    /**
     * destroy
     *
     * @param MenuHandler $handler menu handler
     * @param string      $menuId  to delete menu entity object id
     *
     * @return RedirectResponse
     */
    public function destroy(MenuHandler $handler, $menuId)
    {
        XeDB::beginTransaction();

        try {
            $menu = Menu::find($menuId);

            $handler->remove($menu);
        } catch (Exception $e) {
            XeDB::rollback();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();
        return Redirect::route('settings.menu.index')
            ->with('alert', ['type' => 'success', 'message' => 'Menu deleted']);

    }

    /**
     * editMenuPermission
     *
     * @param MenuHandler $handler menu handler
     * @param string      $menuId menu id
     *
     * @return RendererInterface
     */
    public function editMenuPermission(MenuHandler $handler, $menuId)
    {
        $menu = Menu::find($menuId);

        $permission = $handler->getPermission($menu);

        $accessGrant = $permission[MenuHandler::ACCESS];
        $accessParams = [
            'rating' => $accessGrant['rating'],
            'group' => UserGroup::whereIn('id', $accessGrant['group'])->get(),
            'user' => User::whereIn('id', $accessGrant['user'])->get(),
            'except' => User::whereIn('id', $accessGrant['except'])->get(),
        ];

        $visibleGrant = $permission[MenuHandler::VISIBLE];
        $visibleParams = [
            'rating' => $visibleGrant['rating'],
            'group' => UserGroup::whereIn('id', $visibleGrant['group'])->get(),
            'user' => User::whereIn('id', $visibleGrant['user'])->get(),
            'except' => User::whereIn('id', $visibleGrant['except'])->get(),
        ];

        return Presenter::make(
            'menu.permission',
            [
                'menu' => $menu,
                MenuHandler::ACCESS => [
                    'grant' => $accessParams,
                    'title' => 'access'
                ],
                MenuHandler::VISIBLE => [
                    'grant' => $visibleParams,
                    'title' => 'visible',
                ]
            ]
        );
    }

    /**
     * updateMenuPermission
     *
     * @param MenuHandler $handler menu handler
     * @param string      $menuId  menu id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function updateMenuPermission(MenuHandler $handler, $menuId)
    {
        XeDB::beginTransaction();

        try {
            $inputs = Request::all();
            $menu = Menu::find($menuId);

            $accessInput = $this->inputFilterParser(MenuHandler::ACCESS, $inputs);
            $visibleInput = $this->inputFilterParser(MenuHandler::VISIBLE, $inputs);

            $grant = new Grant();
            $grant->set(MenuHandler::ACCESS, $accessInput);
            $grant->set(MenuHandler::VISIBLE, $visibleInput);

            $handler->registerMenuPermission($menu, $grant);

        } catch (Exception $e) {
            XeDB::rollback();
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::route('settings.menu.index');
    }

    protected function inputFilterParser($prefix, $inputs = [])
    {
        $inputs = array_filter($inputs, function ($value) use ($prefix) {
            return starts_with($value, $prefix);
        }, ARRAY_FILTER_USE_KEY);

        $result = [];
        foreach ($inputs as $key => $val) {
            $name = strtolower(ltrim($key, $prefix));
            if (in_array($name, ['group', 'user', 'except'])) {
                $val = array_filter(explode(',', $val));
            }

            $result[$name] = $val;
        }

        return $result;
    }

    /**
     * selectType
     *
     * @param string $menuId menu id
     *
     * @return RendererInterface
     */
    public function selectType($menuId)
    {
        $parent = Request::get('parent', $menuId);

        return Presenter::make(
            'menu.selectItemType',
            [
                'menuId' => $menuId,
                'parent' => $parent
            ]
        );
    }

    /**
     * createItem
     *
     * @param IlluminateConfig $config        laravel config
     * @param MenuHandler      $handler       menu handler
     * @param ModuleHandler    $moduleHandler module handler
     * @param SiteHandler      $siteHandler   site handler
     * @param string           $menuId        menu id
     *
     * @return RendererInterface
     */
    public function createItem(
        IlluminateConfig $config,
        MenuHandler $handler,
        ModuleHandler $moduleHandler,
        SiteHandler $siteHandler,
        $menuId
    ) {
        $menu = Menu::find($menuId);
        $menuConfig = $handler->getMenuTheme($menu);
//        $parent = Request::get('parent', $menuId);
        $parent = Request::get('parent');

        $selectedMenuType = Request::get('selectType');
        if ($selectedMenuType === null) {
            return Redirect::route('settings.menu.select.types', [$menu->id])
                ->with('alert', ['type' => 'warning', 'message' => 'type 을 선택하십시오']);
        }

        $siteKey = $siteHandler->getCurrentSiteKey();
        $menuTypeObj = $moduleHandler->getModuleObject($selectedMenuType);
        $menuMaxDepth = $config->get('xe.menu.maxDepth');

        return Presenter::make(
            'menu.createItem',
            [
                'menu' => $menu,
                'menuType' => $menuTypeObj,
                'siteKey' => $siteKey,
                'maxDepth' => $menuMaxDepth,
                'parent' => $parent,
                'selectedType' => $selectedMenuType,
                'menuTypeArgs' => [
                    'menuType' => $menuTypeObj,
                    'action' => 'createMenuForm',
                    'param' => []
                ],
                'menuConfig' => $menuConfig
            ]
        );
    }

    /**
     * storeItem
     *
     * @param MenuHandler     $handler menu handler
     * @param ModuleHandler   $modules store item handler
     * @param RouteRepository $routes  store item config handler
     * @param string          $menuId  where to store
     *
     * @return $this|RedirectResponse
     * @throws Exception
     */
    public function storeItem(MenuHandler $handler, ModuleHandler $modules, RouteRepository $routes, $menuId)
    {
        XeDB::beginTransaction();

        $menu = Menu::find($menuId);

        try {
            $inputs = Request::except(['_token', 'theme_desktop', 'theme_mobile']);
            $parentThemeMode = Request::get('parentTheme', false);
            if ($parentThemeMode === false) {
                $desktopTheme = Request::get('theme_desktop');
                $mobileTheme = Request::get('theme_mobile');
            } else {
                $desktopTheme = null;
                $mobileTheme = null;
            }

            list($itemInput, $menuTypeInput) = $this->inputClassify($inputs);
            $itemInput['parent'] = $itemInput['parent'] === $menu->getKey() ? null : $itemInput['parent'];
            $item = $handler->createItem($menu, [
                'title' => $itemInput['itemTitle'],
                'url' => $itemInput['itemUrl'],
                'description' => $itemInput['itemDescription'],
                'target' => $itemInput['itemTarget'],
                'type' => $itemInput['selectedType'],
                'ordering' => $itemInput['itemOrdering'],
                'activated' => $itemInput['itemActivated'],
                'parentId' => $itemInput['parent']
            ]);

            // 메뉴 타입 처리
            $menuTypeObj = $modules->getModuleObject($itemInput['selectedType']);
            $menuTypeObj->storeMenu($item->getKey(), $menuTypeInput, $itemInput);

            // 메뉴 타입이 route 를 사용하는 경우 instance route 를 추가해 줌
            if ($menuTypeObj::isRouteAble()) {
                $routes->create([
                    'url' => $itemInput['itemUrl'],
                    'module' => $menuTypeObj::getId(),
                    'instanceId' => $itemInput['itemId'],
                    'menuId' => $item->menuId,
                    'siteKey' => $itemInput['siteKey']
                ]);
            }

            $handler->setMenuItemTheme($item, $desktopTheme, $mobileTheme);

        } catch (Exception $e) {
            XeDB::rollback();
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::route('settings.menu.index');
    }

    protected function inputClassify(array $inputs)
    {
        $itemInputKeys = [
            'itemId',
            'parent',
            'itemTitle',
            'itemUrl',
            'itemDescription',
            'itemTarget',
            'selectedType',
            'itemOrdering',
            'itemActivated',
            'siteKey'
        ];

        return [
            array_only($inputs, $itemInputKeys),
            array_except($inputs, $itemInputKeys),
        ];
    }

    /**
     * editItem
     * 선택된 메뉴의 아이템을 view & edit 페이지 구성
     *
     * @param MenuHandler   $handler menu handler
     * @param ModuleHandler $modules module handler
     * @param SiteHandler   $sites   site handler
     * @param string        $menuId  menu id
     * @param string        $itemId  item id
     *
     * @return RendererInterface
     */
    public function editItem(
        MenuHandler $handler,
        ModuleHandler $modules,
        SiteHandler $sites,
        $menuId,
        $itemId
    ) {
        /** @var MenuItem $item */
        $item = MenuItem::find($itemId);
        $menu = $item->menu;
        if ($menu->getKey() !== $menuId) {
            throw new InvalidArgumentHttpException(400);
        }

        try {
            $menuType = $modules->getModuleObject($item->type);
        } catch (NotFoundModuleException $e) {
            $menuType = null;
        }

        $homeId = $sites->getHomeInstanceId();

        $itemConfig = $handler->getMenuItemTheme($item);
        $desktopTheme = $itemConfig->getPure('desktopTheme');
        $mobileTheme = $itemConfig->getPure('mobileTheme');

        $parentThemeMode = false;
        if ($desktopTheme === null && $mobileTheme === null) {
            $parentThemeMode = true;
        }
        $parentConfig = $itemConfig->getParent();

        return Presenter::make(
            'menu.editItem',
            [
                'menu' => $menu,
                'item' => $item,
                'homeId' => $homeId,
                'menuType' => $menuType,
                'parentThemeMode' => $parentThemeMode,
                'itemConfig' => $itemConfig,
                'parentConfig' => $parentConfig
            ]
        );
    }

    /**
     * updateItem
     * 메뉴 아이템 수정 처리 메소드
     *
     * @param MenuHandler     $handler menu handler
     * @param ModuleHandler   $modules menu change handler
     * @param RouteRepository $routes  menu config handler
     * @param string          $menuId  menu id
     * @param string          $itemId  item id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function updateItem(
        MenuHandler $handler,
        ModuleHandler $modules,
        RouteRepository $routes,
        $menuId,
        $itemId
    ) {
        XeDB::beginTransaction();

        try {
            $inputs = Request::except(['_token', 'theme_desktop', 'theme_mobile']);

            /** @var MenuItem $item */
            $item = MenuItem::find($itemId);
            $menu = $item->menu;
            if ($menu->getKey() !== $menuId) {
                throw new InvalidArgumentHttpException(400);
            }

            $parentThemeMode = Request::get('parentTheme', false);
            if ($parentThemeMode === false) {
                $desktopTheme = Request::get('theme_desktop');
                $mobileTheme = Request::get('theme_mobile');
            } else {
                $desktopTheme = null;
                $mobileTheme = null;
            }

            list($itemInput, $menuTypeInput) = $this->inputClassify($inputs);

            $item->fill([
                'title' => $itemInput['itemTitle'],
                'url' => $itemInput['itemUrl'],
                'description' => $itemInput['itemDescription'],
                'target' => $itemInput['itemTarget'],
                'ordering' => $itemInput['itemOrdering'],
                'activated' => array_get($itemInput, 'itemActivated', '0'),
            ]);

            $handler->putItem($item);

            // 메뉴 타입 처리
            $menuType = $item->type;
            $menuTypeObj = $modules->getModuleObject($menuType);
            $menuTypeObj->updateMenu($item->getKey(), $menuTypeInput, $itemInput);

            if ($menuTypeObj::isRouteAble()) {
                $instanceRoute = $routes->findByInstanceId($item->getKey());
                $instanceRoute->url = $itemInput['itemUrl'];

                $routes->put($instanceRoute);
            }

            $handler->updateMenuItemTheme($item, $desktopTheme, $mobileTheme);

        } catch (Exception $e) {
            XeDB::rollback();
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::route('settings.menu.index');

    }

    /**
     * permitItem
     *
     * @param ModuleHandler $modules module handler
     * @param string        $menuId  menu id
     * @param string        $itemId  item id
     *
     * @return RendererInterface
     */
    public function permitItem(ModuleHandler $modules, $menuId, $itemId)
    {
        /** @var MenuItem $item */
        $item = MenuItem::find($itemId);
        $menu = $item->menu;
        if ($menu->getKey() !== $menuId) {
            throw new InvalidArgumentHttpException(400);
        }

        $menuType = $modules->getModuleObject($item->type);

        return Presenter::make(
            'menu.deleteItem',
            [
                'menu' => $menu,
                'item' => $item,
                'menuType' => $menuType,
            ]
        );
    }

    /**
     * destroyItem
     * 메뉴 아이템 삭제 처리 메소드
     *
     * @param MenuHandler     $handler menu handler
     * @param ModuleHandler   $modules menu alter handler
     * @param RouteRepository $routes  menu config handler
     * @param string          $menuId  menu id
     * @param string          $itemId  item id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroyItem(
        MenuHandler $handler,
        ModuleHandler $modules,
        RouteRepository $routes,
        $menuId,
        $itemId
    ) {
        $item = MenuItem::find($itemId);
        $menu = $item->menu;
        if ($menu->getKey() !== $menuId) {
            throw new InvalidArgumentHttpException(400);
        }

        XeDB::beginTransaction();
        try {
            $handler->removeItem($item);

            $menuType = $item->type;
            $menuTypeObj = $modules->getModuleObject($menuType);
            $menuTypeObj->deleteMenu($item->getKey());

            if ($menuTypeObj::isRouteAble()) {
                $instanceRoute = $routes->findByInstanceId($item->getKey());
                $routes->delete($instanceRoute);
            }

            $handler->deleteMenuItemTheme($item);

        } catch (Exception $e) {
            XeDB::rollback();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();
        return Redirect::route('settings.menu.index')
            ->with('alert', ['type' => 'success', 'message' => 'MenuItem deleted']);
    }

    /**
     * editItemPermission
     * 선택된 메뉴의 아이템을 permission 을 수정하는 페이지 구성
     *
     * @param MenuHandler   $handler menu handler
     * @param ModuleHandler $modules module handler
     * @param string        $menuId  menu id
     * @param string        $itemId  item id
     *
     * @return RendererInterface
     */
    public function editItemPermission(MenuHandler $handler, ModuleHandler $modules, $menuId, $itemId)
    {
        $item = MenuItem::find($itemId);
        $menu = $item->menu;
        if ($menu->getKey() !== $menuId) {
            throw new InvalidArgumentHttpException(400);
        }

        try {
            $menuType = $modules->getModuleObject($item->type);
        } catch (NotFoundModuleException $e) {
            $menuType = null;
        }

        $permission = $handler->getItemPermission($item);


        $accessGrant = $permission[MenuHandler::ACCESS];
        $accessParams = [
            'rating' => $accessGrant['rating'],
            'group' => UserGroup::whereIn('id', $accessGrant['group'])->get(),
            'user' => User::whereIn('id', $accessGrant['user'])->get(),
            'except' => User::whereIn('id', $accessGrant['except'])->get(),
        ];

        $visibleGrant = $permission[MenuHandler::VISIBLE];
        $visibleParams = [
            'rating' => $visibleGrant['rating'],
            'group' => UserGroup::whereIn('id', $visibleGrant['group'])->get(),
            'user' => User::whereIn('id', $visibleGrant['user'])->get(),
            'except' => User::whereIn('id', $visibleGrant['except'])->get(),
        ];

        return Presenter::make(
            'menu.itemPermission',
            [
                'menu' => $menu,
                'item' => $item,
                'menuType' => $menuType,
                MenuHandler::ACCESS => [
                    'mode' => $permission->pure(MenuHandler::ACCESS) === null ? "inherit" : "manual",
                    'grant' => $accessParams,
                    'title' => 'access'
                ],
                MenuHandler::VISIBLE => [
                    'mode' => $permission->pure(MenuHandler::VISIBLE) === null ? "inherit" : "manual",
                    'grant' => $visibleParams,
                    'title' => 'visible',
                ]
            ]
        );
    }

    /**
     * updateItemPermission
     *
     * @param MenuHandler $handler menu handler
     * @param string      $menuId  menu id
     * @param string      $itemId  menu item id
     *
     * @return RedirectResponse
     */
    public function updateItemPermission(
        MenuHandler $handler,
        $menuId,
        $itemId
    ) {
        XeDB::beginTransaction();

        try {
            $inputs = Request::all();
            $item = MenuItem::find($itemId);
            $menu = $item->menu;
            if ($menu->getKey() !== $menuId) {
                throw new InvalidArgumentHttpException(400);
            }

            $accessInput = $this->inputFilterParser(MenuHandler::ACCESS, $inputs);
            $visibleInput = $this->inputFilterParser(MenuHandler::VISIBLE, $inputs);

            $grant = new Grant();
            $grant->set(MenuHandler::ACCESS, $accessInput['mode'] == 'manual' ? $accessInput : []);
            $grant->set(MenuHandler::VISIBLE, $visibleInput['mode'] == 'manual' ? $visibleInput : []);

            $handler->registerItemPermission($item, $grant);

//            $cacheHandler->deleteCachedMenu($item->menuId);

        } catch (Exception $e) {
            XeDB::rollback();
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::route('settings.menu.index');
    }

    /**
     * moveItem
     *
     * @param MenuHandler $handler menu handler
     *
     * @return RendererInterface
     * @throws Exception
     */
    public function moveItem(MenuHandler $handler)
    {
        $ordering = Request::get('ordering');
        $itemId = Request::get('itemId');
        $parentId = Request::get('parent');

        XeDB::beginTransaction();

        try {
            $item = MenuItem::find($itemId);
            if (!$parent = MenuItem::find($parentId)) {
                $menu = Menu::find($parentId);
            } else {
                $menu = $parent->menu;
            }
            $old = clone $item;
            $item = $handler->moveItem($menu, $item, $parent);
            $handler->setOrder($item, $ordering);

            $handler->moveItemConfig($old, $item);
            $handler->moveItemPermission($old, $item);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }

        XeDB::commit();

        return Presenter::makeApi(\Request::all());
    }

    /**
     * setHome
     *
     * @param SiteHandler $siteHandler site handler
     *
     * @return RendererInterface
     *
     */
    public function setHome(SiteHandler $siteHandler)
    {
        $itemId = Request::get('itemId');

        $siteHandler->setHomeInstanceId($itemId);

        return Presenter::makeApi([$itemId]);
    }
}
