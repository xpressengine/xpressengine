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

use Validator;
use Exception;
use Illuminate\Http\RedirectResponse;
use XeDB;
use XeFrontend;
use XeStorage;
use XeMedia;
use XeMenu;
use XeSite;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\Menu\MenuHandler;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Menu\Exceptions\NotFoundModuleException;
use Xpressengine\Permission\PermissionSupport;
use Xpressengine\Presenter\RendererInterface;
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
     * @return RendererInterface
     */
    public function index()
    {
        $siteKey = XeSite::getCurrentSiteKey();
        $menus = XeMenu::menus()->fetchBySiteKey($siteKey, 'items')->getDictionary();
        $homeMenuId = XeSite::getHomeInstanceId();
        $menuMaxDepth = config('xe.menu.maxDepth');

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
     * @return RendererInterface
     */
    public function create()
    {
        $siteKey = XeSite::getCurrentSiteKey();

        return XePresenter::make(
            'menu.create',
            ['siteKey' => $siteKey]
        );
    }

    /**
     * store
     * 새로운 메뉴 생성을 처리하는 메소드
     *
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $desktopTheme = $request->get('theme_desktop');
        $mobileTheme = $request->get('theme_mobile');

        $rules = [
            'menuTitle'=> 'required',
            'theme_desktop' => 'required',
            'theme_mobile' => 'required',
        ];

        $this->validate($request, $rules);

        XeDB::beginTransaction();
        try {
            $menu = XeMenu::createMenu([
                'title' => $request->get('menuTitle'),
                'description' => $request->get('menuDescription'),
                'siteKey' => $request->get('siteKey')
            ]);

            XeMenu::setMenuTheme($menu, $desktopTheme, $mobileTheme);

            $this->permissionRegisterGrant($menu->getKey(), XeMenu::getDefaultGrant());

        } catch (Exception $e) {
            XeDB::rollback();
            $request->flash();
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return redirect()->route('settings.menu.index');
    }

    /**
     * edit
     *
     * @param string      $menuId  string menu id
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function edit($menuId)
    {
        $menu = XeMenu::menus()->find($menuId);
        $menuConfig = XeMenu::getMenuTheme($menu);

        return XePresenter::make('menu.edit', ['menu' => $menu, 'config' => $menuConfig]);
    }

    /**
     * update
     *
     * @param Request $request
     * @param string  $menuId  to update menu entity object id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(Request $request, $menuId)
    {
        $menu = XeMenu::menus()->find($menuId);

        $desktopTheme = $request->get('theme_desktop');
        $mobileTheme = $request->get('theme_mobile');

        $rules = [
            'menuTitle'=> 'required',
            'theme_desktop' => 'required',
            'theme_mobile' => 'required',
        ];

        $this->validate($request, $rules);

        XeDB::beginTransaction();

        try {
            XeMenu::updateMenu($menu, [
                'title' => $request->get('menuTitle'),
                'description' => $request->get('menuDescription'),
            ]);
            XeMenu::updateMenuTheme($menu, $desktopTheme, $mobileTheme);

        } catch (Exception $e) {
            XeDB::rollback();
            $request->flash();
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return redirect()->route('settings.menu.index');
    }

    /**
     * permit
     *
     * @param string      $menuId  menu id
     *
     * @return RendererInterface
     */
    public function permit($menuId)
    {
        $menu = XeMenu::menus()->find($menuId);

        return XePresenter::make(
            'menu.delete',
            ['menu' => $menu]
        );
    }


    /**
     * destroy
     *
     * @param string      $menuId  to delete menu entity object id
     *
     * @return RedirectResponse
     */
    public function destroy($menuId)
    {
        XeDB::beginTransaction();

        try {
            $menu = XeMenu::menus()->find($menuId);

            XeMenu::deleteMenu($menu);
            $this->permissionUnregister($menu->getKey());
        } catch (Exception $e) {
            XeDB::rollback();
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();
        return redirect()->route('settings.menu.index')
            ->with('alert', ['type' => 'success', 'message' => 'Menu deleted']);

    }

    /**
     * editMenuPermission
     *
     * @param string      $menuId menu id
     *
     * @return RendererInterface
     */
    public function editMenuPermission($menuId)
    {
        $menu = XeMenu::menus()->find($menuId);

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
     * @param string      $menuId  menu id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function updateMenuPermission(Request $request, $menuId)
    {
        XeDB::beginTransaction();

        try {
            $menu = XeMenu::menus()->find($menuId);

            $this->permissionRegister($request, $menu->getKey(), [MenuHandler::ACCESS, MenuHandler::VISIBLE]);
        } catch (Exception $e) {
            XeDB::rollback();
            $request->flash();
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => 'success']);
    }

    /**
     * selectType
     *
     * @param Request $request
     * @param string  $menuId menu id
     *
     * @return RendererInterface
     */
    public function selectType(Request $request, $menuId)
    {
        $parent = $request->get('parent', $menuId);

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
     * @param Request       $request
     * @param string        $menuId        menu id
     *
     * @return RendererInterface
     */
    public function createItem(Request $request, $menuId)
    {
        $menu = XeMenu::menus()->find($menuId);
        $menuConfig = XeMenu::getMenuTheme($menu);

        $parent = $request->get('parent');

        $selectedMenuType = $request->get('selectType');
        if ($selectedMenuType === null) {
            return redirect()->route('settings.menu.select.types', [$menu->id])
                ->with('alert', ['type' => 'warning', 'message' => 'type 을 선택하십시오']);
        }

        $siteKey = XeSite::getCurrentSiteKey();
        $menuTypeObj = XeMenu::getModuleHandler()->getModuleObject($selectedMenuType);
        $menuMaxDepth = config('xe.menu.maxDepth');

        return XePresenter::make(
            'menu.createItem',
            [
                'menu' => $menu,
                'menuType' => $menuTypeObj,
                'siteKey' => $siteKey,
                'maxDepth' => $menuMaxDepth,
                'parent' => $parent,
                'selectedType' => $selectedMenuType,
                'menuConfig' => $menuConfig
            ]
        );
    }

    /**
     * storeItem
     *
     * @param Request $request
     * @param string  $menuId  where to store
     *
     * @return $this|RedirectResponse
     * @throws Exception
     */
    public function storeItem(Request $request, $menuId)
    {
        XeDB::beginTransaction();

        $menu = XeMenu::menus()->find($menuId);

        try {
            $inputs = $request->except(['_token', 'theme_desktop', 'theme_mobile']);
            $parentThemeMode = $request->get('parentTheme', false);
            if ($parentThemeMode === false) {
                $desktopTheme = $request->get('theme_desktop');
                $mobileTheme = $request->get('theme_mobile');
            } else {
                $desktopTheme = null;
                $mobileTheme = null;
            }

            list($itemInput, $menuTypeInput) = $this->inputClassify($inputs);
            $itemInput['parent'] = $itemInput['parent'] === $menu->getKey() ? null : $itemInput['parent'];
            $item = XeMenu::createItem($menu, [
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
            XeMenu::updateItem($item, [
                $this->getItemImageKeyName('basicImage') => $this->registerItemImage($request, $item, 'basicImage'),
                $this->getItemImageKeyName('hoverImage') => $this->registerItemImage($request, $item, 'hoverImage'),
                $this->getItemImageKeyName('selectedImage') => $this->registerItemImage($request, $item, 'selectedImage'),
                $this->getItemImageKeyName('mBasicImage') => $this->registerItemImage($request, $item, 'mBasicImage'),
                $this->getItemImageKeyName('mHoverImage') => $this->registerItemImage($request, $item, 'mHoverImage'),
                $this->getItemImageKeyName('mSelectedImage') => $this->registerItemImage($request, $item, 'mSelectedImage')
            ], $menuTypeInput);

            XeMenu::setMenuItemTheme($item, $desktopTheme, $mobileTheme);
            $this->permissionRegisterGrant(XeMenu::permKeyString($item), null, $menu->siteKey);

        } catch (Exception $e) {
            XeDB::rollback();
            $request->flash();
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return redirect()->route('settings.menu.index');
    }

    /**
     * editItem
     * 선택된 메뉴의 아이템을 view & edit 페이지 구성
     *
     * @param string        $menuId  menu id
     * @param string        $itemId  item id
     *
     * @return RendererInterface
     */
    public function editItem($menuId, $itemId)
    {
        $item = XeMenu::items()->find($itemId);
        $menu = $item->menu;
        if ($menu->getKey() !== $menuId) {
            throw new InvalidArgumentHttpException(400);
        }

        try {
            $menuType = XeMenu::getModuleHandler()->getModuleObject($item->type);
        } catch (NotFoundModuleException $e) {
            $menuType = null;
        }

        $homeId = XeSite::getHomeInstanceId();

        $itemConfig = XeMenu::getMenuItemTheme($item);
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
     * @param Request $request
     * @param string  $menuId  menu id
     * @param string  $itemId  item id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function updateItem(Request $request, $menuId, $itemId)
    {
        XeDB::beginTransaction();

        try {
            $inputs = $request->except(['_token', 'theme_desktop', 'theme_mobile']);

            $item = XeMenu::items()->find($itemId);
            $menu = $item->menu;
            if ($menu->getKey() !== $menuId) {
                throw new InvalidArgumentHttpException(400);
            }

            $parentThemeMode = $request->get('parentTheme', false);
            if ($parentThemeMode === false) {
                $desktopTheme = $request->get('theme_desktop');
                $mobileTheme = $request->get('theme_mobile');
            } else {
                $desktopTheme = null;
                $mobileTheme = null;
            }

            list($itemInput, $menuTypeInput) = $this->inputClassify($inputs);

            XeMenu::updateItem($item, [
                'title' => $itemInput['itemTitle'],
                'url' => $itemInput['itemUrl'],
                'description' => $itemInput['itemDescription'],
                'target' => $itemInput['itemTarget'],
                'ordering' => $itemInput['itemOrdering'],
                'activated' => array_get($itemInput, 'itemActivated', '0'),
                $this->getItemImageKeyName('basicImage') => $this->registerItemImage($request, $item, 'basicImage'),
                $this->getItemImageKeyName('hoverImage') => $this->registerItemImage($request, $item, 'hoverImage'),
                $this->getItemImageKeyName('selectedImage') => $this->registerItemImage($request, $item, 'selectedImage'),
                $this->getItemImageKeyName('mBasicImage') => $this->registerItemImage($request, $item, 'mBasicImage'),
                $this->getItemImageKeyName('mHoverImage') => $this->registerItemImage($request, $item, 'mHoverImage'),
                $this->getItemImageKeyName('mSelectedImage') => $this->registerItemImage($request, $item, 'mSelectedImage')
            ], $menuTypeInput);

            XeMenu::updateMenuItemTheme($item, $desktopTheme, $mobileTheme);

        } catch (Exception $e) {
            XeDB::rollback();
            $request->flash();
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return redirect()->route('settings.menu.index');

    }

    protected function getItemImageKeyName($name)
    {
        return $name . 'Id';
    }

    protected function registerItemImage(Request $request, MenuItem $item, $name)
    {
        $columnKeyName = $this->getItemImageKeyName($name);

        if ($uploadImg = $request->file($name)) {
            $image = XeMedia::make(XeStorage::upload($uploadImg, 'public/menu'));
            XeStorage::bind($item->getKey(), $image);

            if (!empty($item->{$columnKeyName})) {
                XeStorage::unBind($item->getKey(), $item->{$name}, true);
            }

            return $image->getKey();
        }

        $key = 'remove' . ucfirst($name);
        if ($request->get($key) && !empty($item->{$columnKeyName})) {
            XeStorage::unBind($item->getKey(), $item->{$name}, true);

            return null;
        }

        return $item->{$columnKeyName};
    }

    /**
     * permitItem
     *
     * @param string $menuId menu id
     * @param string $itemId item id
     *
     * @return RendererInterface
     */
    public function permitItem($menuId, $itemId)
    {
        $item = XeMenu::items()->find($itemId);
        $menu = $item->menu;
        if ($menu->getKey() !== $menuId) {
            throw new InvalidArgumentHttpException(400);
        }

        $menuType = XeMenu::getModuleHandler()->getModuleObject($item->type);

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
     * @param string          $menuId  menu id
     * @param string          $itemId  item id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroyItem($menuId, $itemId)
    {
        $item = XeMenu::items()->find($itemId);
        $menu = $item->menu;
        if ($menu->getKey() !== $menuId) {
            throw new InvalidArgumentHttpException(400);
        }

        XeDB::beginTransaction();
        try {
            XeMenu::deleteItem($item);

            foreach (XeStorage::fetchByFileable($item->getKey()) as $file) {
                XeStorage::unBind($item->getKey(), $file, true);
            }

            XeMenu::deleteMenuItemTheme($item);
            $this->permissionUnregister(XeMenu::permKeyString($item));

        } catch (Exception $e) {
            XeDB::rollback();
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();
        return redirect()->route('settings.menu.index')
            ->with('alert', ['type' => 'success', 'message' => 'MenuItem deleted']);
    }

    /**
     * editItemPermission
     * 선택된 메뉴의 아이템을 permission 을 수정하는 페이지 구성
     *
     * @param string        $menuId  menu id
     * @param string        $itemId  item id
     *
     * @return RendererInterface
     */
    public function editItemPermission($menuId, $itemId)
    {
        $item = XeMenu::items()->find($itemId);
        $menu = $item->menu;
        if ($menu->getKey() !== $menuId) {
            throw new InvalidArgumentHttpException(400);
        }

        try {
            $menuType = XeMenu::getModuleHandler()->getModuleObject($item->type);
        } catch (NotFoundModuleException $e) {
            $menuType = null;
        }

        $permArgs = $this->getPermArguments(
            XeMenu::permKeyString($item),
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
     * @param string      $menuId  menu id
     * @param string      $itemId  menu item id
     *
     * @return RedirectResponse
     */
    public function updateItemPermission(Request $request, $menuId, $itemId)
    {
        XeDB::beginTransaction();

        try {
            $item = XeMenu::items()->find($itemId);
            $menu = $item->menu;
            if ($menu->getKey() !== $menuId) {
                throw new InvalidArgumentHttpException(400);
            }

            $this->permissionRegister(
                $request,
                XeMenu::permKeyString($item),
                [MenuHandler::ACCESS, MenuHandler::VISIBLE]
            );


        } catch (Exception $e) {
            XeDB::rollback();
            $request->flash();
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

		return redirect()->back()->with('alert', ['type' => 'success', 'message' => 'success']);
    }

    /**
     * moveItem
     *
     * @param Request $request
     * @return RendererInterface
     * @throws Exception
     */
    public function moveItem(Request $request)
    {
        $ordering = $request->get('ordering');
        $itemId = $request->get('itemId');
        $parentId = $request->get('parent');

        XeDB::beginTransaction();

        try {

            $item = XeMenu::items()->find($itemId);
            /** @var Menu $menu */
            if (!$parent = XeMenu::items()->find($parentId)) {
                $menu = XeMenu::menus()->find($parentId);
            } else {
                $menu = $parent->menu;
            }
            $old = clone $item;
            // 이동되기 전 상태의 객체를 구성하기 위해 relation 을 사전에 load
            $old->ancestors;

            $item = XeMenu::moveItem($menu, $item, $parent);
            XeMenu::setOrder($item, $ordering);

            XeMenu::moveItemConfig($old, $item);

            $toKey = XeMenu::permKeyString($item);
            $toKey = substr($toKey, 0, strrpos($toKey, '.'));

            $this->permissionMove(XeMenu::permKeyString($old), $toKey);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }

        XeDB::commit();

        return XePresenter::makeApi($request->all());
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
     * @param Request $request
     * @return RendererInterface
     *
     */
    public function setHome(Request $request)
    {
        $itemId = $request->get('itemId');

        XeSite::setHomeInstanceId($itemId);

        return XePresenter::makeApi([$itemId]);
    }
}
