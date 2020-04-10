<?php
/**
 * CanNotUseDomainException
 *
 * PHP version 7
 *
 * @category    Site
 * @package     Xpressengine\Site\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

class CanNotUseDomainException extends SiteException
{
    protected $message = '":host" is not allowed.';
}
