<?php
/**
 * CannotChangeInstanceIdException
 *
 * PHP version 5
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Document\Exceptions;

use Xpressengine\Document\DocumentException;

/**
 * CannotChangeInstanceIdException
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CannotChangeInstanceIdException extends DocumentException
{
    protected $message = 'Instance ID cannot be changed.';
}
