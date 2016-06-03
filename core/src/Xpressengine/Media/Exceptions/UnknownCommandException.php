<?php
/**
 * This file is unknown command exception
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media\Exceptions;

use Xpressengine\Media\MediaException;

/**
 * 알 수 없는 command 를 사용하려고 하는 경우
 *
 * @category    Media
 * @package     Xpressengine\Media
 */
class UnknownCommandException extends MediaException
{
    protected $message = '":name" 은 알 수 없는 command 입니다.';
}
