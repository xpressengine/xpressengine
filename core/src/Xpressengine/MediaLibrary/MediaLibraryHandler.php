<?php
/**
 * MediaLibraryHandler.php
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

namespace Xpressengine\MediaLibrary;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Xpressengine\Http\Request;
use Xpressengine\MediaLibrary\Exceptions\NotFoundFileException;
use Xpressengine\MediaLibrary\Exceptions\NotFoundFolderException;
use Xpressengine\MediaLibrary\Exceptions\UnableRootFolderException;
use Xpressengine\MediaLibrary\Models\MediaLibraryFile;
use Xpressengine\MediaLibrary\Models\MediaLibraryFolder;
use Xpressengine\MediaLibrary\Repositories\MediaLibraryFileRepository;
use Xpressengine\MediaLibrary\Repositories\MediaLibraryFolderRepository;
use XeDB;
use XeStorage;
use XeMedia;
use Xpressengine\Storage\File;
use Xpressengine\Support\Tree\NodePositionTrait;

/**
 * Class MediaLibraryHandler
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MediaLibraryHandler
{
    use NodePositionTrait;

    const MODE_ADMIN = 1;
    const MODE_USER = 2;

    /** @var MediaLibraryFileRepository $files */
    protected $files;

    /** @var MediaLibraryFolderRepository $folders */
    protected $folders;

    /**
     * MediaLibraryHandler constructor.
     */
    public function __construct()
    {
        $this->files = app('xe.media_library.files');
        $this->folders = app('xe.media_library.folders');
    }

    /**
     * @param Request $request request
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
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

    /**
     * @param Request $request  request
     * @param string  $folderId folder id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     * @throws \Exception
     */
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

    /**
     * @param Request $request  request
     * @param string  $folderId folder id
     *
     * @return void
     */
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

    /**
     * @param Request $request request
     *
     * @return void
     * @throws \Exception
     */
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
                $this->dropMediaLibraryFile($targetId);
            }
        }
    }

    /**
     * @param string $mediaLibraryFileId file id
     *
     * @return void
     * @throws \Exception
     */
    protected function dropMediaLibraryFile($mediaLibraryFileId)
    {
        $mediaLibraryFile = $this->files->query()->find($mediaLibraryFileId);
        if ($mediaLibraryFile == null) {
            return;
        }

        $this->files->delete($mediaLibraryFile);
    }

    /**
     * @param string $folderId folder id
     *
     * @return void
     * @throws \Exception
     */
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
                $this->dropMediaLibraryFile($file->id);
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

    public function getInstanceFolderItem($instanceId)
    {
        $rootFolderItem = $this->folders->getRootFolderItem();

        $menuItem = app('xe.menu')->items()->find($instanceId);
        if ($menuItem !== null) {
            $folderTitle = $menuItem['type'];

            $folderItem = $this->folders->query()->where([['parent_id', $rootFolderItem->id], ['name', $folderTitle]])->first();
            if ($folderItem === null) {
                $folderItem = $this->storeInstanceFolderItem($rootFolderItem, $folderTitle);
            }

            return $folderItem;
        } elseif (app('xe.config')->get('comment' . '.' . $instanceId) !== null) {
            $folderTitle = 'comment';

            $folderItem = $this->folders->query()->where([['parent_id', $rootFolderItem->id], ['name', $folderTitle]])->first();
            if ($folderItem === null) {
                $folderItem = $this->storeInstanceFolderItem($rootFolderItem, $folderTitle);
            }

            return $folderItem;
        }

        return $rootFolderItem;
    }

    private function storeInstanceFolderItem($parentFolderItem, $folderTitle)
    {
        $folderAttribute = [
            'parent_id' => $parentFolderItem->id,
            'disk' => $parentFolderItem->disk,
            'name' => $folderTitle,
        ];

        $folderItem = $this->folders->storeItem($folderAttribute);

        $folderItem->ancestors()->attach($folderItem->getKey(), [$folderItem->getDepthName() => 0]);
        $this->linkHierarchy($folderItem, $parentFolderItem);
        $this->setOrder($folderItem);

        return $folderItem;
    }

    /**
     * @param string $folderId folder id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
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

    /**
     * @param MediaLibraryFolder $targetFolderItem folder item
     * @param Request            $request          request
     *
     * @return Builder[]|Collection
     */
    public function getFolderList(MediaLibraryFolder $targetFolderItem, Request $request)
    {
        if (!$request->user()->isAdmin() || (int)$request->get('index_mode', self::MODE_USER) !== self::MODE_ADMIN) {
            return [];
        }

        if ($request->get('keyword', '') === '') {
            $folderList = $targetFolderItem->getChildren();
        } else {
            $folderList = $this->folders->getFolderItems($request);
        }

        foreach ($folderList as $folderItem) {
            $folderItem->setAttribute('file_count', $this->getChildHasFileCount($folderItem));
        }

        return $folderList;
    }

    /**
     * @param MediaLibraryFolder $parentFolderItem parent folder item
     *
     * @return int
     */
    public function getChildHasFileCount($parentFolderItem)
    {
        $count = 0;
        $count += $parentFolderItem->files->count();
        foreach ($parentFolderItem->getChildren() as $child) {
            $count += $this->getChildHasFileCount($child);
        }

        return $count;
    }

    /**
     * @param MediaLibraryFolder $folderItem target folder item
     *
     * @return array
     */
    public function getFolderPath(MediaLibraryFolder $folderItem)
    {
        $paths = [];
        $ancestors = $folderItem->ancestors(false)->orderBy($folderItem->getDepthName())->get();

        /** @var MediaLibraryFolder $ancestor */
        foreach ($ancestors->reverse() as $ancestor) {
            $paths[] = ['id' => $ancestor->id, 'name' => $ancestor->name];
        }

        return $paths;
    }

    /**
     * @param MediaLibraryFolder $folderItem folder item
     * @param Request            $request    request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getMediaLibraryFileList(MediaLibraryFolder $folderItem, Request $request)
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

        if (!$request->user()->isAdmin()) {
            $attributes['index_mode'] = MediaLibraryHandler::MODE_USER;
        }

        if ($isSearchState === false) {
            if (isset($attributes['index_mode']) && $attributes['index_mode'] == MediaLibraryHandler::MODE_ADMIN) {
                $attributes['folder_id'] = $folderItem->id;
            } else {
                $rootFolderItem = $this->folders->getRootFolderItem();
                if ($rootFolderItem->id !== $folderItem->id) {
                    $attributes['folder_id'] = $folderItem->id;
                }
            }

            if ($request->has('per_page') === true) {
                $attributes['per_page'] = $request->get('per_page');
            }
        }

        $files = $this->files->getItems($attributes);

        $files->each(function ($item) {
            $this->files->setCommonFileVisible($item);
        });

        return $files;
    }

    /**
     * @param string $mediaLibraryFileId file id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getMediaLibraryFileItem($mediaLibraryFileId)
    {
        $mediaLibraryFileItem = $this->files->query()->find($mediaLibraryFileId);
        if ($mediaLibraryFileItem == null) {
            throw new NotFoundFileException();
        }

        $this->files->setCommonFileVisible($mediaLibraryFileItem);

        return $mediaLibraryFileItem;
    }

    /**
     * @param Request $request            request
     * @param string  $mediaLibraryFileId file id
     *
     * @return void
     */
    public function updateFile(Request $request, $mediaLibraryFileId)
    {
        $mediaLibraryFileItem = $this->getMediaLibraryFileItem($mediaLibraryFileId);
        $attribute = $request->only(['title', 'alt_text', 'caption', 'description']);

        $this->files->update($mediaLibraryFileItem, $attribute);
    }

    public function uploadModifyFile(Request $request, $mediaLibraryFile)
    {
        $uploadFile = $request->file('file');

        $mediaLibraryConfig = config('xe.media.mediaLibrary');

        //file size check
        if ($mediaLibraryConfig['max_size'] != null && $mediaLibraryConfig['max_size'] != '' &&
            $mediaLibraryConfig['max_size'] * 1024 * 1024 < $uploadFile->getSize()) {
            throw new HttpException(
                Response::HTTP_REQUEST_ENTITY_TOO_LARGE,
                xe_trans('xe::msgMaxFileSize', [
                    'fileMaxSize' => $mediaLibraryConfig['max_size'],
                    'uploadFileName' => $uploadFile->getClientOriginalName()
                ])
            );
        }

        //file extension check
        $disallowExtensions = array_map(function ($v) {
            return trim($v);
        }, explode(',', $mediaLibraryConfig['disallow_extensions']));

        if (array_search('*', $disallowExtensions) === true
            || in_array(strtolower($uploadFile->getClientOriginalExtension()), $disallowExtensions)) {
            throw new HttpException(
                Response::HTTP_NOT_ACCEPTABLE,
                xe_trans('xe::msgImpossibleUploadingFiles', [
                    'extensions' => $mediaLibraryConfig['disallow_extensions'],
                    'uploadFileName' => $uploadFile->getClientOriginalName()
                ])
            );
        }

        $file = XeStorage::upload($uploadFile, 'public/media_library/modify', null, 'media');
        XeStorage::bind($mediaLibraryFile->id, $file);

        return $file;
    }

    /**
     * @param Request $request request
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function uploadMediaLibraryFile(Request $request)
    {
        $uploadFile = $request->file('file');

        $mediaLibraryConfig = config('xe.media.mediaLibrary');

        //file size check
        if ($mediaLibraryConfig['max_size'] != null && $mediaLibraryConfig['max_size'] != '' &&
            $mediaLibraryConfig['max_size'] * 1024 * 1024 < $uploadFile->getSize()) {
            throw new HttpException(
                Response::HTTP_REQUEST_ENTITY_TOO_LARGE,
                xe_trans('xe::msgMaxFileSize', [
                    'fileMaxSize' => $mediaLibraryConfig['max_size'],
                    'uploadFileName' => $uploadFile->getClientOriginalName()
                ])
            );
        }

        //file extension check
        $disallowExtensions = array_map(function ($v) {
            return trim($v);
        }, explode(',', $mediaLibraryConfig['disallow_extensions']));

        if (array_search('*', $disallowExtensions) === true
            || in_array(strtolower($uploadFile->getClientOriginalExtension()), $disallowExtensions)) {
            throw new HttpException(
                Response::HTTP_NOT_ACCEPTABLE,
                xe_trans('xe::msgImpossibleUploadingFiles', [
                    'extensions' => $mediaLibraryConfig['disallow_extensions'],
                    'uploadFileName' => $uploadFile->getClientOriginalName()
                ])
            );
        }

        $file = XeStorage::upload($uploadFile, 'public/media_library', null, 'media');

        if (XeMedia::is($file) == true) {
            $media = XeMedia::make($file);
            XeMedia::createThumbnails($media);
        }

        $folderItem = null;
        if ($instanceId = $request->get('instance_id')) {
            $folderItem = $this->getInstanceFolderItem($instanceId);
        } else {
            $folderItem = $this->getFolderItem($request->get('folder_id', ''));
            if ($folderItem === null) {
                throw new NotFoundFolderException();
            }
        }

        $fileAttribute = [
            'file_id' => $file->id,
            'folder_id' => $folderItem->id,
            'user_id' => \Auth::user()->getId(),
            'title' => $uploadFile->getClientOriginalName(),
            'ext' => $uploadFile->getClientOriginalExtension()
        ];

        $mediaLibraryFileItem = $this->files->storeItem($fileAttribute);

        XeStorage::bind($mediaLibraryFileItem->id, $file);


        $this->files->setCommonFileVisible($mediaLibraryFileItem);

        return $mediaLibraryFileItem;
    }

    /**
     * @param Request $request request
     *
     * @return void
     * @throws \Exception
     */
    public function moveMediaLibraryFile(Request $request)
    {
        $targetFolder = $this->getFolderItem($request->get('folder_id', ''));
        $fileIds = $request->get('file_id', []);
        if (is_array($fileIds) == false) {
            $fileIds = [$fileIds];
        }

        foreach ($fileIds as $fileId) {
            XeDB::beginTransaction();
            try {
                $fileItem = $this->getMediaLibraryFileItem($fileId);

                $this->files->update($fileItem, ['folder_id' => $targetFolder->id]);
            } catch (\Exception $e) {
                XeDB::rollback();

                throw $e;
            }
            XeDB::commit();
        }
    }

    public function swapImageFile(MediaLibraryFile $originalMediaLibraryFile, File $newFile)
    {
        $imageHandler = XeMedia::image();

        $originFile = $originalMediaLibraryFile->file;
        $originImage = XeMedia::make($originFile);
        $newImage = XeMedia::make($newFile);

        $dirtyAttributes = $originFile->getDirty();
        foreach ($dirtyAttributes as $key => $dirtyAttribute) {
            if (isset($originFile->{$key}) === true) {
                unset($originFile[$key]);
            }
        }

        $newImageThumbnails = $imageHandler->getThumbnails($newImage);
        $originImageThumbnails = $imageHandler->getThumbnails($originImage);

        //기존 썸네일 파일 정보 교체
        foreach ($originImageThumbnails as $originImageThumbnail) {
            $originImageThumbnailCode = $originImageThumbnail->meta->code;

            $newImageThumbnail = $newImageThumbnails->filter(
                function ($newImageThumbnail) use ($originImageThumbnailCode) {
                    return $newImageThumbnail->meta->code === $originImageThumbnailCode;
                }
            )->first();

            if ($newImageThumbnail == null) {
                continue;
            }

            //파일 교체
            $this->swapFile($originImageThumbnail, $newImageThumbnail);

            $originImageThumbnailAttributes = array_diff_key(
                $originImageThumbnail->meta->getAttributes(),
                array_flip(['id', 'file_id'])
            );

            $newImageThumbnailAttributes = array_diff_key(
                $newImageThumbnail->meta->getAttributes(),
                array_flip(['id', 'file_id'])
            );

            $tempThumbnailAttributes = $originImageThumbnailAttributes;
            $originImageThumbnailAttributes = $newImageThumbnailAttributes;
            $newImageThumbnailAttributes = $tempThumbnailAttributes;

            $newImageThumbnail->meta->update($newImageThumbnailAttributes);
            $originImageThumbnail->meta->update($originImageThumbnailAttributes);
        }

        //파일 교체
        $this->swapFile($originFile, $newFile);

        //파일 정보 변경
        $originFileSize = $originFile->getAttribute('size');
        $newFileSize = $newFile->getAttribute('size');

        $tempSize = $originFileSize;
        $originFileSize = $newFileSize;
        $newFileSize = $tempSize;

        $originFile->update(['size' => $originFileSize]);
        $newFile->update(['size' => $newFileSize]);

        $originImageMetaAttributes = array_diff_key(
            $originImage->meta->getAttributes(),
            array_flip(['id', 'file_id'])
        );
        $newImageMetaAttributes = array_diff_key(
            $newImage->meta->getAttributes(),
            array_flip(['id', 'file_id'])
        );

        $tempImageMetaAttributes = $originImageMetaAttributes;
        $originImageMetaAttributes = $newImageMetaAttributes;
        $newImageMetaAttributes = $tempImageMetaAttributes;

        $originImage->meta->update($originImageMetaAttributes);
        $newImage->meta->update($newImageMetaAttributes);

        //이미지를 여러번 수정 하더라도 최초에 업로드한 파일만 저장
        if ($originalMediaLibraryFile['origin_file_id'] === null) {
            $originalMediaLibraryFile->update(['origin_file_id' => $newImage->id]);
        } else {
            //최초 수정한 파일이 아니면 변경 후 삭제 처리
            XeStorage::unBind($originalMediaLibraryFile['id'], $newImage, true);
        }
    }

    private function swapFile($originFile, $newFile)
    {
        $originFilePath = config('filesystems.disks.' . $originFile->disk . '.root') . DIRECTORY_SEPARATOR . $originFile->path . DIRECTORY_SEPARATOR;
        $newFilePath = config('filesystems.disks.' . $newFile->disk . '.root') . DIRECTORY_SEPARATOR . $newFile->path . DIRECTORY_SEPARATOR;

        $tempFileName = app('xe.keygen')->generate();

        rename($originFilePath . $originFile->filename, $newFilePath . $tempFileName);
        rename($newFilePath . $newFile->filename, $originFilePath . $originFile->filename);
        rename($newFilePath . $tempFileName, $newFilePath . $newFile->filename);
    }
}
