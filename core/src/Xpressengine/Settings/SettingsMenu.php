<?php
/**
 * SettingsMenu class.
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

use Closure;
use Illuminate\Routing\Route;
use JsonSerializable;
use Xpressengine\Settings\Exceptions\LinkNotFoundException;
use Xpressengine\Support\Entity;
use Xpressengine\Support\Tree\NodeInterface;

/**
 * 관리메뉴를 표현하는 클래스
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SettingsMenu extends Entity implements NodeInterface, JsonSerializable
{
    /**
     * @var null|SettingsMenu 상위 Item 인스턴스 이거나 null
     */
    protected $parent = null;
    /**
     * @var SettingsMenu[] 하위의 Item 들을 나타내는 배열
     */
    protected $childItems = [];
    /**
     * @var bool 주로 UI 상에서 표현을 위한 선택되어진 유무를 가지고 있음
     */
    protected $selected = false;
    /**
     * @var int 이 Item 이 Tree 상에서 얼마나 깊이 있는지 표시
     */
    protected $depth;
    /**
     * @var array 이 Item 의 빵조각 정보를 담고 있는 배열 Menu 의 Id 부터 시작
     */
    protected $breadCrumbs = [];

    /**
     * @var boolean 출력할 하위 메뉴가 있는지의 여부
     */
    protected $hasVisibleChild = null;


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
            return null;
        }

        // menu에 링크 정보가 있을 경우
        if ($this->link !== null) {
            if ($this->link instanceof Closure) {
                return call_user_func($this->link);
            } else {
                return $this->link;
            }
        }

        // 어떤 링크정보도 찾을 수 없으면 #
        if ($this->route === null) {
            return null;
        }

        // route 정보 사용
        if ($name = $this->route->getName()) {
            return route($name);
        } elseif ($action = $this->route->getActionName()) {
            if ($action !== 'Closure') {
                return action($action);
            }
        }
        throw new LinkNotFoundException();
    }

    /**
     * 메뉴의 자식 메뉴중 visible 상태인 메뉴가 있는지 조회한다.
     *
     * @return bool
     */
    public function hasVisibleChild()
    {

        if ($this->hasVisibleChild !== null) {
            return $this->hasVisibleChild;
        }

        if (count($this->childItems) <= 0) {
            return $this->hasVisibleChild = false;
        }

        foreach ($this->childItems as $item) {
            if ($item->display === true) {
                return $this->hasVisibleChild = true;
            }
        }

        return $this->hasVisibleChild = false;
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

    /**
     * Get the unique identifier for the node
     *
     * @return string|int
     */
    public function getNodeIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the unique identifier name for the node
     *
     * @return string
     */
    public function getNodeIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the parent identifier for the node
     *
     * @return string|int
     */
    public function getParentNodeIdentifier()
    {
        return $this->parentId;
    }

    /**
     * setParent
     *
     * @param NodeInterface $item parent menu item
     *
     * @return void
     */
    public function setParent(NodeInterface $item)
    {
        $this->parent = $item;
    }
    /**
     * Return the parent node or null
     *
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * addChild
     *
     * @param NodeInterface $item one child node - menu item
     *
     * @return void
     */
    public function addChild(NodeInterface $item)
    {
        $this->childItems[$item->id] = $item;
    }
    /**
     * hasChild
     *
     * @return bool
     */
    public function hasChild()
    {
        if (sizeof($this->childItems) > 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * setChildren
     *
     * @param NodeInterface[] $children set array of menuItems
     *
     * @return void
     */
    public function setChildren($children = [])
    {
        $this->childItems = $children;
    }
    /**
     * getChildren
     *
     * @return NodeInterface[]
     */
    public function getChildren()
    {
        return $this->childItems;
    }

    /**
     * get order key name
     *
     * @return string
     */
    public function getOrderKeyName()
    {
        return 'ordering';
    }

    /**
     * setIsSelected
     *
     * @param bool $selected     menuItem selected flag
     * @param bool $parentSelect parent menuItem to selected flag
     *
     * @return void
     */
    public function setSelected($selected, $parentSelect = true)
    {
        $this->selected = $selected;
        if ($parentSelect && !is_null($this->parent)) {
            $this->parent->setSelected($selected, $parentSelect);
        }
    }
    /**
     * isSelected
     *
     * @return bool
     */
    public function isSelected()
    {
        return $this->selected;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *       which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return array_merge($this->attributes, ['items' => $this->childItems]);
    }
}
