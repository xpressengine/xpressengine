<?php
/**
 * Menu Repository
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

use Exception;
use Illuminate\Database\QueryException;
use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Menu\Exceptions\CanNotCreateItemException;
use Xpressengine\Menu\Exceptions\CanNotCreateMenuException;
use Xpressengine\Menu\Exceptions\NotFoundMenuException;
use Xpressengine\Menu\Exceptions\NotFoundMenuItemException;
use Xpressengine\Support\Tree\ClosureTableTrait;
use Xpressengine\Support\Tree\TreeCollection;

/**
 * Menu Repository
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class DBMenuRepository implements MenuRepositoryInterface
{
    use ClosureTableTrait;

    protected $treeTable = 'menu';
    protected $nodeTable = 'menuItem';
    protected $hierarchyTable = 'menuTreePath';

    /**
     * @var Keygen
     */
    protected $keyGen;

    public $DUPLICATE_RETRY_CNT = 2;

    /**
     * @param VirtualConnectionInterface $conn   database conn
     * @param KeyGen                     $keyGen key gen
     */
    public function __construct(VirtualConnectionInterface $conn, KeyGen $keyGen)
    {
        $this->conn = $conn;
        $this->keyGen = $keyGen;
    }

    /**
     * Get One Menu by Menu ID
     *
     * @param string $menuId string Menu ID
     *
     * @return MenuEntity
     */
    public function findMenu($menuId)
    {
        $menuRow = $this->getMenuRow($menuId);
        if ($menuRow === null) {
            throw new NotFoundMenuException($menuId);
        }
        $treeCollection = $this->fetchTree(new MenuItem(['id' => $menuId]));
        $menu = $this->createTreeModel($menuRow, $treeCollection);

        return $menu;
    }

    /**
     * Get One Menu by Menu Item ID
     *
     * @param string $itemId string Menu Item ID
     *
     * @return MenuEntity
     */
    public function findMenuByItem($itemId)
    {
        $menuId = $this->getMenuIdByItem($itemId);
        return $this->findMenu($menuId);
    }

    /**
     * findAllMenu
     * Return All Array of Menu Ids
     *
     * @param string $siteKey site key
     *
     * @return array
     */
    public function findAllMenuIds($siteKey)
    {
        $menuRows = $this->getMenuRows(['id'], function ($query) use ($siteKey) {
            $query->where('site', '=', $siteKey);
        });
        $menus = array_map(function ($menu) {
            return $menu['id'];
        }, $menuRows);
        return $menus;
    }

    /**
     * Get One Item by Item ID
     *
     * @param string $itemId string Item ID
     *
     * @return MenuItem
     */
    public function findItem($itemId)
    {
        $prefix = $this->conn->getTablePrefix();
        $row = $this->conn->table($this->nodeTable . ' as t')
            ->selectRaw(
                "{$prefix}t.*, {$prefix}h.`depth`, GROUP_CONCAT({$prefix}crumbs.`ancestor` " .
                "order by {$prefix}crumbs.`depth` desc) AS breadcrumbs"
            )
            ->join($this->hierarchyTable . ' as h', 't.id', '=', 'h.descendant')
            ->join($this->hierarchyTable . ' as crumbs', 'crumbs.descendant', '=', 'h.descendant')
            ->where('h.ancestor', $itemId)
            ->where('h.depth', 0)
            ->groupBy('t.id')
            ->first();

        if ($row === null) {
            throw new NotFoundMenuItemException($itemId);
        }

        $node = $this->createNodeModel(array_diff_key($row, array_flip(['depth', 'breadcrumbs'])));
        $node->setdepth($row['depth']);
        $node->setBreadcrumbs(explode(',', $row['breadcrumbs']));

        return $node;
    }

    /**
     * count id 에 해당하는 MenuEntity 가 이미 존재하는지 확인
     *
     * @param string $menuId MenuEntity id
     *
     * @return int
     */
    public function countMenu($menuId)
    {
        return $this->conn->table($this->treeTable)->where('id', '=', $menuId)->count();
    }

    /**
     * count id 에 해당하는 MenuItem 이 이미 존재하는지 확인
     *
     * @param string $itemId item id
     *
     * @return int
     */
    public function countItem($itemId)
    {
        return $this->conn->table($this->nodeTable)->where('id', '=', $itemId)->count();
    }

    /**
     * Get children node items
     *
     * @param MenuItem $parent item object
     *
     * @return MenuItem[]
     */
    public function children(MenuItem $parent)
    {
        $children = $this->fetchDesc($parent, 1);

        return $this->sort($children);
    }

    /**
     * Update Menu Object
     *
     * @param MenuEntity $menu menu object for update
     *
     * @return int $affectedRow
     */
    public function updateMenu(MenuEntity $menu)
    {
        $affectedRow = $this->conn->table($this->treeTable)
            ->where('id', $menu->id)
            ->update(
                [
                    'title' => $menu->title
                    ,
                    'description' => $menu->description
                ]
            );
        return $affectedRow;
    }

    /**
     * Delete Menu
     *
     * @param MenuEntity $menu menu instance of menu entity
     *
     * @return void
     * @throws Exception
     */
    public function deleteMenu(MenuEntity $menu)
    {
        $this->conn->beginTransaction();

        try {
            $this->conn->table($this->hierarchyTable)
                ->where('ancestor', '=', $menu->id)
                ->delete();
            $this->conn->table($this->nodeTable)
                ->whereIn('id', function ($query) use ($menu) {
                    $query->select(['descendant'])
                        ->from($this->nodeTable)
                        ->where('ancestor', '=', $menu->id)
                        ->get();
                })
                ->delete();
            $this->conn->table($this->treeTable)->where('id', '=', $menu->id)->delete();
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }

        $this->conn->commit();

    }

    /**
     * Create New Menu
     *
     * @param MenuEntity $menu new menu object to create
     *
     * @return MenuEntity
     */
    public function insertMenu(MenuEntity $menu)
    {
        $cnt = 0;
        $result = false;
        while (!$result && ($cnt++ < $this->DUPLICATE_RETRY_CNT)) {
            $menu->id = $this->generateNewId();
            try {
                $result = $this->conn->table($this->treeTable)
                    ->insert(
                        $menu->getAttributes()
                    );
            } catch (QueryException $e) {
                $sqlState = $e->errorInfo[0];
                if ($sqlState === "23000") {
                    $result = false;
                } else {
                    throw $e;
                }
            }
        }

        if ($result) {
            return $menu;
        }
        throw new CanNotCreateMenuException;
    }

    /**
     * Create New Item on Menu
     *
     * @param MenuItem $item new menuItem object to add at menu
     *
     * @return MenuItem
     * @throws Exception
     */
    public function insertItem(MenuItem $item)
    {
        $cnt = 0;
        $result = false;
        while (!$result && ($cnt++ < $this->DUPLICATE_RETRY_CNT)) {
            $item->id = $this->generateNewId();
            try {
                $result = $this->conn->table($this->nodeTable)
                    ->insert(
                        $item->getAttributes()
                    );

            } catch (QueryException $e) {
                $sqlState = $e->errorInfo[0];
                if ($sqlState === "23000") {
                    $result = false;
                } else {
                    throw $e;
                }
            }
        }

        if ($result) {
            return $item;
        }
        throw new CanNotCreateItemException;
    }

    /**
     * Update MenuItem
     *
     * @param MenuItem $item item instance has updated attributes
     *
     * @return int affected row count
     */
    public function updateItem(MenuItem $item)
    {
        return $this->conn->table($this->nodeTable)
            ->where('id', $item->id)
            ->update([
                'title' => $item->title,
                'url' => $item->url,
                'description' => $item->description,
                'target' => $item->target,
                'ordering' => $item->ordering,
                'activated' => $item->activated,
            ]);
    }

    /**
     * Delete Menu Item Menu Id & by Item Id
     *
     * @param MenuItem $item item
     *
     * @return int $affectedRow
     * @throws Exception
     */
    public function deleteItem(MenuItem $item)
    {
        $this->conn->beginTransaction();

        try {
            $affected = $this->conn->table($this->nodeTable)->where('id', '=', $item->id)->delete();
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }

        $this->conn->commit();

        return $affected;
    }

    /**
     * Sort item by ordering value
     *
     * @param MenuItem[] $items array of item objects
     *
     * @return MenuItem[]
     */
    protected function sort(array $items)
    {
        uasort($items, function ($preItem, $postItem) {
            if ($preItem->ordering == $postItem->ordering) {
                return 0;
            }
            return $preItem->ordering < $postItem->ordering ? -1 : 1;
        });

        return $items;
    }

    /**
     * return Menu XeDB row by menu Id
     *
     * @param string $menuId menu Id to get
     *
     * @return mixed
     */
    protected function getMenuRow($menuId)
    {
        $menuRow = $this->conn->table($this->treeTable)
            ->where('id', '=', $menuId)
            ->first();
        return $menuRow;
    }

    /**
     * return Menu XeDB row by menu Id
     *
     * @param string $itemId menuItem Id to get
     *
     * @return string
     */
    public function getMenuIdByItem($itemId)
    {
        $menuRow = $this->conn->table($this->hierarchyTable)
            ->where('descendant', '=', $itemId)
            ->orderBy('depth', 'desc')
            ->select('ancestor')
            ->first();

        if ($menuRow === null) {
            throw new NotFoundMenuException($itemId);
        }

        return $menuRow['ancestor'];
    }

    /**
     * return All Menu XeDB rows
     *
     * @param array    $columns want to find menu columns
     * @param callable $filter  where filter
     *
     * @return mixed
     */
    protected function getMenuRows($columns = array('*'), callable $filter = null)
    {
        $query = $this->conn->table($this->treeTable);
        if ($filter !== null) {
            $query->where($filter);
        }

        $menuRows = $query->get($columns);
        return $menuRows;
    }

    /**
     * create a new tree model
     *
     * @param array          $attributes     model's attributes
     * @param TreeCollection $treeCollection menu item's tree collection
     *
     * @return MenuEntity
     */
    protected function createTreeModel(array $attributes, TreeCollection $treeCollection)
    {
        return new MenuEntity($attributes, $treeCollection);
    }

    /**
     * create a new node model
     *
     * @param array $attributes model's attributes
     *
     * @return MenuItem
     */
    protected function createNodeModel(array $attributes)
    {
        return new MenuItem($attributes);
    }

    /**
     * generateNewId
     *
     * @return string
     */
    protected function generateNewId()
    {
        $newId = substr($this->keyGen->generate(), 0, 8);
        return $newId;
    }
}
