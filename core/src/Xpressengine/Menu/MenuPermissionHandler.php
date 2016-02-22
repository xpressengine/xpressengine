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

use Xpressengine\Member\Repositories\GroupRepositoryInterface;
use Xpressengine\Member\Repositories\MemberRepositoryInterface;
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\PermissionHandler;

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
     * @var PermissionHandler $permission
     */
    protected $permission;

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
    
    const ACCESS = 'access';
    
    const VISIBLE = 'visible';

    /**
     * Construct
     *
     * @param PermissionHandler                   $permission permission factory
     * @param GroupRepositoryInterface  $groupRepo  group repository
     * @param MemberRepositoryInterface $memberRepo member repository
     *
     */
    public function __construct(
        PermissionHandler $permission,
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
     * getMenuAccessPermission
     *
     * @param MenuEntity $menu to get access permission
     *
     * @return \Xpressengine\Permission\Permission
     * @throws \Xpressengine\Permission\Exceptions\WrongInstanceException
     */
    public function getMenuAccessPermission(MenuEntity $menu)
    {
        $registered = $this->permission->find($menu->id, 'default');

        $menuAccessGrant = $registered[static::ACCESS];

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
     * @throws \Xpressengine\Permission\Exceptions\WrongInstanceException
     */
    public function getMenuVisiblePermission(MenuEntity $menu)
    {
        $registered = $this->permission->find($menu->id, 'default');

        $menuVisibleGrant = $registered[static::VISIBLE];

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
        $this->permission->register($menu->id, $grant, 'default');
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
        $this->permission->destroy($menu->id, 'default');
    }

    /**
     * getItemAccessPermission
     *
     * @param MenuItem $item to find permission target item object
     *
     * @return \Xpressengine\Permission\Permission
     * @throws \Xpressengine\Permission\Exceptions\WrongInstanceException
     */
    public function getItemAccessPermission(MenuItem $item)
    {
        $registered = $this->permission->find($item->getBreadCrumbsKeyString(), 'default');

        $pureGrant = $registered->pure(static::ACCESS);
        $mode = ($pureGrant === null) ? "inherit" : "manual";
        $menuAccessGrant = $registered->offsetGet(static::ACCESS);

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
     * @return \Xpressengine\Permission\Permission
     */
    public function registerItemPermission(MenuItem $item, Grant $grant)
    {
        return $this->permission->register($item->getBreadCrumbsKeyString(), $grant, 'default');
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
        $this->permission->destroy($item->getBreadCrumbsKeyString(), 'default');
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
        $registered = $this->permission->find($item->getBreadCrumbsKeyString(), 'default');

        $pureGrant = $registered->pure(static::VISIBLE);
        $mode = ($pureGrant === null) ? "inherit" : "manual";
        $menuVisibleGrant = $registered->offsetGet(static::VISIBLE);

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

        $grant->add(static::ACCESS, 'rating', $rating);
        $grant->add(static::ACCESS, 'group', $group);
        $grant->add(static::ACCESS, 'user', $user);
        $grant->add(static::ACCESS, 'except', $except);

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

        $grant->add(static::VISIBLE, 'rating', $rating);
        $grant->add(static::VISIBLE, 'group', $group);
        $grant->add(static::VISIBLE, 'user', $user);
        $grant->add(static::VISIBLE, 'except', $except);

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
        $registered = $this->permission->find($fromItem->getBreadCrumbsKeyString(), 'default');

        $this->permission->move($registered, $movedItem->getBreadCrumbsKeyString());

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

        return array_filter($ret);
    }
}
