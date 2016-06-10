<?php
/**
 * CanNotUseDomainException
 *
 * PHP version 5
 *
 * @category    Site
 * @package     Xpressengine\Site\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Site\Exceptions;

use Xpressengine\Site\SiteException;

/**
 * Class CanNotUseDomainException
 *
 * @category    Site
 * @package     Xpressengine\Site\Exceptions
 */

class CanNotUseDomainException extends SiteException
{
    protected $message = '":host" 은 사용할 수 없습니다.';
}
