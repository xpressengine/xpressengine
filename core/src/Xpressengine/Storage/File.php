<?php
/**
 * This file is File object
 *
 * PHP version 5
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Storage;

use JsonSerializable;
use Xpressengine\Support\EntityTrait;

/**
 * 파일의 정보를 담고 있는 객체 클래스
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class File implements JsonSerializable
{
    use EntityTrait;

    /**
     * protected property when update
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * constructor
     *
     * @param array $attributes object attributes
     */
    public function __construct(array $attributes)
    {
        if (isset($attributes['pathname'])) {
            $attributes['path'] = pathinfo($attributes['pathname'], PATHINFO_DIRNAME);
            $attributes['filename'] = pathinfo($attributes['pathname'], PATHINFO_BASENAME);
            unset($attributes['pathname']);
        }

        $this->original = $this->attributes = $attributes;
    }

    /**
     * Returns id
     *
     * @return string
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

    /**
     * Original file's id
     *
     * @param bool $defaultSelf returns self id when parent not exists
     * @return null|string
     */
    public function getOriginId($defaultSelf = true)
    {
        return $this->parentId ?: ($defaultSelf ? $this->getId() : null);
    }

    /**
     * Returns mime type
     *
     * @return string
     */
    public function getMime()
    {
        return $this->attributes['mime'];
    }

    /**
     * File path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->attributes['path'];
    }

    /**
     * File name
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->attributes['filename'];
    }

    /**
     * directory path and file name
     *
     * @return string
     */
    public function getPathname()
    {
        return rtrim($this->attributes['path'], '/') . '/' . $this->attributes['filename'];
    }

    /**
     * check exists
     *
     * @return bool
     */
    public function exists()
    {
//        return file_exists($this->attributes['pathname']);
    }

    /**
     * For json encode
     *
     * @return array visible properties
     */
    public function jsonSerialize()
    {
        return $this->getAttributes();
    }
}
