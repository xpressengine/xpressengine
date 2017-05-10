<?php
/**
 * SimpleDecomposer.php
 *
 * PHP version 5
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tag;

/**
 * Class SimpleDecomposer
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class SimpleDecomposer implements Decomposer
{
    /**
     * Character set
     *
     * @var string
     */
    protected $charSet;

    /**
     * Constructor
     *
     * @param string $charSet Character set
     */
    public function __construct($charSet = 'UTF-8')
    {
        $this->charSet = $charSet;
    }

    /**
     * Execute decomposing
     *
     * @param string $string string whatever
     * @return string
     */
    public function execute($string)
    {
        $cho = ["ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ",
            "ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ"];
        $jung = ["ㅏ","ㅐ","ㅑ","ㅒ","ㅓ","ㅔ","ㅕ","ㅖ","ㅗ","ㅘ","ㅙ",
            "ㅚ","ㅛ","ㅜ","ㅝ","ㅞ","ㅟ","ㅠ","ㅡ","ㅢ","ㅣ"];
        $jong = ["","ㄱ","ㄲ","ㄳ","ㄴ","ㄵ","ㄶ","ㄷ","ㄹ","ㄺ","ㄻ","ㄼ","ㄽ","ㄾ",
            "ㄿ","ㅀ","ㅁ","ㅂ","ㅄ","ㅅ","ㅆ","ㅇ","ㅈ","ㅊ","ㅋ"," ㅌ","ㅍ","ㅎ"];

        $result = "";
        for ($i = 0; $i < $this->strlen($string); $i++) {
            $char = $this->charAt($string, $i);
            $code = $this->ord($char) - 44032;
            if ($code > -1 && $code < 11172) {
                $choIdx = $code / 588;
                $jungIdx = $code % 588 / 28;
                $jongIdx = $code % 28;
                $result .= $cho[$choIdx] . $jung[$jungIdx] . $jong[$jongIdx];
            } else {
                $result .= $char;
            }
        }

        return $result;
    }

    /**
     * Get string length
     *
     * @param string $str string
     * @return int
     */
    protected function strlen($str)
    {
        return mb_strlen($str, $this->charSet);
    }

    /**
     * 지정한 인덱스에 해당하는 문자를 반환한다.
     *
     * @param string $str string
     * @param int    $num character index
     * @return string
     */
    protected function charAt($str, $num)
    {
        return mb_substr($str, $num, 1, $this->charSet);
    }

    /**
     * Return ASCII value of character
     *
     * @param string $ch character
     * @return int|null
     */
    protected function ord($ch)
    {
        $len = strlen($ch);

        if ($len <= 0) {
            return null;
        }

        $h = ord($ch{0});

        if ($h <= 0x7F) {
            return $h;
        }
        if ($h < 0xC2) {
            return null;
        }
        if ($h <= 0xDF && $len>1) {
            return ($h & 0x1F) <<  6 | (ord($ch{1}) & 0x3F);
        }
        if ($h <= 0xEF && $len>2) {
            return ($h & 0x0F) << 12 | (ord($ch{1}) & 0x3F) << 6 | (ord($ch{2}) & 0x3F);
        }
        if ($h <= 0xF4 && $len>3) {
            return ($h & 0x0F) << 18 | (ord($ch{1}) & 0x3F) << 12 | (ord($ch{2}) & 0x3F) << 6 | (ord($ch{3}) & 0x3F);
        }
    }
}
