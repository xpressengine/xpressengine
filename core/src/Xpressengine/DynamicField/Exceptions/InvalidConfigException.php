<?php
/**
 * AlreadyExistException
 *
 * PHP version 5
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\DynamicField\Exceptions;

use Xpressengine\DynamicField\DynamicFieldException;

/**
 * Invalid config exception
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 */
class InvalidConfigException extends DynamicFieldException
{
    protected $message = 'Invalid dynamic field config.';
}
