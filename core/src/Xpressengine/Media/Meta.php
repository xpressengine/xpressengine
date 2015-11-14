<?php
/**
 * This file is Media meta data entity class
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Media;

use ArrayAccess;
use IteratorAggregate;
use ArrayIterator;
use Xpressengine\Support\EntityTrait;

/**
 * 미디어의 메타 데이터 객체
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Meta implements ArrayAccess, IteratorAggregate
{
    use EntityTrait;

    /**
     * json 형식으로 인코딩
     *
     * @param array $jsonType 대상 이름 배열
     * @return void
     */
    public function dataEncode(array $jsonType)
    {
        foreach ($this as $key => $value) {
            if (in_array($key, $jsonType) === true && is_scalar($value) !== true) {
                $this[$key] = json_enc($value);
            }
        }
    }

    /**
     * Determine if a given offset exists.
     *
     * @param string $offset array key name
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->{$offset} !== null;
    }

    /**
     * Get the value at a given offset.
     *
     * @param string $offset array key name
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }

    /**
     * Set the value at a given offset.
     *
     * @param string $offset array key name
     * @param mixed  $value  array value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }

    /**
     * Unset the value at a given offset.
     *
     * @param string $offset array key name
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }

    /**
     * Get an iterator for the items.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getAttributes());
    }
}
