<?php
/**
 * This file is variable type caster
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
 * 폼에 의해 전달받은 값은 모두 string 인데
 * 이러한 값들을 원래 타입에 맞게 형변환 해주는 역할을 함
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Caster
{
    /**
     * To cast a value
     *
     * @param mixed $value original value
     * @return mixed
     */
    public static function cast($value)
    {
        if (is_scalar($value) === false || $value === null || $value === '') {
            return $value;
        }

        $methods = get_class_methods(self::class);
        foreach ($methods as $method) {
            if ($method == 'cast') {
                continue;
            }

            $castVal = self::$method($value);
            if ($castVal !== null) {
                $value = $castVal;
                break;
            }
        }

        return $value;
    }

    /**
     * To boolean cast a value
     *
     * @param mixed $v original value
     * @return bool|null
     */
    protected static function castBool($v)
    {
        if ($v === true || $v === 'true') {
            return true;
        } elseif ($v === false || $v === 'false') {
            return false;
        }

        return null;
    }

    /**
     * To Integer cast a value
     *
     * @param mixed $v original value
     * @return int|null
     */
    protected static function castInt($v)
    {
        return !preg_match('/[^0-9]/', $v) ? (int)$v : null;
    }

    /**
     * To float cast a value
     *
     * @param mixed $v original value
     * @return float|null
     */
    protected static function castFloat($v)
    {
        return !preg_match('/[^0-9\.]/', $v) ? (float)$v : null;
    }
}
