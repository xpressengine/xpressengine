<?php
/**
 * Class Translation
 *
 * PHP version 7
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
use Illuminate\Support\Arr;

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
class TransCache implements Repository
{
    private $cache;

    private $repo;

    private $transCacheKey = 'translator';

    private $cachedLines = null;

    /**
     * @param Cache               $cache 라라벨 캐시
     * @param TransCachedDatabase $repo  저장소
     */
    public function __construct(Cache $cache, TransCachedDatabase $repo)
    {
        $this->cache = $cache;
        $this->repo = $repo;
    }

    /**
     * 캐시된 라인을 얻습니다
     *
     * @param string $namespace 네임스페이스
     * @param string $item      아이템
     * @param string $locale    로케일
     * @return string
     */
    public function getLine($namespace, $item, $locale)
    {
        if (!$this->cachedLines) {
            $this->load();
        }

        return isset($this->cachedLines[$namespace][$item][$locale])
            ? $this->cachedLines[$namespace][$item][$locale]
            : null;
    }

    /**
     * 라인을 추가합니다
     *
     * @param string $namespace 네임스페이스
     * @param string $item      아이템
     * @param string $locale    로케일
     * @param string $value     번역문
     * @param bool   $multiLine 멀티라인 지원 여부
     * @param bool   $force     force update
     * @return void
     */
    public function putLine($namespace, $item, $locale, $value, $multiLine = false, $force = false)
    {
        $this->flush();

        $this->repo->putLine($namespace, $item, $locale, $value, $multiLine, true);
    }

    /**
     * 다국어 데이터를 일괄 등록
     *
     * @param string   $namespace 네임스페이스
     * @param LangData $langData  추가하려는 LangData
     * @param bool     $force     force update
     * @return void
     */
    public function putLangData($namespace, LangData $langData, $force = false)
    {
        $this->flush();

        $this->repo->putLangData($namespace, $langData, $force);
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
        // nothing to do
    }

    /**
     * 캐시를 비웁니다
     *
     * @return void
     */
    public function flush()
    {
        $this->cache->forget($this->transCacheKey);
        $this->cachedLines = null;
    }

    /**
     * 캐시를 로드합니다
     *
     * @return void
     */
    private function load()
    {
        $cachedJsonString = $this->cache->get($this->transCacheKey);
        if ($cachedJsonString === null) {
            $this->cachedLines = [];
            $this->repo->chunk(function ($lines) {
                foreach ($lines as $line) {
                    $keys = [$line->namespace, $line->item, $line->locale];
                    Arr::set($this->cachedLines, implode('.', $keys), $line->value);
                }
            });
            $this->cache->forever($this->transCacheKey, json_enc($this->cachedLines));
        } else {
            $this->cachedLines = json_decode($cachedJsonString, true);
        }
    }
}
