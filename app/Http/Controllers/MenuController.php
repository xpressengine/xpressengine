<?php
/**
 * MenuController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
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
use Xpressengine\Presenter\Presentable;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;

/**
 * Class MenuController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MenuController extends Controller
{
    use PermissionSupport;

    /**
     * Show menu
     *
     * @return Presentable
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
     * Show the create form for the menu.
     *
     * @return Presentable
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
     * Store new menu.
     *
     * @param Request $request request
     * @return RedirectResponse
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
                'site_key' => $request->get('siteKey')
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
     * Show the edit form for the menu.
     *
     * @param string $menuId menu id
     * @return Presentable
     */
    public function edit($menuId)
    {
        $menu = XeMenu::menus()->find($menuId);
        $menuConfig = XeMenu::getMenuTheme($menu);

        return XePresenter::make('menu.edit', ['menu' => $menu, 'config' => $menuConfig]);
    }

    /**
     * Update a menu.
     *
     * @param Request $request request
     * @param string  $menuId  menu id
     * @return RedirectResponse
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
     * Show the permit form for the menu.
     *
     * @param string $menuId menu id
     * @return Presentable
     */
    public function permit($menuId)
    {
        $menu = XeMenu::menus()->find($menuId);

        return XePresenter::make('menu.delete', ['menu' => $menu]);
    }


    /**
     * Delete a menu.
     *
     * @param string $menuId menu id
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
            ->with('alert', ['type' => 'success', 'message' => xe_trans('xe::deleted')]);

    }

    /**
     * Show the edit form for the menu permission.
     *
     * @param string $menuId menu id
     * @return Presentable
     */
    public function editMenuPermission($menuId)
    {
        $menu = XeMenu::menus()->find($menuId);

        $permArgs = $this->getPermArguments($menu->getKey(), [MenuHandler::ACCESS, MenuHandler::VISIBLE]);

        return XePresenter::make('menu.permission', array_merge(['menu' => $menu], $permArgs));
    }

    /**
     * Update menu permission
     *
     * @param Request $request request
     * @param string  $menuId  menu id
     * @return RedirectResponse
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

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * Show the type select form for the menu item.
     *
     * @param Request $request request
     * @param string  $menuId  menu id
     * @return Presentable
     */
    public function selectType(Request $request, $menuId)
    {
        $parent = $request->get('parent', $menuId);

        return XePresenter::make('menu.selectItemType', [
            'menuId' => $menuId,
            'parent' => $parent
        ]);
    }

    /**
     * Show the create from for the menu item.
     *
     * @param Request $request request
     * @param string  $menuId  menu id
     * @return Presentable
     */
    public function createItem(Request $request, $menuId)
    {
        $this->validate($request, ['selectType' => 'required']);

        $menu = XeMenu::menus()->find($menuId);
        $menuConfig = XeMenu::getMenuTheme($menu);

        $parent = $request->get('parent');
        $selectedMenuType = $request->get('selectType');

        $siteKey = XeSite::getCurrentSiteKey();
        $menuTypeObj = XeMenu::getModuleHandler()->getModuleObject($selectedMenuType);
        $menuMaxDepth = config('xe.menu.maxDepth');

        return XePresenter::make('menu.createItem', [
            'menu' => $menu,
            'menuType' => $menuTypeObj,
            'siteKey' => $siteKey,
            'maxDepth' => $menuMaxDepth,
            'parent' => $parent,
            'selectedType' => $selectedMenuType,
            'menuConfig' => $menuConfig
        ]);
    }

    /**
     * Store a new menu item.
     *
     * @param Request $request request
     * @param string  $menuId  where to store
     * @return RedirectResponse
     */
    public function storeItem(Request $request, $menuId)
    {
        $this->validate($request, [
            'itemUrl'=> 'required',
            'itemTitle' => 'langRequired',
        ]);

        $inputs = $request->except(['_token', 'theme_desktop', 'theme_mobile']);
        $parentThemeMode = $request->get('parentTheme', false);
        if ($parentThemeMode === false) {
            $desktopTheme = $request->get('theme_desktop');
            $mobileTheme = $request->get('theme_mobile');
        } else {
            $desktopTheme = null;
            $mobileTheme = null;
        }

        $menu = XeMenu::menus()->find($menuId);

        list($itemInput, $menuTypeInput) = $this->inputClassify($inputs);
        $url = $this->urlAvailable(trim($itemInput['itemUrl'], " \t\n\r\0\x0B/"));

        $menuType = XeMenu::getModuleHandler()->getModuleObject($itemInput['selectedType']);
        if ($menuType::isRouteAble() && XeMenu::items()->query()->where('url', $url)->exists()) {
            return back()->with('alert', ['type' => 'danger', 'message' => xe_trans('xe::menuItemUrlAlreadyExists')]);
        }

        XeDB::beginTransaction();
        try {
            $itemInput['parent'] = $itemInput['parent'] === $menu->getKey() ? null : $itemInput['parent'];

            $item = XeMenu::createItem($menu, [
                'title' => $itemInput['itemTitle'],
                'url' => $url,
                'description' => $itemInput['itemDescription'],
                'target' => $itemInput['itemTarget'],
                'type' => $itemInput['selectedType'],
                'ordering' => $itemInput['itemOrdering'],
                'activated' => isset($itemInput['itemActivated']) ? $itemInput['itemActivated'] : 0,
                'parent_id' => $itemInput['parent']
            ], $menuTypeInput);

            // link image 등록
            XeMenu::updateItem($item, [
                $this->getItemImageKeyName('menuImage') => $this->registerItemImage($request, $item, 'menuImage'),
                $this->getItemImageKeyName('basicImage') => $this->registerItemImage($request, $item, 'basicImage'),
                $this->getItemImageKeyName('hoverImage') => $this->registerItemImage($request, $item, 'hoverImage'),
                $this->getItemImageKeyName('selectedImage') => $this->registerItemImage($request, $item, 'selectedImage'),
                $this->getItemImageKeyName('mBasicImage') => $this->registerItemImage($request, $item, 'mBasicImage'),
                $this->getItemImageKeyName('mHoverImage') => $this->registerItemImage($request, $item, 'mHoverImage'),
                $this->getItemImageKeyName('mSelectedImage') => $this->registerItemImage($request, $item, 'mSelectedImage')
            ], $menuTypeInput);

            XeMenu::setMenuItemTheme($item, $desktopTheme, $mobileTheme);
            $this->permissionRegisterGrant(XeMenu::permKeyString($item), null, $menu->site_key);
        } catch (Exception $e) {
            XeDB::rollback();
            $request->flash();
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return redirect()->route('settings.menu.index')
            ->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * Show the edit form for the menu item.
     *
     * @param string $menuId menu id
     * @param string $itemId item id
     * @return Presentable
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

        return XePresenter::make('menu.editItem', [
            'menu' => $menu,
            'item' => $item,
            'homeId' => $homeId,
            'menuType' => $menuType,
            'parentThemeMode' => $parentThemeMode,
            'itemConfig' => $itemConfig,
            'parentConfig' => $parentConfig
        ]);
    }

    /**
     * Update a menu item.
     *
     * @param Request $request request
     * @param string  $menuId  menu id
     * @param string  $itemId  item id
     * @return RedirectResponse
     */
    public function updateItem(Request $request, $menuId, $itemId)
    {
        $this->validate($request, [
            'itemUrl'=> 'required',
            'itemTitle' => 'langRequired',
        ]);

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
        $url = $this->urlAvailable(trim($itemInput['itemUrl'], " \t\n\r\0\x0B/"));

        $menuType = XeMenu::getModuleHandler()->getModuleObject($item->type);
        if ($menuType::isRouteAble() && XeMenu::items()->query()->where('url', $url)->whereKeyNot($item->getKey())->exists()) {
            return back()->with('alert', ['type' => 'danger', 'message' => xe_trans('xe::menuItemUrlAlreadyExists')]);
        }

        XeDB::beginTransaction();
        try {

            XeMenu::updateItem($item, [
                'title' => $itemInput['itemTitle'],
                'url' => $url,
                'description' => $itemInput['itemDescription'],
                'target' => $itemInput['itemTarget'],
                'ordering' => $itemInput['itemOrdering'],
                'activated' => array_get($itemInput, 'itemActivated', '0'),
                $this->getItemImageKeyName('menuImage') => $this->registerItemImage($request, $item, 'menuImage'),
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

        return redirect()->route('settings.menu.index')
            ->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);

    }

    /**
     * Determine if the given keyword is available for url
     *
     * @param string $keyword url name
     * @return string
     */
    protected function urlAvailable($keyword)
    {
        $reserved = array_merge(
            array_values(config('xe.routing')),
            array_values(config('xe.lang.locales'))
        );

        if (in_array($keyword, $reserved)) {
            throw new HttpException(422, xe_trans('xe::unavailableUrl'));
        }

        return $keyword;
    }

    /**
     * Returns key string for the image of menu item.
     *
     * @param string $name image field name
     * @return string
     */
    protected function getItemImageKeyName($name)
    {
        return snake_case($name . 'Id');
    }

    /**
     * Register a image of menu item.
     *
     * @param Request  $request request
     * @param MenuItem $item    menu item
     * @param string   $name    image field name
     * @return string|null
     */
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

        if ($request->get($name) === '__delete_file__' && !empty($item->{$columnKeyName})) {
            XeStorage::unBind($item->getKey(), $item->{$name}, true);

            return null;
        }

        return $item->{$columnKeyName};
    }

    /**
     * Show the permit form for the menu item.
     *
     * @param string $menuId menu id
     * @param string $itemId item id
     * @return Presentable
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
     * Delete a menu item.
     *
     * @param string $menuId  menu id
     * @param string $itemId  item id
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

        if ($item->getKey() === XeSite::getHomeInstanceId()) {
            throw new HttpException(422, xe_trans('xe::unableDeleteHomeMenuItem'));
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
            ->with('alert', ['type' => 'success', 'message' => xe_trans('xe::deleted')]);
    }

    /**
     * Show the edit form for the menu item permission.
     *
     * @param string $menuId menu id
     * @param string $itemId item id
     * @return Presentable
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

        return XePresenter::make('menu.itemPermission', array_merge([
            'menu' => $menu,
            'item' => $item,
            'menuType' => $menuType,
        ], $permArgs));
    }

    /**
     * Update a menu item permission
     *
     * @param Request $request request
     * @param string  $menuId  menu id
     * @param string  $itemId  menu item id
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

		return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * Move a menu item to another position.
     *
     * @param Request $request request
     * @return Presentable
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

    /**
     * Classify given inputs.
     *
     * @param array $inputs inputs
     * @return array
     */
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
     * Set given menu item to home.
     *
     * @param Request $request request
     * @return Presentable
     *
     */
    public function setHome(Request $request)
    {
        $this->validate($request, ['itemId' => 'required']);

        $itemId = $request->get('itemId');

        XeSite::setHomeInstanceId($itemId);

        return XePresenter::makeApi([$itemId]);
    }
}
