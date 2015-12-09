<?php
/**
 * CanNotUseDomainException
 *
 * PHP version 5
 *
 * @category    Site
 * @package     Xpressengine\Site\Exceptions
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Site\Exceptions;

use Xpressengine\Site\SiteException;

/**
 * Class CanNotUseDomainException
 *
 * @category    Site
 * @package     Xpressengine\Site\Exceptions
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

class CanNotUseDomainException extends SiteException
{
    protected $message = '":host" 은 사용할 수 없습니다.';
}
