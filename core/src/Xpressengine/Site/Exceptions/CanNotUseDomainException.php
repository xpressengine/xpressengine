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

use RuntimeException;

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

class CanNotUseDomainException extends RuntimeException
{

    /**
     * CanNotUseDomainException constructor.
     *
     * @param string $domain site domain
     */
    public function __construct($domain)
    {

    }
}
