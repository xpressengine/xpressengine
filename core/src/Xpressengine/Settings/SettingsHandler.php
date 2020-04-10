<?php
/**
 * SettingsHandler class.
 *
 * PHP version 7
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Settings;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Permission\Instance;
use Xpressengine\Register\Container;
use Xpressengine\Settings\Exceptions\PermissionIDNotFoundException;
use Xpressengine\Settings\Exceptions\SettingsMenuNotMatchedException;
use Xpressengine\Support\Tree\Tree;

/**
 * SettingsHandler는 XpressEngine의 관리자 페이지를 관리합니다. 관리자 페이지의 좌측 메뉴와 각 페이지에 대한 접근 권한의 관리를 담당합니다.
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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

            // 만약 route에 permission 정보가 있고, 그 permission을 현재 user가 통과하지 못하면 display=false로 지정한다.
            $permissions = array_get($route->getAction(), 'permission', []);
            $visible = false;
            if (false && !$isSuper) {
                foreach ((array) $permissions as $permissionId) {
                    // todo: implementing
                    $instance = new Instance('settings.'.$permissionId);

                    $perm = app('xe.permission')->get($instance->getName(), $instance->getSiteKey());
                    if ($perm === null) {
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

                if ($menu === null) {
                    throw new SettingsMenuNotMatchedException(['menu' => $menuId]);
                }

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
        $selectedMenuIds = (array) $selectedMenuIds;

        if (count($selectedMenuIds) === 0) {
            return;
        }

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
