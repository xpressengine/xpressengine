<?php
/**
 * This file is storage division in a round robin schema
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

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * 파일을 각 저장소에 저장하고 가져오는 역할을 수행
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class FileHandler // filesystem 으로 이름 바꿔?
{
    /**
     * filesystem manager instance
     *
     * @var FilesystemManager
     */
    protected $filesystem;

    /**
     * distributor instance
     *
     * @var Distributor
     */
    protected $distributor;

    /**
     * constructor
     *
     * @param FilesystemManager $filesystem  filesystem manager instance
     * @param Distributor       $distributor distributor instance
     */
    public function __construct(FilesystemManager $filesystem, Distributor $distributor)
    {
        $this->filesystem = $filesystem;
        $this->distributor = $distributor;
    }

    /**
     * returns disk filesystem
     *
     * @param string $name disk name
     * @return Filesystem
     */
    protected function getDisk($name)
    {
        return $this->filesystem->disk($name);
    }

    /**
     * read file contents
     *
     * @param File $file file instance
     * @return string
     */
    public function content(File $file)
    {
        return $this->getDisk($file->disk)->get($file->getPathname());
    }

    /**
     * file content to disk storage
     *
     * @param string      $content  file content
     * @param string      $pathname be saved path and file name
     * @param string|null $disk     be saved disk name
     * @return File
     */
    public function store($content, $pathname, $disk = null)
    {
        $disk = $disk ?: $this->distributor->allot($content);

        $this->getDisk($disk)->put($pathname, $content);

        return new File([
            'disk' => $disk,
            'pathname' => $pathname,
            'mime' => $this->getMime($content),
            'size' => strlen($content)
        ]);
    }

    /**
     * change file content
     *
     * @param File   $file    file instance
     * @param string $content new file content
     * @return File
     */
    public function change(File $file, $content)
    {
        $this->getDisk($file->disk)->put($file->getPathname(), $content);

        $file->mime = $this->getMime($content);
        $file->size = strlen($content);

        return $file;
    }

    /**
     * Get file mime
     *
     * @param string $content file content
     * @return string file mime type
     */
    private function getMime($content)
    {
        $tempPathname = tempnam(sys_get_temp_dir(), 'storage');

        $fp = fopen($tempPathname, 'wb');
        fwrite($fp, $content);
        fclose($fp);

        // get mime type
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($tempPathname);

        unlink($tempPathname);

        return $mime;
    }

    /**
     * remove file from storage
     *
     * @param File $file file instance
     * @return void
     */
    public function delete(File $file)
    {
        $this->getDisk($file->disk)->delete($file->getPathname());
    }

    /**
     * check exists a file
     *
     * @param File $file file instance
     * @return bool
     */
    public function exists(File $file)
    {
        return $this->getDisk($file->disk)->exists($file->getPathname());
    }

    /**
     * filesystem manager instance
     *
     * @return FilesystemManager
     */
    public function getFilesystem()
    {
        return $this->filesystem;
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
}
