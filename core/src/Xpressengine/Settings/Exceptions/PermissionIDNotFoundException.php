<?php
/**
 * PermissionIDNotFoundException class
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Settings\Exceptions;

use Xpressengine\Settings\SettingsException;

/**
 * 관리권한의 아이디를 찾을수 없을 경우 발생하는 예외
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 */
class PermissionIDNotFoundException extends SettingsException
{

}
