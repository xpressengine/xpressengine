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
 * # Storage
 * 패키지의 메인클래스로 저장소에 파일의 저장을 요청하고 파일의 정보를
 * 데이터베이스등에 저장, 또는 정보를 요청하는 기능을 수행함
 *
 * ### app binding : xe.storage 으로 바인딩 되어 있음
 * `XeStorage` Facade 로 접근이 가능
 *
 * ### 파일 저장
 * 업로드된 파일을 저장하는 경우 `Request` 에서 반환하는
 * `Symfony\Component\HttpFoundation\File\UploadedFile` 객체를 전달 해야 합니다.
 *
 * ```php
 * $uploadFile = Input::file('file');
 * $file = XeStorage::upload($uploadFile, 'dir/path');
 * ```
 *
 * 업로드 되는 파일의 이름을 별도로 지정하고 싶은 경우 3번째 인자로
 * 지정하고 싶은 이름을 넣어 주면 됩니다.
 *
 * ```php
 * XeStorage::upload($uploadFile, 'dir/path', 'new_name');
 * ```
 *
 * 저장되는 저장소를 지정하고 싶은 경우 4번째 인자로
 * config 에 설정된 저장소 중 하나를 함께 전달 하면 됩니다.
 *
 * ```php
 * XeStorage::upload($uploadFile, 'dir/path', 'new_name', 's3');
 * ```
 *
 * file content 를 직접 저장시킬 수 도 있습니다.
 * 이때는 `create` 메서드를 사용합니다.
 *
 * ```
 * $content = file_get_content('path/to/file');
 *
 * XeStorage::create($content, 'dir/path', 'filename');
 * ```
 *
 * 또한 `create` 메서드를 통해 부모 자식관계를 형성할 수 있습니다.
 * 이때는 5번째 인자로 부모에 해당하는 파일의 아이디를 전달하면 됩니다.
 *
 * ```php
 * XeStorage::create($content, 'dir/path', 'filename', null, 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
 * ```
 *
 * ### 다운로드
 * 다운로드 시에는 `download` 메서드에 파일객체를 전달하면 됩니다.
 * 이때 다운로드 되는 파일명을 변경하고자 하는 경우 변경할 이름도 함께 전달해야합니다.
 *
 * ```
 * XeStorage::download($file, 'new_filename');
 * ```
 *
 * ### 연결
 * Storage 는 특정 대상이 파일을 소유하는 형태가 아닌
 * 파일을 특정대상과 연결하는 방식으로 제공 됩니다.
 *
 * 특정 대상으로 부터 파일 업로드 후 연결 처리를 하기위해 다음과 같이 사용해야 합니다.
 *
 * ```php
 * $uploadFile = Input::file('file');
 * $file = XeStorage::upload($file, 'dir/path');
 *
 * XeStorage::bind('target id', $file);
 * ```
 *
 * 연결을 끊는 동작은 `unBind`를 이용합니다.
 *
 * ```php
 * XeStorage::unBind('target id', $file);
 * ```
 *
 * 이때 파일에 연결된 대상이 더이상 존재하지 않는 경우 삭제를 원한다면
 * 삭제처리를 하도록 추가 정보를 전달합니다.
 *
 * ```php
 * XeStorage::unBind('target id', $file, true);
 * ```
 *
 * ### file 의 url
 * 미디어 객채의 url 은 UrlMaker 를 통해 제공됨
 * 이때 filesystem config 의 각 저장소별 설정에서 url 항목이
 * 작성되어진 경우 해당 항목을 이용해 직접 저장소의 파일에 접근할 수
 * 있는 url 을 제공하고 그렇지 않은경우 내부 시스템을 통해 제공되는
 * url 을 제공함
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
     * @param FilesystemHandler $files       filesystem handler instance
     * @param Authenticator     $auth        Authenticator instance
     * @param Keygen            $keygen      key generator instance
     * @param Distributor       $distributor distributor instance
     * @param TempFileCreator   $tempFiles   temporary file creator instance
     */
    public function __construct(
        FilesystemHandler $files,
        Authenticator $auth,
        Keygen $keygen,
        Distributor $distributor,
        TempFileCreator $tempFiles
    ) {
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

        $file = $this->createModel();
        $file->id = $id;
        $file->userId = $user->getId();
        $file->disk = $disk;
        $file->path = $path;
        $file->filename = $name;
        $file->clientname = $uploaded->getClientOriginalName();
        $file->mime = $uploaded->getMimeType();
        $file->size = $uploaded->getSize();

        $file->save();

        return $file;
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

        $file = $this->createModel();
        $file->id = $id;
        $file->userId = $user->getId();
        $file->disk = $disk;
        $file->path = $path;
        $file->filename = $name;
        $file->clientname = $name;
        $file->mime = $tempFile->getMimeType();
        $file->size = $tempFile->getSize();

        if ($originId !== null) {
            $file->originId = $originId;
        }

        $file->save();
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
     * remove file
     *
     * @param File $file file instance
     * @return bool
     */
    public function remove(File $file)
    {
        // 파일이 원본일 경우 동적으로 생성된 파일 모두 삭제 처리 함
        if ($file->originId === null) {
            foreach ($file->getRawDerives() as $child) {
                $this->remove($child);
            }
        }

        $file->getConnection()->table($file->getFileableTable())->where('fileId', $file->id)->delete();
        $this->files->delete($file);

        return $file->delete();
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

        $file->increment('useCount');
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

        $file->useCount--;
        if ($remove === true && $file->useCount < 1) {
            $this->remove($file);
        } else {
            $file->save();
        }
    }

    /**
     * unset all fileable's files to fileable
     *
     * @param string $fileableId fileable identifier
     * @return void
     */
    public function unBindAll($fileableId)
    {
        $model = $this->createModel();
        $files = $model::getByFileable($fileableId);

        foreach ($files as $file) {
            $this->unBind($fileableId, $file, true);
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

        $model = $this->createModel();
        $files = $model->newQuery()->whereIn('id', $fileIds)->get();
        $olds = $model->getByFileable($fileableId)->getDictionary();

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
     * mime 별 파일 용량 정보 반환
     *
     * @param callable $scope 검색 조건
     * @return array ex.) [mime => bytes]
     */
    public function bytesByMime(callable $scope = null)
    {
        $model = $this->createModel();
        $query = $model->getConnection()->table($model->getTable());

        if ($scope) {
            call_user_func($scope, $query);
        }

        $rows = $query->groupBy('mime')
            ->select(['mime', new Expression('sum(`size`) as amount')])
            ->get();

        $array = [];
        foreach ($rows as $row) {
            $row = (array)$row;
            $array[$row['mime']] = $row['amount'];
        }

        return $array;
    }

    /**
     * mime 별 파일 갯수 반환
     *
     * @param callable $scope 검색 조건
     * @return array ex.) [mime => count]
     */
    public function countByMime(callable $scope = null)
    {
        $model = $this->createModel();
        $query = $model->getConnection()->table($model->getTable());

        if ($scope) {
            call_user_func($scope, $query);
        }

        $rows = $query->groupBy('mime')
            ->select(['mime', new Expression('count(*) as cnt')])
            ->get();

        $array = [];
        foreach ($rows as $row) {
            $row = (array)$row;
            $array[$row['mime']] = $row['cnt'];
        }

        return $array;
    }

    /**
     * Returns model class
     *
     * @return string
     */
    public function getModel()
    {
        return File::class;
    }

    /**
     * create file model
     *
     * @return File
     */
    public function createModel()
    {
        $class = $this->getModel();

        return new $class;
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
}
