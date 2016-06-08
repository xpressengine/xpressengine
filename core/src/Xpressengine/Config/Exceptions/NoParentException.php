<?php
/**
 * This file is the exception of object has not parent.
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Config\Exceptions;

use Xpressengine\Config\ConfigException;

/**
 * 설정에 부모 객체가 없는 경우 발생되는 예외
 *
 * @category    Config
 * @package     Xpressengine\Config
 */
class NoParentException extends ConfigException
{
    protected $message = 'Parent is not exists';
}
