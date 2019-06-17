<?php

namespace Xpressengine\MediaLibrary\Repositories;

use Xpressengine\Http\Request;
use Xpressengine\MediaLibrary\Exceptions\NotExistRootFolderException;
use Xpressengine\Support\EloquentRepositoryTrait;

class MediaLibraryFolderRepository
{
    use EloquentRepositoryTrait;

    public function getRootFolderItem()
    {
        $rootFolderItem = $this->query()->where([['parent_id', ''], ['name', '/']])->first();

        if ($rootFolderItem == null) {
            throw new NotExistRootFolderException();
        }

        return $rootFolderItem;
    }

    public function getFolderItems(Request $request)
    {
        $query = $this->query();

        if ($name = $request->get('keyword')) {
            $query = $query->where('name', 'like', '%' . $name . '%');
        }

        return $query->get();
    }
}
