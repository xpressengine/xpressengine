<?php
/**
 * Menu Entity
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
use Xpressengine\Menu\Exceptions\NotFoundMenuItemException;
use Xpressengine\Menu\Permission\MenuPermission;
use Xpressengine\Support\Entity;
use Xpressengine\Support\Tree\TreeCollection;

/**
 * MenuEntity
 * Menu 패키지에서 Item 들을 저장하고 있는 메뉴의 단위 ex) 메인메뉴
 * Tree 정보를 담고 있는 TreeCollection 을 가지고 있다
 *
 * ## 생성자에서 필요한 항목들
 * * attributes array - EntityTrait 을 사용하므로 생성자에서 속성에 해당하는 array 를 받는다
 * * MenuItem (Node) 들의 Tree 정보를 담고 있는 TreeCollection 을 받는다
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 *
 * @property string $id          자동생성된 고유한 식별자
 * @property string $title       메뉴의 이름
 * @property string $description 설명
 * @property string $site        사이트 식별
 *
 */
class MenuEntity extends Entity
{
    /**
     * @var TreeCollection MenuItem 들을 Tree 형태로 가지고 있는 Collection 객체
     */
    protected $treeCollection;
    /**
     * @var bool 주로 UI 상에서 표현을 위한 선택되어진 유무를 가지고 있음
     */
    protected $selected = false;
    /**
     * @var MenuPermission $permission 해당 메뉴의 권한. 하위의 item 들이 참조할 때 사용됨
     */
    protected $permission;

    /**
     * @param array          $attributes     to menu entity instance attributes
     * @param TreeCollection $treeCollection tree has item collection
     */
    public function __construct(array $attributes, TreeCollection $treeCollection)
    {
        parent::__construct($attributes);

        $this->treeCollection = $treeCollection;
    }

    /**
     * applyPermission
     *
     * @param MenuPermission[] $permissions menu permissions to apply self and children items
     *
     * @return void
     */
    public function applyPermission(array $permissions)
    {
        $this->permission = $permissions[$this->id];

        /**
         * @var MenuItem[] $items
         */
        $items = $this->treeCollection->getNodes();

        foreach ($items as $item) {
            $item->setPermission($permissions[$item->getBreadCrumbsKeyString()]);
        }
    }

    /**
     * Add New MenuItem on Menu
     * ReArrange Menu Tree
     *
     * @param MenuItem $item MenuItem Object to Add at Menu
     *
     * @return void
     */
    public function addItem(MenuItem $item)
    {
        $this->treeCollection->add($item);
    }

    /**
     * Return count of Items
     * countItem
     *
     * @return int
     */
    public function countItem()
    {
        return $this->treeCollection->size();
    }

    /**
     * Return MenuItems with Raw Items
     *
     * @return MenuItem[]
     */
    public function getRawItems()
    {
        return $this->treeCollection->getNodes();
    }

    /**
     * Return MenuItems with Tree Structure
     *
     * @return MenuItem[]
     */
    public function getItems()
    {
        return $this->treeCollection->getTree();
    }

    /**
     * Return MenuItem by Item Id
     * menu have empty or many items
     * this method return item that menu has
     * if can not found, not found menu item exception is thrown
     *
     * @param string $itemId to find item's id
     *
     * @return MenuItem
     * @throws NotFoundMenuItemException
     */
    public function getItem($itemId)
    {
        if ($this->treeCollection->offsetExists($itemId)) {
            return $this->treeCollection->offsetGet($itemId);
        } else {
            throw new NotFoundMenuItemException(['id' => $itemId]);
        }
    }

    /**
     * hasItem
     * menu have empty or many items
     * this method return menu has the items
     *
     * @param string $itemId to find item's id
     *
     * @return bool
     */
    public function hasItem($itemId)
    {
        return $this->treeCollection->offsetExists($itemId);
    }

    /**
     * setSelected
     * almost this attribute can use that menu is selected on view
     *
     * @param bool $selected if this is true this entity is selected
     *
     * @return void
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;
    }

    /**
     * setItemSelected
     *
     * @param string $itemId   menuItem id to check selected flag
     * @param bool   $selected selected flag
     *
     * @return void
     */
    public function setItemSelected($itemId, $selected = true)
    {
        if ($this->hasItem($itemId)) {
            $this->getItem($itemId)->setSelected($selected);
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
     * checkAccessPermission
     *
     * @param MemberEntityInterface $user to check permission user
     *
     * @return mixed
     */
    public function checkAccessPermission(MemberEntityInterface $user = null)
    {
        if ($user !== null) {
            $this->permission->setUser($user);
        }
        return $this->permission->ables('access');
    }

    /**
     * checkVisiblePermission
     *
     * @param MemberEntityInterface $user to check permission user
     *
     * @return mixed
     */
    public function checkVisiblePermission(MemberEntityInterface $user = null)
    {
        if ($user !== null) {
            $this->permission->setUser($user);
        }
        return $this->permission->ables('visible');
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *       which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return array_merge($this->attributes, [
            'items' => $this->treeCollection,
            'entity' => 'menu',
            'itemCount' => $this->countItem()
        ]);
    }
}
