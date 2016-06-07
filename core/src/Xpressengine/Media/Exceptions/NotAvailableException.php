<?php
/**
 * This file is not available exception
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
 * 이용가능하지 않은 경우
 *
 * @category    Media
 * @package     Xpressengine\Media
 */
class NotAvailableException extends MediaException
{
    protected $message = '사용할 수 없는 파일입니다.';
}
