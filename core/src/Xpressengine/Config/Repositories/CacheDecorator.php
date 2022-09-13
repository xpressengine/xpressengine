<?php
/**
 * Cache Decorator class
 *
 * PHP version 7
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Config\Repositories;

use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Psr\SimpleCache\InvalidArgumentException;
use Xpressengine\Config\ConfigRepository;
use Xpressengine\Config\ConfigEntity;

/**
 * 저장소를 wrapping 하여 cache 에 있는 정보는
 * 저장소에 요청되지 않고 cache 에서 반환 되도록 함
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CacheDecorator implements ConfigRepository
{
    /**
     * repository instance
     *
     * @var ConfigRepository
     */
    protected $repo;

    /**
     * cache instance
     *
     * @var CacheContract
     */
    protected $cache;

    /**
     * expire time
     *
     * @var int
     */
    protected $seconds;

    /**
     * Prefix for cache key
     *
     * @var string
     */
    protected $prefix = 'config';

    /**
     * memory cache
     *
     * @var array
     */
    protected $bag = [];

    /**
     * create instance
     *
     * @param  ConfigRepository  $repo  repository instance
     * @param  CacheContract  $cache  cache instance
     * @param  int  $seconds  expire time
     */
    public function __construct(ConfigRepository $repo, CacheContract $cache, int $seconds = 3600)
    {
        $this->repo = $repo;
        $this->cache = $cache;
        $this->seconds = $seconds;
    }

    /**
     * search getter
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  the name
     * @return ConfigEntity
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function find($siteKey, $name)
    {
        $data = $this->getData($siteKey, $this->getHead($name));

        return Arr::first($data, static function ($item, $idx) use ($name) {
            return $item->name === $name;
        });
    }

    /**
     * search ancestors getter
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  the name
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function fetchAncestor($siteKey, $name)
    {
        $data = $this->getData($siteKey, $this->getHead($name));

        return Arr::where($data, static function ($item, $idx) use ($name) {
            return Str::startsWith($name, $item->name.'.') && $name !== $item->name;
        });
    }

    /**
     * search descendants getter
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  the name
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function fetchDescendant($siteKey, $name)
    {
        $data = $this->getData($siteKey, $this->getHead($name));

        return Arr::where($data, static function ($item, $idx) use ($name) {
            return Str::startsWith($item->name, $name.'.') && $name !== $item->name;
        });
    }

    /**
     * save
     *
     * @param  ConfigEntity  $config  config object
     * @return ConfigEntity
     */
    public function save(ConfigEntity $config)
    {
        $this->erase($config->site_key, $config->name);

        return $this->repo->save($config);
    }

    /**
     * clear all just descendants vars
     *
     * @param  ConfigEntity  $config  config object
     * @param  array  $excepts  target to the except
     * @return void
     */
    public function clearLike(ConfigEntity $config, $excepts = [])
    {
        $this->erase($config->site_key, $config->name);

        $this->repo->clearLike($config, $excepts);
    }

    /**
     * remove
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  the name
     * @return void
     */
    public function remove($siteKey, $name)
    {
        $this->erase($siteKey, $name);

        $this->repo->remove($siteKey, $name);
    }

    /**
     * Parent Changing with descendant
     *
     * @param  ConfigEntity  $config  config object
     * @param  string  $to  to config prefix
     * @return void
     */
    public function foster(ConfigEntity $config, $to)
    {
        $this->erase($config->site_key, $config->name);
        $this->erase($config->site_key, $to);

        $this->repo->foster($config, $to);
    }

    /**
     * affiliated to another config
     *
     * @param  ConfigEntity  $config  config object
     * @param  string  $to  parent name
     * @return void
     */
    public function affiliate(ConfigEntity $config, $to)
    {
        $this->erase($config->site_key, $config->name);
        $this->erase($config->site_key, $to);

        $this->repo->affiliate($config, $to);
    }

    /**
     * get cached data
     *
     * @param  string  $siteKey  site key
     * @param  string  $head  root name
     * @return array
     * @throws InvalidArgumentException
     */
    protected function getData($siteKey, $head)
    {
        $key = $this->makeKey($siteKey, $head);

        if (isset($this->bag[$key]) === false) {
            $cacheKey = $this->getCacheKey($key);
            $data = $this->cache->get($cacheKey);

            if ($data === null) {
                $config = $this->repo->find($siteKey, $head);

                if ($config === null) {
                    return [];
                }

                $descendant = $this->repo->fetchDescendant($siteKey, $head);
                $data = array_merge([$config], $descendant);

                $this->cache->put($cacheKey, $data, $this->seconds);
            }

            $this->bag[$key] = $data;
        }

        return $this->bag[$key];
    }

    /**
     * Remove cache data
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  config name
     * @return void
     */
    protected function erase($siteKey, $name)
    {
        $key = $this->makeKey($siteKey, $this->getHead($name));

        unset($this->bag[$key]);
        $this->cache->forget($this->getCacheKey($key));
    }

    /**
     * parse name to head and segments
     *
     * @param  string  $name  the name
     * @return string
     */
    private function getHead($name)
    {
        $segments = explode('.', $name);

        return reset($segments);
    }

    /**
     * Make key by combination of site key and config name
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  config name
     * @return string
     */
    protected function makeKey($siteKey, $name)
    {
        return $siteKey.':'.$name;
    }

    /**
     * String for cache key
     *
     * @param  string  $keyword  keyword
     * @return string
     */
    protected function getCacheKey($keyword)
    {
        return $this->prefix.'@'.$keyword;
    }
}