<?php
/**
 * Class MenuController
 *
 * PHP version 5
 *
 * @category  App\Http\Controllers
 * @package   App\Http\Controllers
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace App\Http\Controllers;

use XeFrontend;
use XeStorage;
use XeMedia;
use Exception;
use Illuminate\Contracts\Config\Repository as IlluminateConfig;
use Illuminate\Http\RedirectResponse;
use XePresenter;
use Redirect;
use Input;
use Validator;
use XeDB;
use Xpressengine\Http\Request;
use Xpressengine\Menu\MenuHandler;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Menu\Exceptions\NotFoundModuleException;
use Xpressengine\Menu\ModuleHandler;
use Xpressengine\Permission\PermissionSupport;
use Xpressengine\Presenter\RendererInterface;
use Xpressengine\Site\SiteHandler;
use Xpressengine\Storage\File;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;

/**
 * Class MenuController
 *
 * @category    App
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class MenuController extends Controller
{
    use PermissionSupport;

    /**
     * index
     *
     * @param MenuHandler      $handler     menu handler
     * @param IlluminateConfig $config      laravel config
     * @param SiteHandler      $siteHandler site handler
     *
     * @return RendererInterface
     */
    public function index(MenuHandler $handler, IlluminateConfig $config, SiteHandler $siteHandler)
    {
        $siteKey = $siteHandler->getCurrentSiteKey();
        $menus = $handler->getAll($siteKey);
        $homeMenuId = $siteHandler->getHomeInstanceId();
        $menuMaxDepth = $config->get('xe.menu.maxDepth');

        $transKey = [];
        foreach ($menus as $menu) {
            foreach ($menu->items as $item) {
                $transKey[] = $item->title;
            }
        }

        // 메뉴 어드민 트리 뷰에서 필요한 고유 다국어
        XeFrontend::translation(['xe::addMenu', 'xe::addItem', 'xe::goLink', 'xe::setHome']);
        // 메뉴 타이틀 user 다국어
        XeFrontend::translation($transKey);
        return XePresenter::make('menu.index',
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

        return XePresenter::make(
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
        $desktopTheme = Input::get('theme_desktop');
        $mobileTheme = Input::get('theme_mobile');

        $rules = [
            'menuTitle'=> 'required',
            'theme_desktop' => 'required',
            'theme_mobile' => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            Input::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $validator->messages()]);
        }

        XeDB::beginTransaction();
        try {
            $menu = $handler->create([
                'title' => Input::get('menuTitle'),
                'description' => Input::get('menuDescription'),
                'siteKey' => Input::get('siteKey')
            ]);

            $handler->setMenuTheme($menu, $desktopTheme, $mobileTheme);

            $this->permissionRegisterGrant($menu->getKey(), $handler->getDefaultGrant());

        } catch (Exception $e) {
            XeDB::rollback();
            Input::flash();
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
        $menu = $handler->get($menuId);
        $menuConfig = $handler->getMenuTheme($menu);

        return XePresenter::make('menu.edit', ['menu' => $menu, 'config' => $menuConfig]);
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
        $menu = $handler->get($menuId);

        $desktopTheme = Input::get('theme_desktop');
        $mobileTheme = Input::get('theme_mobile');

        $rules = [
            'menuTitle'=> 'required',
            'theme_desktop' => 'required',
            'theme_mobile' => 'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            Input::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $validator->messages()]);
        }

        XeDB::beginTransaction();

        try {
            $menu->title = Input::get('menuTitle');
            $menu->description = Input::get('menuDescription');

            $handler->put($menu);
            $handler->updateMenuTheme($menu, $desktopTheme, $mobileTheme);

        } catch (Exception $e) {
            XeDB::rollback();
            Input::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::route('settings.menu.index');
    }

    /**
     * permit
     *
     * @param MenuHandler $handler menu handler
     * @param string      $menuId  menu id
     *
     * @return RendererInterface
     */
    public function permit(MenuHandler $handler, $menuId)
    {
        $menu = $handler->get($menuId, 'items');

        return XePresenter::make(
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
            $menu = $handler->get($menuId);

            $handler->remove($menu);
            $this->permissionUnregister($menu->getKey());
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
        $menu = $handler->get($menuId);

        $permArgs = $this->getPermArguments($menu->getKey(), [MenuHandler::ACCESS, MenuHandler::VISIBLE]);

        return XePresenter::make(
            'menu.permission',
            array_merge(['menu' => $menu], $permArgs)
        );
    }

    /**
     * updateMenuPermission
     *
     * @param Request     $request request
     * @param MenuHandler $handler menu handler
     * @param string      $menuId  menu id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function updateMenuPermission(Request $request, MenuHandler $handler, $menuId)
    {
        XeDB::beginTransaction();

        try {
            $menu = $handler->get($menuId);

            $this->permissionRegister($request, $menu->getKey(), [MenuHandler::ACCESS, MenuHandler::VISIBLE]);
        } catch (Exception $e) {
            XeDB::rollback();
            $request->flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::back()->with('alert', ['type' => 'success', 'message' => 'success']);
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
        $parent = Input::get('parent', $menuId);

        return XePresenter::make(
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
        $menu = $handler->get($menuId);
        $menuConfig = $handler->getMenuTheme($menu);

        $parent = Input::get('parent');

        $selectedMenuType = Input::get('selectType');
        if ($selectedMenuType === null) {
            return Redirect::route('settings.menu.select.types', [$menu->id])
                ->with('alert', ['type' => 'warning', 'message' => 'type 을 선택하십시오']);
        }

        $siteKey = $siteHandler->getCurrentSiteKey();
        $menuTypeObj = $moduleHandler->getModuleObject($selectedMenuType);
        $menuMaxDepth = $config->get('xe.menu.maxDepth');

        return XePresenter::make(
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
     * @param string          $menuId  where to store
     *
     * @return $this|RedirectResponse
     * @throws Exception
     */
    public function storeItem(MenuHandler $handler, $menuId)
    {
        XeDB::beginTransaction();

        $menu = $handler->get($menuId);

        try {
            $inputs = Input::except(['_token', 'theme_desktop', 'theme_mobile']);
            $parentThemeMode = Input::get('parentTheme', false);
            if ($parentThemeMode === false) {
                $desktopTheme = Input::get('theme_desktop');
                $mobileTheme = Input::get('theme_mobile');
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
                'activated' => isset($itemInput['itemActivated']) ? $itemInput['itemActivated'] : 0,
                'parentId' => $itemInput['parent']
            ], $menuTypeInput);

            // link image 등록
            $this->registerItemImage($item, 'basicImage');
            $this->registerItemImage($item, 'hoverImage');
            $this->registerItemImage($item, 'selectedImage');
            $this->registerItemImage($item, 'mBasicImage');
            $this->registerItemImage($item, 'mHoverImage');
            $this->registerItemImage($item, 'mSelectedImage');

            $handler->putItem($item, $menuTypeInput);

            $handler->setMenuItemTheme($item, $desktopTheme, $mobileTheme);
            $this->permissionRegisterGrant($handler->permKeyString($item), null, $menu->siteKey);

        } catch (Exception $e) {
            XeDB::rollback();
            Input::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::route('settings.menu.index');
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
        $item = $handler->getItem($itemId, [
            'basicImage', 'hoverImage', 'selectedImage',
            'mBasicImage', 'mHoverImage', 'mSelectedImage'
        ]);
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

        return XePresenter::make(
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
     * @param string          $menuId  menu id
     * @param string          $itemId  item id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function updateItem(MenuHandler $handler, $menuId, $itemId)
    {

        XeDB::beginTransaction();

        try {
            $inputs = Input::except(['_token', 'theme_desktop', 'theme_mobile']);

            $item = $handler->getItem($itemId);
            $menu = $item->menu;
            if ($menu->getKey() !== $menuId) {
                throw new InvalidArgumentHttpException(400);
            }

            $parentThemeMode = Input::get('parentTheme', false);
            if ($parentThemeMode === false) {
                $desktopTheme = Input::get('theme_desktop');
                $mobileTheme = Input::get('theme_mobile');
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

            // link image 등록
            $this->registerItemImage($item, 'basicImage');
            $this->registerItemImage($item, 'hoverImage');
            $this->registerItemImage($item, 'selectedImage');
            $this->registerItemImage($item, 'mBasicImage');
            $this->registerItemImage($item, 'mHoverImage');
            $this->registerItemImage($item, 'mSelectedImage');

            $handler->putItem($item, $menuTypeInput);

            $handler->updateMenuItemTheme($item, $desktopTheme, $mobileTheme);

        } catch (Exception $e) {
            XeDB::rollback();
            Input::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return Redirect::route('settings.menu.index');

    }

    protected function registerItemImage(MenuItem $item, $name)
    {
        $columnKeyName = $name . 'Id';

        if ($uploadImg = Input::file($name)) {
            $image = XeMedia::make(XeStorage::upload($uploadImg, 'public/menu'));
            XeStorage::bind($item->getKey(), $image);

            if ($item->{$columnKeyName} !== null) {
                XeStorage::unBind($item->getKey(), $item->{$name});
            }

            $item->{$columnKeyName} = $image->getKey();
        } else {
            $key = 'remove' . ucfirst($name);
            if (Input::get($key) && $item->{$columnKeyName} !== null) {
                XeStorage::unBind($item->getKey(), $item->{$name});
                $item->{$columnKeyName} = null;
            }
        }
    }

    /**
     * permitItem
     *
     * @param MenuHandler   $handler menu handler
     * @param ModuleHandler $modules module handler
     * @param string        $menuId  menu id
     * @param string        $itemId  item id
     *
     * @return RendererInterface
     */
    public function permitItem(MenuHandler $handler, ModuleHandler $modules, $menuId, $itemId)
    {
        $item = $handler->getItem($itemId);
        $menu = $item->menu;
        if ($menu->getKey() !== $menuId) {
            throw new InvalidArgumentHttpException(400);
        }

        $menuType = $modules->getModuleObject($item->type);

        return XePresenter::make(
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
     * @param string          $menuId  menu id
     * @param string          $itemId  item id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroyItem(MenuHandler $handler, $menuId, $itemId)
    {
        $item = $handler->getItem($itemId);
        $menu = $item->menu;
        if ($menu->getKey() !== $menuId) {
            throw new InvalidArgumentHttpException(400);
        }

        XeDB::beginTransaction();
        try {
            $handler->removeItem($item);

            foreach (File::getByFileable($item->getKey()) as $file) {
                XeStorage::unBind($item->getKey(), $file);
            }

            $handler->deleteMenuItemTheme($item);
            $this->permissionUnregister($handler->permKeyString($item));

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
        $item = $handler->getItem($itemId);
        $menu = $item->menu;
        if ($menu->getKey() !== $menuId) {
            throw new InvalidArgumentHttpException(400);
        }

        try {
            $menuType = $modules->getModuleObject($item->type);
        } catch (NotFoundModuleException $e) {
            $menuType = null;
        }

        $permArgs = $this->getPermArguments(
            $handler->permKeyString($item),
            [MenuHandler::ACCESS, MenuHandler::VISIBLE]
        );

        return XePresenter::make(
            'menu.itemPermission',
            array_merge([
                'menu' => $menu,
                'item' => $item,
                'menuType' => $menuType,
            ], $permArgs)
        );
    }

    /**
     * updateItemPermission
     *
     * @param Request     $request request
     * @param MenuHandler $handler menu handler
     * @param string      $menuId  menu id
     * @param string      $itemId  menu item id
     *
     * @return RedirectResponse
     */
    public function updateItemPermission(
        Request $request,
        MenuHandler $handler,
        $menuId,
        $itemId
    ) {
        XeDB::beginTransaction();

        try {
            $item = $handler->getItem($itemId);
            $menu = $item->menu;
            if ($menu->getKey() !== $menuId) {
                throw new InvalidArgumentHttpException(400);
            }

            $this->permissionRegister(
                $request,
                $handler->permKeyString($item),
                [MenuHandler::ACCESS, MenuHandler::VISIBLE]
            );


        } catch (Exception $e) {
            XeDB::rollback();
            Input::flash();
            return Redirect::back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

		return Redirect::back()->with('alert', ['type' => 'success', 'message' => 'success']);
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
        $ordering = Input::get('ordering');
        $itemId = Input::get('itemId');
        $parentId = Input::get('parent');

        XeDB::beginTransaction();

        try {

            $item = $handler->getItem($itemId);
            /** @var Menu $menu */
            if (!$parent = $handler->getItem($parentId)) {
                $menu = $handler->get($parentId);
            } else {
                $menu = $parent->menu;
            }
            $old = clone $item;
            // 이동되기 전 상태의 객체를 구성하기 위해 relation 을 사전에 load
            $old->ancestors;

            $item = $handler->moveItem($menu, $item, $parent);
            $handler->setOrder($item, $ordering);

            $handler->moveItemConfig($old, $item);

            $toKey = $handler->permKeyString($item);
            $toKey = substr($toKey, 0, strrpos($toKey, '.'));

            $this->permissionMove($handler->permKeyString($old), $toKey);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }

        XeDB::commit();

        return XePresenter::makeApi(Input::all());
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
            'basicImage',
            'hoverImage',
            'selectedImage',
        ];

        return [
            array_only($inputs, $itemInputKeys),
            array_except($inputs, $itemInputKeys),
        ];
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
        $itemId = Input::get('itemId');

        $siteHandler->setHomeInstanceId($itemId);

        return XePresenter::makeApi([$itemId]);
    }
}
