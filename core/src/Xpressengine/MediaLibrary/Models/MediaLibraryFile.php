<?php

namespace Xpressengine\MediaLibrary\Models;

use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\Storage\File;
use Xpressengine\User\Models\User;

class MediaLibraryFile extends DynamicModel
{
    protected $table = 'media_library_files';

    public $incrementing = false;

    protected $fillable = [
        'file_id', 'folder_id', 'user_id', 'title', 'caption',
        'alt_text', 'description'
    ];

    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    public function getTitleAttribute()
    {
        if ($this->attributes['title'] == '') {
            return $this->file->clientname;
        } else {
            return $this->attributes['title'];
        }
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
