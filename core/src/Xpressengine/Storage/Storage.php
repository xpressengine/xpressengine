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

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Xpressengine\Member\GuardInterface as Authenticator;
use Xpressengine\Storage\Exceptions\InvalidFileException;
use Xpressengine\Storage\Exceptions\FileDoesNotExistException;
use Xpressengine\Keygen\Keygen;

/**
 * # Storage
 * 패키지의 메인클래스로 저장소에 파일의 저장을 요청하고 파일의 정보를
 * 데이터베이스등에 저장, 또는 정보를 요청하는 기능을 수행함
 *
 * ### app binding : xe.storage 으로 바인딩 되어 있음
 * `Storage` Facade 로 접근이 가능
 *
 * ### 파일 저장
 * 업로드된 파일을 저장하는 경우 `Request` 에서 반환하는
 * `Symfony\Component\HttpFoundation\File\UploadedFile` 객체를 전달 해야 합니다.
 *
 * ```php
 * $uploadFile = Input::file('file');
 * Storage::upload($uploadFile, 'dir/path');
 * ```
 *
 * 업로드 되는 파일의 이름을 별도로 지정하고 싶은 경우 3번째 인자로
 * 지정하고 싶은 이름을 넣어 주면 됩니다.
 *
 * ```php
 * Storage::upload($uploadFile, 'dir/path', 'new_name');
 * ```
 *
 * 저장되는 저장소를 지정하고 싶은 경우 4번째 인자로
 * config 에 설정된 저장소 중 하나를 함께 전달 하면 됩니다.
 *
 * ```php
 * Storage::upload($uploadFile, 'dir/path', 'new_name', 's3');
 * ```
 *
 * file content 를 직접 저장시킬 수 도 있습니다.
 * 이때는 `create` 메서드를 사용합니다.
 *
 * ```
 * $content = file_get_content('path/to/file');
 *
 * Storage::create($content, 'dir/path', 'filename');
 * ```
 *
 * 또한 `create` 메서드를 통해 부모 자식관계를 형성할 수 있습니다.
 * 이때는 5번째 인자로 부모에 해당하는 파일의 아이디를 전달하면 됩니다.
 *
 * ```php
 * Storage::create($content, 'dir/path', 'filename', null, 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
 * ```
 *
 * ### 다운로드
 * 다운로드 시에는 `download` 메서드에 파일객체를 전달하면 됩니다.
 * 이때 다운로드 되는 파일명을 변경하고자 하는 경우 변경할 이름도 함께 전달해야합니다.
 *
 * ```
 * Storage::download($file, 'new_filename');
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
 * $file = Storage::upload($file, 'dir/path');
 *
 * Storage::bind('target id', $file);
 * ```
 *
 * 연결을 끊는 동작은 `unBind`를 이용합니다.
 *
 * ```php
 * Storage::unBind('target id', $file);
 * ```
 *
 * 이때 파일에 연결된 대상이 더이상 존재하지 않는 경우 삭제를 원한다면
 * 삭제처리를 하도록 추가 정보를 전달합니다.
 *
 * ```php
 * Storage::unBind('target id', $file, true);
 * ```
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
     * file handler instance
     *
     * @var FileHandler
     */
    protected $files;

    /**
     * repository instance
     *
     * @var FileRepository
     */
    protected $repo;

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
     * constructor
     *
     * @param FileHandler    $files  file handler instance
     * @param FileRepository $repo   repository instance
     * @param Authenticator  $auth   Authenticator instance
     * @param Keygen         $keygen key generator instance
     */
    public function __construct(FileHandler $files, FileRepository $repo, Authenticator $auth, Keygen $keygen)
    {
        $this->files = $files;
        $this->repo = $repo;
        $this->auth = $auth;
        $this->keygen = $keygen;
    }

    /**
     * file upload to storage
     *
     * @param UploadedFile $uploaded uploaded file instance
     * @param string       $path     be saved path
     * @param string|null  $name     be saved file name
     * @param string|null  $disk     disk name (ex. local, ftp, s3 ...)
     * @return File
     * @throws InvalidFileException
     */
    public function upload(UploadedFile $uploaded, $path, $name = null, $disk = null)
    {
        if ($uploaded->isValid() === false) {
            throw new InvalidFileException();
        }

        $name = $name ?: $this->makeFilename($uploaded->getClientOriginalName());
        $id = $this->keygen->generate();

        $file = $this->files->store(
            file_get_contents($uploaded->getPathname()),
            $this->makePathname($id, $path, $name),
            $disk
        );

        $file->id = $id;
        $file->userId = $this->auth->user()->getId();
        $file->clientname = $uploaded->getClientOriginalName();

        return $this->repo->insert($file);
    }

    /**
     * create file
     *
     * @param string      $content  file content
     * @param string      $path     directory for saved
     * @param string      $name     saved name
     * @param string|null $disk     disk for saved
     * @param string|null $parentId original file id
     * @return File
     */
    public function create($content, $path, $name, $disk = null, $parentId = null)
    {
        $id = $this->keygen->generate();

        $file = $this->files->store($content, $this->makePathname($id, $path, $name), $disk);

        $file->id = $id;
        $file->clientname = $name;

        if ($parentId !== null) {
            $file->parentId = $parentId;
        }

        return $this->repo->insert($file);
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

        $file->downloadCount++;
        $this->repo->update($file);

        $name = $name ?: $file->clientname;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header(sprintf('Content-Disposition: attachment; filename=%s', $name));
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $file->size);

        file_put_contents('php://output', $this->read($file));
    }

    /**
     * read a file contents
     *
     * @param File $file file instance
     * @return string
     */
    public function read(File $file)
    {
        return $this->files->content($file);
    }

    /**
     * return file one
     *
     * @param string $id file identifier
     * @return File
     */
    public function get($id)
    {
        return $this->repo->find($id);
    }

    /**
     * returns files by identifiers
     *
     * @param array $ids file identifier array
     * @return array File object list
     */
    public function getsIn(array $ids)
    {
        return $this->repo->fetchIn($ids);
    }

    /**
     * return target's files
     *
     * @param string $targetId target identifier
     * @return array File objects
     */
    public function getsByTargetId($targetId)
    {
        $files = $this->repo->fetchByTargetId($targetId);

        return $files;
    }

    /**
     * returns paginator consisting of file
     *
     * @param array $wheres where clause
     * @param int   $take   take record count
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $wheres = [], $take = 15)
    {
        return $this->repo->paginate($wheres, $take);
    }

    /**
     * modify file information
     *
     * @param File $file file instance
     * @return File
     */
    public function modify(File $file)
    {
        return $this->repo->update($file);
    }

    /**
     * modify file content
     *
     * @param File   $file    file instance
     * @param string $content new file content
     * @return File
     */
    public function modifyContent(File $file, $content)
    {
        $file = $this->files->change($file, $content);

        return $this->modify($file);
    }

    /**
     * remove file
     *
     * @param File $file file instance
     * @return void
     */
    public function remove(File $file)
    {
        // 파일이 원본일 경우 동적으로 생성된 파일 모두 삭제 처리 함
        if ($file->parentId === null) {
            $children = $this->children($file);
            foreach ($children as $child) {
                $this->remove($child);
            }
        }

        $this->repo->delete($file);

        $this->files->delete($file);
    }

    /**
     * remove all target's files
     *
     * @param string $targetId target identifier
     * @return void
     */
    public function removeAll($targetId)
    {
        $files = $this->repo->fetchByTargetId($targetId);

        foreach ($files as $file) {
            $this->unBind($targetId, $file, true);
        }
    }

    /**
     * set the target be have a file
     *
     * @param string $targetId target identifier
     * @param File   $file     file instance
     * @return void
     */
    public function bind($targetId, File $file)
    {
        $this->repo->relating($targetId, $file->id);
    }

    /**
     * set the target be not have a file
     *
     * @param string $targetId target identifier
     * @param File   $file     file instance
     * @param bool   $remove   remove file when given true
     * @return void
     */
    public function unBind($targetId, File $file, $remove = false)
    {
        $this->repo->unRelating($targetId, $file->id);

        if ($remove === true && --$file->useCount < 1) {
            $this->remove($file);
        }
    }

    /**
     * make path name
     *
     * @param string $id   identifier
     * @param string $path directory path
     * @param string $name file name
     * @return string
     */
    private function makePathname($id, $path, $name)
    {
        $dividePath = implode('/', [substr($id, 0, 2), substr($id, 2, 2)]);

        $path = trim($path, '/');
        if (empty($path) !== true) {
            $path = $path . '/';
        }
        return $path . $dividePath . '/' . $name;
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
     * get children of file
     *
     * @param File $file file instance
     * @return File[]
     */
    public function children(File $file)
    {
        return $this->repo->fetch(['parentId' => $file->id]);
    }

    /**
     * 파일들의 용량 정보
     *
     * @param array $where 검색 조건
     * @return int
     */
    public function bytes(array $where = [])
    {
        return $this->repo->sum('size', $where);
    }

    /**
     * mime 별 파일 용량 정보 반환
     *
     * @param array $where 검색 조건
     * @return array ex.) [mime => bytes]
     */
    public function bytesByMime(array $where = [])
    {
        return $this->repo->sumGroupBy('size', 'mime', $where);
    }

    /**
     * 파일 갯수 반환
     *
     * @param array $wheres 검색 조건
     * @return int
     */
    public function count(array $wheres = [])
    {
        return $this->repo->count($wheres);
    }

    /**
     * mime 별 파일 갯수 반환
     *
     * @param array $wheres 검색 조건
     * @return array ex.) [mime => count]
     */
    public function countByMime(array $wheres = [])
    {
        return $this->repo->countGroupBy('mime', $wheres);
    }

    /**
     * file handler instance
     *
     * @return FileHandler
     */
    public function getFileHandler()
    {
        return $this->files;
    }
}
