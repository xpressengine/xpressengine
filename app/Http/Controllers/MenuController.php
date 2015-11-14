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
use Xpressengine\Menu\MenuAlterHandler;
use Xpressengine\Menu\MenuCacheHandler;
use Xpressengine\Menu\MenuConfigHandler;
use Xpressengine\Menu\MenuPermissionHandler;
use Xpressengine\Menu\MenuRetrieveHandler;
use Xpressengine\Module\Exceptions\NotFoundModuleException;
use Xpressengine\Module\ModuleHandler;
use Xpressengine\Permission\Grant;
use Xpressengine\Presenter\RendererInterface;
use Xpressengine\Site\SiteHandler;

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
     * @param MenuRetrieveHandler $menuHandler  menu handler
     * @param MenuCacheHandler    $cacheHandler menu cache handler
     * @param SiteHandler         $siteHandler  site handler
     *
     * @return RendererInterface
     */
    public function index(
        IlluminateConfig $config,
        MenuRetrieveHandler $menuHandler,
        MenuCacheHandler $cacheHandler,
        SiteHandler $siteHandler
    ) {
        $siteKey = $siteHandler->getCurrentSiteKey();
        $menus = $menuHandler->getAllMenu($siteKey);
        $homeMenuId = $siteHandler->getHomeInstanceId();
        $menuMaxDepth = $config->get('xe.menu.maxDepth');

        $transKey = [];
        foreach ($menus as $menu) {
            $transKey = array_merge($transKey, $cacheHandler->getMenuItemKeys($menu));
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
     * @param MenuAlterHandler      $menuChanger       menu alter handler
     * @param MenuConfigHandler     $configHandler     menu config like theme config handler
     * @param MenuPermissionHandler $permissionHandler menu permission handler
     *
     * @return mixed
     * @throws Exception
     */
    public function store(
        MenuAlterHandler $menuChanger,
        MenuConfigHandler $configHandler,
        MenuPermissionHandler $permissionHandler
    ) {
        $inputs = Request::all();
        $selectedDesktopTheme = Request::get('theme_desktop');
        $selectedMobileTheme = Request::get('theme_mobile');

        $rules = [
            'menuTitle'=> 'required',
            'theme_desktop' => 'required',
            'theme_mobile' => 'required',
        ];
        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $validator->messages()]);
        }

        XeDB::beginTransaction();
        try {
            $menu = $menuChanger->addMenu($inputs);
            $configHandler->setMenuTheme($menu, $selectedDesktopTheme, $selectedMobileTheme);

            $defaultMenuPermission = $permissionHandler->getDefaultMenuPermission();
            $permissionHandler->registerMenuPermission($menu, $defaultMenuPermission);

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
     * @param MenuRetrieveHandler $menuHandler   menu handler
     * @param MenuConfigHandler   $configHandler config handler
     * @param string              $menuId        string menu id
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function edit(MenuRetrieveHandler $menuHandler, MenuConfigHandler $configHandler, $menuId)
    {
        $menu = $menuHandler->getMenu($menuId);
        $menuConfig = $configHandler->getMenuTheme($menu);

        return Presenter::make('menu.edit', ['menu' => $menu, 'config' => $menuConfig]);
    }

    /**
     * update
     *
     * @param MenuRetrieveHandler $menuHandler   basic handler
     * @param MenuAlterHandler    $menuChanger   menu alter handler
     * @param MenuConfigHandler   $configHandler menu config handler
     * @param string              $menuId        to update menu entity object id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(
        MenuRetrieveHandler $menuHandler,
        MenuAlterHandler $menuChanger,
        MenuConfigHandler $configHandler,
        $menuId
    ) {
        $menu = $menuHandler->getMenu($menuId);

        $inputs = Request::all();

        $rules = [
            'menuTitle'=> 'required',
            'theme_desktop' => 'required',
            'theme_mobile' => 'required',
        ];
        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $validator->messages()]);
        }

        XeDB::beginTransaction();

        try {
            $menuChanger->putMenu($menu, $inputs);
            $desktopTheme = $inputs['theme_desktop'];
            $mobileTheme = $inputs['theme_desktop'];
            $configHandler->updateMenuTheme($menu, $desktopTheme, $mobileTheme);
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
     * @param MenuRetrieveHandler $menuHandler basic handler
     * @param string              $menuId      menu id
     *
     * @return RendererInterface
     */
    public function permit(MenuRetrieveHandler $menuHandler, $menuId)
    {
        $menu = $menuHandler->getMenu($menuId);

        return Presenter::make(
            'menu.delete',
            ['menu' => $menu]
        );
    }


    /**
     * destroy
     *
     * @param MenuRetrieveHandler   $menuHandler       menu handler
     * @param MenuAlterHandler      $menuChanger       menu alter handler
     * @param MenuConfigHandler     $configHandler     menu config handler
     * @param MenuPermissionHandler $permissionHandler menu permission handler
     * @param string                $menuId            to delete menu entity object id
     *
     * @return RedirectResponse
     */
    public function destroy(
        MenuRetrieveHandler $menuHandler,
        MenuAlterHandler $menuChanger,
        MenuConfigHandler $configHandler,
        MenuPermissionHandler $permissionHandler,
        $menuId
    ) {

        XeDB::beginTransaction();

        try {
            $menu = $menuHandler->getMenu($menuId);
            $menuChanger->removeMenu($menu);
            $configHandler->deleteMenuTheme($menu);
            $permissionHandler->deleteMenuPermission($menu);

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
     * @param MenuRetrieveHandler   $menuHandler       menu handler
     * @param MenuPermissionHandler $permissionHandler menu permission handler
     * @param string                $menuId            menu id
     *
     * @return RendererInterface
     */
    public function editMenuPermission(
        MenuRetrieveHandler $menuHandler,
        MenuPermissionHandler $permissionHandler,
        $menuId
    ) {
        $menu = $menuHandler->getMenu($menuId);

        $accessPermission = $permissionHandler->getMenuAccessPermission($menu);
        $visiblePermission = $permissionHandler->getMenuVisiblePermission($menu);

        return Presenter::make(
            'menu.permission',
            [
                'menu' => $menu,
                'access' => [
                    'grant' => $accessPermission,
                    'title' => 'access'
                ],
                'visible' => [
                    'grant' => $visiblePermission,
                    'title' => 'visible',
                ]
            ]
        );
    }

    /**
     * updateMenuPermission
     *
     * @param MenuRetrieveHandler   $menuHandler       menu handler
     * @param MenuCacheHandler      $cacheHandler      menu cache handler
     * @param MenuPermissionHandler $permissionHandler menu permission handler
     * @param string                $menuId            menu id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function updateMenuPermission(
        MenuRetrieveHandler $menuHandler,
        MenuCacheHandler $cacheHandler,
        MenuPermissionHandler $permissionHandler,
        $menuId
    ) {
        XeDB::beginTransaction();

        try {
            $inputs = Request::all();
            $menu = $menuHandler->getMenu($menuId);

            $menuGrant = $permissionHandler->createAccessGrant($inputs);
            $menuGrant = $permissionHandler->createVisibleGrant($inputs, $menuGrant);
            $permissionHandler->registerMenuPermission($menu, $menuGrant);

            $cacheHandler->deleteCachedMenu($menuId);

        } catch (Exception $e) {
            XeDB::rollback();
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::route('settings.menu.index');
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
     * @param IlluminateConfig    $config        laravel config
     * @param MenuRetrieveHandler $menuHandler   menu handler
     * @param ModuleHandler       $moduleHandler module handler
     * @param MenuConfigHandler   $configHandler menu config handler
     * @param SiteHandler         $siteHandler   site handler
     * @param string              $menuId        menu id
     *
     * @return RendererInterface
     */
    public function createItem(
        IlluminateConfig $config,
        MenuRetrieveHandler $menuHandler,
        ModuleHandler $moduleHandler,
        MenuConfigHandler $configHandler,
        SiteHandler $siteHandler,
        $menuId
    ) {
        $menu = $menuHandler->getMenu($menuId);
        $menuConfig = $configHandler->getMenuTheme($menu);
        $parent = Request::get('parent', $menuId);

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
     * @param MenuRetrieveHandler   $menuHandler       to get menu has item
     * @param MenuAlterHandler      $menuChanger       store item handler
     * @param MenuConfigHandler     $configHandler     store item config handler
     * @param MenuPermissionHandler $permissionHandler store item permission handler
     * @param string                $menuId            where to store
     *
     * @return $this|RedirectResponse
     * @throws Exception
     */
    public function storeItem(
        MenuRetrieveHandler $menuHandler,
        MenuAlterHandler $menuChanger,
        MenuConfigHandler $configHandler,
        MenuPermissionHandler $permissionHandler,
        $menuId
    ) {
        XeDB::beginTransaction();

        $menu = $menuHandler->getMenu($menuId);

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

            $item = $menuChanger->addItem($menu, $inputs);
            $configHandler->setMenuItemTheme($item, $desktopTheme, $mobileTheme);
            $permissionHandler->registerItemPermission($item, new Grant);

        } catch (Exception $e) {
            XeDB::rollback();
            Request::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::route('settings.menu.index');
    }


    /**
     * editItem
     * 선택된 메뉴의 아이템을 view & edit 페이지 구성
     *
     * @param MenuRetrieveHandler $menuHandler   menu handler
     * @param ModuleHandler       $moduleHandler module handler
     * @param MenuConfigHandler   $configHandler menu config handler
     * @param SiteHandler         $siteHandler   site handler
     * @param string              $menuId        menu id
     * @param string              $itemId        item id
     *
     * @return RendererInterface
     */
    public function editItem(
        MenuRetrieveHandler $menuHandler,
        ModuleHandler $moduleHandler,
        MenuConfigHandler $configHandler,
        SiteHandler $siteHandler,
        $menuId,
        $itemId
    ) {
        $menu = $menuHandler->getMenu($menuId);
        $item = $menu->getItem($itemId);

        try {
            $menuType = $moduleHandler->getModuleObject($item->type);
        } catch (NotFoundModuleException $e) {
            $menuType = null;
        }

        $homeId = $siteHandler->getHomeInstanceId();

        $itemConfig = $configHandler->getMenuItemTheme($item);
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
     * @param MenuRetrieveHandler $menuHandler   menu handler
     * @param MenuAlterHandler    $menuChanger   menu change handler
     * @param MenuConfigHandler   $configHandler menu config handler
     * @param string              $menuId        menu id
     * @param string              $itemId        item id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function updateItem(
        MenuRetrieveHandler $menuHandler,
        MenuAlterHandler $menuChanger,
        MenuConfigHandler $configHandler,
        $menuId,
        $itemId
    ) {
        XeDB::beginTransaction();

        try {
            $inputs = Request::except(['_token', 'theme_desktop', 'theme_mobile']);
            $menu = $menuHandler->getMenu($menuId);
            $item = $menu->getItem($itemId);

            $parentThemeMode = Request::get('parentTheme', false);
            if ($parentThemeMode === false) {
                $desktopTheme = Request::get('theme_desktop');
                $mobileTheme = Request::get('theme_mobile');
            } else {
                $desktopTheme = null;
                $mobileTheme = null;
            }

            $menuChanger->putItem($item, $inputs);
            $configHandler->updateMenuItemTheme($item, $desktopTheme, $mobileTheme);

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
     * @param MenuRetrieveHandler $menuHandler   menu handler
     * @param ModuleHandler       $moduleHandler module handler
     * @param string              $menuId        menu id
     * @param string              $itemId        item id
     *
     * @return RendererInterface
     */
    public function permitItem(MenuRetrieveHandler $menuHandler, ModuleHandler $moduleHandler, $menuId, $itemId)
    {
        $menu = $menuHandler->getMenu($menuId);
        $item = $menu->getItem($itemId);

        $menuType = $moduleHandler->getModuleObject($item->type);

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
     * @param MenuRetrieveHandler   $menuHandler       menu handler
     * @param MenuAlterHandler      $menuChanger       menu alter handler
     * @param MenuConfigHandler     $configHandler     menu config handler
     * @param MenuPermissionHandler $permissionHandler menu permission handler
     * @param string                $menuId            menu id
     * @param string                $itemId            item id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroyItem(
        MenuRetrieveHandler $menuHandler,
        MenuAlterHandler $menuChanger,
        MenuConfigHandler $configHandler,
        MenuPermissionHandler $permissionHandler,
        $menuId,
        $itemId
    ) {

        XeDB::beginTransaction();
        try {
            $menu = $menuHandler->getMenu($menuId);
            $item = $menu->getItem($itemId);

            $menuChanger->removeItem($item);
            $configHandler->deleteMenuItemTheme($item);
            $permissionHandler->deleteItemPermission($item);

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
     * @param MenuRetrieveHandler                $menuHandler       menu handler
     * @param MenuPermissionHandler              $permissionHandler menu permission handler
     * @param \Xpressengine\Module\ModuleHandler $moduleHandler     module handler
     * @param string                             $menuId            menu id
     * @param string                             $itemId            item id
     *
     * @return RendererInterface
     */
    public function editItemPermission(
        MenuRetrieveHandler $menuHandler,
        MenuPermissionHandler $permissionHandler,
        ModuleHandler $moduleHandler,
        $menuId,
        $itemId
    ) {

        $menu = $menuHandler->getMenu($menuId);
        $item = $menu->getItem($itemId);

        try {
            $menuType = $moduleHandler->getModuleObject($item->type);
        } catch (NotFoundModuleException $e) {
            $menuType = null;
        }

        $accessPermission = $permissionHandler->getItemAccessPermission($item);
        $visiblePermission = $permissionHandler->getItemVisiblePermission($item);

        return Presenter::make(
            'menu.itemPermission',
            [
                'menu' => $menu,
                'item' => $item,
                'menuType' => $menuType,
                'access' => [
                    'mode' => $accessPermission['mode'],
                    'grant' => $accessPermission,
                    'title' => 'access'
                ],
                'visible' => [
                    'mode' => $visiblePermission['mode'],
                    'grant' => $visiblePermission,
                    'title' => 'visible',
                ]
            ]
        );
    }

    /**
     * updateItemPermission
     *
     * @param MenuRetrieveHandler   $menuHandler       menu handler
     * @param MenuCacheHandler      $cacheHandler      menu cache handler
     * @param MenuPermissionHandler $permissionHandler menu permission handler
     * @param string                $menuId            menu id
     * @param string                $itemId            menu item id
     *
     * @return RedirectResponse
     */
    public function updateItemPermission(
        MenuRetrieveHandler $menuHandler,
        MenuCacheHandler $cacheHandler,
        MenuPermissionHandler $permissionHandler,
        $menuId,
        $itemId
    ) {
        XeDB::beginTransaction();

        try {
            $inputs = Request::all();
            $menu = $menuHandler->getMenu($menuId);
            $item = $menu->getItem($itemId);

            $menuGrant = $permissionHandler->createAccessGrant($inputs);
            $menuGrant = $permissionHandler->createVisibleGrant($inputs, $menuGrant);
            $permissionHandler->registerItemPermission($item, $menuGrant);

            $cacheHandler->deleteCachedMenu($item->menuId);

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
     * @param MenuRetrieveHandler   $menuRetrieveHandler menu handler
     * @param MenuAlterHandler      $menuChanger         menu alter handler
     * @param MenuConfigHandler     $configHandler       menu config handler
     * @param MenuPermissionHandler $permissionHandler   menu permission handler
     *
     * @return RendererInterface
     * @throws Exception
     */
    public function moveItem(
        MenuRetrieveHandler $menuRetrieveHandler,
        MenuAlterHandler $menuChanger,
        MenuConfigHandler $configHandler,
        MenuPermissionHandler $permissionHandler
    ) {

        $ordering = Request::get('ordering');
        $itemId = Request::get('itemId');
        $parentId = Request::get('parent');
        XeDB::beginTransaction();

        try {
            $item = $menuRetrieveHandler->getItem($itemId);
            $movedItem = $menuChanger->moveItem($item, $parentId);
            $menuChanger->setOrder($item, $ordering);
            $configHandler->moveItemConfig($item, $movedItem);
            $permissionHandler->moveItemPermission($item, $movedItem);

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
