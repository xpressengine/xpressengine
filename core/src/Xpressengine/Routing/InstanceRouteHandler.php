<?php
/**
 * Instance Route Handler
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

use Illuminate\Contracts\Config\Repository as IlluminateConfig;
use Xpressengine\Routing\Exceptions\NotFoundInstanceRouteException;
use Xpressengine\Site\SiteHandler;

/**
 * InstanceRouteHandler
 * InstanceRoute 를 관리하는 클래스
 *
 * ## app binding
 * * xe.router 으로 바인딩 되어 있음
 * * 별도의 Facade 는 제공하지 않음
 *
 * ## 생성자에서 필요한 항목들
 * * InstanceRouteRepository $instanceRouteRepository - repository
 * * InstanceRouteCacheHandler $cache - cache 를 관리하는 핸들러
 * * IlluminateConfig $illuminateConfig - 라라벨의 cache repository
 *
 * ## 사용법
 *
 * ### SiteKey 에 해당하는 InstanceRoute 들 획득하기
 *
 * ```php
 * $handler->getsBySite($siteKey);
 * ```
 *
 * ### Url 에 해당하는 InstanceRoute 획득하기
 *
 * ```php
 * $handler->getByUrl($url);
 * ```
 *
 * ### InstanceId 에 해당하는 InstanceRoute 획득하기
 *
 * ```php
 * $handler->getByInstanceId($instanceId)
 * ```
 *
 * ### Module Id 에 해당하는 InstanceRoute 들 획득하기
 *
 * ```php
 * $handler->getsByModule($module);
 * ```
 *
 * ### 새로운 RouteInstance 추가
 *
 * ```php
 * $handler->add(InstanceRoute $instanceRoute);
 * ```
 *
 * ### InstanceRoute 수정
 * * InstanceRoute 의 정보 수정은 url 과 description 만 가능하다
 *
 * ```php
 * $handler->put(InstanceRoute $instanceRoute)
 * ```
 *
 * ### InstanceRoute 삭제
 *
 * ```php
 * $handler->remove(InstanceRoute $instanceRoute)
 * ```
 *
 * ### 신규로 생성하려는 InstanceRoute 의 Url 이 사용 가능한지 확인
 *
 * ```php
 * $handler->usableUrl($url);
 * ```
 *
 * @category Routing
 * @package  Xpressengine\Routing
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class InstanceRouteHandler
{
    /**
     * List of protected Url
     *
     * @var $protectedUrl
     */
    public static $protectedUrl = [
        'locale',
        'auth',
        'member',
        'file',
        'tag',
        'fieldType',
        'temporary',
    ];

    /**
     * @var InstanceRouteRepository $instanceRouteRepository
     */
    protected $instanceRouteRepository;
    /**
     * @var IlluminateConfig
     */
    protected $illuminateConfig;

    /**
     * @var SiteHandler
     */
    protected $siteHandler;
    /**
     * @var InstanceRouteCacheHandler
     */
    protected $cache;
    /**
     * @var InstanceRoute[]
     */
    protected $loadedInstanceRoutes = [];

    /**
     * Construct
     *
     * @param InstanceRouteRepository   $instanceRouteRepository instance route repository
     * @param InstanceRouteCacheHandler $cache                   illuminate cache manager
     * @param IlluminateConfig          $illuminateConfig        illuminate config
     */
    public function __construct(
        InstanceRouteRepository $instanceRouteRepository,
        InstanceRouteCacheHandler $cache,
        IlluminateConfig $illuminateConfig
    ) {
        $this->instanceRouteRepository = $instanceRouteRepository;
        $this->illuminateConfig = $illuminateConfig;
        $this->cache = $cache;
    }

    /**
     * Get All Instance Route of site
     * return list of all Instance Route from Repo
     *
     * @param string $siteKey to get siteKey
     *
     * @return InstanceRoute[]
     */
    public function getsBySite($siteKey)
    {
        if ($this->cache->isExistCachedSiteInstanceRoutes($siteKey)) {
            $instanceRoutes = $this->cache->getCachedSiteInstanceRoutes($siteKey);
            array_merge($this->loadedInstanceRoutes, $instanceRoutes);
            return $instanceRoutes;
        }

        $filter = function ($query) use ($siteKey) {
            return $query->where('site', '=', $siteKey);
        };

        $instanceRoutes = $this->instanceRouteRepository->fetch($filter);
        $this->loadedInstanceRoutes = array_merge($this->loadedInstanceRoutes, $instanceRoutes);
        $this->cache->setSiteInstanceCache($siteKey, $instanceRoutes);

        return $instanceRoutes;
    }

    /**
     * Get One Instance Route
     * return one Instance Route from repo
     *
     * @param string $siteKey site key
     * @param string $url     to get instance route
     *
     * @return InstanceRoute
     */
    public function getByUrl($siteKey, $url)
    {
        foreach ($this->loadedInstanceRoutes as $instanceRoute) {
            if ($instanceRoute->url === $url) {
                return $instanceRoute;
            }
        }
        $instanceRoutes = $this->getsBySite($siteKey);
        foreach ($instanceRoutes as $instanceRoute) {
            if ($instanceRoute->url === $url) {
                return $instanceRoute;
            }
        }
        throw new NotFoundInstanceRouteException;
    }

    /**
     * Get One Instance Route
     * return one Instance Route from repo
     *
     * @param string $instanceId instance id
     *
     * @return InstanceRoute
     * @throws Exceptions\NotFoundInstanceRouteException
     *
     */
    public function getByInstanceId($instanceId)
    {
        if (isset($this->loadedInstanceRoutes[$instanceId])) {
            return $this->loadedInstanceRoutes[$instanceId];
        } else {
            if ($this->cache->isExistCachedInstanceRoute($instanceId)) {
                $instanceRoute = $this->cache->getCachedInstanceRoute($instanceId);
            } else {
                $instanceRoute = $this->instanceRouteRepository->find($instanceId);
                $this->cache->setInstanceRouteCache($instanceId, $instanceRoute);
            }
            $this->loadedInstanceRoutes[$instanceId] = $instanceRoute;
            return $instanceRoute;
        }
    }

    /**
     * Get InstanceRoutes by module
     * return Generator Multi Instance Routes from repo
     *
     * @param string $module module id
     *
     * @return InstanceRoute[]
     */
    public function getsByModule($module)
    {
        $instanceRoutes = $this->instanceRouteRepository->fetch(function ($query) use ($module) {
            return $query->where('module', '=', $module);
        });
        $this->loadedInstanceRoutes = array_merge($this->loadedInstanceRoutes, $instanceRoutes);
        return $instanceRoutes;
    }

    /**
     * Create New Instance Route
     *
     * @param InstanceRoute $instanceRoute insert new instance Route to Repo
     *
     * @return InstanceRoute
     */
    public function add(InstanceRoute $instanceRoute)
    {
        $this->instanceRouteRepository->insert($instanceRoute);
        $this->cache->deleteCachedInstanceRoute($instanceRoute->instanceId);
        $this->cache->deleteCachedSiteInstanceRoutes($instanceRoute->site);
        $this->loadedInstanceRoutes[$instanceRoute->instanceId] = $instanceRoute;
        return $instanceRoute;
    }

    /**
     * Modify Instance Route Info
     *
     * @param InstanceRoute $instanceRoute update instance Route information
     *
     * @return InstanceRoute
     */
    public function put(InstanceRoute $instanceRoute)
    {
        $this->instanceRouteRepository->update($instanceRoute);
        $this->cache->deleteCachedInstanceRoute($instanceRoute->instanceId);
        $this->cache->deleteCachedSiteInstanceRoutes($instanceRoute->site);
        $this->loadedInstanceRoutes[$instanceRoute->instanceId] = $instanceRoute;
        return $instanceRoute;
    }

    /**
     * Delete Instance Route
     *
     * @param InstanceRoute $instanceRoute to delete instance Route
     *
     * @return int $affectedRow
     */
    public function remove(InstanceRoute $instanceRoute)
    {
        $result = $this->instanceRouteRepository->delete($instanceRoute->instanceId);
        $this->cache->deleteCachedInstanceRoute($instanceRoute->instanceId);
        $this->cache->deleteCachedSiteInstanceRoutes($instanceRoute->site);
        if (isset($this->loadedInstanceRoutes[$instanceRoute->instanceId])) {
            unset($this->loadedInstanceRoutes[$instanceRoute->instanceId]);
        }
        return $result;
    }

    /**
     * usableUrl
     *
     * @param string $siteKey site key
     * @param string $url     url
     *
     * @return bool
     */
    public function usableUrl($siteKey, $url)
    {
        $checkIncludingSlash = strpos($url, '/');
        if ($checkIncludingSlash !== false) {
            return false;
        }

        $configUrl = [
            $this->illuminateConfig->get('xe.routing.fixedPrefix'),
            $this->illuminateConfig->get('xe.routing.settingsPrefix')
        ];

        if (($this->instanceRouteRepository->countByUrl($siteKey, $url) > 0)
            or
            (in_array($url, static::$protectedUrl))
            or
            (in_array($url, $configUrl))
        ) {
            return false;
        } else {
            return true;
        }
    }
}
