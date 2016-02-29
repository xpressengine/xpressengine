<?php

/**
 * InstanceRouteCacheHandler
 *
 * PHP version 5
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\Routing;

use Illuminate\Cache\Repository as CacheManager;
use Xpressengine\Routing\Exceptions\NotFoundInstanceRouteException;

/**
 * InstanceRouteCacheHandler
 * InstanceRoute 캐시을 체크하고, 관리하는 클래스
 *
 * ## app binding
 * * xe.router.cache 으로 바인딩 되어 있음
 * * 별도의 Facade 는 제공하지 않음
 *
 * ## 구성
 * * 캐시는 2가지를 기준으로 하여 관리되는데,
 * * 첫번째는 개별 InstanceRoute 를 InstanceId 를 기준으로 하여 캐시 관리
 * * 두번째는 SiteKey 를 기준으로 하여 캐시 관리
 *
 * ## 생성자에서 필요한 항목들
 * * CacheManager $cache - Laravel Cache Manager
 * * 캐시 정보를 Laravel Cache Manager 를 통해서 저장하고 확인한다
 *
 * ## 사용법
 *
 * ### InstanceRoute Cache 존재 유무 확인
 * * InstanceRoute 캐시가 존재하는지 확인
 *
 * ```php
 * $cacheHandler->isExistCachedInstanceRoute($instanceId);
 * ```
 *
 * ### SiteKey 에 해당하는 InstanceRoute 들에 대한 캐시 존재 유무 확인
 * * SiteKey 에 해당하는 InstanceRoute 캐시들 존재하는지 확인
 *
 * ```php
 * $cacheHandler->isExistCachedSiteInstanceRoutes($siteKey);
 * ```
 *
 * ### InstanceRoute Cache 획득
 * * InstanceRoute 캐시 획득
 *
 * ```php
 * $cacheHandler->getCachedInstanceRoute($instanceId);
 * ```
 *
 * ### SiteKey 에 해당하는 InstanceRoute 캐시 획득
 * * SiteKey 에 해당하는 InstanceRoute 캐시 가져오기
 *
 * ```php
 * $cacheHandler->getCachedSiteInstanceRoutes($siteKey);
 * ```
 *
 * ### InstanceId 에 해당하는 InstanceRoute 캐시 저장
 * * InstanceId 에 해당하는 InstanceRoute 캐시를 저장
 *
 * ```php
 * $cacheHandler->setInstanceRouteCache($instanceId, InstanceRoute $instanceRoute);
 * ```
 *
 * ### InstanceId 에 해당하는 InstanceRoute 캐시 삭제
 *
 * ```php
 * $cacheHandler->deleteCachedInstanceRoute($instanceId);
 * ```
 *
 * ### SiteKey 에 해당하는 InstanceRoute 들에 대한 캐시 저장
 *
 * ```php
 * $cacheHandler->setSiteInstanceCache($siteKey, $instanceRoutes)
 * ```
 *
 * ### SiteKey 에 해당하는 InstanceRoute 들에 대한 캐시 삭제
 *
 * ```php
 * $cacheHandler->deleteCachedSiteInstanceRoutes($siteKey);
 * ```
 *
 * @category Routing
 * @package  Xpressengine\Routing
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 *
 * @deprecated
 */

class InstanceRouteCacheHandler
{
    /**
     * @var CacheManager $cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $sitePrefixKey = 'xe.instance.site';

    /**
     * @var string
     */
    protected $instancePrefixKey = 'xe.instances';

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
     * isExistCachedInstanceRoute
     *
     * @param string $instanceId id of entity to use instance route cache key
     *
     * @return bool
     */
    public function isExistCachedInstanceRoute($instanceId)
    {
        if ($this->debugMode) {
            return false;
        }
        $keyString = $this->getInstanceRouteCacheKeyString($instanceId);
        return $this->cache->has($keyString);
    }

    /**
     * isExistCachedSiteInstanceRoutes
     *
     * @param string $siteKey key of to confirm exist site instance routes
     *
     * @return bool
     */
    public function isExistCachedSiteInstanceRoutes($siteKey)
    {
        if ($this->debugMode) {
            return false;
        }
        $keyString = $this->getSiteCacheKeyString($siteKey);
        return $this->cache->has($keyString);
    }

    /**
     * getCachedInstanceRoute
     *
     * @param string $instanceId id of instance route to use cache key
     *
     * @return mixed
     */
    public function getCachedInstanceRoute($instanceId)
    {
        $keyString = $this->getInstanceRouteCacheKeyString($instanceId);
        if ($this->isExistCachedInstanceRoute($instanceId)) {
            return unserialize($this->cache->get($keyString));
        } else {
            throw new NotFoundInstanceRouteException;
        }
    }

    /**
     * setInstanceRouteCache
     *
     * @param string        $instanceId    key of cache
     * @param InstanceRoute $instanceRoute caching target
     *
     * @return void
     */
    public function setInstanceRouteCache($instanceId, InstanceRoute $instanceRoute)
    {
        $keyString = $this->getInstanceRouteCacheKeyString($instanceId);
        $this->cache->forever($keyString, serialize($instanceRoute));
    }

    /**
     * deleteCachedInstanceRoute
     *
     * @param string $instanceId id of instance route
     *
     * @return void
     */
    public function deleteCachedInstanceRoute($instanceId)
    {
        $keyString = $this->getInstanceRouteCacheKeyString($instanceId);
        $this->cache->forget($keyString);
    }

    /**
     * getCachedSiteInstanceRoutes
     *
     * @param string $siteKey site key to get instance routes
     *
     * @return mixed
     */
    public function getCachedSiteInstanceRoutes($siteKey)
    {
        $keyString = $this->getSiteCacheKeyString($siteKey);
        if ($this->isExistCachedSiteInstanceRoutes($siteKey)) {
            return unserialize($this->cache->get($keyString));
        } else {
            throw new NotFoundInstanceRouteException;
        }
    }

    /**
     * setSiteInstanceCache
     *
     * @param string          $siteKey        to regenerate site instances cache
     * @param InstanceRoute[] $instanceRoutes instance routes array
     *
     * @return void
     */
    public function setSiteInstanceCache($siteKey, $instanceRoutes)
    {
        $keyString = $this->getSiteCacheKeyString($siteKey);
        $this->cache->forever($keyString, serialize($instanceRoutes));
    }

    /**
     * deleteCachedSiteInstanceRoutes
     *
     * @param string $siteKey key of site
     *
     * @return void
     */
    public function deleteCachedSiteInstanceRoutes($siteKey)
    {
        $keyString = $this->getSiteCacheKeyString($siteKey);
        $this->cache->forget($keyString);
    }

    /**
     * getInstanceRouteCacheKeyString
     *
     * @param string $instanceId instance route id of cache to get
     *
     * @return string
     */
    protected function getInstanceRouteCacheKeyString($instanceId)
    {
        return sprintf("%s.%s", $this->instancePrefixKey, $instanceId);
    }

    /**
     * getSiteCacheKeyString
     *
     * @param string $siteKey site key
     *
     * @return string
     */
    protected function getSiteCacheKeyString($siteKey)
    {
        return sprintf("%s.%s", $this->sitePrefixKey, $siteKey);
    }
}
