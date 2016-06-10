<?php
/**
 * Class Translation
 *
 * PHP version 5
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Translation;

use Illuminate\Cache\Repository as Cache;

/**
 * 다국어용 캐시 클래스
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class TransCache
{
    private $cache;
    private $transCacheKey = null;
    private $cachedLines = null;

    private $debug = false;

    /**
     * @param Cache      $cache 라라벨 캐시
     * @param bool|false $debug 디버그 모드 여부
     */
    public function __construct(Cache $cache, $debug = false)
    {
        $this->cache = $cache;
        $this->debug = $debug;
    }

    /**
     * 그룹단위 캐시의 키를 지정합니다
     *
     * 디버그 모드인 경우 캐시에 사용된 캐시 키 목록을 저장합니다
     *
     * @param string $transCacheKey 캐시용 키
     * @return void
     */
    public function setCacheKey($transCacheKey)
    {
        $this->transCacheKey = $transCacheKey;
        if ($this->debug) {
            $cachedJsonString = $this->cache->get('_xe_transCacheKeys');
            $transCacheKeys = json_decode($cachedJsonString, true);
            $transCacheKeys = $transCacheKeys ?: [];
            $transCacheKeys[$transCacheKey] = true;
            $jsonString = json_enc($transCacheKeys);
            $this->cache->forever('_xe_transCacheKeys', $jsonString);
        }
    }

    /**
     * 캐시된 라인을 얻습니다
     *
     * @param string $namespace 네임스페이스
     * @param string $item      아이템
     * @param string $locale    로케일
     * @return string
     */
    public function get($namespace, $item, $locale)
    {
        if (!$this->cachedLines) {
            $this->load();
        }

        return isset($this->cachedLines[$namespace][$item][$locale])
            ? $this->cachedLines[$namespace][$item][$locale]
            : null;
    }

    /**
     * 라인을 캐싱합니다
     *
     * @param string $namespace 네임스페이스
     * @param string $item      아이템
     * @param string $locale    로케일
     * @param string $value     번역문
     * @return void
     */
    public function set($namespace, $item, $locale, $value)
    {
        if (!$this->cachedLines) {
            $this->load();
        }

        $this->cachedLines[$namespace][$item][$locale] = $value;
        $jsonString = json_enc($this->cachedLines);
        $this->cache->forever($this->transCacheKey, $jsonString);
    }

    /**
     * 캐시를 비웁니다
     *
     * @return void
     */
    public function flush()
    {
        $this->cache->getStore()->flush();
    }

    /**
     * 캐시를 로드합니다
     *
     * @return void
     */
    private function load()
    {
        if (!$this->transCacheKey) {
            $this->transCacheKey = '';
        }

        $cachedJsonString = $this->cache->get($this->transCacheKey);
        if ($cachedJsonString === null) {
            $this->cachedLines = [];
            return;
        }

        $this->cachedLines = json_decode($cachedJsonString, true);
    }
}
