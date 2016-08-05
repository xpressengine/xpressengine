<?php
/**
 * CacheDecorator.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Config\Repositories;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Support\CacheInterface;

class CacheDecorator2 implements RepositoryInterface
{
    /**
     * repository instance
     *
     * @var RepositoryInterface
     */
    protected $repo;

    /**
     * cache instance
     *
     * @var CacheInterface
     */
    protected $cache;

    /**
     * Prefix for cache key
     *
     * @var string
     */
    protected $prefix = 'config';

    /**
     * CacheDecorator constructor.
     *
     * @param RepositoryInterface $repo  repository instance
     * @param CacheInterface      $cache cache instance
     */
    public function __construct(RepositoryInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * search getter
     *
     * @param string $siteKey site key
     * @param string $name the name
     * @return ConfigEntity
     */
    public function find($siteKey, $name)
    {
        $key = $this->getCacheKey($siteKey, $name);

        if (!$config = $this->cache->get($key)) {
            if ($config = $this->repo->find($siteKey, $name)) {
                $this->cache->put($key, $config);
            }
        }

        return $config;
    }

    /**
     * search ancestors getter
     *
     * @param string $siteKey site key
     * @param string $name the name
     * @return array
     */
    public function fetchParent($siteKey, $name)
    {
        $key = $this->getCacheKey($siteKey, $name, 'ancestor');
        if (!$ancestors = $this->cache->get($key)) {
            $ancestors = $this->repo->fetchParent($siteKey, $name);
            if (!empty($ancestors)) {
                $this->cache->put($key, $ancestors);
            }
        }

        return $ancestors;
    }

    /**
     * search descendants getter
     *
     * @param string $siteKey site key
     * @param string $name the name
     * @return array
     */
    public function fetchChildren($siteKey, $name)
    {
        $key = $this->getCacheKey($siteKey, $name, 'descendant');
        if (!$descendants = $this->cache->get($key)) {
            $descendants = $this->repo->fetchChildren($siteKey, $name);
            if (!empty($descendants)) {
                $this->cache->put($key, $descendants);
            }
        }

        return $descendants;
    }

    /**
     * save
     *
     * @param ConfigEntity $config config object
     * @return ConfigEntity
     */
    public function save(ConfigEntity $config)
    {
        $config = $this->repo->save($config);
        $this->cache->put($this->getCacheKey($config->siteKey, $config->name), $config);

        return $config;
    }

    /**
     * clear all just descendants vars
     *
     * @param ConfigEntity $config config object
     * @param array $excepts target to the except
     * @return void
     */
    public function clearLike(ConfigEntity $config, $excepts = [])
    {
        $this->repo->clearLike($config, $excepts);
    }

    /**
     * remove
     *
     * @param string $siteKey site key
     * @param string $name the name
     * @return void
     */
    public function remove($siteKey, $name)
    {
        $this->repo->remove($siteKey, $name);
    }

    /**
     * Parent Changing with descendant
     *
     * @param ConfigEntity $config config object
     * @param string $to to config prefix
     * @return void
     */
    public function foster(ConfigEntity $config, $to)
    {
        $this->repo->foster($config, $to);
    }

    /**
     * affiliated to another config
     *
     * @param ConfigEntity $config config object
     * @param string $to parent name
     * @return void
     */
    public function affiliate(ConfigEntity $config, $to)
    {
        $this->repo->affiliate($config, $to);
    }

    /**
     * String for cache key
     *
     * @param string      $siteKey site key
     * @param string      $name    permission name
     * @param string|null $etc     etc keyword
     * @return string
     */
    protected function getCacheKey($siteKey, $name, $etc = null)
    {
        return $this->prefix . '::' . $siteKey . '-' . $name . ($etc ? '_' . $etc : '');
    }
}
