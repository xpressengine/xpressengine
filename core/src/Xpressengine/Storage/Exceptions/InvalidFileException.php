<?php
/**
 * This file is a exception to invalid file
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
namespace Xpressengine\Storage\Exceptions;

use Xpressengine\Storage\StorageException;

/**
 * 업로드된 파일이 유요하지 않은 경우 발생되는 예외
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class InvalidFileException extends StorageException
{
    protected $message = 'Not uploading possible file [:name] :detail';
}
