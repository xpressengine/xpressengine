<?php
/**
 * ConfigurationNotExistsException class
 *
 * PHP version 7
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Captcha\Exceptions;

use Xpressengine\Captcha\CaptchaException;

/**
 * 캡차 설정이 되어있지 않은 경우 발생하는 예외
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ConfigurationNotExistsException extends CaptchaException
{
    protected $message = 'Captcha setting is not set. Check the configuration file (config / captcha.php).';
}
