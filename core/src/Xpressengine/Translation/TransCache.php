<?php
/**
 * Class Translation
 *
 * PHP version 7
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TransCache implements Repository
{
    private $cache;

    private $repo;

    private $transCacheKey = 'translator';

    private $fallbackKey = 'translator_fb';

    private $cachedLines = null;

    private $added = [];

    /**
     * Constructor
     *
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
        $this->repo->putLine($namespace, $item, $locale, $value, $multiLine, true);

        $this->add($namespace, $item, $locale, $value);
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

        $this->build();
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
        // 캐시를 비운 후 현재 요청이외에 다른 요청을 처리하기 위해 대체키에 캐시데이터를 복제
        if (!$this->cache->has($this->fallbackKey)) {
            $this->cache->forever($this->fallbackKey, $this->cache->get($this->transCacheKey));
        }

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
        if (!$cachedJsonString = $this->getRaw()) {
            $this->build();
        } else {
            $this->cachedLines = json_dec($cachedJsonString, true);
        }

        $this->cachedLines = $this->merge($this->cachedLines);
    }

    /**
     * Get raw cached data
     *
     * @return string|null
     */
    protected function getRaw()
    {
        if (!$data = $this->cache->get($this->transCacheKey)) {
            $data = $this->cache->get($this->fallbackKey);
        }

        return $data;
    }

    /**
     * Build cache data
     *
     * @return void
     */
    protected function build()
    {
        $this->cachedLines = [];
        $this->repo->chunk(function ($lines) {
            foreach ($lines as $line) {
                $this->cachedLines[$line->namespace][$line->item][$line->locale] = $line->value;
            }
        });
        $this->cache->forever($this->transCacheKey, json_enc($this->cachedLines));
        $this->cache->forget($this->fallbackKey);
    }

    /**
     * Add one line
     *
     * @param string $namespace 네임스페이스
     * @param string $item      아이템
     * @param string $locale    로케일
     * @param string $value     번역문
     * @return void
     */
    protected function add($namespace, $item, $locale, $value)
    {
        // 1개의 요청에 여러 line 의 데이터가 추가되는 경우
        // 매 line 마다 캐시를 다시 쓰는 행위를 피하기위해 메모리상에 임시저장 함.
        $this->added[$namespace][$item][$locale] = $value;

        if ($this->cachedLines) {
            $this->cachedLines[$namespace][$item][$locale] = $value;
        }
    }

    /**
     * Merge added lines to the given data
     *
     * @param array $data data array
     * @return array
     */
    protected function merge(array $data)
    {
        if (!empty($this->added)) {
            $data = array_replace_recursive($data, $this->added);
        }

        return $data;
    }

    /**
     * Destructor
     *
     * @return void
     */
    public function __destruct()
    {
        // 클래스가 종료되는 시점에 임시저장된 다국어 line 을 캐시파일에 추가
        if (!empty($this->added)) {
            $data = [];
            if ($raw = $this->getRaw()) {
                $data = json_dec($raw, true);
            }

            $this->cache->forever($this->transCacheKey, json_enc($this->merge($data)));
        }
    }
}
