<?php
/**
 * Menu
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

use Illuminate\Contracts\Foundation\Application;
use Xpressengine\Member\Repositories\GroupRepositoryInterface;
use Xpressengine\Member\Repositories\MemberRepositoryInterface;
use Xpressengine\Menu\Permission\MenuPermission;
use Xpressengine\Permission\Action;
use Xpressengine\Permission\Factory;
use Xpressengine\Permission\Grant;

/**
 * MenuPermission
 * 메뉴의 권한을 체크하고, 관리하는 클래스
 *
 * ## app binding
 * * xe.menu.permission 으로 바인딩 되어 있음
 * * Facade 는 제공하지 않음
 *
 * ## 생성자에서 필요한 항목들
 * * Factory $permission - Permission 패키지의 고유 factory
 * * GroupRepositoryInterface $groupRepo - 그룹 조회를 위한 group repository
 * * MemberRepositoryInterface $memberRepo - 멤버 조회를 위한 member repository
 *
 * ## 사용법
 *
 * ### 기본 메뉴 권한 획득
 *
 * * 기본적으로 메뉴에서 사용할 권한을 획득한다
 * * 기본 설정은 member rating, no group, no user, no except
 *
 * ```php
 * $permissionHandler->getDefaultMenuPermission();
 * ```
 *
 * ### MenuEntity 의 AccessPermission 조회
 * * MenuEntity 의 AccessPermission 은 소속된 MenuItem 들의 기본 AccessPermission 을 의미함
 * * MenuEntity 를 인자로 전달
 *
 * ```php
 * $accessPermissionArr = $permissionHandler->getMenuAccessPermission(MenuEntity $menu);
 * ```
 *
 * ### MenuEntity 의 VisiblePermission 조회
 * * MenuEntity 의 VisiblePermission 은 소속된 MenuItem 들의 기본 VisiblePermission 을 의미함
 * * MenuEntity 를 인자로 전달
 *
 * ```php
 * $visiblePermissionArr = $permissionHandler->getMenuVisiblePermission(MenuEntity $menu);
 * ```
 *
 * ### MenuEntity 의 MenuPermission 등록
 *
 * * MenuEntity 와 Grant 를 인자로 전달
 *
 * ```php
 * $permissionHandler->registerMenuPermission(MenuEntity $menu, Grant $grant);
 * ```
 *
 * ### MenuEntity 의 MenuPermission 삭제
 *
 * * MenuEntity 를 인자로 전달
 *
 * ```php
 * $permissionHandler->deleteMenuPermission(MenuEntity $menu);
 * ```
 *
 * ### MenuItem 의 AccessPermission 조회
 * * MenuItem 를 인자로 전달
 *
 * ```php
 * $accessPermissionArr = $permissionHandler->getItemAccessPermission(MenuItem $item);
 * ```
 *
 * ### MenuItem 의 VisiblePermission 조회
 * * MenuItem 를 인자로 전달
 *
 * ```php
 * $visiblePermissionArr = $permissionHandler->getItemVisiblePermission(MenuItem $item);
 * ```
 *
 * ### MenuItem 의 MenuPermission 등록
 *
 * * MenuItem 와 Grant 를 인자로 전달
 *
 * ```php
 * $permissionHandler->registerItemPermission(MenuItem $item, Grant $grant);
 * ```
 *
 * ### MenuItem 의 MenuPermission 삭제
 *
 * * MenuItem 를 인자로 전달
 *
 * ```php
 * $permissionHandler->deleteItemPermission(MenuItem $item);
 * ```
 *
 * ### 인자를 바탕으로 새로운 AccessGrant 객체 생성
 *
 * * 입력값을 바탕으로 새로운 Grant 객체를 생성한다
 * * input array 와 Grant 객체를 인자로 전달
 * * 넘겨 받은 $grant 가 null 일 경우 신규로 생성 그렇지 않은 경우에는 기존 grant 에 추가
 *
 * ```php
 * $permissionHandler->createAccessGrant(array $inputs, $grant = null);
 * ```
 *
 * ### 인자를 바탕으로 새로운 VisibleGrant 객체 생성
 *
 * * 입력값을 바탕으로 새로운 Grant 객체를 생성한다
 * * input array 와 Grant 객체를 인자로 전달
 * * 넘겨 받은 $grant 가 null 일 경우 신규로 생성 그렇지 않은 경우에는 기존 grant 에 추가
 *
 * ```php
 * $permissionHandler->createVisibleGrant(array $inputs, $grant = null);
 * ```
 *
 * ### MenuItem 에 연결된 MenuPermission 의 Hierarchy 이동
 *
 * * MenuItem 두개를 인자로 전달
 * * from -> to 의 형태로 동작함
 *
 * ```php
 * $permissionHandler->moveItemPermission(MenuItem $fromItem, MenuItem $movedItem);
 * ```
 *
 * ### 모든 MenuPermission 의 조회
 *
 * * 모든 MenuPermission 을 배열 형태로 반환 받는다
 * * Menu 의 Cache 에 권한 정보를 apply 하기 위해서 사용된다
 *
 * ```php
 * $permissionHandler->getMenuPermissions()
 * ```
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuPermissionHandler
{
    /**
     * @var array
     */
    protected static $permissions = [];

    /**
     * @var Application $app
     */
    protected $app;
    /**
     * @var Factory $permission
     */
    protected $permission;

    /**
     * @var string $permissionType
     */
    protected $permissionType = 'menu';

    /**
     * @var array
     */
    public static $accessPermissionKeys = [
        'accessRating',
        'accessGroup',
        'accessIncludeUser',
        'accessExcludeUser'
    ];

    /**
     * @var array
     */
    public static $visiblePermissionKeys = [
        'visibleRating',
        'visibleGroup',
        'visibleIncludeUser',
        'visibleExcludeUser'
    ];

    /**
     * @var GroupRepositoryInterface $groupRepo
     */
    protected $groupRepo;

    /**
     * @var MemberRepositoryInterface $memberRepo ;
     */
    protected $memberRepo;

    /**
     * Construct
     *
     * @param Factory                   $permission permission factory
     * @param GroupRepositoryInterface  $groupRepo  group repository
     * @param MemberRepositoryInterface $memberRepo member repository
     *
     */
    public function __construct(
        Factory $permission,
        GroupRepositoryInterface $groupRepo,
        MemberRepositoryInterface $memberRepo
    ) {
        $this->permission = $permission;
        $this->groupRepo = $groupRepo;
        $this->memberRepo = $memberRepo;
    }

    /**
     * getDefaultMenuPermission
     *
     * @return Grant
     */
    public function getDefaultMenuPermission()
    {
        $grant = new Grant();

        $grant->add(Action::ACCESS, 'rating', 'guest');
        $grant->add(Action::ACCESS, 'group', []);
        $grant->add(Action::ACCESS, 'user', []);
        $grant->add(Action::ACCESS, 'except', []);

        $grant->add(Action::VISIBLE, 'rating', 'guest');
        $grant->add(Action::VISIBLE, 'group', []);
        $grant->add(Action::VISIBLE, 'user', []);
        $grant->add(Action::VISIBLE, 'except', []);

        return $grant;
    }

    /**
     * getMenuAccessPermission
     *
     * @param MenuEntity $menu to get access permission
     *
     * @return \Xpressengine\Permission\Permission
     * @throws \Xpressengine\Permission\Exceptions\NotMatchedInstanceException
     */
    public function getMenuAccessPermission(MenuEntity $menu)
    {
        $registered = $this->permission->findRegistered($this->permissionType, $menu->id);

        $menuAccessGrant = $registered->offsetGet(Action::ACCESS);

        $groups = $this->groupRepo->findAll($menuAccessGrant['group']);
        $users = $this->memberRepo->findAll($menuAccessGrant['user']);
        $excepts = $this->memberRepo->findAll($menuAccessGrant['except']);

        return [
            'rating' => $menuAccessGrant['rating'],
            'group' => $groups,
            'user' => $users,
            'except' => $excepts,
        ];
    }

    /**
     * getMenuVisiblePermission
     *
     * @param MenuEntity $menu to get visible permission
     *
     * @return \Xpressengine\Permission\Permission
     * @throws \Xpressengine\Permission\Exceptions\NotMatchedInstanceException
     */
    public function getMenuVisiblePermission(MenuEntity $menu)
    {
        $registered = $this->permission->findRegistered($this->permissionType, $menu->id);

        $menuVisibleGrant = $registered->offsetGet(Action::VISIBLE);

        $groups = $this->groupRepo->findAll($menuVisibleGrant['group']);
        $users = $this->memberRepo->findAll($menuVisibleGrant['user']);
        $excepts = $this->memberRepo->findAll($menuVisibleGrant['except']);

        return [
            'rating' => $menuVisibleGrant['rating'],
            'group' => $groups,
            'user' => $users,
            'except' => $excepts,
        ];
    }

    /**
     * registerMenuPermission
     *
     * @param MenuEntity $menu  grant's owner
     * @param Grant      $grant menu's grant
     *
     * @return void
     */
    public function registerMenuPermission(MenuEntity $menu, Grant $grant)
    {
        $this->permission->register($this->permissionType, $menu->id, $grant);
    }

    /**
     * deleteMenuPermission
     *
     * @param MenuEntity $menu grant's owner
     *
     * @return void
     */
    public function deleteMenuPermission(MenuEntity $menu)
    {
        $this->permission->removeRegistered($this->permissionType, $menu->id);
    }

    /**
     * getItemAccessPermission
     *
     * @param MenuItem $item to find permission target item object
     *
     * @return \Xpressengine\Permission\Permission
     * @throws \Xpressengine\Permission\Exceptions\NotMatchedInstanceException
     */
    public function getItemAccessPermission(MenuItem $item)
    {
        $registered = $this->permission->findRegistered($this->permissionType, $item->getBreadCrumbsKeyString());

        $pureGrant = $registered->pure(Action::ACCESS);
        $mode = ($pureGrant === null) ? "inherit" : "manual";
        $menuAccessGrant = $registered->offsetGet(Action::ACCESS);

        $groups = $this->groupRepo->findAll($menuAccessGrant['group']);
        $users = $this->memberRepo->findAll($menuAccessGrant['user']);
        $excepts = $this->memberRepo->findAll($menuAccessGrant['except']);

        return [
            'mode' => $mode,
            'rating' => $menuAccessGrant['rating'],
            'group' => $groups,
            'user' => $users,
            'except' => $excepts,
        ];

    }

    /**
     * registerItemPermission
     *
     * @param MenuItem $item  item has menu permission
     * @param Grant    $grant item's permission grant
     *
     * @return \Xpressengine\Permission\Registered
     */
    public function registerItemPermission(MenuItem $item, Grant $grant)
    {
        return $this->permission->register($this->permissionType, $item->getBreadCrumbsKeyString(), $grant);
    }

    /**
     * deleteItemAccessPermission
     *
     * @param MenuItem $item grant's owner
     *
     * @return void
     */
    public function deleteItemPermission(MenuItem $item)
    {
        $this->permission->removeRegistered($this->permissionType, $item->getBreadCrumbsKeyString());
    }

    /**
     * getItemVisiblePermission
     *
     * @param MenuItem $item to get visible permission
     *
     * @return mixed
     */
    public function getItemVisiblePermission(MenuItem $item)
    {
        $registered = $this->permission->findRegistered($this->permissionType, $item->getBreadCrumbsKeyString());

        $pureGrant = $registered->pure(Action::VISIBLE);
        $mode = ($pureGrant === null) ? "inherit" : "manual";
        $menuVisibleGrant = $registered->offsetGet(Action::VISIBLE);

        return [
            'mode' => $mode,
            'rating' => $menuVisibleGrant['rating'],
            'group' => $menuVisibleGrant['group'],
            'user' => $menuVisibleGrant['user'],
            'except' => $menuVisibleGrant['except'],
        ];


    }

    /**
     * createAccessGrant
     *
     * @param array $inputs to create grant params array
     * @param Grant $grant  if need to add already exist grant this param is not null
     *
     * @return Grant
     *
     */
    public function createAccessGrant(array $inputs, $grant = null)
    {
        if ($grant === null) {
            $grant = new Grant;
        }

        if (isset($inputs['accessMode']) && ($inputs['accessMode'] === 'inherit')) {
            return $grant;
        }

        $rating = $inputs['accessRating'];
        $group = $this->innerParamParsing($inputs['accessGroup']);
        $user = $this->innerParamParsing($inputs['accessUser']);
        $except = $this->innerParamParsing($inputs['accessExcept']);

        $grant->add(Action::ACCESS, 'rating', $rating);
        $grant->add(Action::ACCESS, 'group', $group);
        $grant->add(Action::ACCESS, 'user', $user);
        $grant->add(Action::ACCESS, 'except', $except);

        return $grant;

    }

    /**
     * createAccessGrant
     *
     * @param array $inputs to create grant params array
     * @param Grant $grant  if need to add already exist grant this param is not null
     *
     * @return Grant
     *
     */
    public function createVisibleGrant(array $inputs, $grant = null)
    {
        if ($grant === null) {
            $grant = new Grant;
        }

        if (isset($inputs['visibleMode']) && ($inputs['visibleMode'] === 'inherit')) {
            return $grant;
        }

        $rating = $inputs['visibleRating'];
        $group = $this->innerParamParsing($inputs['visibleGroup']);
        $user = $this->innerParamParsing($inputs['visibleUser']);
        $except = $this->innerParamParsing($inputs['visibleExcept']);

        $grant->add(Action::VISIBLE, 'rating', $rating);
        $grant->add(Action::VISIBLE, 'group', $group);
        $grant->add(Action::VISIBLE, 'user', $user);
        $grant->add(Action::VISIBLE, 'except', $except);

        return $grant;

    }

    /**
     * moveItemConfig
     *
     * @param MenuItem $fromItem  item of before moving
     * @param MenuItem $movedItem item of after moving
     *
     * @return void
     */
    public function moveItemPermission(MenuItem $fromItem, MenuItem $movedItem)
    {
        $registered = $this->permission->findRegistered(
            $this->permissionType,
            $fromItem->getBreadCrumbsKeyString()
        );

        $this->permission->move($registered, $movedItem->getBreadCrumbsKeyString());

    }

    /**
     * getMenuPermissions
     *
     * @return MenuPermission[]
     * @throws \Xpressengine\Permission\Exceptions\NotMatchedInstanceException
     */
    public function getMenuPermissions()
    {
        if (count(static::$permissions) == 0) {
            static::$permissions = $this->permission->makesByType('menu');
        }

        return static::$permissions;
    }

    /**
     * innerParamParsing
     *
     * @param string $param to parse string
     *
     * @return array
     */
    protected function innerParamParsing($param)
    {
        if (empty($param)) {
            return [];
        }

        $ret = explode(',', $param);
        return array_except($ret, [""]);
    }
}
