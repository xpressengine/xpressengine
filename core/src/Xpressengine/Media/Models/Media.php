<?php
/**
 * This file is abstract Media class
 *
 * PHP version 7
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media\Models;

use Xpressengine\Media\Models\Meta\Meta;
use Xpressengine\Storage\File;
use Xpressengine\Media\MimeTypeFilter;

/**
 * Abstract class Media
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class Media extends File
{
    use MimeTypeFilter;

    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';
    const TYPE_AUDIO = 'audio';

    /**
     * Available mime type
     *
     * @var array
     */
    protected static $mimes = [];

    /**
     * The attributes that should be visible for serialization.
     *
     * @var array
     */
    protected $visible = ['id', 'user_id', 'clientname', 'mime', 'size', 'download_count', 'url', 'meta'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['url', 'meta'];

    /**
     * Make media model
     *
     * @param File $file file model
     * @return static
     */
    public static function make(File $file)
    {
        $model = new static();

        foreach ($file->getAttributes() as $key => $val) {
            $model->{$key} = $val;
        }

        $model->exists = $file->exists;

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
     * Get the mutated url attribute.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->url();
    }

    /**
     * Get the meta data.
     *
     * @return Meta|null
     */
    public function getMetaAttribute()
    {
        return $this->getRelationValue('meta');
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
