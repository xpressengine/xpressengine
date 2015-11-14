<?php
/**
 * Value object class
 *
 * PHP version 5
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Config;

use Closure;
use Xpressengine\Support\EntityTrait;

/**
 * 특정 대상이 가지는 여러 값을 가지는 entity 클래스
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ConfigVO implements \JsonSerializable
{
    use EntityTrait;

    /**
     * except closure values
     *
     * @return array
     */
    public function scalar()
    {
        $scalars = [];
        foreach ($this->attributes as $key => $value) {
            if ($value instanceof Closure === false) {
                $scalars[$key] = $value;
            }
        }

        return $scalars;
    }

    /**
     * for "json_encode"
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->scalar();
    }
}
