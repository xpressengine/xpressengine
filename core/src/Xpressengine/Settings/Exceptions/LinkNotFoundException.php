<?php
/**
 * LinkNotFoundException class
 *
 * PHP version 7
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Settings\Exceptions;

use Xpressengine\Settings\SettingsException;

/**
 * 관리메뉴의 링크를 찾을 수 없을 경우 발생하는 예외
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class LinkNotFoundException extends SettingsException
{
    protected $message = 'Routes for which the configuration page menu is specified must have name(as) specified 
    or Controller action.';
}
