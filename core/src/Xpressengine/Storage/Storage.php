<?php
/**
 * This file is main class of Storage package
 *
 * PHP version 5
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Storage;

use Illuminate\Database\Query\Expression;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Xpressengine\User\UserInterface;
use Xpressengine\User\GuardInterface as Authenticator;
use Xpressengine\Storage\Exceptions\InvalidFileException;
use Xpressengine\Storage\Exceptions\FileDoesNotExistException;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Storage\Exceptions\WritingFailException;
use Carbon\Carbon;

/**
 * Class Storage
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Storage
{
    /**
     * file repository instance
     *
     * @var FileRepository
     */
    protected $repo;

    /**
     * filesystem handler instance
     *
     * @var FilesystemHandler
     */
    protected $files;

    /**
     * Authenticator instance
     *
     * @var Authenticator
     */
    protected $auth;

    /**
     * key generator instance
     *
     * @var Keygen
     */
    protected $keygen;

    /**
     * distributor instance
     *
     * @var Distributor
     */
    protected $distributor;

    /**
     * temporary file creator instance
     *
     * @var TempFileCreator
     */
    protected $tempFiles;

    /**
     * constructor
     *
     * @param FileRepository    $repo        file repository instance
     * @param FilesystemHandler $files       filesystem handler instance
     * @param Authenticator     $auth        Authenticator instance
     * @param Keygen            $keygen      key generator instance
     * @param Distributor       $distributor distributor instance
     * @param TempFileCreator   $tempFiles   temporary file creator instance
     */
    public function __construct(
        FileRepository $repo,
        FilesystemHandler $files,
        Authenticator $auth,
        Keygen $keygen,
        Distributor $distributor,
        TempFileCreator $tempFiles
    ) {
        $this->repo = $repo;
        $this->files = $files;
        $this->auth = $auth;
        $this->keygen = $keygen;
        $this->distributor = $distributor;
        $this->tempFiles = $tempFiles;
    }

    /**
     * file upload to storage
     *
     * @param UploadedFile  $uploaded uploaded file instance
     * @param string        $path     be saved path
     * @param string|null   $name     be saved file name
     * @param string|null   $disk     disk name (ex. local, ftp, s3 ...)
     * @param UserInterface $user     user instance
     * @return File
     */
    public function upload(
        UploadedFile $uploaded,
        $path,
        $name = null,
        $disk = null,
        UserInterface $user = null
    ) {
        if ($uploaded->isValid() === false) {
            throw new InvalidFileException([
                'name' => $uploaded->getClientOriginalName(),
                'detail' => $uploaded->getErrorMessage()
            ]);
        }

        $id = $this->keygen->generate();
        if ($name === null) {
            $name = sprintf(
                '%s.%s',
                $this->makeFilename($uploaded->getClientOriginalName()),
                $uploaded->getClientOriginalExtension()
            );
        }

        $path = $this->makePath($id, $path);

        $disk = $disk ?: $this->distributor->allot($uploaded);
        $user = $user ?: $this->auth->user();

        if (!$this->files->store(file_get_contents($uploaded->getPathname()), $path . '/' . $name, $disk)) {
            throw new WritingFailException;
        }

        return $this->repo->create([
            'userId' => $user->getId(),
            'disk' => $disk,
            'path' => $path,
            'filename' => $name,
            'clientname' => $uploaded->getClientOriginalName(),
            'mime' => $uploaded->getMimeType(),
            'size' => $uploaded->getSize(),
        ], $id);
    }

    /**
     * create file
     *
     * @param string        $content  file content
     * @param string        $path     directory for saved
     * @param string        $name     saved name
     * @param string|null   $disk     disk for saved
     * @param string|null   $originId original file id
     * @param UserInterface $user     user instance
     * @return File
     */
    public function create($content, $path, $name, $disk = null, $originId = null, UserInterface $user = null)
    {
        $id = $this->keygen->generate();
        $path = $this->makePath($id, $path);

        $tempFile = $this->tempFiles->create($content);
        $disk = $disk ?: $this->distributor->allot($tempFile);
        $user = $user ?: $this->auth->user();

        if (!$this->files->store($content, $path . '/' . $name, $disk)) {
            throw new WritingFailException;
        }

        $file = $this->repo->create([
            'userId' => $user->getId(),
            'disk' => $disk,
            'path' => $path,
            'filename' => $name,
            'clientname' => $name,
            'mime' => $tempFile->getMimeType(),
            'size' => $tempFile->getSize(),
            'originId' => $originId,
        ], $id);

        $tempFile->destroy();

        return $file;
    }

    /**
     * file download from storage
     *
     * @param File        $file file instance
     * @param string|null $name name of be downloaded file
     * @return void
     * @throws FileDoesNotExistException
     */
    public function download(File $file, $name = null)
    {
        if ($this->files->exists($file) === false) {
            throw new FileDoesNotExistException();
        }

        $file->increment('downloadCount');

        $name = $name ?: $file->clientname;

        /**
         * google chrome download issue
         * https://github.com/xpressengine/plugin-board/issues/110
         *
         * comma(,) change to space
         */
        $name = str_replace(',', ' ', $name);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header(sprintf('Content-Disposition: attachment; filename=%s', $name));
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $file->size);

        file_put_contents('php://output', $file->getContent());
    }

    /**
     * delete file
     *
     * @param File $file file instance
     * @return bool
     */
    public function delete(File $file)
    {
        // 파일이 원본일 경우 동적으로 생성된 파일 모두 삭제 처리 함
        if ($file->originId === null) {
            foreach ($file->getRawDerives() as $child) {
                $this->delete($child);
            }
        }

        $file->getConnection()->table($file->getFileableTable())->where('fileId', $file->id)->delete();
        $this->files->delete($file);

        return $this->repo->delete($file);
    }

    /**
     * delete file. alias for delete
     *
     * @param File $file file instance
     * @return bool
     *
     * @deprecated since beta.17. Use delete instead.
     */
    public function remove(File $file)
    {
        return $this->delete($file);
    }

    /**
     * set the target be have a file
     *
     * @param string $fileableId fileable identifier
     * @param File   $file       file instance
     * @return void
     */
    public function bind($fileableId, File $file)
    {
        $file->getConnection()->table($file->getFileableTable())->insert([
            'fileId' => $file->getKey(),
            'fileableId' => $fileableId,
            'createdAt' => Carbon::now()
        ]);

        $this->repo->increment($file, 'useCount');
    }

    /**
     * has
     *
     * @param string $fileableId fileable identifier
     * @param File   $file       file instance
     * @return bool
     */
    public function has($fileableId, File $file)
    {
        return $file->getConnection()->table($file->getFileableTable())
            ->where('fileId', $file->getKey())
            ->where('fileableId', $fileableId)
            ->first() === null ? false : true;
    }

    /**
     * set the target be not have a file
     *
     * @param string $fileableId fileable identifier
     * @param File   $file       file instance
     * @param bool   $remove     remove file when given true
     * @return void
     */
    public function unBind($fileableId, File $file, $remove = false)
    {
        $file->getConnection()->table($file->getFileableTable())
            ->where('fileId', $file->getKey())
            ->where('fileableId', $fileableId)
            ->delete();

        if ($remove === true && $file->useCount - 1 < 1) {
            $this->delete($file);
        } else {
            $this->repo->decrement($file, 'useCount');
        }
    }

    /**
     * unset all fileable's files to fileable
     *
     * @param string $fileableId fileable identifier
     * @param bool   $remove     remove file when given true
     * @return void
     */
    public function unBindAll($fileableId, $remove = false)
    {
        $files = $this->repo->fetchByFileable($fileableId);

        foreach ($files as $file) {
            $this->unBind($fileableId, $file, $remove);
        }
    }

    /**
     * Sync fileable's files to fileable
     *
     * @param string $fileableId fileable identifier
     * @param array  $fileIds    file identifier
     * @return void
     */
    public function sync($fileableId, $fileIds = [])
    {
        $fileIds = is_array($fileIds) ? $fileIds : [$fileIds];

        $files = $this->repo->fetchIn($fileIds);
        $olds = $this->repo->fetchByFileable($fileableId)->getDictionary();

        foreach ($files as $file) {
            if (!isset($olds[$file->getKey()])) {
                $this->bind($fileableId, $file);
            } else {
                unset($olds[$file->getKey()]);
            }
        }

        foreach ($olds as $old) {
            $this->unBind($fileableId, $old, true);
        }
    }

    /**
     * make path name
     *
     * @param string $id   identifier
     * @param string $path directory path
     * @return string
     */
    private function makePath($id, $path)
    {
        $dividePath = implode('/', [substr($id, 0, 2), substr($id, 2, 2)]);

        $path = trim($path, '/');
        if (empty($path) !== true) {
            $path = $path . '/';
        }
        return $path . $dividePath;
    }

    /**
     * make file name
     *
     * @param string $clientname client original file name
     * @return string
     */
    private function makeFilename($clientname)
    {
        return date('YmdHis') . hash('sha1', $clientname);
    }

    /**
     * file system handler instance
     *
     * @return FilesystemHandler
     */
    public function getFilesystemHandler()
    {
        return $this->files;
    }

    /**
     * distributor instance
     *
     * @return Distributor
     */
    public function getDistributor()
    {
        return $this->distributor;
    }

    /**
     * set distributor instance
     *
     * @param Distributor $distributor distributor instance
     * @return void
     */
    public function setDistributor(Distributor $distributor)
    {
        $this->distributor = $distributor;
    }

    /**
     * Returns the TempFileCreator instance
     *
     * @return TempFileCreator
     */
    public function getTempFileCreator()
    {
        return $this->tempFiles;
    }

    /**
     * __call
     *
     * @param string $name      method name
     * @param array  $arguments arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repo, $name], $arguments);
    }
}
