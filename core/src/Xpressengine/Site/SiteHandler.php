<?php
/**
 * SiteHandler
 *
 * PHP version 5
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Site;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Config\ConfigManager as Config;
use Xpressengine\Config\Exceptions\InvalidArgumentException;
use Xpressengine\Site\Exceptions\CanNotUseDomainException;

/**
 * Class SiteHandler
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class SiteHandler
{
    /**
     * @var Config
     */
    protected $config;

    protected $model = Site::class;

    /**
     * @var Site
     */
    protected $currentSite;

    /**
     * SiteHandler constructor.
     *
     * @param Config $config xpressengine config manager
     */
    public function __construct(Config $config)
    {
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
     * add
     *
     * @param array $inputs input array
     *
     * @return Site
     */
    public function add(array $inputs)
    {
        $this->checkUsableDomain($inputs['host']);

        /** @var Site $site */
        $site = $this->createModel();
        $site->siteKey = $inputs['siteKey'];
        $site->host = $inputs['host'];
        $site->save();

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
        if ($site->isDirty()) {
            $site->save();
        }

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
        $model = $this->createModel();
        /** @var Site $site */
        if ($site = $model->newQuery()->where('host', $host)->get()) {
            $site->delete();
        }
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
        $model = $this->createModel();
        if ($model->newQuery()->where('host', $host)->exists()) {
            throw new CanNotUseDomainException(['host' => $host]);
        }
    }

    /**
     * Create new site model
     *
     * @return string
     */
    public function createModel()
    {
        $class = $this->getModel();

        return new $class;
    }

    /**
     * Get site model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set site model
     *
     * @param string $model model class
     * @return void
     */
    public function setModel($model)
    {
        $this->model = '\\' . ltrim($model, '\\');
    }
}
