<?php
/**
 * Cache Decorator class
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Config\Repositories;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Support\CacheInterface;

/**
 * 저장소를 wrapping 하여 cache 에 있는 정보는
 * 저장소에 요청되지 않고 cache 에서 반환 되도록 함
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CacheDecorator extends AbstractDecorator
{
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
     * memory cache
     *
     * @var array
     */
    protected $bag = [];

    /**
     * create instance
     *
     * @param RepositoryInterface $repo  repository instance
     * @param CacheInterface      $cache cache instance
     */
    public function __construct(RepositoryInterface $repo, CacheInterface $cache)
    {
        parent::__construct($repo);

        $this->cache = $cache;
    }

    /**
     * search getter
     *
     * @param string $siteKey site key
     * @param string $name    the name
     * @return ConfigEntity
     */
    public function find($siteKey, $name)
    {
        $key = $this->makeKey($siteKey, $name);
        if (!isset($this->bag[$key]) || $this->bag[$key] === null) {
            if (!$config = $this->retrieve($key)) {
                if ($config = $this->repo->find($siteKey, $name)) {
                    $this->put($config);
                }
            }

            $this->bag[$key] = $config;
        }

        return $this->bag[$key];
    }

    /**
     * Retrieve cache data
     *
     * @param string $key config name
     * @return mixed
     */
    protected function retrieve($key)
    {
        $segments = explode('.', $key);
        $head = reset($segments);

        $cache = $this->getAll($head);

        foreach ($segments as $idx => $segment) {
            $cache = &$cache[$segment];
            if ($idx < count($segments) - 1) {
                $cache = &$cache['children'];
            }
        }

        return isset($cache['value']) ? $cache['value'] : null;
    }

    /**
     * All cache data by head keyword
     *
     * @param string $head head keyword
     * @return mixed
     */
    protected function getAll($head)
    {
        return $this->cache->get($this->getCacheKey($head));
    }

    /**
     * Store data to cache
     *
     * @param ConfigEntity $config config object
     * @return void
     */
    protected function put(ConfigEntity $config)
    {
        $key = $this->makeKey($config->siteKey, $config->name);
        $segments = explode('.', $key);
        $head = reset($segments);

        $cache = $this->getAll($head);
        $cache = $this->make($cache, $segments, $config);

        $this->cache->put($this->getCacheKey($head), $cache);
    }

    /**
     * Make data for cache store
     *
     * @param array|null $arr      previous cache data
     * @param array      $segments config name parse to array
     * @param mixed      $val      value to be set
     * @return array
     */
    protected function make($arr, $segments, $val)
    {
        if (is_array($arr) !== true) {
            $arr = [];
        }

        $segment = array_shift($segments);
        if (isset($arr[$segment]) !== true) {
            $arr[$segment] = [
                'value' => null,
                'children' => []
            ];
        }

        if (count($segments) > 0) {
            $arr[$segment]['children'] = $this->make($arr[$segment]['children'], $segments, $val);
        } else {
            if ($val !== null) {
                $arr[$segment]['value'] = $val;
            } else {
                unset($arr[$segment]);
            }
        }

        return $arr;
    }

    /**
     * save
     *
     * @param ConfigEntity $config config object
     * @return ConfigEntity
     */
    public function save(ConfigEntity $config)
    {
        $this->put($config);
        $this->bag[$this->makeKey($config->siteKey, $config->name)] = $config;

        return $this->repo->save($config);
    }

    /**
     * remove
     *
     * @param string $siteKey site key
     * @param string $name    the name
     * @return void
     */
    public function remove($siteKey, $name)
    {
        $this->repo->remove($siteKey, $name);

        $this->erase($this->makeKey($siteKey, $name));
    }

    /**
     * Remove cache data
     *
     * @param string $key config name
     * @return void
     */
    protected function erase($key)
    {
        $segments = explode('.', $key);
        $head = reset($segments);

        if ($key == $head) {
            $this->cache->forget($this->getCacheKey($head));
        } else {
            $cache = $this->make($this->getAll($head), $segments, null);

            $this->cache->put($this->getCacheKey($head), $cache);
        }

        foreach ($this->bag as $k => $item) {
            if (substr($k, 0, strlen($key)) == $key) {
                unset($this->bag[$k]);
            }
        }
    }

    /**
     * clear all just descendants vars
     *
     * @param ConfigEntity $config  config object
     * @param array        $excepts target to the except
     * @return void
     */
    public function clearLike(ConfigEntity $config, $excepts = [])
    {
        $this->repo->clearLike($config, $excepts);

        $key = $this->makeKey($config->siteKey, $config->name);
        $this->erase($key);
        $this->put($config);
        $this->bag[$key] = $config;
    }

    /**
     * Parent Changing with descendant
     *
     * @param ConfigEntity $config config object
     * @param string       $to     to config prefix
     * @return void
     */
    public function foster(ConfigEntity $config, $to)
    {
        $this->repo->foster($config, $to);

        $this->erase($this->makeKey($config->siteKey, $config->name));
    }

    /**
     * affiliated to another config
     *
     * @param ConfigEntity $config config object
     * @param string       $to     parent name
     * @return void
     */
    public function affiliate(ConfigEntity $config, $to)
    {
        $this->repo->affiliate($config, $to);

        $this->erase($this->makeKey($config->siteKey, $config->name));
    }

    /**
     * Make key by combination of site key and config name
     *
     * @param string $siteKey site key
     * @param string $name    config name
     * @return string
     */
    public function makeKey($siteKey, $name)
    {
        return $siteKey . ':' . $name;
    }

    /**
     * String for cache key
     *
     * @param string $head head keyword
     * @return string
     */
    protected function getCacheKey($head)
    {
        return $this->prefix . '@' . $head;
    }
}
