<?php
/**
 * GuestNotSupportException
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Counter\Exceptions;

use Xpressengine\Counter\CounterException;

/**
 * GuestNotSupportException
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 */
class GuestNotSupportException extends CounterException
{
    protected $message = '":name" counter not support "Guest"';
}
