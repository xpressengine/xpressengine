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
namespace Xpressengine\Media\Models;

use Xpressengine\Storage\File;
use Xpressengine\Media\MimeTypeFilter;

/**
 * Abstract class Media
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class Media extends File
{
    use MimeTypeFilter;

    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';
    const TYPE_AUDIO = 'audio';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Available mime type
     *
     * @var array
     */
    protected static $mimes = [];

    /**
     * Make media model
     *
     * @param File $file file model
     * @return static
     */
    public static function make(File $file)
    {
        $model = new static($file->getAttributes());

        $model->exists = true;

        return $model;
    }

    /**
     * Returns available mime type
     *
     * @return array
     */
    public static function getMimes()
    {
        return static::$mimes;
    }

    /**
     * Meta data relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function meta()
    {
        $class = $this->getMetaModel();

        $instance = new $class;

        return $this->hasOne($class, $instance->getForeignKey());
    }

    /**
     * Returns meta data model for current model
     *
     * @return string
     */
    abstract public function getMetaModel();

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
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['url'] = $this->url();

        if (!isset($array['meta'])) {
            $array['meta'] = $this->getRelationValue('meta');
        }

        return $array;
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
}
