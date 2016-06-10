<?php
/**
 * Class Json
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

/**
 * php json 함수 사용시 exception 이 발생하지 않기 때문에
 * 예외처리가 가능하도록 exception 을 발생
 *
 * @category    Support
 * @package     Xpressengine\Support
 */
class Json
{
    /**
     * call json_encode function
     *
     * @param mixed $value   target for encoding
     * @param int   $options json behavior constant
     * @param int   $depth   maximum depth
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
     * @return mixed
     */
    public static function decode($string, $assoc = false, $depth = 512, $options = 0)
    {
        $decoded = json_decode($string, $assoc, $depth, $options);

        static::lastError();

        return $decoded;
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
