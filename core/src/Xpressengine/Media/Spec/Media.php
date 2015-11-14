<?php
/**
 * This file is abstract Media class
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
namespace Xpressengine\Media\Spec;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Xpressengine\Media\Meta;
use Xpressengine\Storage\File;
use Xpressengine\Storage\UrlMaker;

/**
 * 미디어 객체
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class Media implements Arrayable, \JsonSerializable
{
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';
    const TYPE_AUDIO = 'audio';

    /**
     * Storage UrlMaker instance
     *
     * @var UrlMaker
     */
    protected static $urls;

    /**
     * File instance
     *
     * @var File
     */
    protected $file;

    /**
     * Meta instance
     *
     * @var Meta
     */
    protected $meta;

    /**
     * Json type meta data name list
     *
     * @var array
     */
    protected static $jsonType = [];

    /**
     * Constructor
     *
     * @param File $file File instance
     * @param Meta $meta Meta instance
     */
    public function __construct(File $file, Meta $meta)
    {
        $this->file = $file;
        $this->meta = $meta;
    }

    /**
     * Rendered media
     *
     * @param array $option rendering option
     * @return string
     */
    abstract public function render(array $option = []);

    /**
     * Returns media type
     *
     * @return string
     */
    abstract public function getType();

    /**
     * File instance
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Meta instance
     *
     * @return Meta
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Returns json type meta name list
     * @return array
     */
    public static function getJsonType()
    {
        return static::$jsonType;
    }

    /**
     * Media file url
     *
     * @param callable $callback callback
     * @return string
     */
    public function url(Closure $callback = null)
    {
        return static::$urls->url($this->file, $callback);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = $this->meta->toArray();
        $array['file'] = $this->file->toArray();
        $array['url'] = $this->url();

        return $array;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Dynamically access the object attributes.
     *
     * @param string $key key name of want get attribute
     * @return mixed
     */
    public function __get($key)
    {
        if (in_array($key, static::$jsonType) === true) {
            return json_dec($this->meta->{$key}, true);
        }

        return $this->meta->{$key};
    }

    /**
     * Dynamically set an attribute on the user.
     *
     * @param string $key key name of want set attribute
     * @param mixed  $val match value of key name
     * @return void
     */
    public function __set($key, $val)
    {
        if (in_array($key, static::$jsonType) === true) {
            $val = json_enc($val);
        }

        $this->meta->{$key} = $val;
    }

    /**
     * Dynamically check if a value is set on the object.
     *
     * @param string $key key name of want check attribute
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->meta->{$key});
    }

    /**
     * Dynamically unset a value on the object.
     *
     * @param string $key key name of want clear attribute
     * @return void
     */
    public function __unset($key)
    {
        unset($this->meta->{$key});
    }

    /**
     * Convert to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->url();
    }

    /**
     * Set UrlMaker instance
     *
     * @param UrlMaker $urlMaker UrlMaker instance
     * @return void
     */
    public static function setUrlMaker(UrlMaker $urlMaker)
    {
        static::$urls = $urlMaker;
    }
}
