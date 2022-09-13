<?php
/**
 * This file is File model
 *
 * PHP version 7
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Storage;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * Class File
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 *
 * @property string $id
 * @property string $origin_id
 * @property string $user_id
 * @property string $disk
 * @property string $path
 * @property string $filename
 * @property string $clientname
 * @property string $mime
 * @property int $size
 * @property int $use_count
 * @property int $download_count
 */
class File extends DynamicModel
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * The table associated with the model for morph.
     *
     * @var string
     */
    protected $fileableTable = 'fileables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'origin_id',
        'user_id',
        'disk',
        'path',
        'filename',
        'clientname',
        'mime',
        'size',
        'site_key'
    ];

    /**
     * The attributes that should be visible for serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'user_id',
        'clientname',
        'mime',
        'size',
        'download_count'
    ];

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The file content reader
     *
     * @var callable
     */
    protected static $reader;

    /**
     * Storage UrlMaker instance
     *
     * @var UrlMaker
     */
    protected static $urls;

    /**
     * Get a path name of file
     *
     * @return string
     */
    public function getPathname()
    {
        return rtrim($this->getAttribute('path'), '/').'/'.$this->getAttribute('filename');
    }

    /**
     * Get the content of file
     *
     * @return string
     */
    public function getContent()
    {
        return call_user_func(static::$reader, $this);
    }

    /**
     * Original file's identifier
     *
     * @return string
     */
    public function getOriginKey()
    {
        return $this->getAttribute('origin_id') ?: $this->getKey();
    }

    /**
     * Get the derive files of current file
     *
     * @return Collection|static[]
     */
    public function getDerives()
    {
        return static::derives($this)->get();
    }

    /**
     * Get the derive files of current file with the File type
     *
     * @return Collection|static[]
     */
    public function getRawDerives()
    {
        $class = __CLASS__;
        $model = new $class();

        return $model->derives($this)->get();
    }

    /**
     * Get a file url
     *
     * @param  \Closure|null  $callback  callback
     * @return string
     */
    public function url(Closure $callback = null)
    {
        return static::$urls->url($this, $callback);
    }

    /**
     * Scope for derives
     *
     * @param  Builder  $query  query builder instance
     * @param  File  $file  file instance
     * @return Builder
     */
    public function scopeDerives(Builder $query, File $file)
    {
        return $query->where('origin_id', $file->getKey());
    }

    /**
     * Set the ContentReader instance
     *
     * @param  callable  $reader  file content reader
     * @return void
     */
    public static function setContentReader(callable $reader)
    {
        static::$reader = $reader;
    }

    /**
     * Set the UrlMaker instance
     *
     * @param  UrlMaker  $urlMaker  UrlMaker instance
     * @return void
     */
    public static function setUrlMaker(UrlMaker $urlMaker)
    {
        static::$urls = $urlMaker;
    }

    /**
     * Get a fileable table name
     *
     * @return string
     */
    public function getFileableTable()
    {
        return $this->fileableTable;
    }

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        $currentSiteKeyResolver = static function ($model) {
            if (isset($model->site_key) === false) {
                $model->site_key = \XeSite::getCurrentSiteKey();
            }
        };

        static::creating($currentSiteKeyResolver);
        static::updating($currentSiteKeyResolver);
        static::saving($currentSiteKeyResolver);
    }
}
