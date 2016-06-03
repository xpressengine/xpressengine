<?php
/**
 * This file is the exception of duplicate.
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
 * 중복된 이름이 전달된 경우
 *
 * @category    Config
 * @package     Xpressengine\Config
 */
class DuplicateException extends ConfigException
{
    protected $message = '":name" 은 중복된 값입니다.';
}
