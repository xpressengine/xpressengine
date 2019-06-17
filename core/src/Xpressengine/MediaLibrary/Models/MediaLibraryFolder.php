<?php

namespace Xpressengine\MediaLibrary\Models;

use Xpressengine\Support\Tree\Node;

class MediaLibraryFolder extends Node
{
    public $incrementing = false;

    public $timestamps = true;

    protected $table = 'media_library_folders';

    protected $fillable = ['disk', 'parent_id', 'name', 'ordering'];

    protected $hidden = ['files'];

    protected static $aggregator;

    public function getClosureTable()
    {
        return 'media_library_folder_closure';
    }

    public function getAncestorName()
    {
        return 'ancestor';
    }

    public function getDescendantName()
    {
        return 'descendant';
    }

    public function getDepthName()
    {
        return 'depth';
    }

    public function getParentIdName()
    {
        return 'parent_id';
    }

    public function getOrderKeyName()
    {
        return 'ordering';
    }

    public function getAggregatorModel()
    {
        return static::$aggregator;
    }

    public function getAggregatorKeyName()
    {
        //TODO ??
        return 'folder_id';
    }

    public static function setAggregatorModel($model)
    {
        static::$aggregator = '\\' . ltrim($model, '\\');
    }

    public function files()
    {
        return $this->hasMany(MediaLibraryFile::class, 'folder_id', 'id');
    }
}
