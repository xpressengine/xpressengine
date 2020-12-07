<?php
/**
 * SiteHandler
 *
 * PHP version 7
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Site;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Config\Exceptions\InvalidArgumentException;

/**
 * Class SiteHandler
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SiteHandler
{
    /**
     * @var SiteRepository
     */
    protected $repo;

    /**
     * @var ConfigManager
     */
    protected $config;

    /**
     * @var Site
     */
    protected $currentSite;

    /**
     * SiteHandler constructor.
     *
     * @param SiteRepository $repo   SiteRepository instance
     * @param ConfigManager  $config ConfigManager instance
     */
    public function __construct(SiteRepository $repo, ConfigManager $config)
    {
        $this->repo = $repo;
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
        return $this->currentSite ? $this->currentSite->site_key : 'default';
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
            $siteKey = $this->currentSite->site_key;
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
            $siteKey = $this->currentSite->site_key;
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
            $siteKey = $this->currentSite->site_key;
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
            $siteKey = $this->currentSite->site_key;
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
            $siteKey = $this->currentSite->site_key;
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
            $siteKey = $this->currentSite->site_key;
        }
        return $this->config->getVal(sprintf("site.%s.%s", $siteKey, $key));
    }

    /**
     * __call
     *
     * @param string $name      method name
     * @param array  $arguments arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repo, $name], $arguments);
    }
}
