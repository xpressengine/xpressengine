<?php
/**
 * MediaLibraryFile.php
 *
 * PHP version 7
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\MediaLibrary\Models;

use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\Storage\File;
use Xpressengine\User\Models\User;

/**
 * Class MediaLibraryFile
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MediaLibraryFile extends DynamicModel
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'media_library_files';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string[]
     */
    protected $fillable = [
        'file_id',
        'origin_file_id',
        'folder_id',
        'user_id',
        'title',
        'ext',
        'caption',
        'alt_text',
        'description',
        'site_key'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function originFile()
    {
        return $this->hasOne(File::class, 'id', 'origin_file_id');
    }

    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->attributes['title'] ?: $this->file->clientname;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
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
