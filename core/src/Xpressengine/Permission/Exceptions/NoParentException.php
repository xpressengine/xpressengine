<?php
/**
 * This file is exception of no parent.
 *
 * PHP version 5
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Permission\Exceptions;

use Xpressengine\Permission\PermissionException;

/**
 * This file is exception of invalid argument.
 *
 * PHP version 5
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 */
class NoParentException extends PermissionException
{
    protected $message = '부모 객체가 존재 하지 않습니다.';
}
