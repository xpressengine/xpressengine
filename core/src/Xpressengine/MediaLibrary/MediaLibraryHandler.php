<?php

namespace Xpressengine\MediaLibrary;

use Xpressengine\Http\Request;
use Xpressengine\MediaLibrary\Exceptions\NotFoundFolderException;
use Xpressengine\MediaLibrary\Models\MediaLibraryFolder;
use Xpressengine\MediaLibrary\Repositories\MediaLibraryFileRepository;
use Xpressengine\MediaLibrary\Repositories\MediaLibraryFolderRepository;
use XeDB;
use XeStorage;
use XeMedia;

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

    public function getFolderItem($folderId)
    {
        if ($folderId != '') {
            $folderItem = $this->folders->find($folderId);
        } else {
            $folderItem = $this->folders->getRootFolderItem();
        }

        return $folderItem;
    }

    public function getFolderList(MediaLibraryFolder $folderItem, Request $request)
    {
        if ($request->get('keyword', '') == '') {
            $folderList = $folderItem->getChildren();
        } else {
            $folderList = $this->folders->getFolderItems($request);
        }

        foreach ($folderList as $folderItem) {
            $folderItem->setAttribute('file_count', $this->getChildHasFileCount($folderItem));
        }

        return $folderList;
    }

    private function getChildHasFileCount($parentFolderItem)
    {
        $count = 0;
        $count += $parentFolderItem->files->count();
        foreach ($parentFolderItem->getChildren() as $child) {
            $count += $this->getChildHasFileCount($child);
        }

        return $count;
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

    public function uploadFile(Request $request)
    {
        XeDB::beginTransaction();

        try {
            $uploadFile = $request->file('file');
            $file = XeStorage::upload($uploadFile, 'public/media_library', null, 'media');

            if (XeMedia::is($file) == true) {
                $media = XeMedia::make($file);
                XeMedia::createThumbnails($media);
            }

            $folderItem = $this->getFolderItem($request->get('folder_id', ''));
            if ($folderItem == null) {
                throw new NotFoundFolderException();
            }

            $fileAttribute = [
                'file_id' => $file->id,
                'folder_id' => $folderItem->id,
                'user_id' => \Auth::user()->getId(),
                'ext' => $uploadFile->getClientOriginalExtension()
            ];

            $fileModel = $this->files->createModel();
            $fileModel->fill($fileAttribute);
            $fileModel->save();
        } catch (\Exception $e) {
            XeDB::rollback();

            throw $e;
        }

        XeDB::commit();

        return $fileModel;
    }
}
