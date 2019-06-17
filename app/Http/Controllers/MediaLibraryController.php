<?php

namespace App\Http\Controllers;

use Xpressengine\Http\Request;
use XePresenter;
use Xpressengine\MediaLibrary\Exceptions\UploadFileNotExistException;
use Xpressengine\MediaLibrary\MediaLibraryHandler;

class MediaLibraryController extends Controller
{
    /** @var MediaLibraryHandler $handler */
    protected $handler;

    public function __construct()
    {
        $this->handler = app('xe.media_library');
    }

    public function index(Request $request)
    {
        $returnValue = [];

        $targetFolderItem = $this->handler->getFolderItem($request->get('folder_id', ''));

        $returnValue['path'] = $this->handler->getFolderPath($targetFolderItem);
        $returnValue['folder'] = $this->handler->getFolderList($targetFolderItem, $request);
        $returnValue['file'] = $this->handler->getFileList($targetFolderItem, $request);

        return XePresenter::makeApi($returnValue);
    }

    public function createFolder(Request $request)
    {
        $folderItem = $this->handler->createFolder($request);

        return XePresenter::makeApi([$folderItem]);
    }

    public function moveFolder(Request $request, $folderId)
    {
        $newParentFolderItem = $this->handler->moveFolder($request, $folderId);

        return XePresenter::makeApi([$newParentFolderItem]);
    }

    public function updateFolder(Request $request, $folderId)
    {
        $this->handler->updateFolder($request, $folderId);

        return \XePresenter::makeApi([
            'message' => xe_trans('xe::folderRenameMessage')
        ]);
    }

    public function dropFolder(Request $request, $folderId)
    {
        $this->handler->dropFolder($request, $folderId);

        return \XePresenter::makeApi([]);
    }

    public function upload(Request $request)
    {
        if ($request->file('file') == null) {
            throw new UploadFileNotExistException();
        }

        $file = $this->handler->uploadFile($request);

        return XePresenter::makeApi([$file]);
    }
}
