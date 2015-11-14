<?php
/**
 * This file is category handler class.
 *
 * PHP version 5
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Category;

use Xpressengine\Category\Exceptions\UnableMoveToSelfException;
use Xpressengine\Support\Tree\TreeCollection;

/**
 * # CategoryHandler
 * 여러단어들로 구성된 카테고리 처리를 담당
 *
 * ### app binding : xe.category 로 바인딩 되어 있음
 * `Category` Facade 로 접근 가능
 *
 * ### 카테고리 생성
 * ```php
 *  // 신규 카테고리 그룹 생성
 *  $category = Category::create();
 *  // 카테고리 그룹에 아이템 추가
 *  $item = Category::createItem($category, ['word' => '단어', 'description' => '설명']);
 *  // 특정 단어의 하위 노드로 등록하고자 할땐
 *  // 3번째 인자로 부모에 해당하는 아이템을 넘겨주면 됩니다.
 *  $child = Category::createItem($category, ['word' => '자식'], $item);
 * ```
 *
 * ### 카테고리 사용
 * ```php
 *  // 최상위 레벨 아이템 목록
 *  $items = Category::progenitors($category);
 *  // 특정 아이템의 하위 노드 아이템 목록
 *  $item = array_shift($items);
 *  $_1depthItems = Category::children($item);
 * ```
 *
 * 전체를 tree collection 으로 반환 받을수도 있습니다.
 * ```php
 *  $category = Category::get($id);
 *  $tree = Category::getTree($category);
 * ```
 *
 * ### 특정 대상과 카테고리 아이템의 연결
 * 카테고리 패키지는 대상이 어떤 단어를 사용하는지에 대한 정보를 가지고 관리합니다.
 * ```php
 *  // 연결
 *  Category::used($docId, $categoryItem);
 *  // 해제
 *  Category::unused($docId, $categoryItem);
 * ```
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CategoryHandler
{
    /**
     * Repository instance
     *
     * @var CategoryRepository
     */
    protected $repo;

    /**
     * ItemRepository instance
     *
     * @var CategoryItemRepository
     */
    protected $itemRepo;

    /**
     * Constructor
     *
     * @param CategoryRepository     $repo     Repository instance
     * @param CategoryItemRepository $itemRepo ItemRepository instance
     */
    public function __construct(CategoryRepository $repo, CategoryItemRepository $itemRepo)
    {
        $this->repo = $repo;
        $this->itemRepo = $itemRepo;
    }

    /**
     * Get a category
     *
     * @param int $id category id
     * @return null|CategoryEntity
     */
    public function get($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Create new category
     *
     * @param array $inputs attributes for created
     * @return CategoryEntity
     */
    public function create(array $inputs)
    {
        $category = new CategoryEntity();
        foreach ($inputs as $key => $val) {
            $category->{$key} = $val;
        }

        return $this->add($category);
    }

    /**
     * Category add to repository
     *
     * @param CategoryEntity $category category object
     * @return CategoryEntity
     */
    public function add(CategoryEntity $category)
    {
        return $this->repo->insert($category);
    }

    /**
     * Remove category
     *
     * @param CategoryEntity $category category object
     * @return int affecting statement
     */
    public function remove(CategoryEntity $category)
    {
        return $this->repo->delete($category);
    }

    /**
     * Increment count has items
     *
     * @param CategoryEntity $category category object
     * @param int            $amount   increase amount
     * @return int affecting statement
     */
    public function increment(CategoryEntity $category, $amount = 1)
    {
        return $this->repo->increment($category, $amount);
    }

    /**
     * @param CategoryEntity $category category object
     * @param int            $amount   decrease amount
     * @return int affecting statement
     */
    public function decrement(CategoryEntity $category, $amount = 1)
    {
        return $this->repo->decrement($category, $amount);
    }

    /**
     * Get a category item
     *
     * @param int $id item id
     * @return null|CategoryItemEntity
     */
    public function getItem($id)
    {
        return $this->itemRepo->find($id);
    }

    /**
     * Create a new category item
     *
     * @param CategoryEntity     $category category object
     * @param array              $inputs   item attributes for created
     * @param CategoryItemEntity $parent   parent item object
     * @return CategoryItemEntity
     */
    public function createItem(CategoryEntity $category, array $inputs, CategoryItemEntity $parent = null)
    {
        $item = new CategoryItemEntity();
        foreach ($inputs as $key => $val) {
            $item->{$key} = $val;
        }

        return $this->addItem($category, $item, $parent);
    }

    /**
     * Add a category item
     *
     * @param CategoryEntity     $category category object
     * @param CategoryItemEntity $item     item object
     * @param CategoryItemEntity $parent   parent item object
     * @return CategoryItemEntity
     */
    public function addItem(CategoryEntity $category, CategoryItemEntity $item, CategoryItemEntity $parent = null)
    {
        $item->categoryId = $category->id;

        $item = $this->itemRepo->insert($item);
        $this->itemRepo->insertHierarchy($item, $parent);

        // set default last
        $this->setOrder($item, $category->count);

        $this->increment($category);

        return $item;
    }

    /**
     * Modify item information
     *
     * @param CategoryItemEntity $item item object
     * @return CategoryItemEntity
     */
    public function putItem(CategoryItemEntity $item)
    {
        return $this->itemRepo->update($item);
    }

    /**
     * Remove single item or all descendant
     *
     * @param CategoryItemEntity $item  item object
     * @param bool               $batch if true then remove all descendant
     * @return void
     */
    public function removeItem(CategoryItemEntity $item, $batch = true)
    {
        $parent = $children = null;

        if ($batch === true) {
            $items = $this->itemRepo->fetchDesc($item, 0, false);
        } else {
            $items = [$item];
            $parent = $this->parent($item);
            $children = $this->children($item);
        }

        $category = $this->get($item->categoryId);
        foreach ($items as $item) {
            $this->decrement($category);

            $this->itemRepo->delete($item);
            $this->itemRepo->removeHierarchy($item);
        }

        if ($parent && $children) {
            foreach ($children as $child) {
                $this->itemRepo->insertHierarchy($child, $parent);
            }
        }
    }

    /**
     * All categories item in a tree form
     *
     * @param CategoryEntity $category category object
     * @return TreeCollection
     */
    public function getTree(CategoryEntity $category)
    {
        $progenitors = $this->progenitors($category);

        $items = [];
        foreach ($progenitors as $progenitor) {
            $tree = $this->itemRepo->fetchTree($progenitor);
            $items = array_merge($items, $tree->getNodes());
        }

        return new TreeCollection($items);
    }

    /**
     * Get top level items
     *
     * @param CategoryEntity $category category object
     * @return array of item object
     */
    public function progenitors(CategoryEntity $category)
    {
        return $this->progenitorsByCategoryId($category->id);
    }

    /**
     * Get top level items by category id
     *
     * @param int $categoryId category id
     * @return array of item object
     */
    public function progenitorsByCategoryId($categoryId)
    {
        $progenitors = $this->itemRepo->fetchProgenitor($categoryId);

        return $this->sort($progenitors);
    }

    /**
     * Get a parent node item
     *
     * @param CategoryItemEntity $child item object
     * @return CategoryItemEntity|null
     */
    public function parent(CategoryItemEntity $child)
    {
        $parent = $this->itemRepo->fetchAsc($child, 1);

        return array_shift($parent);
    }

    /**
     * Get children node items
     *
     * @param CategoryItemEntity $parent item object
     * @return CategoryItemEntity[]
     */
    public function children(CategoryItemEntity $parent)
    {
        $children = $this->itemRepo->fetchDesc($parent, 1);

        return $this->sort($children);
    }

    /**
     * Sort item by ordering value
     *
     * @param array $items array of item objects
     * @return array of item objects
     */
    private function sort(array $items)
    {
        usort($items, function ($a, $b) {
            if ($a->ordering == $b->ordering) {
                return 0;
            }
            return $a->ordering < $b->ordering ? -1 : 1;
        });

        return $items;
    }

    /**
     * Move to another parent node
     *
     * @param CategoryItemEntity $item   item object
     * @param CategoryItemEntity $parent new parent item object
     * @return void
     * @throws UnableMoveToSelfException
     */
    public function moveTo(CategoryItemEntity $item, CategoryItemEntity $parent = null)
    {
        if ($parent !== null && $item->id === $parent->id) {
            throw new UnableMoveToSelfException();
        }

        $oldParent = $this->parent($item);

        if ($oldParent !== null && $parent !== null && $oldParent->id == $parent->id) {
            return;
        }

        if ($oldParent !== null) {
            $this->itemRepo->unlinkHierarchy($item, $oldParent);
        }

        if ($parent !== null) {
            $this->itemRepo->linkHierarchy($item, $parent);
        }
    }

    /**
     * Set item ordering value
     *
     * @param CategoryItemEntity $item     item object
     * @param int                $ordering sequence value
     * @return void
     */
    public function setOrder(CategoryItemEntity $item, $ordering)
    {
        $parent = $this->parent($item);

        if ($parent === null) {
            $children = $this->progenitorsByCategoryId($item->categoryId);
        } else {
            $children = $this->children($parent);
        }

        $children = array_filter($children, function ($child) use ($item) {
            return $child->id != $item->id;
        });

        $children = array_merge(
            array_slice($children, 0, $ordering),
            [$item],
            array_slice($children, $ordering)
        );

        $seq = 0;
        foreach ($children as $child) {
            $child->ordering = $seq;
            $this->itemRepo->update($child);
            $seq++;
        }
    }

    /**
     * Set a target used category item
     *
     * @param string             $targetId target id
     * @param CategoryItemEntity $item     item object
     * @return void
     */
    public function used($targetId, CategoryItemEntity $item)
    {
        if (!$this->itemRepo->existsUsed($targetId, $item)) {
            $this->itemRepo->insertUsed($targetId, $item);

            $item->count++;
            $this->itemRepo->update($item);
        }
    }

    /**
     * Set a target unused category item
     *
     * @param string             $targetId target id
     * @param CategoryItemEntity $item     item object
     * @return void
     */
    public function unused($targetId, CategoryItemEntity $item)
    {
        if ($this->itemRepo->existsUsed($targetId, $item)) {
            $this->itemRepo->deleteUsed($targetId, $item);

            $item->count--;
            $this->itemRepo->update($item);
        }
    }

    /**
     * Get a target used items
     *
     * @param string $targetId target id
     * @return CategoryItemEntity[]
     */
    public function hasMany($targetId)
    {
        return $this->itemRepo->hasMany($targetId);
    }

    /**
     * Get an item's descendant count
     *
     * @param CategoryItemEntity $top   std item object for counting
     * @param int                $depth search depth value
     * @return int
     */
    public function count(CategoryItemEntity $top, $depth = 0)
    {
        return $this->itemRepo->count($top, $depth);
    }

    /**
     * Get item count by category
     *
     * @param CategoryEntity $category category object
     * @param int            $depth    search depth value
     * @return int
     */
    public function countByCategory(CategoryEntity $category, $depth)
    {
        $progenitors = $this->progenitors($category);

        if ($depth === 1) {
            return count($progenitors);
        }

        $count = 0;
        foreach ($progenitors as $progenitor) {
            $count += $this->count($progenitor, $depth - 1);
        }

        return $count + count($progenitors);
    }
}
