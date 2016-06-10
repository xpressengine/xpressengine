<?php
/**
 * DivisionException
 *
 * PHP version 5
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Document\Exceptions;

use Xpressengine\Document\DocumentException;

/**
 * DivisionException
 *
 * @category    Document
 * @package     Xpressengine\Document
 */
class NotAllowedTypeException extends DocumentException
{
    protected $message = '":type" type not allowed to ":to"';
}
