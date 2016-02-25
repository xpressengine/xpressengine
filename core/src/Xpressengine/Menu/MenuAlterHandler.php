<?php
/**
 * MenuAlterHandler
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

use Xpressengine\Menu\Exceptions\CanNotDeleteMenuEntityHaveChildException;
use Xpressengine\Menu\Exceptions\CanNotDeleteMenuItemHaveChildException;
use Xpressengine\Module\ModuleHandler;
use Xpressengine\Routing\InstanceRoute;
use Xpressengine\Routing\InstanceRouteHandler;
use Xpressengine\Routing\Exceptions\UnusableUrlException;
use Xpressengine\Support\Tree\TreeCollection;

/**
 * MenuAlterHandler
 * Menu 및 MenuItem 의 추가, 삭제 및 갱신 과 관련된 사항들을 처리하며
 * MenuRetrieveHandler 와 같이 메뉴를 처리하는 역활을 함
 *
 * ## app binding
 * * xe.menu.changer 으로 바인딩 되어 있음
 * * MenuRetrieveHandler 와는 다르게 변경과 관련된 역활을 하며 Facade 는 제공하지 않음
 *
 * ## 생성자에서 필요한 항목들
 * * MenuRepositoryInterface $menuRepository - 정보를 가져오기 위한 저장소 인터페이스
 * * ModuleHandler $typeHandler - menuType 과 관련된 다양한 작업들을 수행하기 위한 핸들러
 * * InstanceRouteHandler $routeHandler - menuType 이 routeAble 인 경우에 instance 와 관련된 처리를 진행하는 핸들러
 * * MenuCacheHandler $cacheHandler - 정보가 변경될때 캐시를 갱신하기 위한 핸들러
 *
 * ## 사용법
 *
 * ### Menu 등록
 * ```php
 * $menuChanger->addMenu(
 *   ['menuId' => 'id', 'menuTitle' => 'title', 'menuDescription' => 'description, 'site' => 'default']
 * );
 * ```
 *
 * ### Menu 수정
 *
 * * MenuEntity 와 수정할 입력값들을 인자로 전달함
 * * Menu 의 ID 와 SiteKey 는 수정할 수 없으므로, title 과 description 만 수정 가능.
 *
 * ```php
 * MenuEntity $menu
 * $menuChanger->putMenu($menu, ['menuTitle' => 'modifiedTitle', 'menuDescription' => 'modifiedDescription']);
 * ```
 *
 * ### Menu 삭제
 *
 * * 삭제시에는 MenuId 를 식별자로 하여 삭제를 수행함
 * * 하위에 연결되어 있는 MenuItem 이 있는경우 삭제할 수 없는 제약사항이 있음
 *
 * ```php
 * $menuChanger->removeMenu($menuId);
 * ```
 *
 * ### MenuItem 생성
 *
 * * 새로운 MenuItem 생성
 * * 생성할 MenuItem 이 소속될 MenuEntity 의 ID 와 입력값 배열을 인자로 전달
 * * 전달할 입력값 배열은 다음과 같은 항목들이 필요함
 *
 * - itemId : 고유한 ID , MenuEntity 또는 다른 ItemId 와 중복될 수 없음
 * - parentItem : 상위에 연결될 Item 또는 MenuEntity 의 ID
 * - itemTitle : 사용자에게 표시될 이름
 * - itemUrl : url
 * - itemDescription : 설명
 * - itemTarget : 이 MenuItem 을 클릭했을 때의 링크 옵션(새창. 현재창...)
 * - selectedType : MenuItem 이 어떤 모듈의 인스턴스인지 판별하는 TypeId
 * - itemOrdering : MenuItem 의 정렬 순번
 * - itemActivated : MenuItem 의 활성화 여부
 *
 * * 새로운 아이템이 생성될 때에는 해당 type(target) 에 따라서 새로운 InstanceRoute 를 생성해주게 된다
 * 이때에는 MenuItem 을 생성하기 위한 input array 를 제외한 나머지 정보들이 사용되며 추가적으로
 * SiteKey 가 필요로 하다
 *
 *
 * ```php
 * $menuChanger->addItem(MenuEntity $menu, $inputs);
 * ```
 *
 * ### MenuItem 수정
 *
 * * 기존의 MenuItem 의 정보 변경
 * * 수정할 MenuItem 의 인스턴스와 함께 변경할 정보를 담고 있는 배열을 인자로 전달
 * * 전달할 입력값 배열은 다음과 같은 항목들이 필요함
 *
 * - itemTitle : 수정할 이름
 * - itemUrl : 변경할 URL
 * - itemDescription : 설명
 * - itemTarget : 클릭시 옵션
 * - itemOrdering : 정렬 순번
 * - itemActivated : 활성화 여부
 *
 * ```php
 * $menuChanger->putItem(MenuItem $item, $inputs);
 * ```
 *
 * ### MenuItem 삭제
 *
 * * MenuItem 의 삭제
 * * 삭제하려는 MenuItem 인스턴스를 인자로 전달
 * * 하위에 MenuItem 이 연결되어 있으면 삭제할 수 없음
 *
 * ```php
 * $menuChanger->removeItem(MenuItem $item)
 * ```
 *
 * ### MoveItem 아이템의 위치 이동
 *
 * * MenuItem 의 위치 이동
 * * 보유하고 있는 자식 노드를 포함하여 연결되어 있는 상위 노드를 변경한다
 * * 이동하려는 MenuItem 인스턴스와 MenuItem id 또는 MenuEntity Id 를 인자로 전달 받는다
 *
 * ```php
 * $menuChanger->moveItem(MenuItem $item, $newParentId);
 * ```
 *
 * ### setOrder 아이템의 정렬 순서 지정
 *
 * * MenuItem 의 정렬 순서를 지정하는 역할
 * * 상위로 부터 모든 children 을 가져와 순서를 재정렬 하는 방식으로 진행
 *
 * ```php
 * $menuChanger->setOrder(MenuItem $menuItem, $ordering)
 * ```
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 *
 * @deprecated
 */
