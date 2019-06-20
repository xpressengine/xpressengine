<?php

namespace Xpressengine\MediaLibrary;

use Xpressengine\Http\Request;
use Xpressengine\MediaLibrary\Exceptions\NotFoundFileException;
use Xpressengine\MediaLibrary\Exceptions\NotFoundFolderException;
use Xpressengine\MediaLibrary\Exceptions\UnableRootFolderException;
use Xpressengine\MediaLibrary\Models\MediaLibraryFolder;
use Xpressengine\MediaLibrary\Repositories\MediaLibraryFileRepository;
use Xpressengine\MediaLibrary\Repositories\MediaLibraryFolderRepository;
use XeDB;
use XeStorage;
use XeMedia;
use Xpressengine\Support\Tree\NodePositionTrait;

class MediaLibraryHandler
{
    use NodePositionTrait;

    /** @var MediaLibraryFileRepository $files */
    protected $files;

    /** @var MediaLibraryFolderRepository $folders */
    protected $folders;

    public function __construct()
    {
        $this->files = app('xe.media_library.files');
        $this->folders = app('xe.media_library.folders');
    }

    public function createFolder(Request $request)
    {
        XeDB::beginTransaction();

        try {
            $parentFolderItem = $this->getFolderItem($request->get('parent_id', ''));

            $attribute = $request->except('_token');
            $attribute['parent_id'] = $parentFolderItem->id;

            $folderItem = $this->folders->storeItem($attribute);

            $folderItem->ancestors()->attach($folderItem->getKey(), [$folderItem->getDepthName() => 0]);
            $this->linkHierarchy($folderItem, $parentFolderItem);
            $this->setOrder($folderItem);
        } catch (\Exception $e) {
            XeDB::rollback();

            throw $e;
        }

        XeDB::commit();

        return $folderItem;
    }

    public function moveFolder(Request $request, $folderId)
    {
        XeDB::beginTransaction();

        try {
            $folderItem = $this->getFolderItem($folderId);
            if ($folderItem == null) {
                throw new NotFoundFolderException();
            } elseif ($folderItem == $this->folders->getRootFolderItem()) {
                throw new UnableRootFolderException();
            }

            $oldParentFolderItem = $this->getFolderItem($folderItem->parent_id);
            $newParentFolderItem = $this->getFolderItem($request->get('parent_id', ''));

            $this->unlinkHierarchy($folderItem, $oldParentFolderItem);
            $this->linkHierarchy($folderItem, $newParentFolderItem);
            $this->setOrder($folderItem);

            $this->folders->update($folderItem, [$folderItem->getParentIdName() => $newParentFolderItem->id]);
        } catch (\Exception $e) {
            XeDB::rollback();

            throw $e;
        }

        XeDB::commit();

        return $newParentFolderItem;
    }

    public function updateFolder(Request $request, $folderId)
    {
        $folderItem = $this->getFolderItem($folderId);
        if ($folderItem == null) {
            throw new NotFoundFolderException();
        } elseif ($folderItem == $this->folders->getRootFolderItem()) {
            throw new UnableRootFolderException();
        }

        $attribute = $request->except(['_token', 'parent_id', 'disk', 'ordering']);

        $this->folders->update($folderItem, $attribute);
    }

    public function dropItems(Request $request)
    {
        $targetIds = $request->get('target_ids', []);
        if (is_array($targetIds) == false) {
            $targetIds = [$targetIds];
        }

        foreach ($targetIds as $targetId) {
            if ($this->folders->query()->find($targetId) != null) {
                $this->dropFolder($targetId);
            } else {
                $this->dropFile($targetId);
            }
        }
    }

    protected function dropFile($fileId)
    {
        $fileItem = $this->files->query()->find($fileId);
        if ($fileItem == null) {
            return;
        }

        $this->files->delete($fileItem);
    }

    protected function dropFolder($folderId)
    {
        XeDB::beginTransaction();

        try {
            $folderItem = $this->getFolderItem($folderId);
            if ($folderItem == null) {
                throw new NotFoundFolderException();
            } elseif ($folderItem == $this->folders->getRootFolderItem()) {
                throw new UnableRootFolderException();
            }

            foreach ($folderItem->getChildren() as $child) {
                $this->dropFolder($child->id);
            }

            foreach ($folderItem->files as $file) {
                $this->dropFile($file->id);
            }

            $parentFolderItem = $this->getFolderItem($folderItem->parent_id);

            $this->unlinkHierarchy($folderItem, $parentFolderItem);
            $folderItem->ancestors(false)->detach();

            $this->folders->delete($folderItem);
        } catch (\Exception $e) {
            XeDB::rollback();

            throw $e;
        }

        XeDB::commit();
    }

    public function getFolderItem($folderId)
    {
        if ($folderId != '') {
            $folderItem = $this->folders->find($folderId);

            if ($folderItem == null) {
                throw new NotFoundFolderException();
            }
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

    public function getChildHasFileCount($parentFolderItem)
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
            $this->files->setCommonFileVisible($item);
        });

        return $files;
    }

    public function getFileItem($fileId)
    {
        $fileItem = $this->files->query()->find($fileId);
        if ($fileItem == null) {
            throw new NotFoundFileException();
        }

        $this->files->setCommonFileVisible($fileItem);

        return $fileItem;
    }

    public function updateFile(Request $request, $fileId)
    {
        $fileItem = $this->getFileItem($fileId);
        $attribute = $request->only(['title', 'alt_text', 'caption', 'description']);

        $this->files->update($fileItem, $attribute);
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
                'title' => $uploadFile->getClientOriginalName(),
                'ext' => $uploadFile->getClientOriginalExtension()
            ];

            $fileItem = $this->files->storeItem($fileAttribute);
        } catch (\Exception $e) {
            XeDB::rollback();

            throw $e;
        }

        XeDB::commit();

        return $fileItem;
    }

    public function moveFile(Request $request)
    {
        $targetFolder = $this->getFolderItem($request->get('folder_id', ''));
        $fileIds = $request->get('file_id', []);
        if (is_array($fileIds) == false) {
            $fileIds = [$fileIds];
        }

        foreach ($fileIds as $fileId) {
            XeDB::beginTransaction();
            try {
                $fileItem = $this->getFileItem($fileId);

                $this->files->update($fileItem, ['folder_id' => $targetFolder->id]);
            } catch (\Exception $e) {
                XeDB::rollback();

                throw $e;
            }
            XeDB::commit();
        }
    }
}
