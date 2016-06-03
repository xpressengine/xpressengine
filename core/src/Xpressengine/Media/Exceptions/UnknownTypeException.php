<?php
/**
 * This file is unknown type exception
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
 * type 을 알 수 없는 경우
 *
 * @category    Media
 * @package     Xpressengine\Media
 */
class UnknownTypeException extends MediaException
{
    protected $message = 'type 을 알 수 없습니다.';
}