class MenuAlterHandler
{
    /**
     * @var array
     */
    public static $itemParamKeys = [
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

    /**
     * @var MenuRepositoryInterface
     */
    protected $menuRepository;

    /**
     * @var ModuleHandler
     */
    protected $typeHandler;

    /**
     * @var InstanceRouteHandler
     */
    private $routeHandler;
    /**
     * @var MenuCacheHandler
     */
    private $cache;

    /**
     * @param MenuRepositoryInterface $menuRepository menu repository
     * @param ModuleHandler           $typeHandler    type handler
     * @param InstanceRouteHandler    $routeHandler   instance route handler
     * @param MenuCacheHandler        $cacheHandler   menu cache handler
     */
    public function __construct(
        MenuRepositoryInterface $menuRepository,
        ModuleHandler $typeHandler,
        InstanceRouteHandler $routeHandler,
        MenuCacheHandler $cacheHandler
    ) {
        $this->menuRepository = $menuRepository;
        $this->typeHandler = $typeHandler;
        $this->routeHandler = $routeHandler;
        $this->cache = $cacheHandler;
    }

    /**
     * Create new Menu
     *
     * @param array $inputs to create menu entity instance attributes
     *
     * @return MenuEntity
     */
    public function addMenu(array $inputs)
    {
        $menuTitle = $inputs['menuTitle'];
        $menuDescription = $inputs['menuDescription'];
        $siteKey = $inputs['siteKey'];

        $menu = $this->menuRepository->insertMenu(new MenuEntity(
            ['title' => $menuTitle, 'description' => $menuDescription, 'site' => $siteKey],
            new TreeCollection([])
        ));
        $this->menuRepository->insertHierarchy(new MenuItem(['id' => $menu->id]));

        return $menu;
    }

    /**
     * Update Menu
     *
     * @param MenuEntity $menu   menu object to update
     * @param array      $inputs updated attributes
     *
     * @return int
     */
    public function putMenu(MenuEntity $menu, array $inputs)
    {
        $menuTitle = $inputs['menuTitle'];
        $menuDescription = $inputs['menuDescription'];

        $menu->title = $menuTitle;
        $menu->description = $menuDescription;

        $this->cache->deleteCachedMenu($menu->id);

        return $this->menuRepository->updateMenu($menu);
    }

    /**
     * Delete Menu
     *
     * @param MenuEntity $menu menu to delete
     *
     * @throws CanNotDeleteMenuEntityHaveChildException
     * @return void
     */
    public function removeMenu(MenuEntity $menu)
    {
        if ($menu->countItem() > 0) {
            throw new CanNotDeleteMenuEntityHaveChildException;
        }
        $this->menuRepository->deleteMenu($menu);
        $this->cache->deleteCachedMenu($menu->id);
        $this->cache->forgetMenuMap($menu);
    }

    /**
     * Create New Menu Item at Menu Object at Menu Id
     *
     * @param MenuEntity $menu       menu entity id
     * @param array      $itemInputs to create menu item's attributes
     *
     * @return MenuItem
     */
    public function addItem(MenuEntity $menu, array $itemInputs)
    {
        $itemParams = array_only($itemInputs, static::$itemParamKeys);
        $menuTypeParams = array_except($itemInputs, static::$itemParamKeys);

        $newItem = $this->menuRepository->insertItem(new MenuItem(
            [
                'title' => $itemParams['itemTitle'],
                'url' => $itemParams['itemUrl'],
                'description' => $itemParams['itemDescription'],
                'target' => $itemParams['itemTarget'],
                'type' => $itemParams['selectedType'],
                'ordering' => $itemParams['itemOrdering'],
                'activated' => $itemParams['itemActivated']
            ]
        ));
        $newItem->menuId = $menu->id;
        $newItem->parentId = $itemParams['parent'];

        $this->menuRepository->insertHierarchy($newItem, new MenuItem(['id' => $newItem->parentId]));

        $breadCrumbs = $this->generateNewItemBreadCrumbs($menu, $newItem->parentId, $newItem->id);
        $newItem->setDepth((sizeof($breadCrumbs) -1));
        $newItem->setBreadCrumbs($breadCrumbs);

        $itemParams['itemId'] = $newItem->id;
        $this->setOrder($newItem, $itemParams['itemOrdering']);
        $this->insertMenuType($newItem, $menuTypeParams, $itemParams);

        $this->cache->deleteCachedMenu($menu->id);
        return $newItem;

    }

    /**
     * Update MenuItem
     *
     * @param MenuItem $item   MenuItem Object to update
     * @param array    $inputs input parameters
     *
     * @return MenuItem
     */
    public function putItem(MenuItem $item, array $inputs)
    {
        $itemParams = array_only($inputs, static::$itemParamKeys);
        $menuTypeParams = array_except($inputs, static::$itemParamKeys);

        $item->title = $itemParams['itemTitle'];
        $item->url = $itemParams['itemUrl'];
        $item->description = $itemParams['itemDescription'];
        $item->target = $itemParams['itemTarget'];
        $item->ordering = $itemParams['itemOrdering'];
        $item->activated = array_get($itemParams, 'itemActivated', '0');

        $this->updateMenuType($item, $menuTypeParams, $itemParams);

        $this->menuRepository->updateItem($item);

        $this->cache->deleteCachedMenu($item->menuId);
        return $item;
    }

    /**
     * Delete Menu Item at Menu
     *
     * @param MenuItem $item 삭제하려는 MenuItem
     *
     * @return int
     * @throws CanNotDeleteMenuItemHaveChildException
     */
    public function removeItem(MenuItem $item)
    {
        if ($item->hasChild()) {
            throw new CanNotDeleteMenuItemHaveChildException;
        }

        $menuType = $item->type;
        $menuTypeObj = $this->typeHandler->getModuleObject($menuType);

        $affectedRow = $this->menuRepository->deleteItem($item);
        $this->menuRepository->removeHierarchy($item);
        $menuTypeObj->deleteMenu($item->id);

        if ($menuTypeObj::isRouteAble()) {
            $instanceRoute = $this->routeHandler->getByInstanceId($item->id);
            $this->routeHandler->remove($instanceRoute);
        }
        $this->cache->deleteCachedMenu($item->menuId);

        return $affectedRow;
    }

    /**
     * Move MenuItem Location from to id
     *
     * @param MenuItem $item        menu item instance for moving
     * @param string   $newParentId new parent id that menu's or item's
     *
     * @return MenuItem
     */
    public function moveItem(MenuItem $item, $newParentId)
    {
        $oldParent = $item->parentId;
        $oldMenu = $item->menuId;

        $this->menuRepository->unlinkHierarchy($item, new MenuItem(['id' => $oldParent]));
        $this->menuRepository->linkHierarchy($item, new MenuItem(['id' => $newParentId]));

        $menuCount = $this->menuRepository->countMenu($newParentId);
        if ($menuCount > 0) {
            $item->menuId = $newParentId;
        }
        $item->parentId = $newParentId;

        $this->cache->deleteCachedMenu($oldMenu);
        $this->cache->deleteCachedMenu($newParentId);

        return $this->menuRepository->findItem($item->id);

    }

    /**
     * setOrder
     *
     * @param MenuItem $menuItem to change ordering menu item instance
     * @param int      $ordering new ordering number
     *
     * @return void
     */
    public function setOrder(MenuItem $menuItem, $ordering)
    {
        $items = $this->menuRepository->children(new MenuItem(['id' => $menuItem->parentId]));

        $children = array_filter($items, function ($child) use ($menuItem) {
            return $child->id != $menuItem->id;
        });

        $children = array_merge(
            array_slice($children, 0, $ordering),
            [$menuItem],
            array_slice($children, $ordering)
        );

        $seq = 0;
        foreach ($children as $child) {
            $child->ordering = $seq;
            $this->menuRepository->updateItem($child);
            $this->cache->deleteCachedMenu($child->id);
            $seq++;
        }
        $this->cache->deleteCachedMenu($menuItem->menuId);
    }

    /**
     * generateNewItemBreadCrumbs
     *
     * @param MenuEntity $menu         MenuEntity
     * @param string     $parentItemId parent item's id
     * @param string     $newItemId    new item's id
     *
     * @return array
     */
    protected function generateNewItemBreadCrumbs(MenuEntity $menu, $parentItemId, $newItemId)
    {
        if ($parentItemId === $menu->id) {
            return [$parentItemId, $newItemId];
        }

        $parentItem = $menu->getItem($parentItemId);

        $breadCrumbs = $parentItem->getBreadCrumbs();
        array_push($breadCrumbs, $newItemId);

        return $breadCrumbs;
    }

    /**
     * insertMenuType
     *
     * @param MenuItem $item           item for menu type instance
     * @param array    $menuTypeParams to store menu type params
     * @param array    $itemParams     if it need, can use item's
     *
     * @return void
     */
    protected function insertMenuType(MenuItem $item, array $menuTypeParams, array $itemParams)
    {
        $menuTypeObj = $this->typeHandler->getModuleObject($itemParams['selectedType']);
        $menuTypeObj->storeMenu($itemParams['itemId'], $menuTypeParams, $itemParams);

        if ($menuTypeObj::isRouteAble()) {
            if (!$this->routeHandler->usableUrl($itemParams['siteKey'], $itemParams['itemUrl'])) {
                throw new UnusableUrlException(['url' => $itemParams['itemUrl']]);
            }

            $newRoute = new InstanceRoute(
                [
                    'url' => $itemParams['itemUrl'],
                    'module' => $menuTypeObj::getId(),
                    'instanceId' => $itemParams['itemId'],
                    'menuId' => $item->menuId,
                    'site' => $itemParams['siteKey']
                ]
            );
            $this->routeHandler->add($newRoute);
        }
    }

    /**
     * updateMenuType
     *
     * @param MenuItem $item           item for menu type instance
     * @param array    $menuTypeParams to store menu type params
     * @param array    $itemParams     if it need, can use item's
     *
     * @return void
     */
    protected function updateMenuType(MenuItem $item, array $menuTypeParams, array $itemParams)
    {
        $menuType = $item->type;
        $menuTypeObj = $this->typeHandler->getModuleObject($menuType);
        $menuTypeObj->updateMenu($item->id, $menuTypeParams, $itemParams);

        if ($menuTypeObj::isRouteAble()) {
            $instanceRoute = $this->routeHandler->getByInstanceId($item->id);
            $instanceRoute->url = $itemParams['itemUrl'];

            $this->routeHandler->put($instanceRoute);
        }
    }
}
