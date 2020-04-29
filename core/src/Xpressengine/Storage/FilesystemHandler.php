<?php
/**
 * This file is file content I/O handling from disk
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

use Illuminate\Filesystem\FilesystemManager;

/**
 * Class FilesystemHandler
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class FilesystemHandler
{
    /**
     * filesystem manager instance
     *
     * @var FilesystemManager
     */
    protected $filesystem;

    /**
     * constructor
     *
     * @param FilesystemManager $filesystem filesystem manager instance
     */
    public function __construct(FilesystemManager $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * returns disk filesystem
     *
     * @param string $name disk name
     * @return \Illuminate\Contracts\Filesystem\Filesystem
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
    public function read(File $file)
    {
        return $this->getDisk($file->disk)->get($file->getPathname());
    }

    /**
     * file content to disk storage
     *
     * @param string $content  file content
     * @param string $pathname be saved path and file name
     * @param string $disk     be saved disk name
     * @param mixed  $option   disk option (ex. aws s3 'visibility: public')
     * @return bool
     */
    public function store($content, $pathname, $disk, $option = [])
    {
        return $this->getDisk($disk)->put($pathname, $content, $option);
    }

    /**
     * remove file from storage
     *
     * @param File $file file instance
     * @return bool
     */
    public function delete(File $file)
    {
        if (!$this->exists($file)) {
            return false;
        }

        return $this->getDisk($file->disk)->delete($file->getPathname());
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
}
