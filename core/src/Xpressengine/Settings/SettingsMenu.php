<?php
/**
 * SettingsMenu class.
 *
 * PHP version 5
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Settings;

use Closure;
use Illuminate\Routing\Route;
use Xpressengine\Menu\MenuItem;

/**
 * 관리메뉴를 표현하는 클래스
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class SettingsMenu extends MenuItem
{
    /**
     * @var Route
     */
    public $route;

    /**
     * SettingsMenu constructor.
     *
     * @param array $attributes 메뉴정보
     */
    public function __construct(array $attributes = [])
    {
        $this->resolveParentId($attributes);
        parent::__construct($attributes);
    }

    /**
     * 메뉴의 링크를 생성하여 반환한다. 메뉴에 link정보가 있을 경우 link정보를 우선 사용하여 생성한다.
     * 그 다음으로 메뉴에 연결된 route정보를 사용하여 링크를 생성한다.
     *
     * @return Route|mixed|string
     * @throws \Exception
     */
    public function link()
    {
        if ($this->display === false) {
            return '#';
        }

        // menu에 링크 정보가 있을 경우
        if ($this->link !== null) {
            if ($this->link instanceof Closure) {
                return $this->link();
            } else {
                return $this->link;
            }
        }

        // 어떤 링크정보도 찾을 수 없으면 #
        if ($this->route === null) {
            return '#';
        }

        // route 정보 사용
        if ($name = $this->route->getName()) {
            return route($name);
        } elseif ($action = $this->route->getActionName()) {
            if ($action !== 'Closure') {
                return action($action);
            }
        }
        throw new LinkNotFoundException('admin 메뉴가 지정된 route는 name(as)이 지정되어 있거나 Controller action이어야 합니다.');
    }

    /**
     * 메뉴의 자식 메뉴중 visible 상태인 메뉴가 있는지 조회한다.
     *
     * @return bool
     */
    public function hasVisibleChild()
    {
        if (count($this->childItems) <= 0) {
            return false;
        }

        foreach ($this->childItems as $item) {
            if ($item->display === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * 선택된 메뉴의 BreadCrumb을 반환한다.
     *
     * @return SettingsMenu[]
     */
    public function getBreadCrumbs()
    {
        $menus = [];
        $parent = $this;
        do {
            $menus[] = $parent;
            $parent = $parent->getParent();
        } while ($parent !== null);

        return array_reverse($menus);
    }

    /**
     * tree구조를 생성하기 위해 관리메뉴의 부모메뉴 아이디를 찾아서 지정한다.
     *
     * @param array $attributes 메뉴 정보
     *
     * @return void
     */
    private function resolveParentId(&$attributes)
    {
        $pos = strrpos($attributes['id'], '.');
        if ($pos !== false) {
            $parent = substr($attributes['id'], 0, $pos);
            $attributes['parentId'] = $parent;
        }
    }
}
