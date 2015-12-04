<?php
/**
 * This file is a exception to file not exists
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
namespace Xpressengine\Storage\Exceptions;

use Xpressengine\Storage\StorageException;

/**
 * 파일이 존재하지 않는 경우 발생하는 예외
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class FileDoesNotExistException extends StorageException
{
    protected $message = '파일이 존재하지 않습니다.';
}
