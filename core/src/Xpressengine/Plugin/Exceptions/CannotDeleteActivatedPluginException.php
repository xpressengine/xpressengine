<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin\Exceptions;

use Xpressengine\Plugin\PluginException;

/**
 * CannotDeleteActivatedPluginException Class
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 */
class CannotDeleteActivatedPluginException extends PluginException
{
    protected $message = '활성화된 플러그인은 삭제할 수 없습니다.';
}
