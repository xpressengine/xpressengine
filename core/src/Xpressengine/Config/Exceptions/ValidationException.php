<?php
/**
 * This file is the exception of validation test.
 *
 * PHP version 5
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
 * 설정이 유효하지 않을때 발생되는 예외
 *
 * @category    Config
 * @package     Xpressengine\Config
 */
class ValidationException extends ConfigException
{
    protected $message = '유효성 검사 실패 [:message]';
}
