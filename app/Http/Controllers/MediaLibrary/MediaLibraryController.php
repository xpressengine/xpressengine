<?php
/**
 * MediaLibraryController.php
 *
 * PHP version 7
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers\MediaLibrary;

use App\Http\Controllers\Controller;
use Xpressengine\Http\Request;
use XePresenter;
use Xpressengine\MediaLibrary\Exceptions\NotFoundFileException;
use Xpressengine\MediaLibrary\Exceptions\UploadFileNotExistException;
use Xpressengine\MediaLibrary\MediaLibraryHandler;

/**
 * Class MediaLibraryController
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MediaLibraryController extends Controller
{
    /** @var MediaLibraryHandler $handler */
    protected $handler;

    /**
     * MediaLibraryController constructor.
     */
    public function __construct()
    {
        $this->handler = app('xe.media_library.handler');
    }

    /**
     * @param Request $request request
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     */
    public function index(Request $request)
    {
        $returnValue = [];

        $targetFolderItem = $this->handler->getFolderItem($request->get('folder_id', ''));

        $returnValue['path'] = $this->handler->getFolderPath($targetFolderItem);
        $returnValue['folder'] = $this->handler->getFolderList($targetFolderItem, $request);
        $returnValue['file'] = $this->handler->getFileList($targetFolderItem, $request);

        return XePresenter::makeApi($returnValue);
    }

    /**
     * @param Request $request request
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     * @throws \Exception
     */
    public function drop(Request $request)
    {
        $this->handler->dropItems($request);

        return XePresenter::makeApi([]);
    }

    /**
     * @param Request $request  request
     * @param string  $folderId target folder id
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     */
    public function getFolder(Request $request, $folderId)
    {
        $folderItem = $this->handler->getFolderItem($folderId);
        $folderItem->setAttribute('file_count', $this->handler->getChildHasFileCount($folderItem));

        return XePresenter::makeApi([$folderItem]);
    }

    /**
     * @param Request $request request
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     * @throws \Exception
     */
    public function createFolder(Request $request)
    {
        $folderItem = $this->handler->createFolder($request);

        return XePresenter::makeApi([$folderItem]);
    }

    /**
     * @param Request $request  request
     * @param string  $folderId target folder id
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     * @throws \Exception
     */
    public function moveFolder(Request $request, $folderId)
    {
        $newParentFolderItem = $this->handler->moveFolder($request, $folderId);

        return XePresenter::makeApi([$newParentFolderItem]);
    }

    /**
     * @param Request $request  request
     * @param string  $folderId target folder id
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     */
    public function updateFolder(Request $request, $folderId)
    {
        $this->handler->updateFolder($request, $folderId);

        return \XePresenter::makeApi([
            'message' => xe_trans('xe::folderRenameMessage')
        ]);
    }

    /**
     * @param Request $request request
     * @param string  $fileId  target file id
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     */
    public function getFile(Request $request, $fileId)
    {
        $fileItem = $this->handler->getFileItem($fileId);

        return XePresenter::makeApi([$fileItem]);
    }

    /**
     * @param Request $request request
     * @param string  $fileId  target file id
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     */
    public function updateFile(Request $request, $fileId)
    {
        $this->handler->updateFile($request, $fileId);

        return XePresenter::makeApi([
            'message' => xe_trans('xe::fileInformationUpdateMessage')
        ]);
    }

    /**
     * @param Request $request request
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     * @throws \Exception
     */
    public function moveFile(Request $request)
    {
        $this->handler->moveFile($request);

        return XePresenter::makeApi([]);
    }

    /**
     * @param Request $request request
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     * @throws \Exception
     */
    public function upload(Request $request)
    {
        if ($request->file('file') == null) {
            throw new UploadFileNotExistException();
        }

        $file = $this->handler->uploadFile($request);

        return XePresenter::makeApi([$file]);
    }

    /**
     * @param string $fileId fileId
     *
     * @return mixed|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($fileId)
    {
        $mediaLibraryFile = $this->handler->getFileItem($fileId);
        if ($mediaLibraryFile == null || $mediaLibraryFile->file == null) {
            throw new NotFoundFileException;
        }

        return \XeStorage::download($mediaLibraryFile->file);
    }
}
