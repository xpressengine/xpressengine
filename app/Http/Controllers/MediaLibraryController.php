<?php

namespace App\Http\Controllers;

use Xpressengine\Http\Request;
use XePresenter;
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

        //TODO 폴더가 없을 떄 처리 필요
        $returnValue['path'] = $this->handler->getFolderPath($targetFolderItem);
        $returnValue['folder'] = $this->handler->getFolderList($targetFolderItem, $request);
        $returnValue['file'] = $this->handler->getFileList($targetFolderItem, $request);

        return XePresenter::makeApi($returnValue);
    }
}
