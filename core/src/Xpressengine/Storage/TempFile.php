<?php
/**
 * This file is temporary file class
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

use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

/**
 * Class TempFile
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class TempFile extends SymfonyFile
{
    /**
     * Destroy the file from temporary disk
     *
     * @return void
     */
    public function destroy()
    {
        if ($this->isFile()) {
            @unlink($this->getPathname());
        }
    }

    /**
     * Destructor
     *
     * @return void
     */
    public function __destruct()
    {
        $this->destroy();
    }
}
