<?php
/**
 * SettingsHandler class.
 *
 * PHP version 5
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Settings;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Permission\Instance;
use Xpressengine\Register\Container;
use Xpressengine\Settings\Exceptions\PermissionIDNotFoundException;
use Xpressengine\Support\Tree\Tree;

/**
 * SettingsHandler는 XpressEngine의 관리자 페이지를 관리합니다. 관리자 페이지의 좌측 메뉴와 각 페이지에 대한 접근 권한의 관리를 담당합니다.
 *
 * # SettingsHandler
 *
 * ## 관리페이지 메뉴 추가하기
 *
 * 플러그인에서는 관리페이지의 좌측에 노출되는 메뉴 트리에 자유롭게 메뉴를 추가할 수 있습니다.
 * 메뉴를 추가할 때에는 `Register`에 등록해야 합니다. 등록키는 `settings/menu`이어야 합니다.
 *
 * ```php
 *
 * // 등록할 메뉴 아이디를 지정. 다른 메뉴와 겹치지 않도록 고유한 아이디를 정의해야 함.
 * $menuId = 'member.social_login';
 *
 * // 등록할 메뉴의 정보를 지정.
 * $menuInfo = [
 *    'title' => '소셜로그인',
 *     'description' => '소셜로그인을 설정하는 방법을 안내합니다.',
 *     'display' => true,
 *     'ordering' => 350
 * ];
 *
 * // 메뉴를 등록한다.
 * Register::push('settings/menu', $menuId, $menuInfo);
 *
 * ```
 * 메뉴가 출력되는 위치는 메뉴의 아이디로 지정할 수 있습니다. 메뉴 아이디는 dot(.)을 구분자로 하여 부모 메뉴의 아이디를 앞에 붙여주면 됩니다.
 * 위 코드에서는 메뉴의 아이디가 `member.social_login`이기 때문에 회원(`member`) 메뉴의 자식 메뉴로 등록됩니다.
 *
 *
 * ## 관리페이지 메뉴에 링크 연결하기
 *
 * 플러그인은 route를 등록할 때, route와 메뉴를 연결할 수 있습니다. 자동으로 해당 route의 주소가 메뉴에 연결됩니다.
 *
 * ```php
 *
 * // 소셜로그인 관리 페이지의 Route 추가.
 * // 'settings_menu' 항목을 사용하여 이 Route에 메뉴를 연결.
 * Route::settings(
 *     'social_login',
 *     function () {
 *         Route::get('/', [
 *                 'as' => 'social_login::settings',
 *                 'uses' => function () {
 *                     return \XePresenter::make('social_login::tpl.setting');
 *                 },
 *                 'settings_menu' => 'member.social_login'
 *         ]);
 *     }
 * );
 * ```
 *
 * ## 관리페이지 접근권한 추가하기
 *
 * XpressEngine은 기본적으로 최고관리자(super user)만 관리페이지를 접근하는 것을 허용합니다.
 * 만약 최고관리자 이외의 회원에게 특정 관리페이지에 접근할 수 있는 권한을 부여하려면 접근권한을 지정해주면 됩니다.
 * 접근권한을 지정해주는 방법은 관리페이지 메뉴를 등록하는 방법과 유사합니다.
 * 단, Register key는 `settings/permission`을 사용해야 합니다.
 *
 * ```php
 * $id = 'member.edit';
 * $permission = [
 *    'title' => '회원정보수정',
 *    'tab' => '회원관리' // 카테고리
 * ];
 *
 * // 회원정보수정 권한 등록
 * Register::push('settings/permission', $id, $permission);
 * ```
 *
 * 등록한 접근권한을 부여할 회원을 지정하려면 관리페이지의 [설정 > 관리페이지 권한 설정] 메뉴에 접속하십시오.
 *
 * ## 관리 페이지 접근권한 부여하기
 *
 * 위에서 등록한 '회원정보수정' 권한을 '회원수정' 페이지에 지정하려면 '회원수정' 페이지의 route와 권한을 연결하면 됩니다.
 * 그러면 해당 페이지에 접근하려고 할 때, 자동으로 권한 검사를 거치게 됩니다.
 *
 * ```php
 * // 'permission' 항목을 사용하여 이 Route에 권한을 부여.
 * Route::settings(
 *     'member',
 *     function () {
 *         Route::get('{id}/edit', [
 *            'as' => 'settings.user.edit',
 *            'uses' => 'Member\Settings\UserController@getEdit',
 *            'permission' => 'member.edit',
 *         ]
 *     });
 * );
 * ```
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class SettingsHandler
{
    /**
     * @var string basic settings prefix name
     */
    const SETTING_CONFIG_NAME = 'settings';

    /**
     * @var Tree settings menu list
     */
    protected $menuList;

    /**
     * @var SettingsMenu selected menu (linked current request)
     */
    protected $selectedMenu = null;

    /**
     * @var \Xpressengine\Register\Container
     */
    private $container;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var ConfigManager
     */
    private $configManager;

    /**
     * @var GateContract
     */
    private $gate;

    /**
     * constructor
     * render 필드가 있을 경우 메뉴를 출력할 때, render에 지정된 closure가 반환하는 문자열을 그대로 출력한다.
     *
     * @param Container     $container    XpressEngine Register 등록된 관리메뉴와 관리권한을 조회할 때 사용한다.
     * @param Router        $router       router
     * @param ConfigManager $configManger 관리페이지 관련 설정 정보를 조회/저장할 때 사용한다.
     * @param GateContract  $gate         관리페이지 권한 정보를 조회/저장할 때 사용한다.
     */
    public function __construct(
        Container $container,
        Router $router,
        ConfigManager $configManger,
        GateContract $gate
    ) {
        $this->container = $container;
        $this->router = $router;
        $this->configManager = $configManger;
        $this->gate = $gate;
    }

    /**
     * 관리권한 목록을 반환한다. $sortByTab이 true일 경우 tab 필드별로 group by하여 반환한다.
     *
     * @param bool $groupByTab tab별로 group by할지의 여부
     *
     * @return array
     * @throws PermissionIDNotFoundException
     */
    public function getPermissionList($groupByTab = true)
    {
        $permissionArr = $this->container->get('settings/permission');

        if ($groupByTab === false) {
            return $permissionArr;
        }

        $permissionGroup = [];
        foreach ($permissionArr as $id => $permission) {
            $tab = $permission['tab'];
            if (!isset($permissionGroup[$tab])) {
                $permissionGroup[$tab] = [];
            }
            // resolve id
            if (!isset($permission['id'])) {
                if (!is_string($id)) {
                    throw new PermissionIDNotFoundException();
                } else {
                    $permission['id'] = $id;
                }
            }
            $permissionGroup[$tab][$permission['id']] = $permission;
        }

        return $permissionGroup;
    }

    /**
     * 주어진 관리페이지 권한에 해당하는 권한목록을 반환한다.
     *
     * @param string $permissionId 권한아이디
     *
     * @return mixed
     */
    protected function getPermission($permissionId)
    {
        $list = $this->getPermissionList(false);
        return array_get($list, $permissionId);
    }

    /**
     * 현재 request에 해당하는 메뉴를 반환한다. 메뉴목록이 아직 생성되지 않았다면 메뉴 목록을 먼저 만든다.
     *
     * @param boolean $isSuper 최고관리자 여부
     *
     * @return SettingsMenu
     */
    public function getSelectedMenu($isSuper)
    {
        if ($this->menuList === null) {
            $this->makeMenuList($this->router, $isSuper);
        }
        return $this->selectedMenu;
    }

    /**
     * 관리페이지 메뉴 목록을 반환한다.
     *
     * @param boolean $isSuper 최고관리자 여부
     *
     * @return SettingsMenu[]
     */
    public function getSettingsMenus($isSuper)
    {
        if ($this->menuList === null) {
            $this->makeMenuList($this->router, $isSuper);
        }
        return $this->menuList->getTreeNodes();
    }

    /**
     * 관리페이지 관련 설정을 저장한다.
     *
     * @param string $configName 설정 키
     * @param array  $config     config 설정 데이터
     *
     * @return void
     */
    public function setConfig($configName, array $config)
    {
        $this->configManager->set(self::SETTING_CONFIG_NAME.'.'.$configName, $config);
    }

    /**
     * 관리페이지 관련 설정을 조회한다.
     *
     * @param string $config 설정 키
     *
     * @return ConfigEntity
     */
    public function getConfig($config)
    {
        return $this->configManager->get(static::SETTING_CONFIG_NAME.'.'.$config);
    }

    /**
     * 관리페이지 메뉴 목록을 생성한다. 현재 요청의 user와 route 정보를 이용하여 선택된 메뉴, 감추어야할 메뉴를 설정한다.
     *
     * @param Router  $router  router
     * @param boolean $isSuper 최고관리자 여부
     *
     * @return void
     */
    protected function makeMenuList(Router $router, $isSuper)
    {
        // 등록된 menu list를 가져온다.
        $menus = $this->getRegisteredMenus();

        // menu를 tree로 구성한다.
        $this->menuList = new Tree($menus);

        // menu가 지정된 route 목록을 가져온다.
        $routes = $router->getRoutes()->getSettingsMenuRoutes();

        // 각 메뉴에 해당되는 route를 지정한다.
        foreach ($routes as $route) {
            /** @var Route $route */
            $menuIds = array_get($route->getAction(), 'settings_menu', []);

            // 만약 route에 permission 정보가 있고, 그 permission을 현재 member가 통과하지 못하면 display=false로 지정한다.
            $permissions = array_get($route->getAction(), 'permission', []);
            $visible = false;
            if (false && !$isSuper) {
                foreach ((array) $permissions as $permissionId) {
                    // todo: implementing
                    $instance = new Instance('settings.'.$permissionId);

                    $perm = app('xe.permission')->get($instance->getName(), $instance->getSiteKey());
                    if($perm === null) {
                        $visible = false;
                        continue;
                    }

                    if ($this->gate->allows('access', $instance)) {
                        $visible = true;
                    }
                }
            } else {
                $visible = true;
            }

            // 메뉴에 route 지정,
            foreach ((array) $menuIds as $menuId) {
                $menu = $this->menuList[$menuId];
                $menu->route = $route;
                if ($visible === false) {
                    $menu->display = false;
                }
            }
        }

        $this->setSelectedMenu($router->current());
    }

    /**
     * 현재 요청에 해당하는 관리페이지 메뉴를 찾는다.
     *
     * @param Route $route 현재 요청에 매칭된 route
     *
     * @return void
     */
    protected function setSelectedMenu(Route $route)
    {
        $selectedMenuIds = array_get($route->getAction(), 'settings_menu', []);

        if (count($selectedMenuIds) === 0) {
            return;
        }
        $selectedMenuIds = (array) $selectedMenuIds;
        foreach ($selectedMenuIds as $selectedMenuId) {
            $selected = $this->menuList[$selectedMenuId];
            do {
                $selected->setSelected(true);
                $selected = $selected->getParent();
            } while ($selected);
        }

        $this->selectedMenu = $this->menuList[end($selectedMenuIds)];
    }

    /**
     * getRegisteredMenus
     *
     * @return array
     * @throws \Exception
     */
    private function getRegisteredMenus()
    {
        $menus = $this->container->get('settings/menu');
        $menuObjects = [];
        foreach ($menus as $id => $menuInfo) {
            if (!isset($menuInfo['id'])) {
                if (!is_string($id)) {
                    throw new \Exception();
                } else {
                    $menuInfo['id'] = $id;
                }
            }
            $menuObjects[$menuInfo['id']] = new SettingsMenu($menuInfo);
        }
        return $menuObjects;
    }
}
