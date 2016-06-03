<?php
/**
 * Class NotFoundSiteException
 *
 * @category  Site
 * @package   Xpressengine\Site
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Site\Exceptions;

use Xpressengine\Site\SiteException;

/**
 * NotFoundSiteException
 *
 * @category Routing
 * @package  Xpressengine\Routing
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class NotFoundSiteException extends SiteException
{
    protected $message = 'Site 를 찾을 수 없습니다.';
}
