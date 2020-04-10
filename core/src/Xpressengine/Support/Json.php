<?php
/**
 * Class Json
 *
 * PHP version 7
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

/**
 * php json 함수 사용시 exception 이 발생하지 않기 때문에
 * 예외처리가 가능하도록 exception 을 발생
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Json
{
    /**
     * call json_encode function
     *
     * @param mixed $value   target for encoding
     * @param int   $options json behavior constant
     * @param int   $depth   maximum depth
     *
     * @return string
     */
    public static function encode($value, $options = 0, $depth = 512)
    {
        $encoded = json_encode($value, $options, $depth);

        static::lastError();

        return $encoded;
    }

    /**
     * call json_decode function
     *
     * @param string $string  target for decoding
     * @param bool   $assoc   when true, object be converted to array
     * @param int    $depth   recursion depth
     * @param int    $options decode option, just support 'JSON_BIGINT_AS_STRING'
     *
     * @return mixed
     */
    public static function decode($string, $assoc = false, $depth = 512, $options = 0)
    {
        $decoded = json_decode($string, $assoc, $depth, $options);

        static::lastError();

        return $decoded;
    }

    /**
     * 주어진 json string을 보기 편하게 정리한다.
     *
     * This code is based on the Composer\Json\JsonFormatter::format():
     *  https://github.com/composer/composer/blob/master/src/Composer/Json/JsonFormatter.php
     *
     * Originally licensed under MIT by Dave Perrett <mail@recursive-design.com>
     *
     * @param  string $json            json string
     * @param  bool   $unescapeUnicode Un escape unicode
     * @param  bool   $unescapeSlashes Un escape slashes
     *
     * @return string
     */
    public static function format($json, $unescapeUnicode, $unescapeSlashes)
    {
        $result = '';
        $pos = 0;
        $strLen = strlen($json);
        $indentStr = '    ';
        $newLine = "\n";
        $outOfQuotes = true;
        $buffer = '';
        $noescape = true;

        for ($i = 0; $i < $strLen; $i++) {
            // Grab the next character in the string
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ('"' === $char && $noescape) {
                $outOfQuotes = !$outOfQuotes;
            }

            if (!$outOfQuotes) {
                $buffer .= $char;
                $noescape = '\\' === $char ? !$noescape : true;
                continue;
            } elseif ('' !== $buffer) {
                if ($unescapeSlashes) {
                    $buffer = str_replace('\\/', '/', $buffer);
                }

                if ($unescapeUnicode && function_exists('mb_convert_encoding')) {
                    $buffer = preg_replace_callback(
                        '/(\\\\+)u([0-9a-f]{4})/i',
                        function ($match) {
                            $l = strlen($match[1]);

                            if ($l % 2) {
                                return str_repeat('\\', $l - 1).mb_convert_encoding(
                                    pack('H*', $match[2]),
                                    'UTF-8',
                                    'UCS-2BE'
                                );
                            }

                            return $match[0];
                        },
                        $buffer
                    );
                }

                $result .= $buffer.$char;
                $buffer = '';
                continue;
            }

            if (':' === $char) {
                // Add a space after the : character
                $char .= ' ';
            } elseif (('}' === $char || ']' === $char)) {
                $pos--;
                $prevChar = substr($json, $i - 1, 1);

                if ('{' !== $prevChar && '[' !== $prevChar) {
                    // If this character is the end of an element,
                    // output a new line and indent the next line
                    $result .= $newLine;
                    for ($j = 0; $j < $pos; $j++) {
                        $result .= $indentStr;
                    }
                } else {
                    // Collapse empty {} and []
                    $result = rtrim($result);
                }
            }

            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line
            if (',' === $char || '{' === $char || '[' === $char) {
                $result .= $newLine;

                if ('{' === $char || '[' === $char) {
                    $pos++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
        }

        return $result;
    }

    /**
     * catch last error and throw exception
     *
     * @return void
     */
    protected static function lastError()
    {
        if ($error = json_last_error() != JSON_ERROR_NONE) {
            // just returns boolean if higher then 5.5.0
            if (phpversion() >= '5.5.0') {
                throw new JsonException(json_last_error_msg());
            } else {
                static::exception($error);
            }
        }
    }

    /**
     * message make for version lower then 5.5.0
     *
     * @param int $error constant of error type
     *
     * @return void
     */
    protected static function exception($error)
    {
        switch ($error) {
            case JSON_ERROR_DEPTH:
                $msg = 'The maximum stack depth has been exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $msg = 'Invalid or malformed JSON';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $msg = 'Control character error, possibly incorrectly encoded';
                break;
            case JSON_ERROR_SYNTAX:
                $msg = 'Syntax error';
                break;
            case JSON_ERROR_UTF8:
                $msg = 'Malformed UTF-8 characters, possibly incorrectly encoded'; // >= PHP 5.3.3
                break;
            case JSON_ERROR_RECURSION:
                $msg = 'One or more recursive references in the value to be encoded'; // >= PHP 5.5.0
                break;
            case JSON_ERROR_INF_OR_NAN:
                $msg = 'One or more NAN or INF values in the value to be encoded'; // >= PHP 5.5.0
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $msg = 'A value of a type that cannot be encoded was given'; // >= PHP 5.5.0
                break;
            default:
                $msg = 'Something wrong';
                break;
        }

        throw new JsonException($msg);
    }
}
