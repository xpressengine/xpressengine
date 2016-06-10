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
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Site\Exceptions;

use Xpressengine\Site\SiteException;

/**
 * Class CanNotUseDomainException
 *
 * @category    Site
 * @package     Xpressengine\Site\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

class CanNotUseDomainException extends SiteException
{
    protected $message = '":host" 은 사용할 수 없습니다.';
}
