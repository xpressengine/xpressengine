<?php

namespace Xpressengine\MediaLibrary;

use Xpressengine\Http\Request;
use Xpressengine\MediaLibrary\Exceptions\NotExistRootFolderException;
use Xpressengine\MediaLibrary\Models\MediaLibraryFolder;
use Xpressengine\MediaLibrary\Repositories\MediaLibraryFileRepository;
use Xpressengine\MediaLibrary\Repositories\MediaLibraryFolderRepository;

class MediaLibraryHandler
{
    /** @var MediaLibraryFileRepository $files */
    protected $files;

    /** @var MediaLibraryFolderRepository $folders */
    protected $folders;

    public function __construct()
    {
        $this->files = app('xe.media_library.files');
        $this->folders = app('xe.media_library.folders');
    }

    public function getRootFolderItem()
    {
        $rootFolderItem = $this->folders->query()->where([['parent_id', ''], ['name', '/']])->first();

        if ($rootFolderItem == null) {
            throw new NotExistRootFolderException();
        }

        return $rootFolderItem;
    }

    public function getFolderItems(Request $request)
    {
        $query = $this->folders->query();

        if ($name = $request->get('keyword')) {
            $query = $query->where(['name', 'like', '%' . $name . '%']);
        }

        return $query->get();
    }

    public function getFolderItem($folderId)
    {
        if ($folderId != '') {
            $folderItem = $this->folders->find($folderId);
        } else {
            $folderItem = $this->getRootFolderItem();
        }

        return $folderItem;
    }

    public function getFolderList(MediaLibraryFolder $folderItem, Request $request)
    {
        if ($request->get('keyword', '') == '') {
            $folderList = $folderItem->getChildren();
        } else {
            $folderList = $this->getFolderItems($request);
        }

        return $folderList;
    }

    public function getFolderPath(MediaLibraryFolder $folderItem)
    {
        $paths = [];
        $ancestors = $folderItem->ancestors(false)->get();

        /** @var MediaLibraryFolder $ancestor */
        foreach ($ancestors as $ancestor) {
            $paths[] = ['id' => $ancestor->id, 'name' => $ancestor->name];
        }

        return $paths;
    }

    public function getFileList(MediaLibraryFolder $folderItem, Request $request)
    {
        $attributes = $request->all();

        $isSearchState = false;
        $searchAbles = ['keyword', 'startDate', 'endDate', 'mime'];
        foreach ($searchAbles as $searchAble) {
            if (array_key_exists($searchAble, $attributes) == true) {
                $isSearchState = true;
                break;
            }
        }
        if ($isSearchState == false) {
            $attributes = ['folder_id' => $folderItem->id];

            if ($request->has('per_page') == true) {
                $attributes['per_page'] = $request->get('per_page');
            }
        }

        $files = $this->files->getItems($attributes);

        $files->each(function ($item) {
            if ($item->user != null) {
                $item->user->setAttribute('profile_image_url', $item->user->getProfileImage());
                $item->user->addVisible(['profile_image_url']);
            }
            $item->file->addVisible(['path', 'filename']);
        });

        return $files;
    }
}
