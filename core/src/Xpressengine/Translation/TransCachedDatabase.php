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

use Xpressengine\Database\VirtualConnectionInterface;

/**
 * 다국어의 데이터를 제어하기 위한 클래스로
 * DB persistence 그리고 TransCache(다국어 전용 캐시)를 지원한다
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class TransCachedDatabase
{
    protected $transCache;
    protected $conn;

    /**
     * @param TransCache                 $transCache 다국어용 캐시
     * @param VirtualConnectionInterface $conn       다국어용 데이터베이스
     */
    public function __construct(TransCache $transCache, VirtualConnectionInterface $conn)
    {
        $this->transCache = $transCache;
        $this->conn = $conn;
    }

    /**
     * 그룹단위 캐시의 키를 지정합니다
     *
     * @param string $transCacheKey 캐시용 키
     * @return void
     */
    public function setCacheKey($transCacheKey)
    {
        $this->transCache->setCacheKey($transCacheKey);
    }

    /**
     * 전체 캐시를 비웁니다
     * @return void
     */
    public function flush()
    {
        $this->transCache->flush();
    }

    /**
     * 전체 캐시를 비웁니다
     *
     * @param string   $namespace 네임스페이스
     * @param LangData $langData  추가하려는 LangData
     * @param bool     $force     force update
     * @return void
     */
    public function putLangData($namespace, LangData $langData, $force = false)
    {
        $langData->each(function ($item, $locale, $value) use ($namespace, $force) {
            if (is_string($value)) {
                $this->putLine($namespace, $item, $locale, $value, false, $force);
            }
        });
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
        $line = [
            'namespace' => trim($namespace),
            'item' => trim($item),
            'locale' => trim($locale),
            'value' => trim($value),
            'multiline' => $multiLine,
        ];

        $exist = $this->conn->table('translation')
                ->where('namespace', $namespace)
                ->where('item', $item)
                ->where('locale', $locale)
                ->count() > 0;

        if ($exist) {
            if ($force) {
                $this->conn->table('translation')
                    ->where('namespace', $namespace)
                    ->where('item', $item)
                    ->where('locale', $locale)
                    ->update($line);
            }
        } else {
            $this->conn->table('translation')
                ->insert($line);
        }

        $this->flush();
    }

    /**
     * 라인을 얻습니다
     *
     * @param string $namespace 네임스페이스
     * @param string $item      아이템
     * @param string $locale    로케일
     * @return string
     */
    public function getLine($namespace, $item, $locale)
    {
        $value = $this->transCache->get($namespace, $item, $locale);
        if (!$value) {
            $value = $this->conn->table('translation')
                ->where('namespace', $namespace)
                ->where('item', $item)
                ->where('locale', $locale)
                ->first();
            if ($value !== null) {
                $value = $value->value;
            }

            $this->transCache->set($namespace, $item, $locale, $value);
        }
        return $value;
    }
}
