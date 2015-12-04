<?php
/**
 * LinkNotFoundException class
 *
 * PHP version 5
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Settings\Exceptions;

use Xpressengine\Settings\SettingsException;

/**
 * 관리메뉴의 링크를 찾을 수 없을 경우 발생하는 예외
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class LinkNotFoundException extends SettingsException
{
    protected $message = 'admin 메뉴가 지정된 route는 name(as)이 지정되어 있거나 Controller action이어야 합니다.';
}
