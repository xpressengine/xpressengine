<?php
/**
 * This file is File model
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
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 *
 * @property string $id
 * @property string $originId
 * @property string $userId
 * @property string $disk
 * @property string $path
 * @property string $filename
 * @property string $clientname
 * @property string $mime
 * @property int $size
 * @property int $useCount
 * @property int $downloadCount
 */
class File extends DynamicModel
{
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
    protected $fillable = ['originId', 'userId', 'disk', 'path', 'filename', 'clientname', 'mime', 'size'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

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
        return rtrim($this->getAttribute('path'), '/') . '/' . $this->getAttribute('filename');
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
        return $this->getAttribute('originId') ?: $this->getKey();
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
        $model = new $class;

        return $model->derives($this)->get();
    }

    /**
     * Get a file url
     *
     * @param Closure $callback callback
     * @return string
     */
    public function url(Closure $callback = null)
    {
        return static::$urls->url($this, $callback);
    }

    /**
     * Scope for derives
     *
     * @param Builder $query query builder instance
     * @param File    $file  file instance
     * @return Builder
     */
    public function scopeDerives(Builder $query, File $file)
    {
        return $query->where('originId', $file->getKey());
    }

    /**
     * Get the files for fileable
     *
     * @param string $fileableId fileable identifier
     * @return Collection|static[]
     *
     * @deprecated since beta.17. Use XeStorage::fetchByFileable instead.
     */
    public static function getByFileable($fileableId)
    {
        $model = new static;

        return $model->newQuery()
            ->rightJoin($model->getFileableTable(), $model->getTable().'.id', '=', $model->getFileableTable().'.fileId')
            ->where('fileableId', $fileableId)
            ->select([$model->getTable().'.*'])
            ->get();
    }

    /**
     * Set the ContentReader instance
     *
     * @param callable $reader file content reader
     * @return void
     */
    public static function setContentReader(callable $reader)
    {
        static::$reader = $reader;
    }

    /**
     * Set the UrlMaker instance
     *
     * @param UrlMaker $urlMaker UrlMaker instance
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
}
