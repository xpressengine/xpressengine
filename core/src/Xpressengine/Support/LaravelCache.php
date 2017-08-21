<?php
/**
 * Laravel Cache class
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

use Illuminate\Contracts\Cache\Repository as ContractsCache;

/**
 * laravel 의 cache 기능을 이용한 처리를 담당
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 *
 * @deprecated since beta.22
 */
class LaravelCache implements CacheInterface
{
    /**
     * laravel cache instance
     *
     * @var ContractsCache
     */
    protected $cache;

    /**
     * expire time
     *
     * @var integer
     */
    protected $minutes;

    /**
     * constructor
     *
     * @param ContractsCache $cache   laravel cache instance
     * @param int            $minutes expire time
     */
    public function __construct(ContractsCache $cache, $minutes = 60)
    {
        $this->cache = $cache;
        $this->minutes = $minutes;
    }

    /**
     * getter
     *
     * @param string $key key name
     * @return mixed
     */
    public function get($key)
    {
        return $this->cache->get($key);
    }

    /**
     * setter
     *
     * @param string $key     key name
     * @param mixed  $value   the value
     * @param int    $minutes expire time
     * @return void
     */
    public function put($key, $value, $minutes = null)
    {
        if ($minutes == null) {
            $minutes = $this->minutes;
        }

        $this->cache->put($key, $value, $minutes);
    }

    /**
     * has
     *
     * @param string $key key name
     * @return bool
     */
    public function has($key)
    {
        return $this->cache->has($key);
    }

    /**
     * remove
     *
     * @param string $key key name
     * @return void
     */
    public function forget($key)
    {
        $this->cache->forget($key);
    }

    /**
     * cache manager instance
     *
     * @return ContractsCache
     */
    public function getCacheManager()
    {
        return $this->cache;
    }
}
