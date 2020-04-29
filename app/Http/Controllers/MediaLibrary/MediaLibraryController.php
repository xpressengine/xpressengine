<?php
/**
 * MediaLibraryController.php
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

namespace App\Http\Controllers\MediaLibrary;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Xpressengine\Http\Request;
use XeDB;
use XePresenter;
use Xpressengine\MediaLibrary\Exceptions\NotFoundFileException;
use Xpressengine\MediaLibrary\Exceptions\UploadFileNotExistException;
use Xpressengine\MediaLibrary\MediaLibraryHandler;
use Xpressengine\Storage\Exceptions\InvalidFileException;

/**
 * Class MediaLibraryController
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
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
        $returnValue['file'] = $this->handler->getMediaLibraryFileList($targetFolderItem, $request);

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
     * @param Request $request            request
     * @param string  $mediaLibraryFileId target file id
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     */
    public function getFile(Request $request, $mediaLibraryFileId)
    {
        $fileItem = $this->handler->getMediaLibraryFileItem($mediaLibraryFileId);

        return XePresenter::makeApi([$fileItem]);
    }

    /**
     * @param Request $request            request
     * @param string  $mediaLibraryFileId target file id
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     */
    public function updateFile(Request $request, $mediaLibraryFileId)
    {
        $this->handler->updateFile($request, $mediaLibraryFileId);

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
        $this->handler->moveMediaLibraryFile($request);

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

        XeDB::beginTransaction();
        try {
            $file = $this->handler->uploadMediaLibraryFile($request);
        } catch (InvalidFileException $e) {
            XeDB::rollback();

            throw new HttpException(400, xe_trans('xe::msgInvalidUploadedFile'));
        } catch (\Throwable $e) {
            XeDB::rollback();

            throw $e;
        }
        XeDB::commit();

        return XePresenter::makeApi([$file]);
    }

    /**
     * @param string $mediaLibraryFileId fileId
     *
     * @return mixed|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($mediaLibraryFileId)
    {
        $mediaLibraryFile = $this->handler->getMediaLibraryFileItem($mediaLibraryFileId);
        if ($mediaLibraryFile == null || $mediaLibraryFile->file == null) {
            throw new NotFoundFileException;
        }

        return \XeStorage::download($mediaLibraryFile->file);
    }

    public function modifyFile(Request $request, $originFileId)
    {
        $originalMediaLibraryFileItem = $this->handler->getMediaLibraryFileItem($originFileId);
        if ($request->file('file') == null) {
            throw new UploadFileNotExistException();
        }

        XeDB::beginTransaction();
        try {
            $newImageFile = $this->handler->uploadModifyFile($request, $originalMediaLibraryFileItem);

            $this->handler->swapImageFile($originalMediaLibraryFileItem, $newImageFile);
        } catch (InvalidFileException $e) {
            XeDB::rollback();

            throw new HttpException(400, xe_trans('xe::msgInvalidUploadedFile'));
        } catch (\Throwable $e) {
            XeDB::rollback();

            throw $e;
        }
        XeDB::commit();

        return redirect()->back();
    }
}
