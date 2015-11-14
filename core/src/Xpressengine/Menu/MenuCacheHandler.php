<?php
/**
 * Menu class
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

use Illuminate\Cache\CacheManager;
use Xpressengine\Menu\Exceptions\NotFoundMenuException;

/**
 * MenuCacheHandler
 * 메뉴의 캐시을 체크하고, 관리하는 클래스
 * MenuEntity 에 대한 캐시를 관리하며 추가적으로
 * MenuEntity 와 MenuItem 이 연결된 Map 정보를 관리한다
 *
 * ## app binding
 * * xe.menu.cache 으로 바인딩 되어 있음
 * * Facade 는 제공하지 않음
 *
 * ## 생성자에서 필요한 항목들
 * * CacheManager $cache - Illuminate Cache 매니저. 라라벨의 고유 캐시를 사용
 *
 * ## 사용법
 *
 * ### MenuEntity 캐시 존재 여부 조회
 *
 * * MenuEntity 의 Id 를 인자로 전달
 *
 * ```php
 * $returnBool = $cacheHandler->isExistCachedMenu('mainMenu');
 * ```
 *
 * ### MenuEntity 캐시 획득
 *
 * * MenuEntity 의 Id 를 인자로 전달
 *
 * ```php
 * $menu = $cacheHandler->getCachedMenu('mainMenu');
 * ```
 *
 * ### MenuEntity 캐시 갱신
 *
 * * MenuEntity 를 인자로 전달
 *
 * ```php
 * $cacheHandler->setCachedMenu(MenuEntity $menu);
 * ```
 *
 * ### MenuEntity 캐시 삭제
 *
 * * MenuEntity 의 Id 를 인자로 전달
 *
 * ```php
 * $cacheHandler->deleteCachedMenu('mainMenu');
 * ```
 *
 * ### MenuEntity 와 MenuItem 의 연결정보(Map) 획득
 *
 * ```php
 * $returnArray = $cacheHandler->getMenuMap();
 * ```
 *
 * ### MenuEntity 와 MenuItem 의 연결정보(Map) 재생성
 * * 내부에 가지고 있는 map 정보를 재생성한다
 * * MenuEntity 를 인자로 전달
 *
 * ```php
 * $cacheHandler->generateMenuMap(MenuEntity $menu);
 * ```
 *
 * ### MenuEntity 와 MenuItem 의 연결정보(Map) 삭제
 * * 해당 인자로 전달된 MenuEntity 의 map 정보만 제거
 * * 내부에 가지고 있는 map 정보를 재생성한다
 * * MenuEntity 를 인자로 전달
 *
 * ```php
 * $cacheHandler->forgetMenuMap(MenuEntity $menu);
 * ```
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuCacheHandler
{
    /**
     * @var CacheManager $cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $menuMapKey = 'xe.menuMap';

    /**
     * @var string
     */
    protected $menuKeyPrefix = 'xe.menu.entity';

    public $debugMode;

    /**
     * Construct
     *
     * @param CacheManager $cache     illuminate cache manager
     * @param bool         $debugMode app env debug mode
     */
    public function __construct($cache, $debugMode)
    {
        $this->cache = $cache;
        $this->debugMode = $debugMode;
    }

    /**
     * isExistCachedMenu
     *
     * @param string $menuId id of entity to use menu cache key
     *
     * @return bool
     */
    public function isExistCachedMenu($menuId)
    {
        if ($this->debugMode) {
            return false;
        }
        $keyString = $this->getMenuCacheKeyString($menuId);
        return $this->cache->has($keyString);
    }

    /**
     * getCachedMenu
     *
     * @param string $menuId id of entity to use menu cache key
     *
     * @return mixed
     */
    public function getCachedMenu($menuId)
    {
        $keyString = $this->getMenuCacheKeyString($menuId);
        if ($this->isExistCachedMenu($menuId)) {
            return unserialize($this->cache->get($keyString));
        } else {
            throw new NotFoundMenuException;
        }
    }

    /**
     * setCachedMenu
     *
     * @param MenuEntity $menu caching target
     *
     * @return void
     */
    public function setCachedMenu(MenuEntity $menu)
    {
        $keyString = $this->getMenuCacheKeyString($menu->id);
        $this->cache->forever($keyString, serialize($menu));

        $itemKeyString = $this->getMenuItemCacheKeyString($menu->id);
        $items = $menu->getRawItems();
        $itemKeys = [];
        foreach ($items as $item) {
            $itemKeys[] = $item->title;
        }
        $this->cache->forever($itemKeyString, array_unique($itemKeys));
        $this->generateMenuMap($menu);
    }

    /**
     * deleteCachedMenu
     *
     * @param string $menuId key of cache
     *
     * @return void
     */
    public function deleteCachedMenu($menuId)
    {
        $keyString = $this->getMenuCacheKeyString($menuId);
        $this->cache->forget($keyString);

        $itemKeyString = $this->getMenuItemCacheKeyString($menuId);
        $this->cache->forget($itemKeyString);
        $this->forgetMenuMapByKey($menuId);
    }

    /**
     * getMenuItemKeys
     *
     * @param MenuEntity $menu to get menu item key
     *
     * @return array
     */
    public function getMenuItemKeys(MenuEntity $menu)
    {
        $itemKeyString = $this->getMenuItemCacheKeyString($menu->id);
        if ($this->cache->has($itemKeyString)) {
            return $this->cache->get($itemKeyString);
        } else {
            $items = $menu->getRawItems();
            $itemKeys = [];
            foreach ($items as $item) {
                $itemKeys[] = $item->title;
            }
            $this->cache->forever($itemKeyString, array_unique($itemKeys));
            return $itemKeys;
        }
    }


    /**
     * getMenuMap
     *
     * @return array
     */
    public function getMenuMap()
    {
        $menuMap = [];
        if ($this->cache->has($this->menuMapKey)) {
            $menuMap =  $this->cache->get($this->menuMapKey);
        }
        return $menuMap;
    }

    /**
     * generateMenuMap
     *
     * @param MenuEntity $menu to regenerate menu map menu object
     *
     * @return void
     */
    public function generateMenuMap(MenuEntity $menu)
    {
        $itemKeys = array_keys($menu->getRawItems());
        if ($this->cache->has($this->menuMapKey)) {
            /**
             * @var $menuMap array
             */
            $menuMap = $this->cache->get($this->menuMapKey);
            $menuMap = array_except($menuMap, $itemKeys);
        } else {
            $menuMap = [];
        }

        foreach ($itemKeys as $itemId) {
            $menuMap[$itemId] = $menu->id;
        }

        $this->cache->forever($this->menuMapKey, $menuMap);
    }

    /**
     * forgetMenuMap
     *
     * @param MenuEntity $menu to forget keys menu map menu object
     *
     * @return void
     */
    public function forgetMenuMap(MenuEntity $menu)
    {
        $itemKeys = array_keys($menu->getRawItems());
        if ($this->cache->has($this->menuMapKey)) {
            /**
             * @var $menuMap array
             */
            $menuMap = $this->cache->get($this->menuMapKey);
            $menuMap = array_except($menuMap, $itemKeys);
        } else {
            $menuMap = [];
        }

        $this->cache->forever($this->menuMapKey, $menuMap);
    }

    /**
     * forgetMenuMapByKey
     *
     * @param string $menuKey to forget on menu map
     *
     * @return void
     */
    public function forgetMenuMapByKey($menuKey)
    {
        $menuMap = [];
        if ($this->cache->has($this->menuMapKey)) {
            $oldMenuMap = $this->cache->get($this->menuMapKey);
            foreach ($oldMenuMap as $key => $value) {
                if ($key !== $menuKey && $key !== $value) {
                    $menuMap[$key] = $value;
                }
            }
        }

        $this->cache->forever($this->menuMapKey, $menuMap);
    }

    /**
     * getMenuCacheKeyString
     *
     * @param string $menuId menu entity id of cache to get
     *
     * @return string
     */
    protected function getMenuCacheKeyString($menuId)
    {
        return sprintf("%s.%s", $this->menuKeyPrefix, $menuId);
    }

    /**
     * getMenuItemCacheKeyString
     *
     * @param string $menuId menu entity id of cache to get
     *
     * @return string
     */
    protected function getMenuItemCacheKeyString($menuId)
    {
        return sprintf("%s.%s.items", $this->menuKeyPrefix, $menuId);
    }
}
