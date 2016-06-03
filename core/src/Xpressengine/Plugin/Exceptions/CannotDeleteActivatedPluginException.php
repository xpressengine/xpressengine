<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Plugin\Exceptions;

use Xpressengine\Plugin\PluginException;

/**
 * CannotDeleteActivatedPluginException Class
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CannotDeleteActivatedPluginException extends PluginException
{
    protected $message = '활성화된 플러그인은 삭제할 수 없습니다.';
}
