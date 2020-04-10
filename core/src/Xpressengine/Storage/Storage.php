<?php
/**
 * This file is main class of Storage package
 *
 * PHP version 7
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Storage;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Xpressengine\User\UserInterface;
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
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
     * Guard instance
     *
     * @var Guard
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
     * ResponseFactory instance
     *
     * @var ResponseFactory
     */
    protected $response;

    /**
     * MimeFilter instance
     *
     * @var MimeFilter
     */
    protected $mimeFilter;

    /**
     * Custom extension to mime type map
     *
     * @var array
     */
    protected static $customMimeMap = [];

    /**
     * constructor
     *
     * @param FileRepository    $repo        file repository instance
     * @param FilesystemHandler $files       filesystem handler instance
     * @param Guard             $auth        Guard instance
     * @param Keygen            $keygen      key generator instance
     * @param Distributor       $distributor distributor instance
     * @param TempFileCreator   $tempFiles   temporary file creator instance
     * @param ResponseFactory   $response    ResponseFactory instance
     * @param MimeFilter        $mimeFilter  MimeFilter instance
     */
    public function __construct(
        FileRepository $repo,
        FilesystemHandler $files,
        Guard $auth,
        Keygen $keygen,
        Distributor $distributor,
        TempFileCreator $tempFiles,
        ResponseFactory $response,
        MimeFilter $mimeFilter
    ) {
        $this->repo = $repo;
        $this->files = $files;
        $this->auth = $auth;
        $this->keygen = $keygen;
        $this->distributor = $distributor;
        $this->tempFiles = $tempFiles;
        $this->response = $response;
        $this->mimeFilter = $mimeFilter;
    }

    /**
     * file upload to storage
     *
     * @param UploadedFile  $uploaded uploaded file instance
     * @param string        $path     be saved path
     * @param string|null   $name     be saved file name
     * @param string|null   $disk     disk name (ex. local, ftp, s3 ...)
     * @param UserInterface $user     user instance
     * @param mixed         $option   disk option (ex. aws s3 'visibility: public')
     * @return File
     */
    public function upload(
        UploadedFile $uploaded,
        $path,
        $name = null,
        $disk = null,
        UserInterface $user = null,
        $option = []
    ) {

        $this->validateUploadedFile($uploaded);

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

        if (!$this->files->store(file_get_contents($uploaded->getPathname()), $path . '/' . $name, $disk, $option)) {
            throw new WritingFailException;
        }

        return $this->repo->create([
            'user_id' => $user->getId(),
            'disk' => $disk,
            'path' => $path,
            'filename' => $name,
            'clientname' => $this->getNormalizedOriginalName($uploaded),
            'mime' => $uploaded->getMimeType(),
            'size' => $uploaded->getSize(),
        ], $id);
    }

    /**
     * Handle validate given file.
     *
     * @param UploadedFile $uploaded uploaded file
     * @return void
     */
    protected function validateUploadedFile(UploadedFile $uploaded)
    {
        if ($uploaded->isValid() === false) {
            throw new InvalidFileException([
                'name' => $uploaded->getClientOriginalName(),
                'detail' => $uploaded->getErrorMessage()
            ]);
        }

        if (!$this->mimeFilter->isValid($uploaded)) {
            throw new InvalidFileException([
                'name' => $uploaded->getClientOriginalName(),
                'detail' => 'The extension seems to be wrong.'
            ]);
        }
    }

    /**
     * Returns the normalized original file name.
     *
     * thanks @jdssem
     *
     * @param UploadedFile $file uploaded file
     * @return null|string
     */
    protected function getNormalizedOriginalName(UploadedFile $file)
    {
        $filename = $file->getClientOriginalName();

        if (class_exists('Normalizer') && !\Normalizer::isNormalized($filename)) {
            $filename = \Normalizer::normalize($filename);
        }

        return $filename;
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
     * @param mixed         $option   disk option (ex. aws s3 'visibility: public')
     * @return File
     */
    public function create(
        $content,
        $path,
        $name,
        $disk = null,
        $originId = null,
        UserInterface $user = null,
        $option = []
    ) {
        $id = $this->keygen->generate();
        $path = $this->makePath($id, $path);

        $tempFile = $this->tempFiles->create($content);
        $disk = $disk ?: $this->distributor->allot($tempFile);
        $user = $user ?: $this->auth->user();

        if (!$this->files->store($content, $path . '/' . $name, $disk, $option)) {
            throw new WritingFailException;
        }

        $file = $this->repo->create([
            'user_id' => $user->getId(),
            'disk' => $disk,
            'path' => $path,
            'filename' => $name,
            'clientname' => $name,
            'mime' => $tempFile->getMimeType(),
            'size' => $tempFile->getSize(),
            'origin_id' => $originId,
        ], $id);

        $tempFile->destroy();

        return $file;
    }

    /**
     * file download from storage
     *
     * @param File        $file file instance
     * @param string|null $name name of be downloaded file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws FileDoesNotExistException
     */
    public function download(File $file, $name = null)
    {
        if ($this->files->exists($file) === false) {
            throw new FileDoesNotExistException();
        }

        $file->increment('download_count');

        $name = $name ?: $file->clientname;

        /**
         * google chrome download issue
         * https://github.com/xpressengine/plugin-board/issues/110
         *
         * comma(,) change to space
         */
        $name = str_replace(',', ' ', $name);

        $response = $this->response->download($this->tempFiles->create($file->getContent()), $name);
        $response->deleteFileAfterSend(true);

        return $response;
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
        if ($file->origin_id === null) {
            foreach ($file->getRawDerives() as $child) {
                $this->delete($child);
            }
        }

        $file->getConnection()->table($file->getFileableTable())->where('file_id', $file->id)->delete();
        $this->files->delete($file);

        return $this->repo->delete($file);
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
            'file_id' => $file->getKey(),
            'fileable_id' => $fileableId,
            'created_at' => Carbon::now()
        ]);

        $this->repo->increment($file, 'use_count');
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
            ->where('file_id', $file->getKey())
            ->where('fileable_id', $fileableId)
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
            ->where('file_id', $file->getKey())
            ->where('fileable_id', $fileableId)
            ->delete();

        if ($remove === true && $file->use_count - 1 < 1) {
            $this->delete($file);
        } else {
            $this->repo->decrement($file, 'use_count');
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

    /**
     * Returns mime type map
     *
     * @return array
     *
     * @see \League\Flysystem\Util\MimeType::getExtensionToMimeTypeMap
     * @deprecated since 3.0.5 instead use MimeFilter
     */
    public static function getExtensionToMimeTypeMap()
    {
        $map = [
            'hqx'   => 'application/mac-binhex40',
            'cpt'   => 'application/mac-compactpro',
            'csv'   => 'text/x-comma-separated-values',
            'bin'   => 'application/octet-stream',
            'dms'   => 'application/octet-stream',
            'lha'   => 'application/octet-stream',
            'lzh'   => 'application/octet-stream',
            'exe'   => 'application/octet-stream',
            'class' => 'application/octet-stream',
            'psd'   => 'application/x-photoshop',
            'so'    => 'application/octet-stream',
            'sea'   => 'application/octet-stream',
            'dll'   => 'application/octet-stream',
            'oda'   => 'application/oda',
            'pdf'   => 'application/pdf',
            'ai'    => 'application/pdf',
            'eps'   => 'application/postscript',
            'ps'    => 'application/postscript',
            'smi'   => 'application/smil',
            'smil'  => 'application/smil',
            'mif'   => 'application/vnd.mif',
            'xls'   => 'application/vnd.ms-excel',
            'ppt'   => 'application/powerpoint',
            'pptx'  => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'wbxml' => 'application/wbxml',
            'wmlc'  => 'application/wmlc',
            'dcr'   => 'application/x-director',
            'dir'   => 'application/x-director',
            'dxr'   => 'application/x-director',
            'dvi'   => 'application/x-dvi',
            'gtar'  => 'application/x-gtar',
            'gz'    => 'application/x-gzip',
            'gzip'  => 'application/x-gzip',
            'php'   => 'application/x-httpd-php',
            'php4'  => 'application/x-httpd-php',
            'php3'  => 'application/x-httpd-php',
            'phtml' => 'application/x-httpd-php',
            'phps'  => 'application/x-httpd-php-source',
            'js'    => 'application/javascript',
            'swf'   => 'application/x-shockwave-flash',
            'sit'   => 'application/x-stuffit',
            'tar'   => 'application/x-tar',
            'tgz'   => 'application/x-tar',
            'z'     => 'application/x-compress',
            'xhtml' => 'application/xhtml+xml',
            'xht'   => 'application/xhtml+xml',
            'zip'   => [
                'application/x-zip',
                'application/zip',
            ],
            'rar'   => 'application/x-rar',
            'mid'   => 'audio/midi',
            'midi'  => 'audio/midi',
            'mpga'  => 'audio/mpeg',
            'mp2'   => 'audio/mpeg',
            'mp3'   => 'audio/mpeg',
            'aif'   => 'audio/x-aiff',
            'aiff'  => 'audio/x-aiff',
            'aifc'  => 'audio/x-aiff',
            'ram'   => 'audio/x-pn-realaudio',
            'rm'    => 'audio/x-pn-realaudio',
            'rpm'   => 'audio/x-pn-realaudio-plugin',
            'ra'    => 'audio/x-realaudio',
            'rv'    => 'video/vnd.rn-realvideo',
            'wav'   => 'audio/x-wav',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'jpe'   => 'image/jpeg',
            'png'   => 'image/png',
            'gif'   => 'image/gif',
            'bmp'   => 'image/bmp',
            'tiff'  => 'image/tiff',
            'tif'   => 'image/tiff',
            'svg'   => 'image/svg+xml',
            'css'   => 'text/css',
            'html'  => 'text/html',
            'htm'   => 'text/html',
            'shtml' => 'text/html',
            'txt'   => 'text/plain',
            'text'  => 'text/plain',
            'log'   => 'text/plain',
            'rtx'   => 'text/richtext',
            'rtf'   => 'text/rtf',
            'xml'   => 'application/xml',
            'xsl'   => 'application/xml',
            'dmn'   => 'application/octet-stream',
            'bpmn'  => 'application/octet-stream',
            'mpeg'  => 'video/mpeg',
            'mpg'   => 'video/mpeg',
            'mpe'   => 'video/mpeg',
            'qt'    => 'video/quicktime',
            'mov'   => 'video/quicktime',
            'avi'   => 'video/x-msvideo',
            'movie' => 'video/x-sgi-movie',
            'doc'   => 'application/msword',
            'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'docm'  => 'application/vnd.ms-word.template.macroEnabled.12',
            'dot'   => 'application/msword',
            'dotx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'word'  => 'application/msword',
            'xl'    => 'application/excel',
            'eml'   => 'message/rfc822',
            'json'  => [
                'application/json',
                'application/octet-stream',
                'text/plain',
            ],
            'pem'   => 'application/x-x509-user-cert',
            'p10'   => 'application/x-pkcs10',
            'p12'   => 'application/x-pkcs12',
            'p7a'   => 'application/x-pkcs7-signature',
            'p7c'   => 'application/pkcs7-mime',
            'p7m'   => 'application/pkcs7-mime',
            'p7r'   => 'application/x-pkcs7-certreqresp',
            'p7s'   => 'application/pkcs7-signature',
            'crt'   => 'application/x-x509-ca-cert',
            'crl'   => 'application/pkix-crl',
            'der'   => 'application/x-x509-ca-cert',
            'kdb'   => 'application/octet-stream',
            'pgp'   => 'application/pgp',
            'gpg'   => 'application/gpg-keys',
            'sst'   => 'application/octet-stream',
            'csr'   => 'application/octet-stream',
            'rsa'   => 'application/x-pkcs7',
            'cer'   => 'application/pkix-cert',
            '3g2'   => 'video/3gpp2',
            '3gp'   => 'video/3gp',
            'mp4'   => 'video/mp4',
            'm4a'   => 'audio/x-m4a',
            'f4v'   => 'video/mp4',
            'webm'  => 'video/webm',
            'aac'   => 'audio/x-acc',
            'm4u'   => 'application/vnd.mpegurl',
            'm3u'   => 'text/plain',
            'xspf'  => 'application/xspf+xml',
            'vlc'   => 'application/videolan',
            'wmv'   => 'video/x-ms-wmv',
            'au'    => 'audio/x-au',
            'ac3'   => 'audio/ac3',
            'flac'  => 'audio/x-flac',
            'ogg'   => 'audio/ogg',
            'kmz'   => 'application/vnd.google-earth.kmz',
            'kml'   => 'application/vnd.google-earth.kml+xml',
            'ics'   => 'text/calendar',
            'zsh'   => 'text/x-scriptzsh',
            '7zip'  => 'application/x-7z-compressed',
            'cdr'   => 'application/cdr',
            'wma'   => 'audio/x-ms-wma',
            'jar'   => 'application/java-archive',
            'tex'   => 'application/x-tex',
            'latex' => 'application/x-latex',
            'odt'   => 'application/vnd.oasis.opendocument.text',
            'ods'   => 'application/vnd.oasis.opendocument.spreadsheet',
            'odp'   => 'application/vnd.oasis.opendocument.presentation',
            'odg'   => 'application/vnd.oasis.opendocument.graphics',
            'odc'   => 'application/vnd.oasis.opendocument.chart',
            'odf'   => 'application/vnd.oasis.opendocument.formula',
            'odi'   => 'application/vnd.oasis.opendocument.image',
            'odm'   => 'application/vnd.oasis.opendocument.text-master',
            'odb'   => 'application/vnd.oasis.opendocument.database',
            'ott'   => 'application/vnd.oasis.opendocument.text-template',
            'hwp'   => 'application/x-hwp',
            'ico'   => [
                'image/x-icon',
                'image/vnd.microsoft.icon',
            ],
        ];

        return array_merge($map, static::$customMimeMap);
    }

    /**
     * Extend the extension to mime type map
     *
     * @param array $map map array
     * @return void
     *
     * @deprecated since 3.0.5 instead use MimeFilter
     */
    public static function extendMimeMap(array $map)
    {
        static::$customMimeMap = array_merge(static::$customMimeMap, $map);
    }
}
