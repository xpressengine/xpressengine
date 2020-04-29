<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin\Cache;

use Illuminate\Cache\Repository as Cache;

/**
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 *
 * @deprecated since 3.0.1
 */
class FilePluginCache implements PluginCache
{

    /**
     * plugin 정보 목록을 저장할 array
     *
     * @var array plugin info list
     */
    public $plugins = null;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var string
     */
    private $cacheKey;

    /**
     * FilePluginCache constructor.
     *
     * @param Cache  $cache    시스템 캐시 저장소
     * @param string $cacheKey 시스템 캐시 저장소에서 할당된 캐시키
     */
    public function __construct(Cache $cache, $cacheKey)
    {
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
    }

    /**
     * 캐시에 저장된 PluginEntity 목록을 반환한다.
     *
     * @return array
     */
    public function getPluginsFromCache()
    {
        if ($this->plugins === null) {
            $this->plugins = $this->load();
        }
        return $this->plugins;
    }

    /**
     * XE3에 존재하는 플러그인의 PluginEntity 목록을 캐시에 저장한다.
     *
     * @param array $plugins 캐시에 저장할 plugin info 목록
     *
     * @return void
     */
    public function setPluginsToCache(array $plugins)
    {
        $this->plugins = $plugins;

        $dataJson = json_enc($plugins);

        // save plugins info to cache
        $this->cache->forever($this->cacheKey, $dataJson);
    }

    /**
     * 캐싱된 플러그인 정보가 있는지 조사한다.
     *
     * @return bool
     */
    public function hasCachedPlugins()
    {
        return $this->cache->has($this->cacheKey);
    }

    /**
     * load
     *
     * @return array
     */
    protected function load()
    {
        $cachedJsonString = $this->cache->get($this->cacheKey);

        $dataArr = json_dec($cachedJsonString, true);

        return $dataArr;
    }
}
