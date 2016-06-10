<?php
/**
 * Class NotFoundSiteException
 *
 * PHP version 5
 *
 * @category  Site
 * @package   Xpressengine\Site
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Site\Exceptions;

use Xpressengine\Site\SiteException;

/**
 * NotFoundSiteException
 *
 * @category Routing
 * @package  Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class NotFoundSiteException extends SiteException
{
    protected $message = 'Site 를 찾을 수 없습니다.';
}
