<?php
/**
 * SiteHandler
 *
 * PHP version 5
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Site;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Config\ConfigManager as Config;
use Xpressengine\Config\Exceptions\InvalidArgumentException;
use Xpressengine\Site\Exceptions\CanNotUseDomainException;

/**
 * SiteHandler
 * Site 를 관리하는 클래스
 *
 * ## app binding
 * * xe.site 으로 바인딩 되어 있음
 * * Site Facade 제공
 *
 * ## 생성자에서 필요한 항목들
 * * SiteRepository $repository - 사이트 repository
 * * Config $config - Config manager, 사이트의 설정 정보를 관리
 *
 * ## 사용법
 *
 * ### 현재의 Site 객체를 획득
 *
 * ```php
 * $handler->getCurrentSite()
 * ```
 *
 * ### 현재의 Site 객체를 지정
 *
 * ```php
 * $handler->setCurrentSite(Site $site)
 * ```
 *
 * ### 현재의 SiteKey 획득
 * * 현재 사이트 객체에서 사이트 키를 가져옴.
 * * 편의를 위해서 제공
 *
 * ```php
 * $handler->getCurrentSiteKey()
 * ```
 *
 * ### Site 의 ConfigEntity 획득
 * * siteKey 에 해당하는 설정 정보 가져옴
 * * siteKey 를 전달하지 않는 경우에는 defaultSiteKey 가 적용됨
 *
 * ```php
 * $handler->getSiteConfig($siteKey = null)
 * ```
 *
 * ### Site 의 ConfigEntity 업데이트
 * * siteKey 에 해당하는 ConfigEntity 수정
 *
 * ```php
 * $handler->putSiteConfig(ConfigEntity $config)
 * ```
 *
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class SiteHandler
{
    /**
     * @var SiteRepository
     */
    protected $repository;

    /**
     * @var Site
     */
    protected $currentSite;
    /**
     * @var Config
     */
    protected $config;

    /**
     * SiteHandler constructor.
     *
     * @param SiteRepository $repository site repository
     * @param Config         $config     xpressengine config manager
     */
    public function __construct(SiteRepository $repository, Config $config)
    {
        $this->repository = $repository;
        $this->config = $config;
    }

    /**
     * getCurrentSite
     *
     * @return Site
     */
    public function getCurrentSite()
    {
        return $this->currentSite;
    }

    /**
     * setCurrentSite
     *
     * @param Site $site site
     *
     * @return void
     */
    public function setCurrentSite(Site $site)
    {
        $this->currentSite = $site;
    }

    /**
     * getCurrentSiteKey
     *
     * @return string
     */
    public function getCurrentSiteKey()
    {
        return $this->currentSite->siteKey;
    }

    /**
     * getSiteConfig
     *
     * @param string|null $siteKey site key
     *
     * @return ConfigEntity
     */
    public function getSiteConfig($siteKey = null)
    {
        if (is_null($siteKey)) {
            $siteKey = $this->currentSite->siteKey;
        }
        return $this->config->get(sprintf("site.%s", $siteKey));
    }

    /**
     * putSiteConfig
     *
     * @param ConfigEntity $config site config entity
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function putSiteConfig(ConfigEntity $config)
    {
        $this->config->modify($config);
    }


    /**
     * getDefaultMenuEntityId
     *
     * @param null|string $siteKey site key
     *
     * @return string
     */
    public function getDefaultMenuEntityId($siteKey = null)
    {
        if (is_null($siteKey)) {
            $siteKey = $this->currentSite->siteKey;
        }
        return $this->config->getVal(sprintf("site.%s.defaultMenu", $siteKey));
    }

    /**
     * setDefaultMenuEntityId
     *
     * @param string      $menuId  MenuEntity id
     * @param null|string $siteKey site key
     *
     * @return string
     */
    public function setDefaultMenuEntityId($menuId, $siteKey = null)
    {
        if (is_null($siteKey)) {
            $siteKey = $this->currentSite->siteKey;
        }

        $this->config->setVal(sprintf("site.%s.defaultMenu", $siteKey), $menuId);
    }

    /**
     * getHomeInstanceId
     *
     * @param null|string $siteKey site key
     *
     * @return string
     */
    public function getHomeInstanceId($siteKey = null)
    {
        if (is_null($siteKey)) {
            $siteKey = $this->currentSite->siteKey;
        }
        return $this->config->getVal(sprintf("site.%s.homeInstance", $siteKey));
    }

    /**
     * setHomeInstanceId
     *
     * @param string      $instanceId menu item instance id
     * @param null|string $siteKey    site key
     *
     * @return string
     */
    public function setHomeInstanceId($instanceId, $siteKey = null)
    {
        if (is_null($siteKey)) {
            $siteKey = $this->currentSite->siteKey;
        }

        $this->config->setVal(sprintf("site.%s.homeInstance", $siteKey), $instanceId);
    }
    /**
     * getSiteConfigValue
     *
     * @param string      $key     value key
     * @param string|null $siteKey site key
     *
     * @return string
     */
    public function getSiteConfigValue($key, $siteKey = null)
    {
        if (is_null($siteKey)) {
            $siteKey = $this->currentSite->siteKey;
        }
        return $this->config->getVal(sprintf("site.%s.%s", $siteKey, $key));
    }

    /**
     * get
     *
     * @param string $host not included 'http' or 'https' string
     *
     * @return Site
     */
    public function get($host)
    {
        return $this->repository->find($host);
    }

    /**
     * getBySiteKey
     *
     * @param string $siteKey site key string
     *
     * @return Site
     */
    public function getBySiteKey($siteKey)
    {
        return $this->repository->findBySiteKey($siteKey);
    }

    /**
     * add
     *
     * @param array $inputs input array
     *
     * @return Site
     */
    public function add(array $inputs)
    {
        $host = $inputs['host'];
        $siteKey = $inputs['siteKey'];
        $this->checkUsableDomain($host);

        $site = new Site(
            ['host' => $host, 'siteKey' => $siteKey]
        );
        $this->repository->insert($site);

        return $site;
    }

    /**
     * put
     *
     * @param Site $site site object
     *
     * @return Site
     */
    public function put(Site $site)
    {
        $this->repository->update($site);
        return $site;
    }

    /**
     * remove
     *
     * @param string $host site host
     *
     * @return void
     */
    public function remove($host)
    {
        $site = $this->repository->find($host);
        $this->repository->delete($site);
    }

    /**
     * checkUsableDomain
     *
     * @param string $host site host
     *
     * @return void
     * @throws CanNotUseDomainException
     */
    protected function checkUsableDomain($host)
    {
        if ($this->repository->count($host) > 0) {
            throw new CanNotUseDomainException($host);
        }
    }
}
