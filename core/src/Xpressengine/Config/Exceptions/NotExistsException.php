<?php
/**
 * This file is the exception of not exists item.
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
 * 대상이 존재하지 않는 경우
 *
 * @category    Config
 * @package     Xpressengine\Config
 */
class NotExistsException extends ConfigException
{
    protected $message = '":name" 은 존재하지 않습니다.';
}
