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

use Xpressengine\Database\VirtualConnectionInterface;

/**
 * 다국어의 데이터를 제어하기 위한 클래스로
 * DB persistence 그리고 TransCache(다국어 전용 캐시)를 지원한다
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TransCachedDatabase implements Repository
{
    protected $conn;

    /**
     * @param VirtualConnectionInterface $conn 다국어용 데이터베이스
     */
    public function __construct(VirtualConnectionInterface $conn)
    {
        $this->conn = $conn;
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
        $value = $this->conn->table('translation')
            ->where('namespace', $namespace)
            ->where('item', $item)
            ->where('locale', $locale)
            ->first();

        if ($value !== null) {
            $value = $value->value;
        }

        return $value;
    }

    /**
     * Chunk the data of translation.
     *
     * @param callable $callback callable
     * @param int      $count    count for chunking
     * @return void
     */
    public function chunk(callable $callback, $count = 100)
    {
        $this->conn->table('translation')->orderBy('id')->chunk($count, $callback);
    }
}
