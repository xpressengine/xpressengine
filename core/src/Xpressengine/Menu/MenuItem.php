<?php
/**
 * Menu Item
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

use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Menu\Permission\MenuPermission;
use Xpressengine\Permission\Action;
use Xpressengine\Support\Entity;
use Xpressengine\Support\Tree\NodeInterface;

/**
 * Menu Item
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 *
 * @property string $id          자동 생성된 고유한 식별자
 * @property string $menuId      소속된 MenuEntity 의 ID
 * @property string $parentId    부모의 ID
 * @property string $url         해당 메뉴의 URL
 * @property string $preTitle    UI 에서 출력을 위해서 사용되는 property title 출력전에 추가
 * @property string $title       사용자에게 보여지는 이름
 * @property string $postTitle   UI 에서 출력을 위해서 사용되는 property title 출력후에 추가
 * @property string $description 설명
 * @property string $target      링크의 클릭시 옵션
 * @property bool   $activated   활성/비활성 유무
 * @property string $type        해당 메뉴의 type
 * @property int    $ordering    정렬을 위한 순서
 */
class MenuItem extends Entity implements NodeInterface
{
    /**
     * @var null|MenuItem 상위 Item 인스턴스 이거나 null
     */
    protected $parent = null;
    /**
     * @var MenuItem[] 하위의 Item 들을 나타내는 배열
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
     * @var MenuPermission
     */
    protected $permission;

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
    public function setChildren(array $children)
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
     * countSubItems
     *
     * @return int
     */
    public function countSubItems()
    {
        return count($this->childItems);
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
     * setDepth
     *
     * @param int $depth menu item's depth
     *
     * @return void
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    /**
     * setBreadCrumbs
     *
     * @param array $ids breadcrumbs string key array
     *
     * @return void
     */
    public function setBreadCrumbs(array $ids)
    {
        $this->breadCrumbs = $ids;
    }

    /**
     * getDepth
     *
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * getBreadCrumbs
     *
     * @return array
     */
    public function getBreadCrumbs()
    {
        return $this->breadCrumbs;
    }

    /**
     * getBreadCrumbsKeyString
     *
     * @param bool $excludeSelf if this is true return array exclude self id
     *
     * @return string
     */
    public function getBreadCrumbsKeyString($excludeSelf = false)
    {
        if ($excludeSelf) {
            array_pop($this->breadCrumbs);
        }
        return implode('.', $this->breadCrumbs);
    }

    /**
     * setTreeNodePath
     *
     * @param string $path include tree path - hierarchy
     *
     * @return void
     */
    public function setTreeNodePath($path)
    {
        $breadCrumbs = explode(',', $path);
        $this->breadCrumbs = $breadCrumbs;
        $this->attributes['menuId'] = $breadCrumbs[0];
        $this->attributes['parentId'] = $breadCrumbs[(sizeof($breadCrumbs) -2)];
    }

    /**
     * setPermission
     *
     * @param MenuPermission $permission menu's access and visible permission
     *
     * @return void
     */
    public function setPermission(MenuPermission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * getPermission
     *
     * @return mixed
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * applyPermission
     *
     * @param MenuPermission[] $permissions menu permission array
     *
     * @return void
     */
    public function applyPermission($permissions)
    {
        $this->permission = $permissions[$this->getBreadCrumbsKeyString()];

        if ($this->hasChild()) {
            foreach ($this->childItems as $item) {
                $item->applyPermission($permissions);
            }
        }

    }

    /**
     * checkAccessPermission
     *
     * @param MemberEntityInterface $user if user param is not null check permission for user param
     *
     * @return mixed
     */
    public function checkAccessPermission($user)
    {
        $this->permission->setUser($user);
        $able = $this->permission->ables(ACTION::ACCESS);
        return $able;
    }

    /**
     * checkVisiblePermission
     *
     * @param MemberEntityInterface $user if user param is not null check permission for user param
     *
     * @return mixed
     */
    public function checkVisiblePermission($user)
    {
        $this->permission->setUser($user);
        return $this->permission->ables(ACTION::VISIBLE);
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
